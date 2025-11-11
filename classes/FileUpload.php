<?php
/**
 * Clase FileUpload - Gestión de Subida de Archivos
 * 
 * Maneja la validación y subida de archivos (principalmente imágenes).
 */

class FileUpload {
    private $uploadDir;
    private $allowedExtensions;
    private $maxFileSize;
    private $errors = [];

    /**
     * Constructor
     * 
     * @param string $uploadDir Directorio donde se guardarán los archivos
     * @param array $allowedExtensions Extensiones permitidas
     * @param int $maxFileSize Tamaño máximo en bytes
     */
    public function __construct(
        string $uploadDir = UPLOADS_PATH,
        array $allowedExtensions = ALLOWED_EXTENSIONS,
        int $maxFileSize = MAX_FILE_SIZE
    ) {
        $this->uploadDir = $uploadDir;
        $this->allowedExtensions = $allowedExtensions;
        $this->maxFileSize = $maxFileSize;

        // Crear directorio si no existe
        if (!file_exists($this->uploadDir)) {
            mkdir($this->uploadDir, 0755, true);
        }
    }

    /**
     * Subir un archivo
     * 
     * @param array $file Array del archivo desde $_FILES
     * @return string|false Nombre del archivo guardado o false si falla
     */
    public function upload(array $file) {
        $this->errors = [];

        // Validar que se haya subido correctamente
        if (!isset($file['error']) || $file['error'] !== UPLOAD_ERR_OK) {
            $this->errors[] = "Error al subir el archivo.";
            return false;
        }

        // Validar tamaño
        if ($file['size'] > $this->maxFileSize) {
            $sizeMB = $this->maxFileSize / 1048576;
            $this->errors[] = "El archivo excede el tamaño máximo permitido ({$sizeMB}MB).";
            return false;
        }

        // Validar extensión
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($extension, $this->allowedExtensions)) {
            $this->errors[] = "Extensión de archivo no permitida. Permitidas: " . implode(', ', $this->allowedExtensions);
            return false;
        }

        // Validar que sea una imagen real
        $imageInfo = getimagesize($file['tmp_name']);
        if ($imageInfo === false) {
            $this->errors[] = "El archivo no es una imagen válida.";
            return false;
        }

        // Generar nombre único
        $newFileName = $this->generateUniqueFileName($extension);
        $destination = $this->uploadDir . '/' . $newFileName;

        // Mover archivo al destino
        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            $this->errors[] = "Error al guardar el archivo.";
            return false;
        }

        return $newFileName;
    }

    /**
     * Eliminar un archivo del servidor
     * 
     * @param string $fileName Nombre del archivo a eliminar
     * @return bool True si se eliminó correctamente
     */
    public function delete(string $fileName): bool {
        $filePath = $this->uploadDir . '/' . $fileName;
        
        if (file_exists($filePath)) {
            return unlink($filePath);
        }
        
        return false;
    }

    /**
     * Generar nombre único para archivo
     * 
     * @param string $extension Extensión del archivo
     * @return string Nombre único
     */
    private function generateUniqueFileName(string $extension): string {
        return uniqid('img_', true) . '.' . $extension;
    }

    /**
     * Obtener errores de validación
     * 
     * @return array Array de errores
     */
    public function getErrors(): array {
        return $this->errors;
    }

    /**
     * Obtener el primer error
     * 
     * @return string|null Mensaje de error o null
     */
    public function getError(): ?string {
        return $this->errors[0] ?? null;
    }

    /**
     * Validar dimensiones de imagen
     * 
     * @param array $file Array del archivo desde $_FILES
     * @param int $maxWidth Ancho máximo
     * @param int $maxHeight Alto máximo
     * @return bool True si las dimensiones son válidas
     */
    public function validateDimensions(array $file, int $maxWidth, int $maxHeight): bool {
        $imageInfo = getimagesize($file['tmp_name']);
        
        if ($imageInfo === false) {
            return false;
        }

        list($width, $height) = $imageInfo;

        if ($width > $maxWidth || $height > $maxHeight) {
            $this->errors[] = "Las dimensiones de la imagen exceden el máximo permitido ({$maxWidth}x{$maxHeight}px).";
            return false;
        }

        return true;
    }
}
