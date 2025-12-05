# 🚀 Blog CMS - Sistema de Gestión de Contenido

![PHP](https://img.shields.io/badge/PHP-7.4+-777BB4?style=flat&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0+-4479A1?style=flat&logo=mysql&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green.svg)

Sistema de blog desarrollado en **PHP puro** con arquitectura **MVC**, autenticación segura y CRUD completo de publicaciones.

---

## 📋 GUÍA RÁPIDA PARA LEVANTAR EL PROYECTO

### Requisitos Previos

- ✅ **XAMPP** instalado (incluye Apache, MySQL y PHP)
- ✅ **Git** instalado
- ✅ **MySQL Workbench** instalado (para gestionar la base de datos)

> 💡 Descargas:
> - XAMPP: https://www.apachefriends.org/es/index.html
> - MySQL Workbench: https://dev.mysql.com/downloads/workbench/

---

## 🚀 Instalación Paso a Paso

### Paso 1: Iniciar XAMPP

1. Abre el **Panel de Control de XAMPP**
2. Inicia **Apache** (clic en "Start")
3. Inicia **MySQL** (clic en "Start")

> Ambos servicios deben aparecer en verde

---

### Paso 2: Clonar el Repositorio

Abre una terminal (CMD o PowerShell) y ejecuta:

```bash
cd C:\xampp\htdocs
git clone https://github.com/AleGonz2812/Blog-PHP.git
```

> ⚠️ **Importante**: El proyecto debe quedar en `C:\xampp\htdocs\Blog-PHP`

---

### Paso 3: Crear la Base de Datos

1. Abre **MySQL Workbench**

2. Conéctate a tu servidor local (doble clic en "Local instance MySQL")

3. Crea la base de datos ejecutando este comando:
```sql
CREATE DATABASE blog_php;
```

4. Clic en el icono del **rayo ⚡** para ejecutar

---

### Paso 4: Importar las Tablas

1. En MySQL Workbench, selecciona la base de datos:
```sql
USE blog_php;
```

2. Abre el archivo `Blog-PHP/database/schema.sql`:
   - Ve a **File → Open SQL Script**
   - Navega a `C:\xampp\htdocs\Blog-PHP\database\schema.sql`
   - Clic en **Abrir**

3. Ejecuta el script (clic en el **rayo ⚡** o `Ctrl+Shift+Enter`)

4. **Repite el proceso** con el archivo `sample_data.sql`:
   - **File → Open SQL Script**
   - Selecciona `C:\xampp\htdocs\Blog-PHP\database\sample_data.sql`
   - Ejecuta con el **rayo ⚡**

> ✅ Esto carga el usuario admin y los posts de ejemplo

---

### Paso 5: Acceder al Proyecto

1. Abre el navegador
2. Ve a: **http://localhost/Blog-PHP/public**

🎉 **¡Listo! El proyecto debería estar funcionando.**

---

## 🔑 Credenciales de Acceso

| Usuario | Contraseña |
|---------|------------|
| `admin` | `password` |

---

## ✅ Funcionalidades para Probar

Una vez dentro, puedes probar:

### 👤 Autenticación
- Iniciar sesión con las credenciales de arriba
- Registrar un nuevo usuario
- Cerrar sesión (botón rojo "Salir")

### 📝 Gestión de Posts (requiere iniciar sesión)
- **Crear** una nueva publicación (botón "Crear Nueva Publicación")
- **Ver** el detalle de cualquier publicación (clic en "Leer más")
- **Editar** publicaciones propias (botón "Editar" en el detalle)
- **Eliminar** publicaciones propias (botón "Eliminar" con confirmación modal)

### 🖼️ Subida de Imágenes
- Al crear o editar un post, puedes subir una imagen
- Formatos permitidos: JPG, PNG, GIF
- Tamaño máximo: 5MB

---

## 🎨 Características Técnicas Implementadas

| Característica | Implementación |
|---------------|----------------|
| **Arquitectura** | MVC (Modelo-Vista-Controlador) |
| **Base de Datos** | MySQL con PDO y sentencias preparadas |
| **Contraseñas** | Hash seguro con bcrypt (`password_hash`) |
| **Prevención SQL Injection** | Sentencias preparadas (PDO) |
| **Prevención XSS** | `htmlspecialchars()` en todas las salidas |
| **Sesiones** | Manejo seguro con regeneración de ID |
| **Diseño** | CSS3 con tema oscuro futurista |
| **Patrón de Diseño** | Singleton para conexión a BD |

---

## 📁 Estructura del Proyecto

```
Blog-PHP/
│
├── app/                         # Núcleo MVC
│   ├── controllers/             # Controladores
│   │   ├── BaseController.php   # Métodos comunes
│   │   ├── AuthController.php   # Login/Registro
│   │   ├── HomeController.php   # Página principal
│   │   └── PostController.php   # CRUD de posts
│   │
│   ├── models/                  # Modelos (BD)
│   │   ├── Database.php         # Conexión Singleton
│   │   ├── User.php             # Usuarios
│   │   ├── Post.php             # Posts
│   │   └── FileUpload.php       # Subida de archivos
│   │
│   ├── views/                   # Vistas (HTML)
│   │   ├── layouts/main.php     # Plantilla principal
│   │   ├── auth/                # Login y registro
│   │   └── posts/               # Vistas de posts
│   │
│   └── Router.php               # Enrutador
│
├── config/
│   └── config.php               # Configuración global
│
├── database/
│   ├── schema.sql               # Estructura de tablas
│   └── sample_data.sql          # Datos de prueba
│
├── public/                      # Archivos públicos
│   ├── index.php                # Punto de entrada
│   ├── css/                     # Estilos
│   └── js/                      # JavaScript
│
└── uploads/                     # Imágenes subidas
```

---

## 🔧 Solución de Problemas Comunes

### ❌ "Error 404" o "Página no encontrada"
- Verifica que Apache esté ejecutándose en XAMPP (debe estar en verde)
- Asegúrate de acceder a `/Blog-PHP/public` (no solo `/Blog-PHP`)

### ❌ "Error de conexión a base de datos"
- Verifica que MySQL esté ejecutándose en XAMPP
- Confirma que la base de datos `blog_php` existe en MySQL Workbench
- Asegúrate de haber importado `schema.sql`

### ❌ "Credenciales incorrectas"
- Usuario: `admin` (todo en minúsculas)
- Contraseña: `password`
- Si no funciona, ejecuta de nuevo `sample_data.sql` en MySQL Workbench

### ❌ "Las imágenes no se suben"
- Verifica que existe la carpeta `uploads/` en el proyecto
- Crea la carpeta manualmente si no existe

---

## 📚 Conceptos de PHP Implementados

El proyecto demuestra el uso de:

- ✅ **Programación Orientada a Objetos (POO)**
- ✅ **PDO** con sentencias preparadas
- ✅ **Patrón Singleton** para la conexión a base de datos
- ✅ **password_hash()** y **password_verify()** para contraseñas seguras
- ✅ **Gestión de Sesiones** para autenticación
- ✅ **Validación y Sanitización** de datos
- ✅ **Manejo de Archivos** (subida de imágenes)
- ✅ **Arquitectura MVC** completa

---

## 👨‍💻 Autor

**Alejandro González**

Proyecto académico - Diciembre 2025

---

## 📝 Licencia

Este proyecto está bajo la Licencia MIT.
