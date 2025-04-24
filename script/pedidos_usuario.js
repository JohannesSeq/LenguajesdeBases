$(document).ready(function(){

    $(document).on('click', '.btn-desglose', function () {
        var Pedidoid = $(this).data('id'); // Obtiene el ID del distrito a eliminar

        $.ajax({


            url: '../PHP/Pedidos/listarPlatillosPedido_Process.php', // URL del archivo PHP que devolverá los detalles del distrito
            method: 'GET', // Método HTTP para solicitar los datos
            // Envía el ID del distrito como parámetro
            data: 
            {
                id: Pedidoid  
            },                     

            success: function (response) {
        
            var platillos = JSON.parse(response); // Parse la respuesta JSON
            console.log(distrito);

            if (response.error) {

                alert(response.error); // Muestra un mensaje de error si lo hay

            } else {

                var tbody = $('#desgloseTable tbody');
                tbody.empty(); // Limpia la tabla antes de añadir nuevos datos

                // Muestra el modal para modificar el distrito
                $('#modalDesglose').modal('show');

                platillos.forEach(function (platillo) {

                // Construye una fila de la tabla con los datos del pedid
                var row = `<tr>
                    <td>${platillo.NOMBRE_PLATILLO}</td>
                    <td>${platillo.PRECIO_DEL_PLATILLO}</td>
                </tr>`;

        tbody.append(row); // Añade la fila a la tabla
    });

            }
        },
        error: function (error) {
            console.error('Error fetching order details:', error); // Muestra el error en la consola
        }


        });

        
    });

});

function getEmailFromCookie() {
    const match = document.cookie.match(/(?:^|; )email=([^;]*)/);
    return match ? decodeURIComponent(match[1]) : null;
}

function cargarPedidosUsuario() {
    const email = getEmailFromCookie();
    if (!email) {
        Swal.fire("Error", "No se encontró la sesión del usuario", "error");
        return;
    }

    fetch(`../PHP/Personas/listadoindividualcliente_process.php?email=${encodeURIComponent(email)}`)
        .then(res => res.json())
        .then(data => {
            if (data && data[0] && data[0].CEDULA) {
                const cedula = data[0].CEDULA;
                const nombre = `${data[0].NOMBRE} ${data[0].APELLIDO}`;
                consultarPedidosPorCedula(cedula, nombre);
            } else {
                Swal.fire("Error", "No se encontró la cédula del usuario", "error");
            }
        });
}

function consultarPedidosPorCedula(cedula, nombre) {
    fetch("../PHP/Pedidos/listarPedidosUsuario_Process.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ cedula_cliente: cedula })
    })
    .then(res => res.json())
    .then(pedidos => {
        const tbody = document.querySelector("#pedidosUsuarioTable tbody");
        tbody.innerHTML = "";

        pedidos.forEach(p => {
            const acciones = p.ESTADO_PEDIDO === "Pendiente"
                ? `
                <button class="btn btn-secondary btn-desglose" data-id="${p.ID_PEDIDO}">Desglose</button>
                <button class="btn btn-success btn-pagar"
                            data-id="${p.ID_PEDIDO}"
                            data-cliente="${cedula}"
                            data-nombre="${nombre}"
                            data-monto="${p.MONTO_ESTIMADO}">
                        Realizar pago
                   </button>`
                : `<button class="btn btn-secondary btn-desglose" data-id="${p.ID_PEDIDO}">Desglose</button>`;

            const row = `
                <tr>
                    <td>${p.ID_PEDIDO}</td>
                    <td>₡${p.MONTO_ESTIMADO}</td>
                    <td>${p.ESTADO_PEDIDO}</td>
                    <td>${acciones}</td>
                </tr>`;
            tbody.innerHTML += row;
        });
    })
    .catch((error) => {
        console.error("Error al cargar los pedidos:", error);
        Swal.fire("Error", "No se pudieron cargar tus pedidos", "error");
    });
}
