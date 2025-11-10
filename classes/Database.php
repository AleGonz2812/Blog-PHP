<?php
class Database {
    private $host = "localhost";
    private $db_name = "blog_php";
    private $username = "root"; // ajusta si usas otro usuario
    private $password = "";     // pon tu contraseña si la tienes
    private $conn;

    public function connect() {
        $this->conn = null;
        $dsn = "mysql:host={$this->host};dbname={$this->db_name};charset=utf8mb4";

        try {
            $this->conn = new PDO($dsn, $this->username, $this->password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }

        return $this->conn;
    }
}
