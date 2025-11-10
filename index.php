<?php
require_once __DIR__ . '/classes/Database.php';

$db = new Database();
$conn = $db->connect();

echo ($conn instanceof PDO) ? "Conexión correcta a blog_php" : "Conexión fallida";
