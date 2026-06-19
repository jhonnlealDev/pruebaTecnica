<?php 
require_once __DIR__ . "/../config/Conexion.php";

class Producto
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = Conexion::getInstancia();
    }

    public function insertar($descripcion, $precio, $stock)
    {
        $sql = "INSERT INTO productos (descripcion, precio, stock) VALUES (:descripcion, :precio, :stock)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        $stmt->bindParam(':precio', $precio, PDO::PARAM_STR);
        $stmt->bindParam(':stock', $stock, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function editar($id, $descripcion, $precio, $stock)
    {
        $sql = "UPDATE productos SET descripcion = :descripcion, precio = :precio, stock = :stock WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        $stmt->bindParam(':precio', $precio, PDO::PARAM_STR);
        $stmt->bindParam(':stock', $stock, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function eliminar($id)
    {
        $sql = "DELETE FROM productos WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function mostrar($id)
    {
        $sql = "SELECT * FROM productos WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function listar()
    {
        $sql = "SELECT * FROM productos ORDER BY id DESC";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>