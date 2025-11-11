<?php
/**
 * Clase Database - Gestión de Conexión a Base de Datos
 * 
 * Implementa el patrón Singleton para asegurar una única conexión PDO.
 * Utiliza constantes del archivo config.php para las credenciales.
 */

require_once ROOT_PATH . '/config/config.php';

class Database {
    private static $instance = null;
    private $conn;

    /**
     * Constructor privado (patrón Singleton)
     * Esto evita que se creen múltiples instancias de la clase
     */
    private function __construct() {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";

        try {
            $this->conn = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        } catch (PDOException $e) {
            if (DEBUG_MODE) {
                die("Error de conexión: " . $e->getMessage());
            } else {
                die("Error de conexión a la base de datos.");
            }
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->conn;
    }

    private function __clone() {}

    public function __wakeup() {
        throw new Exception("No se puede deserializar un Singleton.");
    }
}
