-- Datos de ejemplo para el blog
USE blog_php;

-- Insertar usuario admin (password: password)
INSERT INTO users (username, password, email) VALUES 
('admin', '$2y$10$zjoGrTdt9Mc3jExhLD/ql.F4sQaaThPh2GzpIxfQrQoFZ/izCu5.O', 'admin@blog.com');

-- Insertar posts de ejemplo (todos del usuario admin con id=1)
INSERT INTO posts (title, content, user_id) VALUES 
('Bienvenido al Blog', 'Este es el primer post de nuestro blog. Aquí encontrarás contenido interesante y actualizado.', 1),
('Guía de PHP Moderno', 'PHP ha evolucionado mucho en los últimos años. En este post veremos las mejores prácticas actuales.', 1),
('Introducción a MVC', 'El patrón Modelo-Vista-Controlador es fundamental para organizar aplicaciones web de manera eficiente.', 1);
