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
        var platillo_id = $(this).data('id'); // Obtiene el ID del platillo a modificar
        console.log('id_platillo:' + platillo_id);
        // Realiza una petición AJAX para obtener los datos del platillo según su ID
        $.ajax({
            url: '../PHP/listadoplatilloindividual_process.php', // URL del archivo PHP que devolverá los detalles del platillo
            method: 'GET', // Método HTTP para solicitar los datos
            // Envía el ID del platillo como parámetro
            data: {
                 id: platillo_id  
                }, 
            
            success: function (response) {
                
                var platillo = JSON.parse(response); // Parse la respuesta JSON
                console.log(platillo);

                if (response.error) {

                    alert(response.error); // Muestra un mensaje de error si lo hay

                } else {
                    // Muestra el modal para modificar el platillo
                    $('#modificarplatillomodal').modal('show'); 
                    // Rellena el formulario modal con los datos del platillo para su modificación
                    $('#modificarplatillomodal input[name="nombre"]').val(platillo[0].NOMBRE_PLATILLO);
                    $('#modificarplatillomodal input[name="precio"]').val(platillo[0].PRECIO_UNITARIO);
                    $('#modificarplatillomodal input[name="cantidad"]').val(platillo[0].CANTIDAD);
                    $('#modificarplatillomodal').data('id', platillo_id); // Guarda el ID del platillo en el modal

                }
            },
            error: function (error) {
                console.error('Error fetching order details:', error); // Muestra el error en la consola
            }
        });
    });

    // Manejador para el envío del formulario de modificar platillo
    $('#ModificarPlatilloForm').on('submit', function (e) {
        e.preventDefault(); // Previene el comportamiento por defecto del formulario

        var platillo_id = $('#modificarplatillomodal').data('id');  // Obtiene el ID del platillo a modificar
        var formData = $(this).serialize() + '&id=' + platillo_id;  // Serializa los datos del formulario y añade el ID del platillo

        // Realiza una petición AJAX para actualizar los datos del platillo
        $.ajax({
            url: '../PHP/modificarplatillo_process.php', // URL del archivo PHP que procesará la solicitud de actualización
            method: 'POST', // Método HTTP para enviar los datos actualizados
            data: formData, // Envía los datos del formulario
            success: function (response) {
                if (response.error) {
                    dispararAlertaError("Error actualizando el platillo").then(() => { });
                    console.error(response);
                    alert(response); // Muestra la respuesta en un alert
                } else {
                    dispararAlertaExito("Platillo actualizado correctamente").then(() => { }); // Muestra un mensaje de éxito
                    location.reload();  
                    $('#modificarplatillomodal').modal('hide'); // Oculta el modal
                }
            },
            error: function (error) {
                console.error('Error updating order:', error);
            }
        });
    });

    // Manejador para el botón de eliminar platillo
    $(document).on('click', '.btn-delete', function () {
        var platilloId = $(this).data('id'); // Obtiene el ID del platillo a eliminar

        // Muestra una alerta de confirmación usando SweetAlert2
        Swal.fire({
            title: '¿Estás seguro?',
            text: "No podrás revertir esta acción!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminarlo!'

        }).then((result) => {
            if (result.isConfirmed) {
                // Si el usuario confirma, realiza una petición AJAX para eliminar el platillo
                $.ajax({
                    url: '../PHP/eliminarplatillo_process.php', // URL del archivo PHP que procesará la eliminación
                    method: 'POST', // Método HTTP para enviar la solicitud de eliminación
                    data: { id: platilloId }, // Envía el ID del platillo como parámetro
                    success: function (response) {
                        if (response.error) {
                            Swal.fire('Error', 'No se pudo eliminar el platillo.', 'error');

                        } else {

                            dispararAlertaExito("El platillo ha sido eliminado.").then(() => { 
                                
                            }); // Muestra un mensaje de éxito
                            location.reload();  // Recarga la lista de platillos

                        }
                    },
                    error: function (error) {
                        console.error('Error deleting order:', error);
                    }
                });
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


