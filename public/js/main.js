/**
 * Main JavaScript - Blog CMS
 * Funcionalidades generales del sitio
 */

// Auto-cerrar alertas después de 5 segundos
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.animation = 'slideUp 0.3s ease';
            setTimeout(() => {
                alert.remove();
            }, 300);
        }, 5000);
    });
});

// Animación de slide up para cerrar alertas
const style = document.createElement('style');
style.textContent = `
    @keyframes slideUp {
        from {
            opacity: 1;
            transform: translateY(0);
        }
        to {
            opacity: 0;
            transform: translateY(-10px);
        }
    }
`;
document.head.appendChild(style);

// Confirmación antes de eliminar
function confirmDelete(message = '¿Estás seguro de que deseas eliminar esto?') {
    return confirm(message);
}

// Scroll suave
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth'
            });
        }
    });
});

// Menú móvil (para futuras implementaciones)
function toggleMobileMenu() {
    const navLinks = document.querySelector('.nav-links');
    navLinks.classList.toggle('mobile-active');
}

console.log('🚀 Blog CMS cargado correctamente');
