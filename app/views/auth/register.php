<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse - Blog CMS</title>
    <link rel="stylesheet" href="<?= ASSETS_URL ?>css/auth.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <!-- Header -->
            <div class="auth-header">
                <h1>✨ Crear Cuenta</h1>
                <p>Únete a nuestra comunidad</p>
            </div>

            <!-- Body -->
            <div class="auth-body">
                <!-- Mensajes Flash -->
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="auth-alert auth-alert-error">
                        <span>❌</span>
                        <span><?= htmlspecialchars($_SESSION['error']) ?></span>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>

                <!-- Formulario -->
                <form action="<?= BASE_URL ?>/register" method="POST" id="registerForm">
                    <div class="form-group">
                        <label for="username">👤 Usuario</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="username" 
                            name="username" 
                            placeholder="Elige un nombre de usuario"
                            required
                            minlength="3"
                            maxlength="50"
                            autocomplete="username"
                        >
                        <small style="color: #718096; font-size: 0.85rem; display: block; margin-top: 0.25rem;">
                            Mínimo 3 caracteres
                        </small>
                    </div>

                    <div class="form-group">
                        <label for="email">📧 Email (opcional)</label>
                        <input 
                            type="email" 
                            class="form-control" 
                            id="email" 
                            name="email" 
                            placeholder="tu@email.com"
                            autocomplete="email"
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
                                placeholder="Crea una contraseña segura"
                                required
                                minlength="6"
                                autocomplete="new-password"
                            >
                            <button type="button" class="toggle-btn" onclick="togglePassword('password')">
                                🙉
                            </button>
                        </div>
                        <small style="color: #718096; font-size: 0.85rem; display: block; margin-top: 0.25rem;">
                            Mínimo 6 caracteres
                        </small>
                    </div>

                    <div class="form-group">
                        <label for="confirm_password">🔒 Confirmar Contraseña</label>
                        <div class="password-toggle">
                            <input 
                                type="password" 
                                class="form-control" 
                                id="confirm_password" 
                                name="confirm_password" 
                                placeholder="Repite tu contraseña"
                                required
                                minlength="6"
                                autocomplete="new-password"
                            >
                            <button type="button" class="toggle-btn" onclick="togglePassword('confirm_password')">
                                🙉
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Crear Cuenta
                    </button>
                </form>
            </div>

            <!-- Footer -->
            <div class="auth-footer">
                ¿Ya tienes cuenta? 
                <a href="<?= BASE_URL ?>/login">Inicia sesión aquí</a>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(fieldId) {
            const passwordInput = document.getElementById(fieldId);
            const toggleBtn = passwordInput.nextElementSibling;
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleBtn.textContent = '🙈';
            } else {
                passwordInput.type = 'password';
                toggleBtn.textContent = '🙉';
            }
        }

        // Validación del formulario
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;

            // Validar campos obligatorios
            if (!username || !password || !confirmPassword) {
                e.preventDefault();
                alert('Por favor, completa todos los campos obligatorios');
                return;
            }

            // Validar longitud de usuario
            if (username.length < 3) {
                e.preventDefault();
                alert('El nombre de usuario debe tener al menos 3 caracteres');
                return;
            }

            // Validar longitud de contraseña
            if (password.length < 6) {
                e.preventDefault();
                alert('La contraseña debe tener al menos 6 caracteres');
                return;
            }

            // Validar que las contraseñas coincidan
            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Las contraseñas no coinciden');
                return;
            }
        });

        // Validar contraseñas en tiempo real
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('confirm_password');

        confirmPassword.addEventListener('input', function() {
            if (password.value !== confirmPassword.value) {
                confirmPassword.setCustomValidity('Las contraseñas no coinciden');
            } else {
                confirmPassword.setCustomValidity('');
            }
        });
    </script>
</body>
</html>
