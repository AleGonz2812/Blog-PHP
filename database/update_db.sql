-- Script de actualización para corregir la base de datos
USE blog_php;

-- Actualizar contraseña del admin a 'password'
UPDATE users SET password = '$2y$10$zjoGrTdt9Mc3jExhLD/ql.F4sQaaThPh2GzpIxfQrQoFZ/izCu5.O' WHERE username = 'admin';

-- Asegurar que todos los posts pertenecen al admin (user_id = 1)
UPDATE posts SET user_id = 1;

-- Verificar cambios
SELECT 'Usuario admin actualizado:' as info;
SELECT id, username, email FROM users WHERE username = 'admin';

SELECT 'Posts actualizados:' as info;
SELECT id, title, user_id, (SELECT username FROM users WHERE id = posts.user_id) as author FROM posts;
