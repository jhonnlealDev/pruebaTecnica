<?php 
require_once "../models/Producto.php";

$producto = new Producto();

// Función para prevenir ataques XSS
function limpiarCadena($str) {
    return htmlspecialchars(trim($str), ENT_QUOTES, 'UTF-8');
}

// Recibimos los datos por POST
$id          = isset($_POST["id"]) ? limpiarCadena($_POST["id"]) : "";
$descripcion = isset($_POST["descripcion"]) ? limpiarCadena($_POST["descripcion"]) : "";
$precio      = isset($_POST["precio"]) ? limpiarCadena($_POST["precio"]) : "";
$stock       = isset($_POST["stock"]) ? limpiarCadena($_POST["stock"]) : "";

switch ($_GET["op"]){
    
    case 'guardaryeditar':
        if (empty($id)){
            $rspta = $producto->insertar($descripcion, $precio, $stock);
            echo $rspta ? "Producto registrado correctamente" : "El producto no se pudo registrar";
        } else {
            $rspta = $producto->editar($id, $descripcion, $precio, $stock);
            echo $rspta ? "Producto actualizado correctamente" : "El producto no se pudo actualizar";
        }
    break;

    case 'eliminar':
        $rspta = $producto->eliminar($id);
        // Si el producto ya fue vendido en una orden, la base de datos (ON DELETE RESTRICT) bloqueará la eliminación
        echo $rspta ? "Producto eliminado correctamente" : "No se pudo eliminar (verifique si el producto pertenece a una orden existente)";
    break;

    case 'mostrar':
        $rspta = $producto->mostrar($id);
        echo json_encode($rspta);
    break;

            case 'contar':
                $pdo = Conexion::getInstancia();

            $sql = "SELECT COUNT(*) as total FROM productos"; 
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            echo $resultado['total']; 
        break;

    case 'listar':
        $rspta = $producto->listar();
        $data = Array();

        foreach ($rspta as $reg) {
            $data[] = array(
                "0" => '<button class="btn btn-warning btn-sm" onclick="mostrar('.$reg['id'].')">✏️ Editar</button> '.
                       '<button class="btn btn-danger btn-sm" onclick="eliminar('.$reg['id'].')">🗑️ Eliminar</button>',
                "1" => $reg['descripcion'],
                "2" => '$ ' . number_format($reg['precio'], 2), // Formateamos el precio para que se vea como moneda
                "3" => $reg['stock'],
                "4" => $reg['created_at']
            );
        }
        
        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );
        
        echo json_encode($results);
    break;

    case 'selectProducto':
        $rspta = $producto->listar();
        echo '<option value="">Seleccione un producto</option>';
        foreach ($rspta as $reg) {
            echo '<option value="' . $reg['id'] . '" data-precio="' . $reg['precio'] . '">' . $reg['descripcion'] . '</option>';
        }
    break;
}
?>