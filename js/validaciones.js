// Validar que solo se permitan números positivos en inputs numéricos
function validarNumerosPositivos(input) {
    input.addEventListener('input', function() {
        // Quitar caracteres que no sean dígitos
        this.value = this.value.replace(/[^0-9.]/g, '');
        // Evitar que comience con punto
        if (this.value.startsWith('.')) {
            this.value = '';
        }
    });
}

// Validar que solo se permitan caracteres alfanuméricos y espacios en campos de texto
function validarTexto(input) {
    input.addEventListener('input', function() {
        // Permite letras, números y espacios, elimina caracteres especiales
        this.value = this.value.replace(/[^a-zA-Z0-9áéíóúñ\s]/g, '');
    });
}

// Confirmar acciones (Eliminar, Editar)
function confirmarAccion(mensaje) {
    return confirm(mensaje);
}

function validarFormularioCrear() {
    return confirm('¿Deseas agregar estas nuevas habitaciones?');
}

function validarFormularioEditar(){
    return confirm('¿Deseas editar estas habitaciones?')
}

document.addEventListener('DOMContentLoaded', function() {
    // Buscar todos los inputs numéricos y aplicar validación
    const inputsNumericos = document.querySelectorAll('input[type="number"]');
    inputsNumericos.forEach(input => {
        validarNumeroPositivo(input);
    });
    // Buscar todos los inputs de texto y aplicar validación
    const inputsTexto = document.querySelectorAll('input[type="text"]');
    inputsTexto.forEach(input => {
        // Solo validar inputs que no sean de búsqueda
        if (input.id !== 'codigo') {
            validarTexto(input);
        }
    });
    // Validar textarea
    const textareas = document.querySelectorAll('textarea');
    textareas.forEach(textarea => {
        validarTexto(textarea);
    });
});