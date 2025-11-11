<!-- Detalle del Post -->
<div class="post-detail">
    <!-- Header del post -->
    <div class="post-detail-header">
        <h1 class="post-detail-title"><?= htmlspecialchars($post['title']) ?></h1>
        
        <div class="post-detail-meta">
            <span class="meta-item">
                <span>👤</span>
                <span><?= htmlspecialchars($post['author']) ?></span>
            </span>
            <span class="meta-item">
                <span>📅</span>
                <span><?= date('d/m/Y H:i', strtotime($post['created_at'])) ?></span>
            </span>
        </div>
    </div>

    <!-- Imagen destacada -->
    <?php if ($post['image']): ?>
        <div class="post-detail-image">
            <img 
                src="<?= BASE_URL ?>/../uploads/<?= htmlspecialchars($post['image']) ?>" 
                alt="<?= htmlspecialchars($post['title']) ?>"
            >
        </div>
    <?php endif; ?>

    <!-- Contenido -->
    <div class="post-detail-content">
        <?= nl2br(htmlspecialchars($post['content'])) ?>
    </div>

    <!-- Acciones (si es el autor) -->
    <?php if (isset($currentUser) && $currentUser['id'] == $post['user_id']): ?>
        <div class="post-actions">
            <a href="<?= BASE_URL ?>/posts/edit/<?= $post['id'] ?>" class="btn btn-edit">
                ✏️ Editar
            </a>
            <button onclick="deletePost(<?= $post['id'] ?>)" class="btn btn-delete">
                🗑️ Eliminar
            </button>
        </div>
    <?php endif; ?>

    <!-- Volver -->
    <div style="margin-top: 2rem;">
        <a href="<?= BASE_URL ?>/" class="btn-back">
            ← Volver al inicio
        </a>
    </div>
</div>

<style>
    .post-detail {
        background: white;
        border-radius: 10px;
        padding: 3rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        max-width: 800px;
        margin: 0 auto;
    }

    .post-detail-header {
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 2px solid #e2e8f0;
    }

    .post-detail-title {
        font-size: 2.5rem;
        color: #2d3748;
        margin-bottom: 1rem;
        line-height: 1.2;
    }

    .post-detail-meta {
        display: flex;
        gap: 1.5rem;
        color: #718096;
        font-size: 0.95rem;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .post-detail-image {
        margin-bottom: 2rem;
        border-radius: 10px;
        overflow: hidden;
    }

    .post-detail-image img {
        width: 100%;
        height: auto;
        display: block;
    }

    .post-detail-content {
        font-size: 1.1rem;
        line-height: 1.8;
        color: #2d3748;
        margin-bottom: 2rem;
    }

    .post-actions {
        display: flex;
        gap: 1rem;
        padding-top: 2rem;
        border-top: 2px solid #e2e8f0;
    }

    .btn {
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-block;
    }

    .btn-edit {
        background: #667eea;
        color: white;
    }

    .btn-edit:hover {
        background: #5568d3;
        transform: translateY(-2px);
    }

    .btn-delete {
        background: #f56565;
        color: white;
    }

    .btn-delete:hover {
        background: #e53e3e;
        transform: translateY(-2px);
    }

    .btn-back {
        color: #667eea;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: color 0.3s;
    }

    .btn-back:hover {
        color: #5568d3;
    }

    @media (max-width: 768px) {
        .post-detail {
            padding: 2rem 1.5rem;
        }

        .post-detail-title {
            font-size: 1.8rem;
        }

        .post-detail-content {
            font-size: 1rem;
        }
    }
</style>

<script>
    function deletePost(id) {
        if (confirm('¿Estás seguro de que deseas eliminar esta publicación?')) {
            window.location.href = '<?= BASE_URL ?>/posts/delete/' + id;
        }
    }
</script>
