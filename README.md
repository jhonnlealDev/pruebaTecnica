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
