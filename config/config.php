<?php
/**
 * Archivo de Configuración Central - Arquitectura MVC
 */

// Configuración de la Base de Datos
define('DB_HOST', 'localhost');
define('DB_NAME', 'blog_php');
define('DB_USER', 'root');
define('DB_PASS', ''); // Cambia esto si tu MySQL tiene contraseña

// Rutas del Proyecto (MVC)
define('ROOT_PATH', dirname(__DIR__)); // Ruta raíz del proyecto
define('APP_PATH', ROOT_PATH . '/app'); // Carpeta app
define('UPLOADS_PATH', ROOT_PATH . '/uploads'); // Carpeta de uploads
define('PUBLIC_PATH', ROOT_PATH . '/public'); // Carpeta pública

// URLs Base (ajusta según tu configuración local)
define('BASE_URL', 'http://localhost:8080'); // URL base de la app
define('ASSETS_URL', BASE_URL . '/'); // URL de assets (css, js, images)

// Configuración de Sesiones
define('SESSION_NAME', 'blog_session');
define('SESSION_LIFETIME', 7200); // 2 horas en segundos

// Configuración de Archivos
define('MAX_FILE_SIZE', 5242880); // 5MB en bytes
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'gif']);

// Configuración General
date_default_timezone_set('Europe/Madrid'); // Ajusta tu zona horaria

// Modo Debug (cambiar a false en producción)
define('DEBUG_MODE', true);

// Configuración de errores
if (DEBUG_MODE) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_name(SESSION_NAME);
    session_start();
}
