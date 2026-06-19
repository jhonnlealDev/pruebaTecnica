<?php
// Mostrar errores para facilitar la depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Ajusta estas rutas dependiendo de dónde guardes este archivo
// Si el archivo está en la raíz, las rutas serían así:
require_once "config/Conexion.php";
require_once "models/Consumidor.php";

try {
    // 1. Instanciar el modelo (Esto probará automáticamente la conexión PDO)
    $consumidor = new Consumidor();

    // 2. Generar datos de prueba
    // Usamos time() en el email para que sea único en cada prueba y no lance error por el UNIQUE
    $nombre = "Usuario de Prueba API";
    $email = "prueba_" . time() . "@oati.edu.co"; 
    $telefono = "3201234567";

    // 3. Ejecutar el método de inserción
    $resultado = $consumidor->insertar($nombre, $email, $telefono);

    // 4. Preparar la respuesta como JSON (buena práctica para la API REST)
    header('Content-Type: application/json; charset=utf-8');

    if ($resultado) {
        echo json_encode([
            "estado" => "exito", 
            "mensaje" => "¡Conexión PDO exitosa! El modelo se comunicó con la BD y el consumidor fue insertado.",
            "datos_insertados" => [
                "nombre" => $nombre,
                "email" => $email
            ]
        ]);
    } else {
        echo json_encode([
            "estado" => "error", 
            "mensaje" => "La conexión funcionó, pero falló la inserción del registro."
        ]);
    }

} catch (Exception $e) {
    // Capturar cualquier error de conexión o de SQL
    header('Content-Type: application/json; charset=utf-8');
    http_response_code(500); // Código HTTP de error del servidor
    echo json_encode([
        "estado" => "error_critico",
        "mensaje" => "Error al ejecutar la prueba: " . $e->getMessage()
    ]);
}
?>