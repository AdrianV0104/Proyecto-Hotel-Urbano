// Modal de Detalles de Habitación

const Modal = {
    abrirDetalles: function(id, codigo, categoria, precio, capacidad, descripcion, imagen) {
        // Crear contenido HTML del modal
        const contenidoHTML = `
            <!DOCTYPE html>
            <html lang="es">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="icon" href="imagenes/favicon.ico" type="image/x-icon">
                <title>Detalles de Habitación</title>
            </head>
            <body>
                <div class="contenedor-modal">
                    <div class="modal-header">
                        <h2>${codigo}</h2>
                        <p>${categoria}</p>
                    </div>
                    
                    <div class="modal-imagen">
                        <img src="${imagen}" alt="Habitación ${codigo}" onerror="this.src='imagenes/habitaciones/sin_imagen.jpg'">
                    </div>
                    
                    <div class="modal-info">
                        <label>Categoría:</label>
                        <p>${categoria}</p>
                    </div>
                    
                    <div class="modal-info">
                        <label>Capacidad:</label>
                        <p>${capacidad} persona(s)</p>
                    </div>
                    
                    <div class="modal-precio">
                        $${parseFloat(precio).toFixed(2)} por noche
                    </div>
                    
                    <div class="modal-info">
                        <label>Descripción:</label>
                        <p>${descripcion}</p>
                    </div>
                    
                    <div class="modal-footer">
                        <button class="btn-cerrar" onclick="window.close();">Cerrar</button>
                    </div>
                </div>
            </body>
            </html>
        `;
        
        // Abrir ventana emergente
        const ventana = window.open('', 'DetallesHabitacion', 'width=700,height=800,resizable=yes,scrollbars=yes');
        ventana.document.writeln(contenidoHTML);
        ventana.document.close();
    }
};

// Función global para facilitar acceso desde HTML
function abrirModalDetalles(id, codigo, categoria, precio, capacidad, descripcion, imagen) {
    Modal.abrirDetalles(id, codigo, categoria, precio, capacidad, descripcion, imagen);
}