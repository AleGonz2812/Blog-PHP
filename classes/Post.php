<?php
/**
 * Clase Post - Gestión de Publicaciones del Blog
 * 
 * Implementa operaciones CRUD (Create, Read, Update, Delete) para posts.
 */

require_once __DIR__ . '/Database.php';

class Post {
    private $conn;
    private $table = 'posts';

    // Propiedades del post
    public $id;
    public $title;
    public $content;
    public $image;
    public $user_id;
    public $created_at;
    public $updated_at;

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }

    /**
     * Crear una nueva publicación
     * 
     * @param string $title Título del post
     * @param string $content Contenido del post
     * @param int $userId ID del usuario autor
     * @param string|null $image Ruta de la imagen (opcional)
     * @return int|false ID del post creado o false si falla
     */
    public function create(string $title, string $content, int $userId, ?string $image = null) {
        // Saneamiento
        $cleanTitle = trim($title);
        $cleanContent = trim($content);

        // Validaciones
        if (empty($cleanTitle) || empty($cleanContent)) {
            return false;
        }

        if (strlen($cleanTitle) > 150) {
            return false;
        }

        try {
            $sql = "INSERT INTO {$this->table} (title, content, user_id, image) 
                    VALUES (:title, :content, :user_id, :image)";
            
            $stmt = $this->conn->prepare($sql);
            
            $success = $stmt->execute([
                ':title' => $cleanTitle,
                ':content' => $cleanContent,
                ':user_id' => $userId,
                ':image' => $image
            ]);

            // Retornar el ID del post creado
            return $success ? (int)$this->conn->lastInsertId() : false;
        } catch (PDOException $e) {
            if (DEBUG_MODE) {
                echo "Error al crear post: " . $e->getMessage();
            }
            return false;
        }
    }

    /**
     * Obtener un post por su ID
     * 
     * @param int $id ID del post
     * @return array|null Array con datos del post o null si no existe
     */
    public function getById(int $id): ?array {
        $sql = "SELECT p.*, u.username as author 
                FROM {$this->table} p
                INNER JOIN users u ON p.user_id = u.id
                WHERE p.id = :id 
                LIMIT 1";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        
        $post = $stmt->fetch();
        return $post ?: null;
    }

    /**
     * Obtener todos los posts (con paginación)
     * 
     * @param int $limit Número de posts por página
     * @param int $offset Desde qué post empezar
     * @return array Array de posts
     */
    public function getAll(int $limit = 10, int $offset = 0): array {
        $sql = "SELECT p.*, u.username as author 
                FROM {$this->table} p
                INNER JOIN users u ON p.user_id = u.id
                ORDER BY p.created_at DESC
                LIMIT :limit OFFSET :offset";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    /**
     * Obtener posts de un usuario específico
     * 
     * @param int $userId ID del usuario
     * @param int $limit Límite de posts
     * @return array Array de posts del usuario
     */
    public function getByUserId(int $userId, int $limit = 10): array {
        $sql = "SELECT p.*, u.username as author 
                FROM {$this->table} p
                INNER JOIN users u ON p.user_id = u.id
                WHERE p.user_id = :user_id
                ORDER BY p.created_at DESC
                LIMIT :limit";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    /**
     * Actualizar un post existente
     * 
     * @param int $id ID del post a actualizar
     * @param string $title Nuevo título
     * @param string $content Nuevo contenido
     * @param string|null $image Nueva imagen (opcional)
     * @return bool True si se actualizó correctamente
     */
    public function update(int $id, string $title, string $content, ?string $image = null): bool {
        // Saneamiento
        $cleanTitle = trim($title);
        $cleanContent = trim($content);

        // Validaciones
        if (empty($cleanTitle) || empty($cleanContent)) {
            return false;
        }

        try {
            // Si se proporciona imagen, actualizarla también
            if ($image !== null) {
                $sql = "UPDATE {$this->table} 
                        SET title = :title, content = :content, image = :image 
                        WHERE id = :id";
                $params = [
                    ':title' => $cleanTitle,
                    ':content' => $cleanContent,
                    ':image' => $image,
                    ':id' => $id
                ];
            } else {
                $sql = "UPDATE {$this->table} 
                        SET title = :title, content = :content 
                        WHERE id = :id";
                $params = [
                    ':title' => $cleanTitle,
                    ':content' => $cleanContent,
                    ':id' => $id
                ];
            }

            $stmt = $this->conn->prepare($sql);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            if (DEBUG_MODE) {
                echo "Error al actualizar post: " . $e->getMessage();
            }
            return false;
        }
    }

    /**
     * Eliminar un post
     * 
     * @param int $id ID del post a eliminar
     * @return bool True si se eliminó correctamente
     */
    public function delete(int $id): bool {
        try {
            // Primero obtener la imagen para eliminarla del servidor
            $post = $this->getById($id);
            
            if ($post && $post['image']) {
                $imagePath = UPLOADS_PATH . '/' . $post['image'];
                if (file_exists($imagePath)) {
                    unlink($imagePath); // Eliminar archivo físico
                }
            }

            // Eliminar el registro de la BD
            $sql = "DELETE FROM {$this->table} WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            if (DEBUG_MODE) {
                echo "Error al eliminar post: " . $e->getMessage();
            }
            return false;
        }
    }

    /**
     * Contar el total de posts
     * 
     * @return int Número total de posts
     */
    public function count(): int {
        $sql = "SELECT COUNT(*) as total FROM {$this->table}";
        $stmt = $this->conn->query($sql);
        $result = $stmt->fetch();
        
        return (int)$result['total'];
    }

    /**
     * Buscar posts por título
     * 
     * @param string $searchTerm Término de búsqueda
     * @return array Array de posts que coinciden
     */
    public function search(string $searchTerm): array {
        $sql = "SELECT p.*, u.username as author 
                FROM {$this->table} p
                INNER JOIN users u ON p.user_id = u.id
                WHERE p.title LIKE :search OR p.content LIKE :search
                ORDER BY p.created_at DESC";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':search' => '%' . $searchTerm . '%']);
        
        return $stmt->fetchAll();
    }
}
