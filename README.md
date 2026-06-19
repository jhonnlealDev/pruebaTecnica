# Sistema de Gestión de Órdenes (Prueba Técnica)

Este proyecto es una aplicación web desarrollada para gestionar consumidores, productos y órdenes de compra, siguiendo una arquitectura **MVC (Modelo-Vista-Controlador)**. Permite registrar, listar, editar y eliminar información de forma dinámica utilizando tecnologías web estándar.

## 🚀 Tecnologías Utilizadas

* **Backend:** PHP (con PDO para conexión segura a base de datos).
* **Frontend:** HTML5, CSS3, JavaScript (jQuery), Bootstrap 3.
* **Base de Datos:** MySQL.
* **Componentes Adicionales:** DataTables (listado dinámico), Bootbox (alertas y diálogos modales).

## 📂 Estructura del Proyecto

```text
/
├── assets/             # Estilos CSS y otros recursos estáticos
├── config/             # Configuración de conexión a la base de datos
├── controlador/        # Lógica de procesamiento de peticiones
├── database/           # Script SQL para la creación de tablas
├── models/             # Interacción directa con la base de datos
├── vistas/             # Archivos de interfaz (HTML/PHP)
│   ├── scripts/        # Lógica JS (general.js)
│   └── ...
└── index.php           # Dashboard principal
Instalación y Configuración
Requisitos: Tener instalado XAMPP o un entorno LAMP/WAMP.

Base de Datos:

Crea una base de datos en tu servidor MySQL (ej. db_prueba).

Importa el archivo .sql ubicado en la carpeta /database.

Configuración de Conexión:

Abre config/Conexion.php y asegúrate de actualizar las credenciales de tu base de datos (nombre de la base de datos, usuario y contraseña).

Ejecución:

Coloca el proyecto en la carpeta htdocs de XAMPP.

Accede a http://localhost/nombre-de-tu-carpeta/index.php.

🛠 Características Principales
Gestión MVC: Separación clara de responsabilidades.

Interfaz Dinámica: Uso de AJAX para no recargar la página al realizar acciones.

Cálculos en tiempo real: Gestión de subtotales y totales al crear nuevas órdenes.

Listados Profesionales: Tablas interactivas con DataTables para búsqueda y paginación.
