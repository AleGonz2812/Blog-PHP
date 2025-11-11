# 🎓 Guía de Uso - Blog CMS con MVC

## 📖 Estructura del Proyecto MVC

El proyecto ahora sigue la arquitectura **MVC (Modelo-Vista-Controlador)**:

```
Blog-PHP/
├── app/                          # Aplicación principal
│   ├── controllers/              # Controladores (lógica de negocio)
│   │   ├── BaseController.php    # Controlador base
│   │   ├── AuthController.php    # Autenticación
│   │   └── HomeController.php    # Página principal
│   ├── models/                   # Modelos (interacción con BD)
│   │   ├── Database.php          # Conexión a BD
│   │   ├── User.php              # Modelo Usuario
│   │   ├── Post.php              # Modelo Post
│   │   └── FileUpload.php        # Gestión de archivos
│   ├── views/                    # Vistas (HTML/UI)
│   │   ├── layouts/              # Plantillas base
│   │   │   └── main.php          # Layout principal
│   │   ├── auth/                 # Vistas de autenticación
│   │   │   ├── login.php         # Formulario login
│   │   │   └── register.php      # Formulario registro
│   │   └── posts/                # Vistas de posts
│   │       ├── index.php         # Listado de posts
│   │       └── show.php          # Detalle de post
│   └── Router.php                # Sistema de enrutamiento
├── config/
│   └── config.php                # Configuración
├── public/                       # Archivos públicos (accesibles)
│   ├── css/
│   │   ├── style.css             # Estilos principales
│   │   └── auth.css              # Estilos de autenticación
│   ├── js/
│   │   └── main.js               # JavaScript
│   ├── images/                   # Imágenes del sitio
│   ├── .htaccess                 # Reescritura de URLs
│   └── index.php                 # Punto de entrada ÚNICO
├── database/
│   └── schema.sql                # Estructura de BD
└── uploads/                      # Archivos subidos
```

## 🚀 Instalación y Configuración

### 1. Configurar la Base de Datos

Ejecuta el archivo SQL para crear las tablas:
```bash
mysql -u root -p < database/schema.sql
```

### 2. Configurar Credenciales

Edita `config/config.php` y ajusta:
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'blog_php');
define('DB_USER', 'root');
define('DB_PASS', ''); // Tu contraseña de MySQL
```

### 3. Configurar URL Base

En `config/config.php`, ajusta la URL según tu entorno:
```php
// Para desarrollo local con XAMPP/WAMP
define('BASE_URL', 'http://localhost/Blog-PHP/public');

// Para servidor PHP integrado
define('BASE_URL', 'http://localhost:8000');
```

### 4. Iniciar el Servidor

#### Opción A: PHP Built-in Server (Recomendado para desarrollo)
```bash
cd public
php -S localhost:8000
```
Accede a: `http://localhost:8000`

#### Opción B: XAMPP/WAMP
- Copia el proyecto a `htdocs/Blog-PHP`
- Accede a: `http://localhost/Blog-PHP/public`

## 📝 Rutas Disponibles

### Autenticación
- `GET /login` - Mostrar formulario de login
- `POST /login` - Procesar login
- `GET /register` - Mostrar formulario de registro
- `POST /register` - Procesar registro
- `GET /logout` - Cerrar sesión

### Posts
- `GET /` - Página principal (listado de posts)
- `GET /post/{id}` - Ver detalle de un post

## 🎨 Conceptos MVC Implementados

### 🔷 Modelo (Model)
Los modelos interactúan con la base de datos:

```php
// Ejemplo: app/models/User.php
class User {
    public function login($username, $password) {
        // Lógica de autenticación
    }
}
```

### 🔷 Vista (View)
Las vistas solo muestran información (HTML):

```php
// Ejemplo: app/views/posts/index.php
<h1><?= $title ?></h1>
<p><?= $content ?></p>
```

### 🔷 Controlador (Controller)
Los controladores conectan modelos y vistas:

```php
// Ejemplo: app/controllers/AuthController.php
class AuthController extends BaseController {
    public function login() {
        // 1. Obtener datos
        // 2. Validar
        // 3. Llamar al modelo
        // 4. Renderizar vista
    }
}
```

## 🔄 Flujo de una Petición

```
1. Usuario accede a: /login
   ↓
2. .htaccess redirige a: public/index.php
   ↓
3. Router.php busca la ruta: GET /login
   ↓
4. Llama a: AuthController->showLogin()
   ↓
5. Controlador renderiza: views/auth/login.php
   ↓
6. Usuario ve el formulario
```

## 📊 Ejemplo de Uso Completo

### Crear un nuevo Post (futuro)

**1. Ruta en `public/index.php`:**
```php
$router->get('/posts/create', function() {
    $controller = new PostController();
    $controller->create();
});
```

**2. Controlador `PostController.php`:**
```php
class PostController extends BaseController {
    public function create() {
        $this->requireAuth(); // Verificar login
        $this->view('posts/create', [
            'currentUser' => $this->userModel->getCurrentUser()
        ]);
    }
}
```

**3. Vista `posts/create.php`:**
```php
<form method="POST" action="/posts">
    <input name="title" placeholder="Título">
    <textarea name="content"></textarea>
    <button type="submit">Publicar</button>
</form>
```

## 🛡️ Seguridad Implementada

- ✅ **PDO con sentencias preparadas** → Previene SQL Injection
- ✅ **password_hash/verify** → Contraseñas seguras
- ✅ **htmlspecialchars** → Previene XSS
- ✅ **session_regenerate_id** → Previene session fixation
- ✅ **Validación de datos** → Entrada segura

## 💡 Tips para Desarrollo

### Añadir nueva ruta
1. Edita `public/index.php`
2. Añade la ruta con el router
3. Crea el método en el controlador
4. Crea la vista correspondiente

### Debugging
Activa el modo debug en `config/config.php`:
```php
define('DEBUG_MODE', true);
```

### Mensajes Flash
```php
// En controlador
$_SESSION['success'] = 'Operación exitosa';
$_SESSION['error'] = 'Hubo un error';

// Se muestran automáticamente en las vistas
```

## 📚 Recursos de Aprendizaje

- **MVC Pattern**: Separación de responsabilidades
- **PDO**: Abstracción de base de datos
- **Router**: URLs limpias y amigables
- **Sessions**: Mantener estado del usuario
- **OOP**: Código reutilizable y mantenible

## 🔮 Próximas Funcionalidades

- [ ] CRUD completo de posts (crear, editar, eliminar)
- [ ] Panel de administración
- [ ] Comentarios en posts
- [ ] Búsqueda de posts
- [ ] Perfil de usuario
- [ ] Likes/favoritos

---

**¡Feliz desarrollo! 🚀**
