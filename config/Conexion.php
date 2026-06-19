<?php 
require_once "global.php";

class Conexion 
{
    // Contenedor de la única instancia de la clase (Singleton)
    private static $instancia = null;
    
    private $pdo;

    private function __construct() 
    {
        try {
            // Se construye el Data Source Name
            // Se asume que DB_ENCODE en tu global.php es 'utf8mb4' o 'utf8'
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_ENCODE;
            
            // Opciones de seguridad y manejo de errores
            $opciones = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Lanza excepciones en caso de error SQL
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Retorna los datos como arrays asociativos
                PDO::ATTR_EMULATE_PREPARES   => false                   // Delega la seguridad de sentencias preparadas a MySQL
            ];

            $this->pdo = new PDO($dsn, DB_USERNAME, DB_PASSWORD, $opciones);

        } catch (PDOException $e) {
            // Manejo de excepciones en la conexión
            printf("Falló conexión a la base de datos: %s\n", $e->getMessage());
            exit();
        }
    }

    // Evitar la clonación del objeto
    private function __clone() {}

    // Método principal para obtener la conexión desde los Modelos
    public static function getInstancia() 
    {
        if (self::$instancia === null) {
            self::$instancia = new self();
        }
        // Retornamos el objeto PDO listo para usarse
        return self::$instancia->pdo;
    }
}
?>