<?php 
require_once "../models/Orden.php";

$orden = new Orden();

function limpiarCadena($str) {
    return htmlspecialchars(trim($str), ENT_QUOTES, 'UTF-8');
}

$consumidor_id = isset($_POST["consumidor_id"]) ? limpiarCadena($_POST["consumidor_id"]) : "";
$total         = isset($_POST["total"]) ? limpiarCadena($_POST["total"]) : "";

switch ($_GET["op"]){
    
case 'guardar':
    $consumidor_id = $_POST['consumidor_id'];
    $total         = $_POST['total'];
    // Capturamos los arrays enviados desde el formulario
    $producto_ids  = $_POST['producto_id'];
    $cantidades    = $_POST['cantidad'];
    $precios       = $_POST['precio_unitario'];

    // Preparamos el array para el modelo
    $productos_array = [];
    for ($i = 0; $i < count($producto_ids); $i++) {
        $productos_array[] = [
            'producto_id'     => $producto_ids[$i],
            'cantidad'        => $cantidades[$i],
            'precio_unitario' => $precios[$i] // Debe coincidir con los nombres en Orden.php
        ];
    }

    $rspta = $orden->insertar($consumidor_id, $total, $productos_array);
    echo $rspta ? "Orden registrada exitosamente" : "Error en base de datos";
break;

        case 'contar':
            $pdo = Conexion::getInstancia();
            
            $sql = "SELECT COUNT(*) as total FROM ordenes";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            echo $resultado['total']; 
        break;

        

case 'listar':
    $rspta = $orden->listar();
    $data = array();
    foreach ($rspta as $reg) {
        $data[] = array(
            "0" => '<button class="btn btn-warning" onclick="editar('.$reg['numero_orden'].')"><i class="fa fa-pencil"></i></button> '.
                   '<button class="btn btn-danger" onclick="eliminar('.$reg['numero_orden'].')"><i class="fa fa-trash"></i></button>',
            "1" => $reg['numero_orden'],
            "2" => $reg['consumidor'],
            "3" => $reg['total'],
            "4" => $reg['fecha_orden']
        );
    }
    echo json_encode(["aaData" => $data]);
break;

case 'mostrar':
    $id = $_POST["id"];
    $rspta = $orden->mostrar($id); // Este método debe existir en tu clase Orden.php
    echo json_encode($rspta);
break;

case 'eliminar':
    $id = $_POST["id"];
    // Asegúrate de que tu modelo tenga el método eliminar
    $rspta = $orden->eliminar($id); 
    echo $rspta ? "Registro eliminado correctamente" : "No se pudo eliminar";
break;

}
?>