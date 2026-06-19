<?php 
require_once "../models/Consumidor.php";

$consumidor = new Consumidor();

// Pequeña función para evitar ataques XSS
function limpiarCadena($str) {
    return htmlspecialchars(trim($str), ENT_QUOTES, 'UTF-8');
}

// Recibimos los datos por POST desde el formulario (Frontend)
$id       = isset($_POST["id"]) ? limpiarCadena($_POST["id"]) : "";
$nombre   = isset($_POST["nombre"]) ? limpiarCadena($_POST["nombre"]) : "";
$email    = isset($_POST["email"]) ? limpiarCadena($_POST["email"]) : "";
$telefono = isset($_POST["telefono"]) ? limpiarCadena($_POST["telefono"]) : "";

switch ($_GET["op"]){
    
    // 1. Guardar o Editar
    case 'guardaryeditar':
        if (empty($id)){
            // Si el ID viene vacío, es un registro nuevo
            $rspta = $consumidor->insertar($nombre, $email, $telefono);
            echo $rspta ? "Consumidor registrado correctamente" : "El consumidor no se pudo registrar";
        }
        else {
            // Si el ID tiene valor, estamos actualizando
            $rspta = $consumidor->editar($id, $nombre, $email, $telefono);
            echo $rspta ? "Consumidor actualizado correctamente" : "El consumidor no se pudo actualizar";
        }
    break;

    // 2. Eliminar (La prueba exige explícitamente "modificación y eliminación de la información" )
    case 'eliminar':
        $rspta = $consumidor->eliminar($id);
        echo $rspta ? "Consumidor eliminado correctamente" : "El consumidor no se pudo eliminar (verifique si tiene órdenes asociadas)";
    break;

    // 3. Mostrar un solo registro (para llenar el formulario al momento de editar)
    case 'mostrar':
        $rspta = $consumidor->mostrar($id);
        // Codificamos el resultado utilizando JSON para que JavaScript lo lea fácilmente
        echo json_encode($rspta);
    break;

    // 4. Listar todos los registros (Formateado para DataTables)
    case 'listar':
        $rspta = $consumidor->listar();
        
        // Vamos a declarar el array que contendrá los datos
        $data = Array();

        // Iteramos sobre los resultados de PDO (ahora usamos foreach, ya no fetch_object)
        foreach ($rspta as $reg) {
            $data[] = array(
                // Botones de acción
                "0" => '<button class="btn btn-warning btn-sm" onclick="mostrar('.$reg['id'].')">✏️ Editar</button> '.
                       '<button class="btn btn-danger btn-sm" onclick="eliminar('.$reg['id'].')">🗑️ Eliminar</button>',
                // Datos del consumidor
                "1" => $reg['nombre'],
                "2" => $reg['email'],
                "3" => $reg['telefono'],
                "4" => $reg['created_at'] 
            );
        }
        
        $results = array(
            "sEcho" => 1, // Información para el datatables
            "iTotalRecords" => count($data), // total registros al datatable
            "iTotalDisplayRecords" => count($data), //  total registros a visualizar
            "aaData" => $data
        );
        
        echo json_encode($results);
    break;

        case 'contar':
            $pdo = Conexion::getInstancia();

            $sql = "SELECT COUNT(*) as total FROM consumidores"; 
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            echo $resultado['total']; 
        break;


    case 'selectConsumidor':
        $rspta = $consumidor->listar();
        echo '<option value="">Seleccione un consumidor</option>';
        foreach ($rspta as $reg) {
            echo '<option value="' . $reg['id'] . '">' . $reg['nombre'] . '</option>';
        }
    break;
}
?>