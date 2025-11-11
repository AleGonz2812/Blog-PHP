<?php
/**
 * Punto de Entrada Principal - Front Controller
 * 
 * Todas las peticiones pasan por aquí gracias al .htaccess
 */

// Cargar configuración
require_once __DIR__ . '/../config/config.php';

// Cargar Router
require_once APP_PATH . '/Router.php';

// Cargar controladores
require_once APP_PATH . '/controllers/AuthController.php';
require_once APP_PATH . '/controllers/HomeController.php';

// Crear instancia del router
$router = new Router();

// ====== RUTAS DE AUTENTICACIÓN ======
$router->get('/login', function() {
    $controller = new AuthController();
    $controller->showLogin();
});

$router->post('/login', function() {
    $controller = new AuthController();
    $controller->login();
});

$router->get('/register', function() {
    $controller = new AuthController();
    $controller->showRegister();
});

$router->post('/register', function() {
    $controller = new AuthController();
    $controller->register();
});

$router->get('/logout', function() {
    $controller = new AuthController();
    $controller->logout();
});

// ====== RUTAS DE HOME/POSTS ======
$router->get('/', function() {
    $controller = new HomeController();
    $controller->index();
});

$router->get('/post/{id}', function($id) {
    $controller = new HomeController();
    $controller->show($id);
});

// ====== RUTA 404 ======
$router->notFound(function() {
    http_response_code(404);
    echo "<!DOCTYPE html>
    <html lang='es'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>404 - Página no encontrada</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
            }
            .error-container {
                text-align: center;
            }
            h1 { font-size: 8em; margin: 0; }
            p { font-size: 1.5em; }
            a {
                color: white;
                text-decoration: none;
                border: 2px solid white;
                padding: 10px 20px;
                display: inline-block;
                margin-top: 20px;
                border-radius: 5px;
                transition: all 0.3s;
            }
            a:hover {
                background: white;
                color: #667eea;
            }
        </style>
    </head>
    <body>
        <div class='error-container'>
            <h1>404</h1>
            <p>Página no encontrada</p>
            <a href='" . BASE_URL . "'>Volver al inicio</a>
        </div>
    </body>
    </html>";
});

// Ejecutar el router
$router->run();
