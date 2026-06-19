<?php 
require_once __DIR__ . "/../config/Conexion.php";

class Orden
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = Conexion::getInstancia();
    }

    // Insertar requiere manejar transacciones porque afecta dos tablas (ordenes y orden_detalles)
    public function insertar($consumidor_id, $total, $productos_array)
    {
        try {
            $this->conexion->beginTransaction();

            // 1. Insertar la orden maestra
            $sqlOrden = "INSERT INTO ordenes (consumidor_id, total) VALUES (:consumidor_id, :total)";
            $stmtOrden = $this->conexion->prepare($sqlOrden);
            $stmtOrden->bindParam(':consumidor_id', $consumidor_id, PDO::PARAM_INT);
            $stmtOrden->bindParam(':total', $total, PDO::PARAM_STR);
            $stmtOrden->execute();

            $orden_id = $this->conexion->lastInsertId();

            // 2. Insertar los detalles iterando sobre el array de productos recibidos
            $sqlDetalle = "INSERT INTO orden_detalles (orden_id, producto_id, cantidad, precio_unitario) 
                           VALUES (:orden_id, :producto_id, :cantidad, :precio_unitario)";
            $stmtDetalle = $this->conexion->prepare($sqlDetalle);

            foreach ($productos_array as $prod) {
                $stmtDetalle->bindParam(':orden_id', $orden_id, PDO::PARAM_INT);
                $stmtDetalle->bindParam(':producto_id', $prod['producto_id'], PDO::PARAM_INT);
                $stmtDetalle->bindParam(':cantidad', $prod['cantidad'], PDO::PARAM_INT);
                $stmtDetalle->bindParam(':precio_unitario', $prod['precio_unitario'], PDO::PARAM_STR);
                $stmtDetalle->execute();
            }

            $this->conexion->commit();
            return true;

        } catch (Exception $e) {
            $this->conexion->rollBack();
            return false;
        }
    }

    // Listar las órdenes con el nombre del consumidor (usando INNER JOIN)
    public function listar() {
        // Ajusta la consulta para traer lo que necesitas ver en la tabla
        $sql = "SELECT o.id as numero_orden, c.nombre as consumidor, 
                    o.total, o.fecha_orden
                FROM ordenes o
                INNER JOIN consumidores c ON o.consumidor_id = c.id
                ORDER BY o.id DESC";
        return $this->conexion->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function mostrar($id) {
        $sql = "SELECT * FROM ordenes WHERE id = '$id'";
        return $this->conexion->query($sql)->fetch(PDO::FETCH_ASSOC);
    }

    public function eliminar($id) {
    $sql = "DELETE FROM ordenes WHERE id = ?";
    $stmt = $this->conexion->prepare($sql);
    return $stmt->execute([$id]);
}
}
?>