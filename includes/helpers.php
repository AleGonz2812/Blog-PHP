<?php
/**
 * Funciones Helper - Utilidades Generales
 * 
 * Funciones auxiliares para validación, saneamiento y utilidades comunes.
 */

/**
 * Sanitizar texto para mostrar en HTML
 * Previene ataques XSS
 * 
 * @param string $text Texto a sanear
 * @return string Texto seguro para HTML
 */
function sanitize($text): string {
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

/**
 * Redirigir a una URL
 * 
 * @param string $url URL de destino
 * @return void
 */
function redirect(string $url): void {
    header("Location: " . $url);
    exit();
}

/**
 * Verificar si el usuario está autenticado
 * Si no lo está, redirige al login
 * 
 * @return void
 */
function requireLogin(): void {
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        redirect('/Blog-PHP/login.php');
    }
}

/**
 * Validar formato de email
 * 
 * @param string $email Email a validar
 * @return bool True si es válido
 */
function isValidEmail(string $email): bool {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Generar nombre único para archivo
 * 
 * @param string $originalName Nombre original del archivo
 * @return string Nombre único generado
 */
function generateUniqueFileName(string $originalName): string {
    $extension = pathinfo($originalName, PATHINFO_EXTENSION);
    return uniqid('img_', true) . '.' . $extension;
}

/**
 * Validar extensión de archivo
 * 
 * @param string $fileName Nombre del archivo
 * @param array $allowedExtensions Extensiones permitidas
 * @return bool True si la extensión es válida
 */
function isValidFileExtension(string $fileName, array $allowedExtensions): bool {
    $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    return in_array($extension, $allowedExtensions);
}

/**
 * Formatear fecha para mostrar
 * 
 * @param string $date Fecha en formato SQL
 * @return string Fecha formateada
 */
function formatDate(string $date): string {
    $timestamp = strtotime($date);
    return date('d/m/Y H:i', $timestamp);
}

/**
 * Truncar texto a cierto número de palabras
 * 
 * @param string $text Texto completo
 * @param int $words Número de palabras
 * @return string Texto truncado
 */
function truncateText(string $text, int $words = 50): string {
    $textArray = explode(' ', $text);
    
    if (count($textArray) <= $words) {
        return $text;
    }
    
    return implode(' ', array_slice($textArray, 0, $words)) . '...';
}

/**
 * Mostrar mensaje flash desde la sesión
 * 
 * @param string $key Clave del mensaje en sesión
 * @return string|null Mensaje o null
 */
function getFlashMessage(string $key): ?string {
    if (isset($_SESSION[$key])) {
        $message = $_SESSION[$key];
        unset($_SESSION[$key]);
        return $message;
    }
    return null;
}

/**
 * Establecer mensaje flash en sesión
 * 
 * @param string $key Clave del mensaje
 * @param string $message Mensaje
 * @return void
 */
function setFlashMessage(string $key, string $message): void {
    $_SESSION[$key] = $message;
}

/**
 * Generar URL limpia (slug) desde un título
 * 
 * @param string $text Texto a convertir
 * @return string Slug generado
 */
function generateSlug(string $text): string {
    // Convertir a minúsculas
    $text = strtolower($text);
    
    // Reemplazar caracteres especiales
    $text = str_replace(
        ['á', 'é', 'í', 'ó', 'ú', 'ñ'],
        ['a', 'e', 'i', 'o', 'u', 'n'],
        $text
    );
    
    // Eliminar caracteres no alfanuméricos
    $text = preg_replace('/[^a-z0-9\s-]/', '', $text);
    
    // Reemplazar espacios y guiones múltiples con un solo guión
    $text = preg_replace('/[\s-]+/', '-', $text);
    
    // Eliminar guiones al inicio y final
    return trim($text, '-');
}

/**
 * Debug: Mostrar variable con formato
 * Solo funciona si DEBUG_MODE está activo
 * 
 * @param mixed $var Variable a mostrar
 * @param bool $die Si debe terminar la ejecución
 * @return void
 */
function dd($var, bool $die = true): void {
    if (DEBUG_MODE) {
        echo '<pre>';
        var_dump($var);
        echo '</pre>';
        
        if ($die) {
            die();
        }
    }
}
