<?php
require_once __DIR__ . '/Database.php';

class User {
    private $conn;

    public function __construct() {
        $this->conn = (new Database())->connect();
    }

    // Método para registrar un nuevo usuario
    public function register(string $username, string $password, ?string $email = null): bool {
        // Validaciones básicas
        $username = trim($username);
        $email = $email ? trim($email) : null;
        if ($username === '' || $password === '') return false;

        // Comprobar si el usuario ya existe
        if ($this->findByUsername($username)) return false;

        // Preparar SQL
        $sql = "INSERT INTO users (username, password, email) VALUES (:username, :password, :email)";
        $stmt = $this->conn->prepare($sql);

        // Hashear la contraseña
        $hashed = password_hash($password, PASSWORD_DEFAULT);

        // Ejecutar
        return $stmt->execute([
            ':username' => $username,
            ':password' => $hashed,
            ':email'    => $email,
        ]);
    }

    // Método auxiliar para buscar usuario por nombre
    public function findByUsername(string $username) {
        $sql = "SELECT * FROM users WHERE username = :username LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':username' => $username]);
        return $stmt->fetch();
    }
}
