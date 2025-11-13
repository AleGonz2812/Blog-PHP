<?php
/**
 * Controlador de Posts
 * Maneja todas las operaciones CRUD de publicaciones
 */

require_once APP_PATH . '/controllers/BaseController.php';
require_once APP_PATH . '/models/Post.php';
require_once APP_PATH . '/models/FileUpload.php';

class PostController extends BaseController
{
    private $postModel;

    public function __construct()
    {
        $this->postModel = new Post();
    }

    /**
     * Mostrar formulario para crear nuevo post
     */
    public function create()
    {
        $this->requireAuth();
        
        $this->render('posts/create', [
            'title' => 'Crear Nueva Publicación'
        ]);
    }

    /**
     * Guardar nuevo post en la base de datos
     */
    public function store()
    {
        $this->requireAuth();

        // Validar campos requeridos
        if (empty($_POST['title']) || empty($_POST['content'])) {
            $_SESSION['error'] = 'El título y el contenido son obligatorios';
            $this->redirect('/posts/create');
            return;
        }

        $title = trim($_POST['title']);
        $content = trim($_POST['content']);
        $userId = $_SESSION['user_id'];
        $imagePath = null;

        // Procesar imagen si se subió
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $fileUpload = new FileUpload();
            $result = $fileUpload->upload($_FILES['image']);
            
            if ($result['success']) {
                $imagePath = $result['filename'];
            } else {
                $_SESSION['error'] = $result['message'];
                $this->redirect('/posts/create');
                return;
            }
        }

        // Crear el post
        try {
            $postId = $this->postModel->create($title, $content, $userId, $imagePath);
            
            if ($postId) {
                $_SESSION['success'] = '✅ Publicación creada exitosamente';
                $this->redirect('/post/' . $postId);
            } else {
                $_SESSION['error'] = 'Error al crear la publicación';
                $this->redirect('/posts/create');
            }
        } catch (Exception $e) {
            $_SESSION['error'] = 'Error: ' . $e->getMessage();
            $this->redirect('/posts/create');
        }
    }

    /**
     * Mostrar formulario para editar post
     */
    public function edit($id)
    {
        $this->requireAuth();

        $post = $this->postModel->findById($id);

        if (!$post) {
            $_SESSION['error'] = 'Publicación no encontrada';
            $this->redirect('/');
            return;
        }

        // Verificar que el usuario sea el autor
        if ($post['user_id'] != $_SESSION['user_id']) {
            $_SESSION['error'] = 'No tienes permiso para editar esta publicación';
            $this->redirect('/');
            return;
        }

        $this->render('posts/edit', [
            'title' => 'Editar Publicación',
            'post' => $post
        ]);
    }

    /**
     * Actualizar post existente
     */
    public function update($id)
    {
        $this->requireAuth();

        $post = $this->postModel->findById($id);

        if (!$post || $post['user_id'] != $_SESSION['user_id']) {
            $_SESSION['error'] = 'No tienes permiso para editar esta publicación';
            $this->redirect('/');
            return;
        }

        // Validar campos
        if (empty($_POST['title']) || empty($_POST['content'])) {
            $_SESSION['error'] = 'El título y el contenido son obligatorios';
            $this->redirect('/posts/edit/' . $id);
            return;
        }

        $title = trim($_POST['title']);
        $content = trim($_POST['content']);
        $imagePath = $post['image']; // Mantener imagen actual por defecto

        // Procesar nueva imagen si se subió
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $fileUpload = new FileUpload();
            $result = $fileUpload->upload($_FILES['image']);
            
            if ($result['success']) {
                // Eliminar imagen anterior si existe
                if ($post['image'] && file_exists(UPLOADS_PATH . '/' . $post['image'])) {
                    unlink(UPLOADS_PATH . '/' . $post['image']);
                }
                $imagePath = $result['filename'];
            }
        }

        // Actualizar post
        try {
            $updated = $this->postModel->update($id, $title, $content, $imagePath);
            
            if ($updated) {
                $_SESSION['success'] = '✅ Publicación actualizada exitosamente';
                $this->redirect('/post/' . $id);
            } else {
                $_SESSION['error'] = 'Error al actualizar la publicación';
                $this->redirect('/posts/edit/' . $id);
            }
        } catch (Exception $e) {
            $_SESSION['error'] = 'Error: ' . $e->getMessage();
            $this->redirect('/posts/edit/' . $id);
        }
    }

    /**
     * Eliminar post
     */
    public function delete($id)
    {
        $this->requireAuth();

        // Verificar que sea una petición POST para evitar eliminaciones accidentales
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error'] = 'Método no permitido';
            $this->redirect('/');
            return;
        }

        $post = $this->postModel->findById($id);

        if (!$post || $post['user_id'] != $_SESSION['user_id']) {
            $_SESSION['error'] = 'No tienes permiso para eliminar esta publicación';
            $this->redirect('/');
            return;
        }

        // Eliminar imagen si existe
        if ($post['image'] && file_exists(UPLOADS_PATH . '/' . $post['image'])) {
            unlink(UPLOADS_PATH . '/' . $post['image']);
        }

        // Eliminar post
        try {
            $deleted = $this->postModel->delete($id);
            
            if ($deleted) {
                $_SESSION['success'] = '✅ Publicación eliminada exitosamente';
            } else {
                $_SESSION['error'] = 'Error al eliminar la publicación';
            }
        } catch (Exception $e) {
            $_SESSION['error'] = 'Error: ' . $e->getMessage();
        }

        $this->redirect('/');
    }
}
