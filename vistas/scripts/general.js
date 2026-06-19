var tabla;

$(document).ready(function() {
    obtenerTotales();
    listarGeneral();
});

// Carga de selects al abrir el modal de orden
$('#modalOrden').on('shown.bs.modal', function () {
    $.post("../controlador/consumidor.php?op=selectConsumidor", function(r){
        $("#consumidor_id").html(r);
    });

    $.post("../controlador/producto.php?op=selectProducto", function(r){
        $("#producto_selector").html(r);
    });
});

// --- GUARDADO DE ORDEN ---
$("#formOrden").on("submit", function(e) {
    e.preventDefault();
    var formData = new FormData($(this)[0]);

    $.ajax({
        url: "../controlador/orden.php?op=guardar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos) {
            bootbox.alert(datos);
            $("#modalOrden").modal('hide');
            // Limpiar tabla y formulario
            $("#detalles").empty();
            $("#total").html("$ 0.00");
            $("#formOrden")[0].reset();
            // Recargar datos
            if (tabla) { tabla.ajax.reload(); }
            obtenerTotales();
        }
    });
});

$("#formProducto").on("submit", function(e) {
    e.preventDefault();
    var formData = new FormData($(this)[0]);
    
    $.ajax({
        url: "../controlador/producto.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos) {
            bootbox.alert(datos);
            $("#modalProducto").modal('hide');
            if (tabla) { tabla.ajax.reload(); }
            obtenerTotales();
            $("#formProducto")[0].reset();
        }
    });
});

$("#formConsumidor").on("submit", function(e) {
    e.preventDefault(); // Detiene el envío clásico del formulario
    var formData = new FormData($(this)[0]);
    
    $.ajax({
        url: "../controlador/consumidor.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos) {
            bootbox.alert(datos); // Muestra "Consumidor registrado..."
            $("#modalConsumidor").modal('hide');
            // Recargar tabla y totales
            if (tabla) { tabla.ajax.reload(); }
            obtenerTotales();
            $("#formConsumidor")[0].reset(); // Limpia el formulario
        },
        error: function(xhr, status, error) {
            console.error("Error en AJAX:", error);
        }
    });
});

function obtenerTotales() {
    $.post("../controlador/consumidor.php?op=contar", function(data) { $("#total_consumidores").html(data); });
    $.post("../controlador/producto.php?op=contar", function(data) { $("#total_productos").html(data); });
    $.post("../controlador/orden.php?op=contar", function(data) { $("#total_ordenes").html(data); });
}

function listarGeneral() {
    tabla = $('#tbllistado').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        "ajax": {
            url: '../controlador/orden.php?op=listar',
            type: "get",
            dataType: "json"
        },
        "bDestroy": true
    }).DataTable();
}

// Lógica de agregar producto a la tabla
function agregarProducto() {
    var select = $("#producto_selector");
    var idProducto = select.val();
    var descripcion = select.find("option:selected").text();
    var precio = parseFloat(select.find("option:selected").attr("data-precio"));

    if (idProducto != "" && !isNaN(precio)) {
        var fila = '<tr class="filas">' +
            '<td><button type="button" class="btn btn-danger" onclick="eliminarFila(this)">X</button></td>' +
            '<td><input type="hidden" name="producto_id[]" value="' + idProducto + '">' + descripcion + '</td>' +
            '<td><input type="number" name="cantidad[]" value="1" min="1" onchange="modificarSubtotales()"></td>' +
            '<td><input type="hidden" name="precio_unitario[]" value="' + precio + '">' + precio + '</td>' +
            '<td><span class="subtotal">' + precio.toFixed(2) + '</span></td>' +
            '</tr>';
        $("#detalles").append(fila);
        calcularTotales();
    }
}

function eliminarFila(btn) {
    $(btn).closest('tr').remove();
    calcularTotales();
}

function modificarSubtotales() {
    var cantidades = document.getElementsByName("cantidad[]");
    var precios = document.getElementsByName("precio_unitario[]");
    var subtotales = document.getElementsByClassName("subtotal");

    for (var i = 0; i < cantidades.length; i++) {
        var cant = cantidades[i].value;
        var prec = precios[i].value;
        // Actualizamos el texto del span subtotal
        subtotales[i].innerHTML = (cant * prec).toFixed(2);
    }
    calcularTotales();
}

function calcularTotales() {
    var total = 0;
    $(".subtotal").each(function() {
        total += parseFloat($(this).text());
    });
    $("#total").html("$ " + total.toFixed(2));
    $("#total_venta").val(total.toFixed(2));
}

function editar(id) {
    // 1. Llamamos al controlador para obtener los datos de la orden
    $.post("../controlador/orden.php?op=mostrar", {id : id}, function(data, status) {
        data = JSON.parse(data);
        
        // 2. Abrimos el modal
        $("#modalOrden").modal("show");
        
        // 3. Llenamos los campos básicos (Ajusta los IDs según tu HTML)
        $("#id_orden").val(data.id);
        $("#consumidor_id").val(data.consumidor_id);
        
        // 4. Si tienes detalles, aquí deberías limpiar la tabla y rellenarla
        // Esta parte depende de cómo tengas estructurado tu modelo
        // bootbox.alert("Datos cargados para editar la orden: " + data.id);
    });
}

function eliminar(id) {
    bootbox.confirm("¿Estás seguro de eliminar este registro?", function(result){
        if(result){
            $.post("../controlador/orden.php?op=eliminar", {id: id}, function(e){
                bootbox.alert(e);
                tabla.ajax.reload();
                obtenerTotales();
            });
        }
    });
}

