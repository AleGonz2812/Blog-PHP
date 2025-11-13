# 📋 Instrucciones para Actualizar la Base de Datos

## 🔧 Opción 1: MySQL Workbench (Recomendado)

### Pasos para ejecutar el script SQL:

1. **Abre MySQL Workbench**
   - Busca el programa en tu computadora
   - Haz doble clic para abrirlo

2. **Conéctate a tu servidor**
   - En la ventana principal verás "MySQL Connections"
   - Haz clic en tu conexión local (usualmente "Local instance MySQL")
   - Si te pide contraseña, usa la de root (por defecto en XAMPP está vacía, solo presiona Enter)

3. **Selecciona la base de datos**
   - En el panel izquierdo, bajo "SCHEMAS", busca `blog_php`
   - Haz clic derecho sobre `blog_php`
   - Selecciona **"Set as Default Schema"** (Establecer como esquema predeterminado)

4. **Abre el editor de consultas**
   - Haz clic en el icono del **rayo ⚡** en la barra superior
   - O ve a `Query` → `New Query Tab`
   - O presiona `Ctrl + Shift + Q`

5. **Copia y pega este código SQL**

```sql
USE blog_php;

-- Actualizar la contraseña del usuario admin a "password"
UPDATE users 
SET password = '$2y$10$zjoGrTdt9Mc3jExhLD/ql.F4sQaaThPh2GzpIxfQrQoFZ/izCu5.O' 
WHERE username = 'admin';

-- Asignar todos los posts al usuario admin
UPDATE posts 
SET user_id = 1;
```

6. **Ejecuta el script**
   - Haz clic en el botón del **rayo ⚡** (Execute)
   - O presiona `Ctrl + Enter`
   - O ve a `Query` → `Execute (All or Selection)`

7. **Verifica que se ejecutó correctamente**
   - En la parte inferior verás un mensaje como:
     ```
     2 row(s) affected
     ```
   - Esto significa que la actualización fue exitosa

8. **¡Listo!** Ahora puedes:
   - Iniciar sesión con **usuario:** `admin` y **contraseña:** `password`
   - Ver todos los posts asignados al usuario admin

---

## 🖥️ Opción 2: phpMyAdmin (Alternativa)

Si prefieres usar phpMyAdmin:

1. Abre tu navegador y ve a: `http://localhost/phpmyadmin`
2. En el panel izquierdo, haz clic en `blog_php`
3. Haz clic en la pestaña **SQL** (arriba)
4. Copia y pega el mismo código SQL de arriba
5. Haz clic en el botón **"Continuar"** o **"Go"**
6. ¡Listo!

---

## 🔍 Verificación

Para verificar que todo funcionó:

### Opción A: Verificar en MySQL Workbench
```sql
-- Ver el usuario admin
SELECT * FROM users WHERE username = 'admin';

-- Ver todos los posts
SELECT id, title, user_id FROM posts;
```

### Opción B: Verificar en la aplicación
1. Ve a `http://localhost/Blog-PHP/public/`
2. Haz clic en **"Iniciar Sesión"**
3. Ingresa:
   - **Usuario:** admin
   - **Contraseña:** password
4. Si entras correctamente, ¡todo está funcionando! ✅

---

## ❓ Problemas Comunes

### "No puedo conectarme a MySQL"
- Asegúrate de que XAMPP esté ejecutándose
- Verifica que el servicio MySQL esté iniciado (debe tener un cuadro verde)
- En el panel de XAMPP, haz clic en "Start" junto a MySQL si está detenido

### "No encuentro la base de datos blog_php"
- Primero debes crear la base de datos ejecutando el archivo `database/schema.sql`
- Luego ejecuta `database/sample_data.sql` para los datos de ejemplo

### "El password no funciona"
- Asegúrate de haber ejecutado el script SQL correctamente
- Verifica que copiaste el hash completo (es muy largo)
- Intenta cerrar sesión y volver a entrar

---

## 🎯 Resumen de Cambios

Este script hace lo siguiente:

1. **Cambia la contraseña del admin** de `admin123` a `password`
2. **Asigna todos los posts al usuario admin** (user_id = 1)

Esto asegura que:
- ✅ Puedas iniciar sesión con admin/password
- ✅ Todos los posts sean editables/eliminables por el admin
- ✅ No haya posts huérfanos de usuarios que no existen

---

## 📞 Ayuda Adicional

Si tienes problemas:
1. Revisa que XAMPP esté corriendo
2. Verifica que MySQL esté iniciado
3. Confirma que la base de datos `blog_php` exista
4. Asegúrate de estar usando las credenciales correctas
