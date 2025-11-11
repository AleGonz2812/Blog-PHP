<?php
/**
 * Punto de Entrada de la Aplicación
 * 
 * Por ahora es una prueba simple de conexión.
 * Más adelante será el router principal.
 */

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/classes/Database.php';

try {
    $db = Database::getInstance();
    $conn = $db->getConnection();
    
    echo "<h2>✅ Conexión exitosa a la base de datos: " . DB_NAME . "</h2>";
    echo "<p>El sistema está listo para continuar.</p>";
} catch (Exception $e) {
    echo "<h2> Error de conexión</h2>";
    echo "<p>" . $e->getMessage() . "</p>";
}
