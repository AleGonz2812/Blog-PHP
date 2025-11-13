<?php
/**
 * Clase BaseController - Controlador Base
 * 
 * Todos los controladores heredan de esta clase.
 * Proporciona métodos comunes para renderizar vistas.
 */

class BaseController {
    /**
     * Renderizar una vista
     * 
     * @param string $view Nombre de la vista (ruta relativa a app/views)
     * @param array $data Datos a pasar a la vista
     * @param string|null $layout Layout a usar (null = sin layout)
     */
    protected function view(string $view, array $data = [], ?string $layout = 'main') {
        // Extraer datos para usar como variables
        extract($data);
        
        // Buffer de salida
        ob_start();
        
        // Incluir la vista
        $viewPath = APP_PATH . '/views/' . $view . '.php';
        if (file_exists($viewPath)) {
            require $viewPath;
        } else {
            die("Vista no encontrada: {$view}");
        }
        
        // Obtener contenido de la vista
        $content = ob_get_clean();
        
        // Si hay layout, renderizarlo
        if ($layout) {
            $layoutPath = APP_PATH . '/views/layouts/' . $layout . '.php';
            if (file_exists($layoutPath)) {
                require $layoutPath;
            } else {
                echo $content;
            }
        } else {
            echo $content;
        }
    }
    
    /**
     * Alias de view para compatibilidad
     */
    protected function render(string $view, array $data = [], ?string $layout = 'main') {
        // Añadir currentUser a los datos si existe
        if (isset($_SESSION['user_id']) && !isset($data['currentUser'])) {
            require_once APP_PATH . '/models/User.php';
            $userModel = new User();
            $data['currentUser'] = $userModel->findById($_SESSION['user_id']);
        }
        
        return $this->view($view, $data, $layout);
    }

    /**
     * Renderizar JSON (para APIs)
     */
    protected function json($data, int $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }

    /**
     * Redireccionar
     */
    protected function redirect(string $path) {
        Router::redirect($path);
    }

    /**
     * Verificar si el usuario está autenticado
     */
    protected function requireAuth() {
        if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
            $this->redirect('/login');
        }
    }
}
