<?php 
require_once __DIR__ . "/../config/Conexion.php";

class Consumidor
{
    private $conexion;

    // Implementamos nuestro constructor que recibe la conexión PDO
    public function __construct()
    {
        $this->conexion = Conexion::getInstancia(); // Ajusta esto a como instancies tu PDO
    }

    // Método para insertar registros
    public function insertar($nombre, $email, $telefono)
    {
        $sql = "INSERT INTO consumidores (nombre, email, telefono) VALUES (:nombre, :email, :telefono)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':telefono', $telefono, PDO::PARAM_STR);
        return $stmt->execute();
    }

    // Método para editar registros
    public function editar($id, $nombre, $email, $telefono)
    {
        $sql = "UPDATE consumidores SET nombre = :nombre, email = :email, telefono = :telefono WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':telefono', $telefono, PDO::PARAM_STR);
        return $stmt->execute();
    }

    // Método para eliminar registros (La prueba pide "eliminación de la información")
    public function eliminar($id)
    {
        $sql = "DELETE FROM consumidores WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Método para mostrar los datos de un registro a modificar
    public function mostrar($id)
    {
        $sql = "SELECT * FROM consumidores WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna una sola fila
    }

    // Método para listar los registros
    public function listar()
    {
        $sql = "SELECT * FROM consumidores ORDER BY id DESC";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna todos los registros
    }
}
?>