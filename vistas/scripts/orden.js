var tabla;
var detalles = 0; // Contador para las filas de productos en la orden

function init(){
    mostrarform(false);
    listar();

    // Evento al enviar el formulario de orden
    $("#formulario").on("submit", function(e) {
        guardaryeditar(e);
    });

    // Cargamos los productos en un select para la orden
    $.post("../controlador/producto.php?op=selectProducto", function(r){
        $("#producto_id").html(r);
        $('#producto_id').selectpicker('refresh');
    });
}

function mostrarform(flag) {
    if (flag) {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnGuardar").prop("disabled", false);
        $("#btnagregar").hide();
    } else {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnagregar").show();
    }
}

function listar() {
    tabla = $('#tbllistado').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        "ajax": {
            url: '../controlador/orden.php?op=listar',
            type: "get",
            dataType: "json",
            error: function(e) { console.log(e.responseText); }
        },
        "bDestroy": true,
        "iDisplayLength": 5
    }).DataTable();
}

// Función para agregar producto a la tabla temporal de la orden
function agregarDetalle(producto_id, descripcion, precio) {
    var cantidad = 1;
    if (producto_id != "") {
        var subtotal = cantidad * precio;
        var fila = '<tr class="filas" id="fila' + detalles + '">' +
            '<td><button type="button" class="btn btn-danger" onclick="eliminarFila(' + detalles + ')">X</button></td>' +
            '<td><input type="hidden" name="producto_id[]" value="' + producto_id + '">' + descripcion + '</td>' +
            '<td><input type="number" name="cantidad[]" value="' + cantidad + '"></td>' +
            '<td><input type="hidden" name="precio_unitario[]" value="' + precio + '">' + precio + '</td>' +
            '<td><span name="subtotal">' + subtotal + '</span></td>' +
            '</tr>';
        detalles++;
        $('#detalles').append(fila);
        calcularTotales();
    }
}

function calcularTotales() {
    var subtotales = document.getElementsByName("subtotal");
    var total = 0.0;
    for (var i = 0; i < subtotales.length; i++) {
        total += document.getElementsByName("subtotal")[i].value;
    }
    $("#total").html("$ " + total);
    $("#total_venta").val(total);
}

function eliminarFila(indice) {
    $("#fila" + indice).remove();
    calcularTotales();
}

function guardaryeditar(e) {
    e.preventDefault();
    var formData = new FormData($("#formulario")[0]);

    $.ajax({
        url: "../controlador/orden.php?op=guardar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos) {
            bootbox.alert(datos);
            mostrarform(false);
            tabla.ajax.reload();
        }
    });
}

init();