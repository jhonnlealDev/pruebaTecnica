var tabla;

// Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	});
}

// Función limpiar
function limpiar()
{
	$("#id").val("");
	$("#nombre").val("");
	$("#email").val("");
	$("#telefono").val("");
}

// Función mostrar formulario
function mostrarform(flag)
{
	limpiar();
	if (flag)
	{
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
	}
	else
	{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
	}
}

// Función cancelarform
function cancelarform()
{
	limpiar();
	mostrarform(false);
}

// Función Listar
function listar()
{
	tabla=$('#tbllistado').dataTable(
	{
		"aProcessing": true, // Activamos el procesamiento del datatables
	    "aServerSide": true, // Paginación y filtrado realizados por el servidor
	    dom: 'Bfrtip', // Definimos los elementos del control de tabla
	    buttons: [		          
		            'copyHtml5',
		            'excelHtml5',
		            'csvHtml5',
		            'pdf'
		        ],
		"ajax":
				{
					url: '../controlador/consumidor.php?op=listar',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 5, // Paginación
	    "order": [[ 0, "desc" ]] // Ordenar (columna,orden) por el ID descendente
	}).DataTable();
}

// Función para guardar o editar
function guardaryeditar(e)
{
	e.preventDefault(); // No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../controlador/consumidor.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {                    
	          bootbox.alert(datos);	          
	          mostrarform(false);
	          tabla.ajax.reload();
	    }
	});
	limpiar();
}

// Función para mostrar los datos en el formulario al momento de editar
function mostrar(id)
{
	$.post("../controlador/consumidor.php?op=mostrar",{id : id}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

		$("#id").val(data.id);
		$("#nombre").val(data.nombre);
		$("#email").val(data.email);
		$("#telefono").val(data.telefono);
 	});
}

// Función para eliminar registros
function eliminar(id)
{
	bootbox.confirm("¿Está Seguro de eliminar este consumidor?", function(result){
		if(result)
        {
        	$.post("../controlador/consumidor.php?op=eliminar", {id : id}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	});
}

init();