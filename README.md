# 🚀 Blog CMS - Sistema de Gestión de Contenido

![PHP](https://img.shields.io/badge/PHP-7.4+-777BB4?style=flat&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0+-4479A1?style=flat&logo=mysql&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green.svg)
![Status](https://img.shields.io/badge/Status-Active-success.svg)

Sistema de gestión de contenido (CMS) para blog personal desarrollado en **PHP puro** con arquitectura MVC, diseño futurista oscuro y funcionalidades completas de CRUD.

> 💡 **Proyecto Académico** - Sistema completo de blog con autenticación, CRUD de posts, gestión de imágenes y diseño moderno.

---

## ✨ Características Principales

### 🎨 Interfaz Moderna
- **Diseño Dark Futurista** con efectos de glassmorphism
- Paleta de colores: Cyan (#00d9ff), Púrpura (#7b2cbf), Rosa (#ff006e)
- Efectos de brillo y animaciones suaves
- Responsive y adaptable a dispositivos móviles

### 🔐 Sistema de Autenticación
- ✅ Registro e inicio de sesión seguro
- ✅ Hash de contraseñas con `password_hash()` y bcrypt
- ✅ Gestión de sesiones
- ✅ Protección contra SQL Injection
- ✅ Validación de datos en cliente y servidor

### 📝 Gestión de Posts
- ✅ **CRUD completo** (Crear, Leer, Actualizar, Eliminar)
- ✅ Subida de imágenes con validación
- ✅ Editor de contenido con vista previa
- ✅ Modal de confirmación para eliminación
- ✅ Asociación de posts con usuarios autores
- ✅ Visualización optimizada de imágenes

### 🗄️ Base de Datos
- ✅ PDO con sentencias preparadas
- ✅ Patrón Singleton para conexión
- ✅ Migraciones SQL incluidas
- ✅ Datos de ejemplo para testing

## 🎯 Arquitectura

El proyecto implementa el patrón **MVC (Modelo-Vista-Controlador)** de forma clara y organizada:

```
┌─────────────┐      ┌──────────────┐      ┌─────────────┐
│   Router    │─────▶│ Controller   │─────▶│    Model    │
│  (Rutas)    │      │  (Lógica)    │      │  (Datos)    │
└─────────────┘      └──────────────┘      └─────────────┘
                             │
                             ▼
                      ┌─────────────┐
                      │    View     │
                      │    (UI)     │
                      └─────────────┘
```

### Componentes
- **Router**: Manejo de rutas dinámicas con parámetros
- **Controladores**: Lógica de negocio y validaciones
- **Modelos**: Interacción con base de datos (PDO)
- **Vistas**: Templates PHP con separación de layouts

## 📁 Estructura del Proyecto

```
Blog-PHP/
├── app/                          # 🎯 Núcleo de la aplicación
│   ├── controllers/              # Controladores MVC
│   │   ├── BaseController.php   # Controlador base con métodos comunes
│   │   ├── AuthController.php   # Autenticación y registro
│   │   ├── HomeController.php   # Página principal y visualización
│   │   └── PostController.php   # CRUD de publicaciones
│   │
│   ├── models/                   # Modelos de datos
│   │   ├── Database.php         # Singleton PDO
│   │   ├── User.php             # Gestión de usuarios
│   │   ├── Post.php             # Gestión de posts
│   │   └── FileUpload.php       # Manejo de archivos
│   │
│   ├── views/                    # Templates y vistas
│   │   ├── layouts/
│   │   │   └── main.php         # Layout principal
│   │   ├── auth/
│   │   │   ├── login.php        # Formulario de login
│   │   │   └── register.php     # Formulario de registro
│   │   └── posts/
│   │       ├── index.php        # Lista de posts
│   │       ├── show.php         # Detalle de post
│   │       ├── create.php       # Crear post
│   │       └── edit.php         # Editar post
│   │
│   └── Router.php                # Sistema de enrutamiento
│
├── config/
│   └── config.php                # Configuración global
│
├── database/                     # 🗄️ Scripts SQL
│   ├── schema.sql               # Estructura de BD
│   └── sample_data.sql          # Datos de ejemplo
│
├── public/                       # 🌐 Archivos públicos
│   ├── css/
│   │   ├── style.css            # Estilos principales
│   │   └── auth.css             # Estilos de autenticación
│   ├── js/
│   │   └── main.js              # JavaScript general
│   ├── images/                  # Imágenes estáticas
│   ├── .htaccess                # Reescritura de URLs
│   └── index.php                # Punto de entrada
│
├── uploads/                      # 📁 Archivos subidos por usuarios
│
└── README.md                     # Documentación
```

## 🛠️ Tecnologías y Herramientas

| Categoría | Tecnología |
|-----------|-----------|
| **Backend** | PHP 7.4+ (POO, PDO) |
| **Base de Datos** | MySQL 8.0 / MariaDB 10.2+ |
| **Frontend** | HTML5, CSS3, JavaScript (Vanilla) |
| **Servidor** | Apache 2.4 / Nginx |
| **Control de Versiones** | Git & GitHub |

### Características de PHP Utilizadas
- ✅ Programación Orientada a Objetos (POO)
- ✅ PDO (PHP Data Objects)
- ✅ Namespaces y Autoloading
- ✅ Sesiones y Cookies
- ✅ Manejo de archivos
- ✅ Validación y sanitización
- ✅ Password hashing (bcrypt)

## 📋 Requisitos del Sistema

- **PHP** >= 7.4
- **MySQL** >= 5.7 o **MariaDB** >= 10.2
- **Apache** 2.4+ con `mod_rewrite` activado
- Extensiones PHP:
  - `pdo`
  - `pdo_mysql`
  - `gd` (procesamiento de imágenes)
  - `fileinfo` (validación de archivos)

## 🚀 Instalación y Configuración

### Método 1: Con XAMPP (Recomendado para Windows)

1. **Clonar el repositorio**
```bash
cd C:\xampp\htdocs
git clone https://github.com/tu-usuario/Blog-PHP.git
cd Blog-PHP
```

2. **Crear la base de datos**
   - Abre **phpMyAdmin**: `http://localhost/phpmyadmin`
   - Crea una nueva base de datos llamada `blog_php`
   - Ve a la pestaña **SQL** e importa los archivos en orden:
     1. `database/schema.sql` (estructura)
     2. `database/sample_data.sql` (datos de ejemplo)

3. **Configurar credenciales**
   
   Edita `config/config.php`:
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'blog_php');
define('DB_USER', 'root');
define('DB_PASS', '');  // Vacío por defecto en XAMPP
define('BASE_URL', 'http://localhost/Blog-PHP/public');
```

4. **Dar permisos a uploads**
```bash
# En Windows, verifica que la carpeta uploads existe
# Si no, créala manualmente
```

5. **Acceder al proyecto**
   - URL: `http://localhost/Blog-PHP/public`
   - Login: `admin` / `password`

### Método 2: Con servidor PHP integrado

1. **Clonar y configurar**
```bash
git clone https://github.com/tu-usuario/Blog-PHP.git
cd Blog-PHP
```

2. **Crear base de datos**
```bash
mysql -u root -p
CREATE DATABASE blog_php;
USE blog_php;
SOURCE database/schema.sql;
SOURCE database/sample_data.sql;
EXIT;
```

3. **Configurar `config/config.php`**
```php
define('BASE_URL', 'http://localhost:8000');
```

4. **Iniciar servidor**
```bash
cd public
php -S localhost:8000
```

5. **Acceder**
   - URL: `http://localhost:8000`
   - Login: `admin` / `password`

## 🔑 Credenciales de Prueba

| Usuario | Contraseña | Rol |
|---------|------------|-----|
| admin | password | Administrador |

## 📖 Uso del Sistema

### Crear un Nuevo Post

1. Inicia sesión con tu cuenta
2. Haz clic en **"Crear Nueva Publicación"**
3. Rellena el formulario:
   - **Título**: Mínimo 5 caracteres
   - **Contenido**: Mínimo 10 caracteres
   - **Imagen** (opcional): JPG, PNG, GIF (máx 5MB)
4. Click en **"Publicar"**

### Editar un Post

1. Entra al detalle del post que creaste
2. Click en **"✏️ Editar"**
3. Modifica los campos necesarios
4. Click en **"Actualizar"**

### Eliminar un Post

1. Entra al detalle del post
2. Click en **"🗑️ Eliminar"**
3. Confirma en el modal personalizado
4. El post se eliminará junto con su imagen

## 🔒 Características de Seguridad

| Característica | Implementación |
|---------------|----------------|
| **SQL Injection** | Sentencias preparadas (PDO) |
| **XSS** | `htmlspecialchars()` en todas las salidas |
| **Contraseñas** | `password_hash()` con bcrypt |
| **Sesiones** | Regeneración de ID tras login |
| **CSRF** | Validación de origen (pendiente tokens) |
| **Archivos** | Validación de tipo MIME y extensión |

## 🎨 Personalización

### Cambiar Colores del Tema

Edita `public/css/style.css`:

```css
:root {
    --primary: #00d9ff;      /* Cyan */
    --secondary: #7b2cbf;    /* Púrpura */
    --accent: #ff006e;       /* Rosa */
    --dark: #0a0e27;         /* Fondo oscuro */
    --text: #e0e7ff;         /* Texto claro */
}
```

### Agregar Nuevas Rutas

Edita `public/index.php`:

```php
$router->get('/mi-ruta', function() {
    $controller = new MiController();
    $controller->miMetodo();
});
```

## 📚 Conceptos de PHP Implementados

### 1. Patrón Singleton
```php
class Database {
    private static $instance = null;
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}
```

### 2. Sentencias Preparadas
```php
$stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
$stmt->execute([':username' => $username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
```

### 3. Hash de Contraseñas
```php
// Crear hash
$hash = password_hash($password, PASSWORD_DEFAULT);

// Verificar
if (password_verify($password, $hash)) {
    // Contraseña correcta
}
```

### 4. Enrutamiento Dinámico
```php
$router->get('/post/{id}', function($id) {
    // $id se extrae automáticamente de la URL
});
```

## 🐛 Solución de Problemas

### Error: "Call to undefined function password_hash()"
- **Solución**: Actualiza PHP a versión 5.5 o superior

### Error: "Connection refused"
- **Solución**: Verifica que MySQL/Apache estén ejecutándose en XAMPP

### Error: "404 Not Found" en todas las rutas
- **Solución**: Activa `mod_rewrite` en Apache
```bash
sudo a2enmod rewrite
sudo service apache2 restart
```

### Las imágenes no se suben
- **Solución**: Verifica permisos de la carpeta `uploads/`
```bash
chmod 755 uploads/
```

## 🤝 Contribuciones

Las contribuciones son bienvenidas. Para cambios importantes:

1. Fork el proyecto
2. Crea una rama (`git checkout -b feature/NuevaCaracteristica`)
3. Commit tus cambios (`git commit -m 'Agregar nueva característica'`)
4. Push a la rama (`git push origin feature/NuevaCaracteristica`)
5. Abre un Pull Request

## 📝 Licencia

Este proyecto es de código abierto bajo la licencia MIT.

## 👨‍💻 Autor

**Proyecto Académico** - Desarrollo Web con PHP

---

⭐ Si este proyecto te fue útil, considera darle una estrella en GitHub

📧 Reporta bugs o sugerencias en [Issues](https://github.com/tu-usuario/Blog-PHP/issues)
