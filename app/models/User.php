<?php
/**
 * Clase User - Gestión de Usuarios y Autenticación
 * 
 * Maneja todo lo relacionado con usuarios: registro, login, sesiones, etc.
 */

require_once __DIR__ . '/Database.php';

class User {
    private $conn;
    private $table = 'users';

    public function __construct() {
        // Usamos el patrón Singleton para obtener la conexión
        $this->conn = Database::getInstance()->getConnection();
    }

    /**
     * Registrar un nuevo usuario
     * 
     * @param string $username Nombre de usuario (único)
     * @param string $password Contraseña en texto plano (se hasheará)
     * @param string|null $email Email del usuario (opcional)
     * @return bool True si se registró correctamente, false en caso contrario
     */
    public function register(string $username, string $password, ?string $email = null): bool {
        // Saneamiento de datos
        $cleanUsername = trim($username);
        $cleanEmail = $email ? trim($email) : null;
        
        // Validaciones básicas
        if (empty($cleanUsername) || empty($password)) {
            return false;
        }

        // Validar longitud de username
        if (strlen($cleanUsername) < 3 || strlen($cleanUsername) > 50) {
            return false;
        }

        // Validar longitud de password
        if (strlen($password) < 6) {
            return false;
        }

        // Comprobar si el usuario ya existe
        if ($this->findByUsername($cleanUsername)) {
            return false;
        }

        // Validar email si se proporcionó
        if ($cleanEmail && !filter_var($cleanEmail, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        try {
            // Preparar consulta SQL con placeholders
            $sql = "INSERT INTO {$this->table} (username, password, email) 
                    VALUES (:username, :password, :email)";
            $stmt = $this->conn->prepare($sql);

            // Hashear la contraseña (NUNCA guardar en texto plano)
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Ejecutar con los parámetros
            return $stmt->execute([
                ':username' => $cleanUsername,
                ':password' => $hashedPassword,
                ':email'    => $cleanEmail,
            ]);
        } catch (PDOException $e) {
            // En producción, logear el error en lugar de mostrarlo
            if (DEBUG_MODE) {
                echo "Error en registro: " . $e->getMessage();
            }
            return false;
        }
    }

    /**
     * Iniciar sesión de usuario
     * 
     * @param string $username Nombre de usuario
     * @param string $password Contraseña en texto plano
     * @return bool True si las credenciales son correctas, false en caso contrario
     */
    public function login(string $username, string $password): bool {
        // Saneamiento
        $cleanUsername = trim($username);

        // Validación básica
        if (empty($cleanUsername) || empty($password)) {
            return false;
        }

        // Buscar usuario en la base de datos
        $user = $this->findByUsername($cleanUsername);

        // Verificar que el usuario existe
        if (!$user) {
            return false;
        }

        // Verificar la contraseña usando password_verify
        // Esto compara el hash almacenado con la contraseña proporcionada
        if (!password_verify($password, $user['password'])) {
            return false;
        }

        // Si llegamos aquí, las credenciales son correctas
        // Guardar datos del usuario en la sesión
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['logged_in'] = true;

        // Regenerar el ID de sesión para prevenir session fixation
        session_regenerate_id(true);

        return true;
    }

    /**
     * Cerrar sesión del usuario
     * 
     * @return bool Siempre retorna true
     */
    public function logout(): bool {
        // Limpiar todas las variables de sesión
        $_SESSION = [];

        // Destruir la cookie de sesión si existe
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 3600, '/');
        }

        // Destruir la sesión
        session_destroy();

        return true;
    }

    /**
     * Verificar si hay un usuario autenticado
     * 
     * @return bool True si hay sesión activa, false en caso contrario
     */
    public function isLoggedIn(): bool {
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }

    /**
     * Obtener datos del usuario actual en sesión
     * 
     * @return array|null Array con datos del usuario o null si no hay sesión
     */
    public function getCurrentUser(): ?array {
        if (!$this->isLoggedIn()) {
            return null;
        }

        // Obtener el usuario completo desde la BD
        $sql = "SELECT id, username, email, created_at FROM {$this->table} WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $_SESSION['user_id']]);
        
        $user = $stmt->fetch();
        return $user ?: null;
    }

    /**
     * Obtener usuario por ID
     * 
     * @param int $id ID del usuario
     * @return array|null Array con datos del usuario o null si no existe
     */
    public function findById(int $id): ?array {
        $sql = "SELECT id, username, email, created_at FROM {$this->table} WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        
        $user = $stmt->fetch();
        return $user ?: null;
    }

    /**
     * Buscar usuario por nombre de usuario
     * 
     * @param string $username Nombre de usuario
     * @return array|null Array con datos del usuario (incluye password) o null
     */
    public function findByUsername(string $username): ?array {
        $sql = "SELECT * FROM {$this->table} WHERE username = :username LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':username' => $username]);
        
        $user = $stmt->fetch();
        return $user ?: null;
    }

    /**
     * Cambiar contraseña de un usuario
     * 
     * @param int $userId ID del usuario
     * @param string $currentPassword Contraseña actual
     * @param string $newPassword Nueva contraseña
     * @return bool True si se cambió correctamente, false en caso contrario
     */
    public function updatePassword(int $userId, string $currentPassword, string $newPassword): bool {
        // Validar que la nueva contraseña tenga longitud mínima
        if (strlen($newPassword) < 6) {
            return false;
        }

        // Obtener el usuario con su contraseña
        $sql = "SELECT password FROM {$this->table} WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $userId]);
        $user = $stmt->fetch();

        if (!$user) {
            return false;
        }

        // Verificar que la contraseña actual sea correcta
        if (!password_verify($currentPassword, $user['password'])) {
            return false;
        }

        // Actualizar con la nueva contraseña hasheada
        $sql = "UPDATE {$this->table} SET password = :password WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        
        return $stmt->execute([
            ':password' => password_hash($newPassword, PASSWORD_DEFAULT),
            ':id' => $userId
        ]);
    }
}
