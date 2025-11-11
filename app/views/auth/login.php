<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Blog CMS</title>
    <link rel="stylesheet" href="<?= ASSETS_URL ?>css/auth.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <!-- Header -->
            <div class="auth-header">
                <h1>🔐 Bienvenido</h1>
                <p>Inicia sesión para continuar</p>
            </div>

            <!-- Body -->
            <div class="auth-body">
                <!-- Mensajes Flash -->
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="auth-alert auth-alert-success">
                        <span>✅</span>
                        <span><?= htmlspecialchars($_SESSION['success']) ?></span>
                    </div>
                    <?php unset($_SESSION['success']); ?>
                <?php endif; ?>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="auth-alert auth-alert-error">
                        <span>❌</span>
                        <span><?= htmlspecialchars($_SESSION['error']) ?></span>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>

                <!-- Formulario -->
                <form action="<?= BASE_URL ?>/login" method="POST" id="loginForm">
                    <div class="form-group">
                        <label for="username">👤 Usuario</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="username" 
                            name="username" 
                            placeholder="Ingresa tu usuario"
                            required
                            autocomplete="username"
                        >
                    </div>

                    <div class="form-group">
                        <label for="password">🔒 Contraseña</label>
                        <div class="password-toggle">
                            <input 
                                type="password" 
                                class="form-control" 
                                id="password" 
                                name="password" 
                                placeholder="Ingresa tu contraseña"
                                required
                                autocomplete="current-password"
                            >
                            <button type="button" class="toggle-btn" onclick="togglePassword()">
                                🙉
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Iniciar Sesión
                    </button>
                </form>
            </div>

            <!-- Footer -->
            <div class="auth-footer">
                ¿No tienes cuenta? 
                <a href="<?= BASE_URL ?>/register">Regístrate aquí</a>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleBtn = document.querySelector('.toggle-btn');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleBtn.textContent = '🙈';
            } else {
                passwordInput.type = 'password';
                toggleBtn.textContent = '🙉';
            }
        }

        // Validación del formulario
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value;

            if (!username || !password) {
                e.preventDefault();
                alert('Por favor, completa todos los campos');
            }
        });
    </script>
</body>
</html>
