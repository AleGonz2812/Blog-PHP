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
            <button onclick="confirmDelete(<?= $post['id'] ?>)" class="btn btn-delete">
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
        background: rgba(21, 25, 50, 0.6);
        backdrop-filter: blur(10px);
        border-radius: 15px;
        padding: 3rem;
        border: 1px solid rgba(0, 217, 255, 0.3);
        box-shadow: 0 8px 32px rgba(0, 217, 255, 0.1);
        max-width: 800px;
        margin: 0 auto;
    }

    .post-detail-header {
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 2px solid rgba(0, 217, 255, 0.3);
    }

    .post-detail-title {
        font-size: 2.5rem;
        color: #00d9ff;
        margin-bottom: 1rem;
        line-height: 1.2;
        text-shadow: 0 0 20px rgba(0, 217, 255, 0.3);
    }

    .post-detail-meta {
        display: flex;
        gap: 1.5rem;
        color: #8b92b0;
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
        border: 1px solid rgba(0, 217, 255, 0.2);
    }

    .post-detail-image img {
        width: 100%;
        height: auto;
        display: block;
    }

    .post-detail-content {
        font-size: 1.1rem;
        line-height: 1.8;
        color: #e0e7ff;
        margin-bottom: 2rem;
    }

    .post-actions {
        display: flex;
        gap: 1rem;
        padding-top: 2rem;
        border-top: 2px solid rgba(0, 217, 255, 0.3);
    }

    .btn {
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-block;
    }

    .btn-edit {
        background: linear-gradient(135deg, #00d9ff, #7b2cbf);
        color: white;
        box-shadow: 0 4px 20px rgba(0, 217, 255, 0.3);
    }

    .btn-edit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 30px rgba(0, 217, 255, 0.5);
    }

    .btn-delete {
        background: linear-gradient(135deg, #ff006e, #ff4d00);
        color: white;
        box-shadow: 0 4px 20px rgba(255, 0, 110, 0.3);
    }

    .btn-delete:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 30px rgba(255, 0, 110, 0.5);
    }

    .btn-back {
        color: #00d9ff;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s;
        padding: 0.75rem 1.5rem;
        border: 1px solid rgba(0, 217, 255, 0.3);
        border-radius: 10px;
        background: rgba(0, 217, 255, 0.05);
    }

    .btn-back:hover {
        color: white;
        background: rgba(0, 217, 255, 0.15);
        border-color: #00d9ff;
        box-shadow: 0 0 20px rgba(0, 217, 255, 0.4);
        text-shadow: 0 0 10px rgba(0, 217, 255, 0.8);
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
    
    /* Modal de confirmación */
    .modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(10, 14, 39, 0.9);
        backdrop-filter: blur(5px);
        z-index: 9999;
        animation: fadeIn 0.3s ease;
    }
    
    .modal-overlay.active {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .modal-box {
        background: rgba(21, 25, 50, 0.95);
        border: 2px solid rgba(0, 217, 255, 0.4);
        border-radius: 15px;
        padding: 2.5rem;
        max-width: 500px;
        width: 90%;
        box-shadow: 0 20px 60px rgba(0, 217, 255, 0.3);
        animation: slideUp 0.3s ease;
    }
    
    .modal-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .modal-icon {
        font-size: 3rem;
    }
    
    .modal-title {
        font-size: 1.5rem;
        color: #00d9ff;
        margin: 0;
    }
    
    .modal-message {
        color: #e0e7ff;
        font-size: 1.05rem;
        line-height: 1.6;
        margin-bottom: 2rem;
    }
    
    .modal-actions {
        display: flex;
        gap: 1rem;
    }
    
    .modal-btn {
        flex: 1;
        padding: 0.875rem 1.5rem;
        border: none;
        border-radius: 10px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .modal-btn-confirm {
        background: linear-gradient(135deg, #ff006e, #ff4d00);
        color: white;
        box-shadow: 0 4px 20px rgba(255, 0, 110, 0.4);
    }
    
    .modal-btn-confirm:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 30px rgba(255, 0, 110, 0.6);
    }
    
    .modal-btn-cancel {
        background: rgba(0, 217, 255, 0.15);
        color: #00d9ff;
        border: 2px solid rgba(0, 217, 255, 0.3);
    }
    
    .modal-btn-cancel:hover {
        background: rgba(0, 217, 255, 0.25);
        border-color: #00d9ff;
        box-shadow: 0 0 20px rgba(0, 217, 255, 0.4);
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<!-- Modal de confirmación de eliminación -->
<div id="deleteModal" class="modal-overlay">
    <div class="modal-box">
        <div class="modal-header">
            <span class="modal-icon">⚠️</span>
            <h3 class="modal-title">Confirmar Eliminación</h3>
        </div>
        <p class="modal-message">
            ¿Estás seguro de que deseas eliminar esta publicación? Esta acción no se puede deshacer.
        </p>
        <div class="modal-actions">
            <button class="modal-btn modal-btn-cancel" onclick="closeModal()">
                ❌ No, cancelar
            </button>
            <button class="modal-btn modal-btn-confirm" onclick="executeDelete()">
                🗑️ Sí, eliminar
            </button>
        </div>
    </div>
</div>

<form id="deleteForm" method="POST" action="" style="display: none;"></form>

<script>
    let postIdToDelete = null;
    
    function confirmDelete(id) {
        event.preventDefault();
        event.stopPropagation();
        postIdToDelete = id;
        document.getElementById('deleteModal').classList.add('active');
    }
    
    function closeModal() {
        document.getElementById('deleteModal').classList.remove('active');
        postIdToDelete = null;
    }
    
    function executeDelete() {
        if (postIdToDelete) {
            const form = document.getElementById('deleteForm');
            form.action = '<?= BASE_URL ?>/posts/delete/' + postIdToDelete;
            form.submit();
        }
    }
    
    // Cerrar modal al hacer clic fuera
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });
    
    // Cerrar modal con tecla ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModal();
        }
    });
</script>
