$(document).ready(function(){

    $('#Agregar_Platillo_Form').submit(function(e){

        // Previene el comportamiento por defecto del formulario (recarga de página)
        e.preventDefault();

        // Obtiene los valores de los campos del formulario
        var nombre = $('#nombre_platillo').val();
        var precio = $('#precio').val();
        var cantidad = $('#cantidad').val();
        
        // Realiza una petición AJAX para enviar los datos del nuevo platillo a agregarPlatillo_Process.php
        $.ajax({
            url: '../php/agregarPlatillo_Process.php',
            method: 'POST',

            data: {
                nombre: nombre,
                precio: precio,
                cantidad: cantidad,
            },

            // Muestra una alerta de éxito y recarga la página
            success: function (response) {
                // Muestra una alerta de éxito y recarga la página
                dispararAlertaExito("Platillo agregado correctamente").then(() => {       
                        
                });
                location.reload();  
            }
        });
    });

    // Manejador para el botón de modificar platillo
    $(document).on('click', '.btn-modify', function () {
        var id_platillo = $(this).data('ID_PLATILLO'); // Obtiene el ID del platillo a modificar
        
        // Realiza una petición AJAX para obtener los datos del platillo según su ID
        $.ajax({
            url: '../PHP/listadoplatilloindividual_process.php', // URL del archivo PHP que devolverá los detalles del platillo
            method: 'GET', // Método HTTP para solicitar los datos
            data: { id: id_platillo }, // Envía el ID del platillo como parámetro
            
            success: function (platillo) {
                var platillo = JSON.parse(platillo); // Parse la respuesta JSON
                if (platillo.error) {
                    alert(platillo.error); // Muestra un mensaje de error si lo hay
                } else {
                    // Rellena el formulario modal con los datos del platillo para su modificación
                    $('#modifyOrderModal input[name="nombre"]').val(platillo.Nombre_cliente);
                    $('#modifyOrderModal input[name="direccion"]').val(platillo.Direcion_entrega);
                    $('#modifyOrderModal input[name="telefono"]').val(platillo.telefono);
                    $('#modifyOrderModal textarea[name="detalles"]').val(platillo.Detalle_pedido);
                    $('#modifyOrderModal select[name="estado"]').val(platillo.estado); 
                    $('#modifyOrderModal').data('id', pedidoId); // Guarda el ID del platillo en el modal

                    $('#modifyOrderModal').modal('show'); // Muestra el modal para modificar el platillo
                }
            },
            error: function (error) {
                console.error('Error fetching order details:', error); // Muestra el error en la consola
            }
        });
    });

    // Manejador para el envío del formulario de modificar pedido
    $('#modifyOrderForm').on('submit', function (e) {
        e.preventDefault(); // Previene el comportamiento por defecto del formulario

        var pedidoId = $('#modifyOrderModal').data('id');  // Obtiene el ID del pedido a modificar
        var formData = $(this).serialize() + '&id=' + pedidoId;  // Serializa los datos del formulario y añade el ID del pedido

        // Realiza una petición AJAX para actualizar los datos del pedido
        $.ajax({
            url: '../PHP/ModificarPedido_Process.php', // URL del archivo PHP que procesará la solicitud de actualización
            method: 'POST', // Método HTTP para enviar los datos actualizados
            data: formData, // Envía los datos del formulario
            success: function (response) {
                if (response.includes("éxito")) {
                    alert('Pedido actualizado correctamente'); // Muestra un mensaje de éxito
                    $('#modifyOrderModal').modal('hide'); // Oculta el modal
                    fetchOrders();  // Recarga la lista de pedidos
                } else {
                    alert('Error actualizando el pedido');
                    console.error(response);
                    alert(response); // Muestra la respuesta en un alert
                }
            },
            error: function (error) {
                console.error('Error updating order:', error);
            }
        });
    });

});

// Función para cargar la lista de platillos desde la base de datos
function listadoplatillos() {
    $.ajax({
        url: '../PHP/listarplatillos_process.php', // URL del archivo PHP que devolverá la lista de platillos
        method: 'GET', // Método HTTP para solicitar los datos

        success: function (data) {
            var platillos = JSON.parse(data); // Parse la respuesta JSON
            var tbody = $('#platillosTable tbody');
            tbody.empty(); // Limpia la tabla antes de añadir nuevos datos

            platillos.forEach(function (platillo) {
                // Construye una fila de la tabla con los datos del pedid
                var row = `<tr>
                    <td>${platillo.ID_PLATILLO}</td>
                    <td>${platillo.NOMBRE_PLATILLO}</td>
                    <td>${platillo.PRECIO_UNITARIO}</td>
                    <td>${platillo.CANTIDAD}</td>
                    <td>
                        <button class="btn btn-primary btn-modify" data-id="${platillo.ID_PLATILLO}">Modificar</button>
                        <button class="btn btn-danger btn-delete" data-id="${platillo.ID_PLATILLO}">Eliminar</button>
                    </td>
                </tr>`;
                tbody.append(row); // Añade la fila a la tabla
            });
        },
        error: function (error) {
            console.error('Error fetching orders:', error); // Muestra el error en la consola
        }
    });
}

// Función para mostrar una alerta de éxito usando SweetAlert2
function dispararAlertaExito(mensaje) {
    Swal.fire({
        icon: "success", // Icono de éxito
        title: mensaje, // Título de la alerta
        confirmButtonText: 'Ok' // Texto del botón de confirmación
    }).then(() => {
        location.reload();  // Recarga la página después de cerrar la alerta
    });
}
// Función para mostrar una alerta de error usando SweetAlert2
function dispararAlertaError(mensaje) {
    Swal.fire({
        icon: "error", // Icono de error
        title: mensaje,
        confirmButtonText: 'Ok' // Texto del botón de confirmación
    }).then(() => {
        location.reload(); // Recarga la página después de cerrar la alerta
    });
}


