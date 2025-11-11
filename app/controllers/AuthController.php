<?php
/**
 * AuthController - Controlador de Autenticación
 * 
 * Maneja login, registro y logout de usuarios.
 */

require_once APP_PATH . '/controllers/BaseController.php';
require_once APP_PATH . '/models/User.php';

class AuthController extends BaseController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    /**
     * Mostrar formulario de login
     */
    public function showLogin() {
        // Si ya está logueado, redirigir al home
        if ($this->userModel->isLoggedIn()) {
            $this->redirect('/');
        }

        $this->view('auth/login', [], null); // Sin layout
    }

    /**
     * Procesar login
     */
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/login');
        }

        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        // Validaciones
        if (empty($username) || empty($password)) {
            $_SESSION['error'] = 'Por favor, completa todos los campos.';
            $this->redirect('/login');
        }

        // Intentar login
        if ($this->userModel->login($username, $password)) {
            $_SESSION['success'] = '¡Bienvenido de nuevo!';
            $this->redirect('/');
        } else {
            $_SESSION['error'] = 'Credenciales incorrectas.';
            $this->redirect('/login');
        }
    }

    /**
     * Mostrar formulario de registro
     */
    public function showRegister() {
        // Si ya está logueado, redirigir al home
        if ($this->userModel->isLoggedIn()) {
            $this->redirect('/');
        }

        $this->view('auth/register', [], null); // Sin layout
    }

    /**
     * Procesar registro
     */
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/register');
        }

        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        // Validaciones
        if (empty($username) || empty($password) || empty($confirmPassword)) {
            $_SESSION['error'] = 'Por favor, completa todos los campos obligatorios.';
            $this->redirect('/register');
        }

        if ($password !== $confirmPassword) {
            $_SESSION['error'] = 'Las contraseñas no coinciden.';
            $this->redirect('/register');
        }

        if (strlen($password) < 6) {
            $_SESSION['error'] = 'La contraseña debe tener al menos 6 caracteres.';
            $this->redirect('/register');
        }

        // Intentar registrar
        if ($this->userModel->register($username, $password, $email)) {
            $_SESSION['success'] = '¡Registro exitoso! Ahora puedes iniciar sesión.';
            $this->redirect('/login');
        } else {
            $_SESSION['error'] = 'El nombre de usuario ya existe o hubo un error.';
            $this->redirect('/register');
        }
    }

    /**
     * Cerrar sesión
     */
    public function logout() {
        $this->userModel->logout();
        $_SESSION['success'] = 'Sesión cerrada correctamente.';
        $this->redirect('/login');
    }
}
