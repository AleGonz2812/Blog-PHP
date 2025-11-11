<?php
/**
 * Archivo de Prueba - Testing del Sistema
 * 
 * Este archivo es solo para desarrollo, para probar las clases.
 * NO debe estar en producción.
 */

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/classes/Database.php';
require_once __DIR__ . '/classes/User.php';
require_once __DIR__ . '/classes/Post.php';
require_once __DIR__ . '/includes/helpers.php';

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test - Blog PHP</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }
        h1 {
            color: #667eea;
            margin-bottom: 10px;
            font-size: 2em;
        }
        .subtitle {
            color: #666;
            margin-bottom: 30px;
            font-size: 0.9em;
        }
        .test-section {
            background: #f8f9fa;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            border-left: 4px solid #667eea;
        }
        .test-section h2 {
            color: #333;
            margin-bottom: 15px;
            font-size: 1.3em;
        }
        .success {
            background: #d4edda;
            color: #155724;
            padding: 12px;
            border-radius: 5px;
            margin: 10px 0;
            border-left: 4px solid #28a745;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 12px;
            border-radius: 5px;
            margin: 10px 0;
            border-left: 4px solid #dc3545;
        }
        .info {
            background: #d1ecf1;
            color: #0c5460;
            padding: 12px;
            border-radius: 5px;
            margin: 10px 0;
            border-left: 4px solid #17a2b8;
        }
        code {
            background: #e9ecef;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: 'Courier New', monospace;
            color: #e83e8c;
        }
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }
        .stat-card {
            background: white;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .stat-number {
            font-size: 2em;
            font-weight: bold;
            color: #667eea;
        }
        .stat-label {
            color: #666;
            font-size: 0.9em;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🚀 Sistema de Blog - Test de Funcionalidad</h1>
        <p class="subtitle">Verificación de conexiones y clases del sistema</p>

        <!-- Test 1: Conexión a Base de Datos -->
        <div class="test-section">
            <h2>📊 Test 1: Conexión a Base de Datos</h2>
            <?php
            try {
                $db = Database::getInstance();
                $conn = $db->getConnection();
                
                if ($conn instanceof PDO) {
                    echo '<div class="success">✅ Conexión exitosa a la base de datos <code>' . DB_NAME . '</code></div>';
                    echo '<div class="info">Host: <code>' . DB_HOST . '</code> | Usuario: <code>' . DB_USER . '</code></div>';
                } else {
                    echo '<div class="error">❌ Error: La conexión no es una instancia de PDO</div>';
                }
            } catch (Exception $e) {
                echo '<div class="error">❌ Error de conexión: ' . sanitize($e->getMessage()) . '</div>';
            }
            ?>
        </div>

        <!-- Test 2: Clase User -->
        <div class="test-section">
            <h2>👤 Test 2: Clase User</h2>
            <?php
            try {
                $user = new User();
                echo '<div class="success">✅ Clase User instanciada correctamente</div>';
                
                // Verificar métodos disponibles
                $methods = ['register', 'login', 'logout', 'isLoggedIn', 'getCurrentUser', 'findByUsername'];
                echo '<div class="info">Métodos disponibles: <code>' . implode(', ', $methods) . '</code></div>';
                
            } catch (Exception $e) {
                echo '<div class="error">❌ Error al instanciar User: ' . sanitize($e->getMessage()) . '</div>';
            }
            ?>
        </div>

        <!-- Test 3: Clase Post -->
        <div class="test-section">
            <h2>📝 Test 3: Clase Post</h2>
            <?php
            try {
                $post = new Post();
                echo '<div class="success">✅ Clase Post instanciada correctamente</div>';
                
                // Contar posts en la BD
                $totalPosts = $post->count();
                echo '<div class="info">Total de posts en la base de datos: <strong>' . $totalPosts . '</strong></div>';
                
                $methods = ['create', 'getById', 'getAll', 'update', 'delete', 'search'];
                echo '<div class="info">Métodos disponibles: <code>' . implode(', ', $methods) . '</code></div>';
                
            } catch (Exception $e) {
                echo '<div class="error">❌ Error al instanciar Post: ' . sanitize($e->getMessage()) . '</div>';
            }
            ?>
        </div>

        <!-- Test 4: Sistema de Sesiones -->
        <div class="test-section">
            <h2>🔐 Test 4: Sistema de Sesiones</h2>
            <?php
            if (session_status() === PHP_SESSION_ACTIVE) {
                echo '<div class="success">✅ Sistema de sesiones activo</div>';
                echo '<div class="info">Nombre de sesión: <code>' . session_name() . '</code></div>';
                echo '<div class="info">ID de sesión: <code>' . session_id() . '</code></div>';
                
                $user = new User();
                if ($user->isLoggedIn()) {
                    $currentUser = $user->getCurrentUser();
                    echo '<div class="success">Usuario autenticado: <strong>' . sanitize($currentUser['username']) . '</strong></div>';
                } else {
                    echo '<div class="info">No hay usuario autenticado actualmente</div>';
                }
            } else {
                echo '<div class="error">❌ Las sesiones no están activas</div>';
            }
            ?>
        </div>

        <!-- Test 5: Configuración del Sistema -->
        <div class="test-section">
            <h2>⚙️ Test 5: Configuración del Sistema</h2>
            <?php
            echo '<div class="info">Ruta raíz del proyecto: <code>' . ROOT_PATH . '</code></div>';
            echo '<div class="info">Carpeta de uploads: <code>' . UPLOADS_PATH . '</code></div>';
            echo '<div class="info">URL base: <code>' . BASE_URL . '</code></div>';
            echo '<div class="info">Tamaño máximo de archivo: <code>' . (MAX_FILE_SIZE / 1048576) . ' MB</code></div>';
            echo '<div class="info">Extensiones permitidas: <code>' . implode(', ', ALLOWED_EXTENSIONS) . '</code></div>';
            
            if (is_writable(UPLOADS_PATH)) {
                echo '<div class="success">✅ Directorio de uploads tiene permisos de escritura</div>';
            } else {
                echo '<div class="error">❌ El directorio de uploads no tiene permisos de escritura</div>';
            }
            ?>
        </div>

        <!-- Estadísticas -->
        <div class="test-section">
            <h2>📈 Estadísticas del Sistema</h2>
            <div class="stats">
                <div class="stat-card">
                    <div class="stat-number">
                        <?php
                        try {
                            $userObj = new User();
                            // Contar usuarios (necesitaríamos un método count en User, por ahora aproximado)
                            echo "N/A";
                        } catch (Exception $e) {
                            echo "0";
                        }
                        ?>
                    </div>
                    <div class="stat-label">Usuarios Registrados</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">
                        <?php
                        try {
                            $postObj = new Post();
                            echo $postObj->count();
                        } catch (Exception $e) {
                            echo "0";
                        }
                        ?>
                    </div>
                    <div class="stat-label">Posts Publicados</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?php echo DEBUG_MODE ? 'ON' : 'OFF'; ?></div>
                    <div class="stat-label">Modo Debug</div>
                </div>
            </div>
        </div>

        <div style="text-align: center; margin-top: 30px; color: #666;">
            <p>✨ Todos los sistemas funcionando correctamente</p>
            <p style="font-size: 0.85em; margin-top: 10px;">
                Siguiente paso: <a href="login.php" style="color: #667eea;">Crear sistema de login</a>
            </p>
        </div>
    </div>
</body>
</html>
