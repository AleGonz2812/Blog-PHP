<!-- Page Header -->
<div class="page-header">
    <h1>Bienvenido al Blog</h1>
    <p>Descubre las últimas publicaciones de nuestra comunidad</p>
    <?php if (isset($currentUser)): ?>
        <a href="<?= BASE_URL ?>/posts/create" class="btn btn-create-post">
            ✍️ Crear Nueva Publicación
        </a>
    <?php endif; ?>
</div>

<?php if (empty($posts)): ?>
    <!-- Estado vacío -->
    <div class="empty-state">
        <div class="empty-state-icon">📝</div>
        <h3>No hay publicaciones aún</h3>
        <p>Sé el primero en crear una publicación</p>
        <?php if (isset($currentUser)): ?>
            <a href="<?= BASE_URL ?>/posts/create" class="btn btn-primary" style="display: inline-block; margin-top: 1rem; padding: 0.75rem 1.5rem;">
                ✍️ Crear Primera Publicación
            </a>
        <?php endif; ?>
    </div>
<?php else: ?>
    <!-- Grid de Posts -->
    <div class="posts-grid">
        <?php foreach ($posts as $post): ?>
            <article class="post-card" onclick="window.location.href='<?= BASE_URL ?>/post/<?= $post['id'] ?>'">
                <?php if ($post['image']): ?>
                    <img 
                        src="<?= BASE_URL ?>/../uploads/<?= htmlspecialchars($post['image']) ?>" 
                        alt="<?= htmlspecialchars($post['title']) ?>"
                        class="post-image"
                    >
                <?php else: ?>
                    <div class="post-image"></div>
                <?php endif; ?>
                
                <div class="post-content">
                    <div class="post-meta">
                        <span class="post-author">
                            <span>👤</span>
                            <span><?= htmlspecialchars($post['author']) ?></span>
                        </span>
                        <span class="post-date">
                            📅 <?= date('d/m/Y', strtotime($post['created_at'])) ?>
                        </span>
                    </div>
                    
                    <h2 class="post-title">
                        <?= htmlspecialchars($post['title']) ?>
                    </h2>
                    
                    <p class="post-excerpt">
                        <?php
                        $content = strip_tags($post['content']);
                        $excerpt = strlen($content) > 150 
                            ? substr($content, 0, 150) . '...' 
                            : $content;
                        echo htmlspecialchars($excerpt);
                        ?>
                    </p>
                    
                    <a href="<?= BASE_URL ?>/post/<?= $post['id'] ?>" class="btn-read-more">
                        Leer más →
                    </a>
                </div>
            </article>
        <?php endforeach; ?>
    </div>

    <!-- Paginación -->
    <?php if ($totalPages > 1): ?>
        <div class="pagination">
            <?php if ($currentPage > 1): ?>
                <a href="<?= BASE_URL ?>/?page=<?= $currentPage - 1 ?>">← Anterior</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <?php if ($i == $currentPage): ?>
                    <span class="active"><?= $i ?></span>
                <?php else: ?>
                    <a href="<?= BASE_URL ?>/?page=<?= $i ?>"><?= $i ?></a>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ($currentPage < $totalPages): ?>
                <a href="<?= BASE_URL ?>/?page=<?= $currentPage + 1 ?>">Siguiente →</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
<?php endif; ?>

<style>
    .btn-primary {
        background: linear-gradient(135deg, #00d9ff 0%, #7b2cbf 100%);
        color: white;
        text-decoration: none;
        border-radius: 10px;
        font-weight: 600;
        box-shadow: 0 4px 20px rgba(0, 217, 255, 0.4);
        transition: all 0.3s;
        border: none;
        cursor: pointer;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 30px rgba(0, 217, 255, 0.6);
    }
    
    .btn-create-post {
        display: inline-block;
        margin-top: 1.5rem;
        padding: 0.875rem 2rem;
        background: linear-gradient(135deg, #00d9ff 0%, #7b2cbf 100%);
        color: white;
        text-decoration: none;
        border-radius: 10px;
        font-weight: 600;
        box-shadow: 0 4px 20px rgba(0, 217, 255, 0.4);
        transition: all 0.3s;
        border: none;
        cursor: pointer;
        font-size: 1.05rem;
    }
    
    .btn-create-post:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 30px rgba(0, 217, 255, 0.6);
    }
</style>
