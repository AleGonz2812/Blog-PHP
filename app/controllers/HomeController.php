<?php
/**
 * HomeController - Controlador Principal
 * 
 * Maneja la página principal y listado de posts.
 */

require_once APP_PATH . '/controllers/BaseController.php';
require_once APP_PATH . '/models/Post.php';
require_once APP_PATH . '/models/User.php';

class HomeController extends BaseController {
    private $postModel;
    private $userModel;

    public function __construct() {
        $this->postModel = new Post();
        $this->userModel = new User();
    }

    /**
     * Página principal - Listado de posts
     */
    public function index() {
        // Obtener página actual para paginación
        $page = $_GET['page'] ?? 1;
        $limit = 6; // Posts por página
        $offset = ($page - 1) * $limit;

        // Obtener posts
        $posts = $this->postModel->getAll($limit, $offset);
        $totalPosts = $this->postModel->count();
        $totalPages = ceil($totalPosts / $limit);

        // Usuario actual (si está logueado)
        $currentUser = $this->userModel->isLoggedIn() 
            ? $this->userModel->getCurrentUser() 
            : null;

        $this->view('posts/index', [
            'posts' => $posts,
            'currentUser' => $currentUser,
            'currentPage' => $page,
            'totalPages' => $totalPages
        ]);
    }

    /**
     * Ver detalle de un post
     */
    public function show($id) {
        $post = $this->postModel->getById($id);

        if (!$post) {
            $_SESSION['error'] = 'Post no encontrado.';
            $this->redirect('/');
        }

        $currentUser = $this->userModel->isLoggedIn() 
            ? $this->userModel->getCurrentUser() 
            : null;

        $this->view('posts/show', [
            'post' => $post,
            'currentUser' => $currentUser
        ]);
    }
}
