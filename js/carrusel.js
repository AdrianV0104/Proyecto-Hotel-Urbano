document.addEventListener('DOMContentLoaded', function() {
    // Seleccionar todos los carruseles en la página
    const carruseles = document.querySelectorAll('.carrusel-track');
    
    carruseles.forEach((track) => {
        // Obtener el contenedor padre del carrusel
        const wrapper = track.closest('.carrusel-wrapper');
        if (!wrapper) return;
        
        const nextButton = wrapper.querySelector('.btn-next');
        const prevButton = wrapper.querySelector('.btn-prev');
        
        if (!nextButton || !prevButton) return;

        // Obtener todas las tarjetas de este carrusel
        const cards = Array.from(track.children);
        
        if(cards.length === 0) return;

        const cardWidth = cards[0].getBoundingClientRect().width;
        const gap = 20; 
        const moveAmount = cardWidth + gap;

        let currentPosition = 0;

        // Función para mover el carrusel
        const moveToPosition = (position) => {
            track.style.transform = `translateX(-${position}px)`;
        };

        nextButton.addEventListener('click', () => {
            // Calculamos el ancho total del contenido
            const trackWidth = track.scrollWidth;
            const containerWidth = track.parentElement.clientWidth;
            
            // Si movernos más excede el ancho total, volvemos al inicio
            const maxScroll = trackWidth - containerWidth;

            if (currentPosition < maxScroll) {
                currentPosition += moveAmount;
                if (currentPosition > maxScroll) currentPosition = maxScroll;
                moveToPosition(currentPosition);
            } else {
                currentPosition = 0;
                moveToPosition(currentPosition);
            }
        });

        prevButton.addEventListener('click', () => {
            if (currentPosition > 0) {
                currentPosition -= moveAmount;
                if (currentPosition < 0) currentPosition = 0;
                moveToPosition(currentPosition);
            }
        });
    });
});

// Función para desplegar la descripción
function toggleDetalles(id) {
    const desc = document.getElementById('desc-' + id);
    if (desc) {
        if (desc.classList.contains('activo')) {
            desc.classList.remove('activo');
        } else {
            desc.classList.add('activo');
        }
    }
}