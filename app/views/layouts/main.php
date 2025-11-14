<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Blog CMS' ?></title>
    <link rel="stylesheet" href="<?= ASSETS_URL ?>css/style.css">
    <style>
        /* Iconos simples con emojis */
        .icon::before {
            margin-right: 0.5rem;
        }
    </style>
</head>
<body>
    <!-- HEADER -->
    <header>
        <div class="container">
            <nav>
                <a href="<?= BASE_URL ?>/" class="logo">
                    Blog CMS
                </a>
                
                <ul class="nav-links">
                    <li><a href="<?= BASE_URL ?>/">Inicio</a></li>
                    
                    <?php if (isset($currentUser)): ?>
                        <li><span class="user-profile">👤 <?= htmlspecialchars($currentUser['username']) ?></span></li>
                        <li><a href="<?= BASE_URL ?>/logout" class="btn-logout">Salir</a></li>
                    <?php else: ?>
                        <li><a href="<?= BASE_URL ?>/login">Iniciar Sesión</a></li>
                        <li><a href="<?= BASE_URL ?>/register">Registrarse</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <main>
        <div class="container">
            <!-- Mensajes Flash -->
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <span>✅</span>
                    <span><?= htmlspecialchars($_SESSION['success']) ?></span>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-error">
                    <span>❌</span>
                    <span><?= htmlspecialchars($_SESSION['error']) ?></span>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <!-- Contenido de la vista -->
            <?= $content ?>
        </div>
    </main>

    <!-- FOOTER -->
    <footer>
        <div class="container">
            <p>&copy; <?= date('Y') ?> Blog CMS - Proyecto Académico PHP</p>
        </div>
    </footer>

    <script src="<?= ASSETS_URL ?>js/main.js"></script>
</body>
</html>
