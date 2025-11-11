<?php
/**
 * Clase Router - Sistema de Enrutamiento
 * 
 * Maneja las rutas de la aplicación y redirige a los controladores correspondientes.
 */

class Router {
    private $routes = [];
    private $notFound;

    /**
     * Registrar una ruta GET
     */
    public function get(string $path, $callback) {
        $this->routes['GET'][$path] = $callback;
    }

    /**
     * Registrar una ruta POST
     */
    public function post(string $path, $callback) {
        $this->routes['POST'][$path] = $callback;
    }

    /**
     * Definir callback para ruta no encontrada (404)
     */
    public function notFound($callback) {
        $this->notFound = $callback;
    }

    /**
     * Ejecutar el router y buscar coincidencias
     */
    public function run() {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];
        
        // Remover query string
        $uri = strtok($uri, '?');
        
        // Remover /Blog-PHP/public del inicio para desarrollo local
        $uri = str_replace('/Blog-PHP/public', '', $uri);
        
        // Si está vacío, es la raíz
        if ($uri === '' || $uri === '/') {
            $uri = '/';
        }

        // Buscar coincidencia exacta
        if (isset($this->routes[$method][$uri])) {
            return call_user_func($this->routes[$method][$uri]);
        }

        // Buscar coincidencias con parámetros dinámicos
        foreach ($this->routes[$method] ?? [] as $route => $callback) {
            $pattern = $this->convertRouteToRegex($route);
            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches); // Remover la coincidencia completa
                return call_user_func_array($callback, $matches);
            }
        }

        // No se encontró la ruta - 404
        if ($this->notFound) {
            http_response_code(404);
            return call_user_func($this->notFound);
        }

        // 404 por defecto
        http_response_code(404);
        echo "404 - Página no encontrada";
    }

    /**
     * Convertir ruta con parámetros a regex
     * Ejemplo: /post/{id} -> /post/([^/]+)
     */
    private function convertRouteToRegex(string $route): string {
        $route = preg_replace('/\{([a-zA-Z]+)\}/', '([^/]+)', $route);
        return '#^' . $route . '$#';
    }

    /**
     * Redireccionar a una URL
     */
    public static function redirect(string $path) {
        header("Location: " . BASE_URL . $path);
        exit();
    }
}
