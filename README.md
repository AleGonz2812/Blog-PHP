# 📝 Blog CMS - Sistema de Gestión de Contenido en PHP

Sistema de gestión de contenido (CMS) para blog personal desarrollado en PHP puro, implementando POO, PDO, autenticación segura y arquitectura MVC.

## 🎯 Objetivo del Proyecto

Proyecto final de asignatura para dominar conceptos fundamentales de desarrollo web en PHP:
- Programación Orientada a Objetos (POO)
- Bases de datos con PDO y sentencias preparadas
- Sistema de autenticación y sesiones seguras
- Enrutamiento y URLs amigables
- Gestión de archivos y validación de datos
- Separación de lógica y presentación (MVC)

## 🚀 Características Implementadas

### ✅ Sistema de Base de Datos
- [x] Conexión PDO con patrón Singleton
- [x] Configuración centralizada
- [x] Manejo de errores y excepciones
- [x] Prevención de SQL Injection

### ✅ Gestión de Usuarios
- [x] Registro de usuarios con validación
- [x] Hash seguro de contraseñas (`password_hash`)
- [x] Sistema de login/logout
- [x] Gestión de sesiones
- [x] Cambio de contraseña

### ✅ Gestión de Posts
- [x] CRUD completo (Create, Read, Update, Delete)
- [x] Asociación con usuarios (autor)
- [x] Búsqueda de posts
- [x] Paginación
- [x] Timestamps automáticos

### ✅ Gestión de Archivos
- [x] Subida de imágenes
- [x] Validación de tipo y tamaño
- [x] Nombres únicos de archivo
- [x] Eliminación segura

### ⏳ En Desarrollo
- [ ] CRUD completo de posts
- [ ] Panel de administración
- [ ] Comentarios en posts
- [ ] Búsqueda avanzada

## 🎨 Arquitectura MVC

El proyecto sigue el patrón **Modelo-Vista-Controlador**:

- **Modelos** (`app/models/`): Interactúan con la base de datos
- **Vistas** (`app/views/`): Presentación HTML
- **Controladores** (`app/controllers/`): Lógica de negocio
- **Router** (`app/Router.php`): Enrutamiento de URLs

Lee la [**GUIA_MVC.md**](GUIA_MVC.md) para entender la arquitectura completa.

## 📁 Estructura del Proyecto

```
Blog-PHP/
├── app/                    # Aplicación MVC
│   ├── controllers/        # Controladores
│   │   ├── BaseController.php
│   │   ├── AuthController.php
│   │   └── HomeController.php
│   ├── models/             # Modelos (BD)
│   │   ├── Database.php
│   │   ├── User.php
│   │   ├── Post.php
│   │   └── FileUpload.php
│   ├── views/              # Vistas (HTML)
│   │   ├── layouts/
│   │   │   └── main.php
│   │   ├── auth/
│   │   │   ├── login.php
│   │   │   └── register.php
│   │   └── posts/
│   │       ├── index.php
│   │       └── show.php
│   └── Router.php          # Sistema de rutas
├── config/                 # Configuración
│   └── config.php
├── database/               # SQL
│   ├── schema.sql
│   └── sample_data.sql
├── includes/               # Helpers
│   └── helpers.php
├── public/                 # Archivos públicos
│   ├── css/
│   │   ├── style.css
│   │   └── auth.css
│   ├── js/
│   │   └── main.js
│   ├── images/
│   ├── .htaccess
│   └── index.php           # Punto de entrada
├── uploads/                # Archivos subidos
├── .gitignore
├── GUIA_MVC.md            # Guía de MVC
└── README.md
```

## 🛠️ Tecnologías Utilizadas

- **PHP 7.4+** - Lenguaje principal
- **MySQL 8.0** - Base de datos
- **PDO** - Capa de abstracción de BD
- **Git** - Control de versiones

## 📋 Requisitos

- PHP >= 7.4
- MySQL >= 5.7 o MariaDB >= 10.2
- Servidor web (Apache/Nginx) o PHP built-in server
- Extensiones PHP: `pdo`, `pdo_mysql`, `gd` (para imágenes)

## 🔧 Instalación

### 1. Clonar el repositorio
```bash
git clone <tu-repositorio>
cd Blog-PHP
```

### 2. Configurar la base de datos
```bash
# Crear la base de datos y tablas
mysql -u root -p < database/schema.sql

# (Opcional) Insertar datos de ejemplo
mysql -u root -p blog_php < database/sample_data.sql
```

### 3. Configurar credenciales
Edita `config/config.php` y ajusta las credenciales de tu base de datos:
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'blog_php');
define('DB_USER', 'tu_usuario');
define('DB_PASS', 'tu_contraseña');
define('BASE_URL', 'http://localhost:8000'); // Ajusta según tu entorno
```

### 4. Dar permisos a la carpeta uploads
```bash
chmod 755 uploads/
```

### 5. Iniciar servidor de desarrollo

#### Opción A: Servidor PHP integrado (Recomendado)
```bash
cd public
php -S localhost:8000
```
Accede a: `http://localhost:8000`

#### Opción B: XAMPP/WAMP
- Coloca el proyecto en `htdocs/Blog-PHP`
- Accede a: `http://localhost/Blog-PHP/public`

### 6. Credenciales de prueba
Si cargaste los datos de ejemplo:
- **Usuario**: `admin`
- **Contraseña**: `password`

## 🧪 Testing

Verifica que todo funciona: `http://localhost:8000/test.php`

## 📚 Conceptos de PHP Aprendidos

### Patrón Singleton
```php
$db = Database::getInstance();
```

### Sentencias Preparadas (PDO)
```php
$stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
$stmt->execute([':username' => $username]);
```

### Hash de Contraseñas
```php
password_hash($password, PASSWORD_DEFAULT);
password_verify($password, $hash);
```

## 🔒 Seguridad Implementada

- ✅ Contraseñas hasheadas
- ✅ Sentencias preparadas (prevención SQL Injection)
- ✅ Validación y saneamiento de datos
- ✅ Prevención XSS
- ✅ Regeneración de ID de sesión

---

**Proyecto Académico** - Noviembre 2025
