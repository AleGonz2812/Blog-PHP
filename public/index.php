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
require_once APP_PATH . '/controllers/PostController.php';

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

// ====== RUTAS DE CRUD DE POSTS ======
$router->get('/posts/create', function() {
    $controller = new PostController();
    $controller->create();
});

$router->post('/posts/store', function() {
    $controller = new PostController();
    $controller->store();
});

$router->get('/posts/edit/{id}', function($id) {
    $controller = new PostController();
    $controller->edit($id);
});

$router->post('/posts/update/{id}', function($id) {
    $controller = new PostController();
    $controller->update($id);
});

$router->get('/posts/delete/{id}', function($id) {
    $controller = new PostController();
    $controller->delete($id);
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
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }
            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
                background: linear-gradient(135deg, #0a0e27 0%, #151932 50%, #1e2139 100%);
                color: #e0e7ff;
            }
            .error-container {
                text-align: center;
                padding: 2rem;
            }
            h1 { 
                font-size: 8em; 
                margin: 0;
                color: #00d9ff;
                text-shadow: 0 0 40px rgba(0, 217, 255, 0.5);
            }
            p { 
                font-size: 1.5em;
                color: #8b92b0;
                margin: 1rem 0 2rem;
            }
            a {
                color: white;
                text-decoration: none;
                border: 2px solid #00d9ff;
                background: rgba(0, 217, 255, 0.1);
                padding: 12px 30px;
                display: inline-block;
                margin-top: 20px;
                border-radius: 10px;
                transition: all 0.3s;
                font-weight: 600;
                font-size: 1.1rem;
            }
            a:hover {
                background: rgba(0, 217, 255, 0.2);
                box-shadow: 0 0 20px rgba(0, 217, 255, 0.5);
                transform: translateY(-2px);
            }
        </style>
    </head>
    <body>
        <div class='error-container'>
            <h1>404</h1>
            <p>Página no encontrada</p>
            <a href='" . BASE_URL . "'>← Volver al inicio</a>
        </div>
    </body>
    </html>";
});

// Ejecutar el router
$router->run();
