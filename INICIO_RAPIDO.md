# 🚀 Inicio Rápido - Blog CMS

## ⚡ Pasos para ejecutar el proyecto

### 1️⃣ Crear la base de datos
```bash
mysql -u root -p
```
```sql
CREATE DATABASE blog_php CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE blog_php;
SOURCE database/schema.sql;
SOURCE database/sample_data.sql;
EXIT;
```

### 2️⃣ Configurar credenciales
Edita `config/config.php`:
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'blog_php');
define('DB_USER', 'root');
define('DB_PASS', ''); // Tu contraseña
define('BASE_URL', 'http://localhost:8000');
```

### 3️⃣ Iniciar servidor
```bash
cd public
php -S localhost:8000
```

### 4️⃣ Acceder a la aplicación
Abre tu navegador en: **http://localhost:8000**

### 5️⃣ Login de prueba
- Usuario: `admin`
- Contraseña: `password`

---

## 📝 Rutas Disponibles

- `/` → Página principal (posts)
- `/login` → Iniciar sesión
- `/register` → Registrarse
- `/logout` → Cerrar sesión
- `/post/{id}` → Ver detalle de post

---

## 🐛 Solución de Problemas

### Error de conexión a BD
✅ Verifica que MySQL esté corriendo
✅ Comprueba las credenciales en `config/config.php`
✅ Asegúrate de que la BD `blog_php` existe

### Página en blanco
✅ Revisa que estés en la carpeta `public/`
✅ Verifica que `DEBUG_MODE = true` en `config/config.php`
✅ Mira los logs de PHP: `php -S localhost:8000 2>&1 | tee error.log`

### URLs no funcionan
✅ Asegúrate de que `mod_rewrite` está habilitado (Apache)
✅ Verifica que `.htaccess` está en `public/`
✅ Usa el servidor PHP integrado: `php -S localhost:8000`

---

## 📚 Siguiente paso

Lee la **[GUIA_MVC.md](GUIA_MVC.md)** para entender la arquitectura del proyecto.

¡Feliz desarrollo! 🎉
