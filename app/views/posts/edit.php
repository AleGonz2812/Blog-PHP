<!-- Formulario de Edición de Post -->
<div class="post-form-container">
    <div class="post-form-header">
        <h1>✏️ Editar Publicación</h1>
        <p>Actualiza tu contenido</p>
    </div>

    <div class="post-form-card">
        <form action="<?= BASE_URL ?>/posts/update/<?= $post['id'] ?>" method="POST" enctype="multipart/form-data" id="postForm">
            <!-- Título -->
            <div class="form-group">
                <label for="title">📝 Título</label>
                <input 
                    type="text" 
                    class="form-control" 
                    id="title" 
                    name="title" 
                    value="<?= htmlspecialchars($post['title']) ?>"
                    placeholder="Escribe un título llamativo"
                    required
                    maxlength="150"
                >
            </div>

            <!-- Contenido -->
            <div class="form-group">
                <label for="content">📄 Contenido</label>
                <textarea 
                    class="form-control" 
                    id="content" 
                    name="content" 
                    rows="12" 
                    placeholder="Escribe el contenido de tu publicación..."
                    required
                ><?= htmlspecialchars($post['content']) ?></textarea>
            </div>

            <!-- Imagen actual -->
            <?php if ($post['image']): ?>
                <div class="current-image">
                    <label>🖼️ Imagen actual</label>
                    <img src="<?= BASE_URL ?>/../uploads/<?= htmlspecialchars($post['image']) ?>" alt="Imagen actual">
                </div>
            <?php endif; ?>

            <!-- Nueva imagen -->
            <div class="form-group">
                <label for="image">🖼️ Cambiar imagen (opcional)</label>
                <input 
                    type="file" 
                    class="form-control-file" 
                    id="image" 
                    name="image" 
                    accept="image/jpeg,image/jpg,image/png,image/gif"
                >
                <small class="form-text">Formatos permitidos: JPG, PNG, GIF. Máximo 5MB.</small>
                <div id="imagePreview" class="image-preview"></div>
            </div>

            <!-- Botones -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <span>💾</span> Guardar Cambios
                </button>
                <a href="<?= BASE_URL ?>/post/<?= $post['id'] ?>" class="btn btn-secondary">
                    <span>❌</span> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<style>
    .post-form-container {
        max-width: 900px;
        margin: 2rem auto;
    }

    .post-form-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .post-form-header h1 {
        font-size: 2.5rem;
        color: #00d9ff;
        margin-bottom: 0.5rem;
        text-shadow: 0 0 20px rgba(0, 217, 255, 0.5);
    }

    .post-form-header p {
        color: #8b92b0;
        font-size: 1.1rem;
    }

    .post-form-card {
        background: rgba(21, 25, 50, 0.6);
        backdrop-filter: blur(10px);
        border-radius: 15px;
        padding: 3rem;
        border: 1px solid rgba(0, 217, 255, 0.3);
        box-shadow: 0 8px 32px rgba(0, 217, 255, 0.1);
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        color: #e0e7ff;
        margin-bottom: 0.5rem;
        font-size: 1rem;
    }

    .form-control {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 2px solid rgba(0, 217, 255, 0.3);
        background: rgba(10, 14, 39, 0.8);
        color: #e0e7ff;
        border-radius: 8px;
        font-size: 1rem;
        font-family: inherit;
        transition: all 0.3s;
        outline: none;
    }

    .form-control:focus {
        border-color: #00d9ff;
        box-shadow: 0 0 20px rgba(0, 217, 255, 0.3);
        background: rgba(10, 14, 39, 0.9);
    }

    .form-control::placeholder {
        color: #8b92b0;
    }

    textarea.form-control {
        resize: vertical;
        min-height: 200px;
        line-height: 1.6;
    }

    .current-image {
        margin-bottom: 1.5rem;
    }

    .current-image label {
        display: block;
        font-weight: 600;
        color: #e0e7ff;
        margin-bottom: 0.75rem;
        font-size: 1rem;
    }

    .current-image img {
        width: 100%;
        max-height: 300px;
        object-fit: cover;
        border: 2px solid rgba(0, 217, 255, 0.3);
        border-radius: 8px;
    }

    .form-control-file {
        width: 100%;
        padding: 0.75rem;
        border: 2px dashed rgba(0, 217, 255, 0.3);
        background: rgba(10, 14, 39, 0.5);
        color: #e0e7ff;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s;
    }

    .form-control-file:hover {
        border-color: #00d9ff;
        background: rgba(10, 14, 39, 0.7);
    }

    .form-text {
        display: block;
        margin-top: 0.5rem;
        color: #8b92b0;
        font-size: 0.875rem;
    }

    .image-preview {
        margin-top: 1rem;
        border-radius: 8px;
        overflow: hidden;
        display: none;
    }

    .image-preview img {
        width: 100%;
        max-height: 300px;
        object-fit: cover;
        border: 2px solid rgba(0, 217, 255, 0.3);
        border-radius: 8px;
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
    }

    .btn {
        flex: 1;
        padding: 1rem 2rem;
        border: none;
        border-radius: 10px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        text-align: center;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .btn-primary {
        background: linear-gradient(135deg, #00d9ff 0%, #7b2cbf 100%);
        color: white;
        box-shadow: 0 4px 20px rgba(0, 217, 255, 0.4);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 30px rgba(0, 217, 255, 0.6);
    }

    .btn-secondary {
        background: rgba(255, 0, 110, 0.15);
        color: #ff006e;
        border: 2px solid rgba(255, 0, 110, 0.3);
    }

    .btn-secondary:hover {
        background: rgba(255, 0, 110, 0.25);
        border-color: #ff006e;
        box-shadow: 0 0 20px rgba(255, 0, 110, 0.4);
    }

    @media (max-width: 768px) {
        .post-form-card {
            padding: 2rem 1.5rem;
        }

        .form-actions {
            flex-direction: column;
        }

        .post-form-header h1 {
            font-size: 2rem;
        }
    }
</style>

<script>
    // Preview de nueva imagen
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('imagePreview');
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = '<img src="' + e.target.result + '" alt="Preview">';
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            preview.style.display = 'none';
            preview.innerHTML = '';
        }
    });

    // Validación del formulario
    document.getElementById('postForm').addEventListener('submit', function(e) {
        const title = document.getElementById('title').value.trim();
        const content = document.getElementById('content').value.trim();

        if (!title || !content) {
            e.preventDefault();
            alert('Por favor, completa el título y el contenido');
            return false;
        }

        if (title.length < 5) {
            e.preventDefault();
            alert('El título debe tener al menos 5 caracteres');
            return false;
        }

        if (content.length < 10) {
            e.preventDefault();
            alert('El contenido debe tener al menos 10 caracteres');
            return false;
        }
    });
</script>
