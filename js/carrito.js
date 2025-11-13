const NOMBRE_COOKIE = 'carrito_urbano';

const Carrito = {
    //Obtener datos de la cookie
    obtener: function() {
        const cookies = document.cookie.split('; ');
        const cookie = cookies.find(c => c.startsWith(NOMBRE_COOKIE + '='));
        if (cookie) {
            try {
                return JSON.parse(decodeURIComponent(cookie.split('=')[1]));
            } catch(e) { return []; }
        }
        return [];
    },

    //Guardar datos en la cookie (1 día de duración)
    guardar: function(carrito) {
        const str = encodeURIComponent(JSON.stringify(carrito));
        document.cookie = `${NOMBRE_COOKIE}=${str}; path=/; max-age=86400`;
    },

    //Función llamada por el botón en listar.php
    agregar: function(id, numero, precio, categoria) {
        let carrito = this.obtener();
        //Verificar si ya está en el carrito
        let existe = carrito.find(item => item.id === id);

        if (existe) {
            existe.cantidad++;
            alert(`Se aumentó la cantidad de la habitación ${numero}.`);
        } else {
            carrito.push({ id, numero, precio, categoria, cantidad: 1 });
            alert(`Habitación ${numero} agregada al carrito.`);
        }
        
        this.guardar(carrito);
    },

    //Métodos para la página del carrito (carrito.php)
    cambiarCantidad: function(id, delta) {
        let carrito = this.obtener();
        let item = carrito.find(item => item.id === id);
        if (item) {
            item.cantidad += delta;
            if (item.cantidad <= 0) this.eliminar(id);
            else {
                this.guardar(carrito);
                this.renderizarTabla();
            }
        }
    },

    eliminar: function(id) {
        if(!confirm("¿Eliminar esta habitación?")) return;
        let carrito = this.obtener();
        carrito = carrito.filter(item => item.id !== id);
        this.guardar(carrito);
        this.renderizarTabla();
    },

    renderizarTabla: function() {
        const tbody = document.getElementById('tabla-carrito');
        const totalSpan = document.getElementById('total-carrito');
        const inputData = document.getElementById('datos_reserva_input');
        if (!tbody) return; 

        let carrito = this.obtener();
        let html = '';
        let total = 0;

        if (carrito.length === 0) {
            tbody.innerHTML = '<tr><td colspan="5" align="center">Carrito vacío</td></tr>';
            totalSpan.innerText = '0.00';
            if(inputData) inputData.value = '';
            return;
        }

        carrito.forEach(item => {
            let subtotal = item.precio * item.cantidad;
            total += subtotal;
            html += `
                <tr>
                    <td>${item.numero} (${item.categoria})</td>
                    <td>$${parseFloat(item.precio).toFixed(2)}</td>
                    <td align="center">
                        <button type="button" onclick="Carrito.cambiarCantidad(${item.id}, -1)">-</button>
                        ${item.cantidad}
                        <button type="button" onclick="Carrito.cambiarCantidad(${item.id}, 1)">+</button>
                    </td>
                    <td>$${subtotal.toFixed(2)}</td>
                    <td><button type="button" onclick="Carrito.eliminar(${item.id})" style="color:red">X</button></td>
                </tr>
            `;
        });
        tbody.innerHTML = html;
        totalSpan.innerText = total.toFixed(2);
        if(inputData) inputData.value = JSON.stringify(carrito);
    }
};

//Inicializar tabla si estamos en carrito.php
document.addEventListener('DOMContentLoaded', () => {
    if(document.getElementById('tabla-carrito')) Carrito.renderizarTabla();
});