$(document).ready(function(){

    $('#Agregar_Distrito_Form').submit(function(e){

        // Previene el comportamiento por defecto del formulario (recarga de página)
        e.preventDefault();

        // Obtiene los valores de los campos del formulario
        var nombre = $('#nombre_distrito').val();
        
        // Realiza una petición AJAX para enviar los datos del nuevo distrito a agregarDistrito_Process.php
        $.ajax({
            url: '../php/agregarDistrito_Process.php',
            method: 'POST',

            data: {
                nombre: nombre,
            },

            // Muestra una alerta de éxito y recarga la página
            success: function (response) {
                // Muestra una alerta de éxito y recarga la página
                dispararAlertaExito("Distrito agregado correctamente").then(() => {       
                        
                });
                location.reload();  
            }
        });
    });

    // Manejador para el botón de modificar distrito
    $(document).on('click', '.btn-modify', function () {
        var distrito_id = $(this).data('id'); // Obtiene el ID del distrito a modificar
        console.log('id_distrito:' + distrito_id);
        // Realiza una petición AJAX para obtener los datos del distrito según su ID
        $.ajax({
            url: '../PHP/listadodistritoindividual_process.php', // URL del archivo PHP que devolverá los detalles del distrito
            method: 'GET', // Método HTTP para solicitar los datos
            // Envía el ID del distrito como parámetro
            data: {
                 id: distrito_id  
                }, 
            
            success: function (response) {
                
                var distrito = JSON.parse(response); // Parse la respuesta JSON
                console.log(distrito);

                if (response.error) {

                    alert(response.error); // Muestra un mensaje de error si lo hay

                } else {
                    // Muestra el modal para modificar el distrito
                    $('#modificardistritomodal').modal('show'); 
                    // Rellena el formulario modal con los datos del distrito para su modificación
                    $('#modificardistritomodal input[name="nombre"]').val(distrito[0].NOMBRE_DISTRITO);
                    $('#modificardistritomodal').data('id', distrito_id); // Guarda el ID del distrito en el modal

                }
            },
            error: function (error) {
                console.error('Error fetching order details:', error); // Muestra el error en la consola
            }
        });
    });

    // Manejador para el envío del formulario de modificar distrito
    $('#ModificarDistritoForm').on('submit', function (e) {
        e.preventDefault(); // Previene el comportamiento por defecto del formulario

        var distrito_id = $('#modificardistritomodal').data('id');  // Obtiene el ID del distrito a modificar
        var formData = $(this).serialize() + '&id=' + distrito_id;  // Serializa los datos del formulario y añade el ID del distrito

        // Realiza una petición AJAX para actualizar los datos del distrito
        $.ajax({
            url: '../PHP/modificardistrito_process.php', // URL del archivo PHP que procesará la solicitud de actualización
            method: 'POST', // Método HTTP para enviar los datos actualizados
            data: formData, // Envía los datos del formulario
            success: function (response) {
                if (response.error) {
                    dispararAlertaError("Error actualizando el distrito").then(() => { });
                    console.error(response);
                    alert(response); // Muestra la respuesta en un alert
                } else {
                    dispararAlertaExito("Distrito actualizado correctamente").then(() => { }); // Muestra un mensaje de éxito
                    location.reload();  
                    $('#modificardistritomodal').modal('hide'); // Oculta el modal
                }
            },
            error: function (error) {
                console.error('Error updating order:', error);
            }
        });
    });

    // Manejador para el botón de eliminar distrito
    $(document).on('click', '.btn-delete', function () {
        var distritoId = $(this).data('id'); // Obtiene el ID del distrito a eliminar

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
                // Si el usuario confirma, realiza una petición AJAX para eliminar el distrito
                $.ajax({
                    url: '../PHP/eliminardistrito_process.php', // URL del archivo PHP que procesará la eliminación
                    method: 'POST', // Método HTTP para enviar la solicitud de eliminación
                    data: { id: distritoId }, // Envía el ID del distrito como parámetro
                    success: function (response) {
                        if (response.error) {
                            Swal.fire('Error', 'No se pudo eliminar el distrito.', 'error');

                        } else {

                            dispararAlertaExito("El distrito ha sido eliminado.").then(() => { 
                                
                            }); // Muestra un mensaje de éxito
                            location.reload();  // Recarga la lista de distritos

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

// Función para cargar la lista de distritos desde la base de datos
function listadodistritos() {
    $.ajax({
        url: '../PHP/listardistritos_process.php', // URL del archivo PHP que devolverá la lista de distritos
        method: 'GET', // Método HTTP para solicitar los datos

        success: function (data) {
            var distritos = JSON.parse(data); // Parse la respuesta JSON
            var tbody = $('#distritosTable tbody');
            tbody.empty(); // Limpia la tabla antes de añadir nuevos datos

            distritos.forEach(function (distrito) {
                // Construye una fila de la tabla con los datos del pedid
                var row = `<tr>
                    <td>${distrito.ID_DISTRITO}</td>
                    <td>${distrito.NOMBRE_DISTRITO}</td>
                    <td>
                        <button class="btn btn-primary btn-modify" data-id="${distrito.ID_DISTRITO}">Modificar</button>
                        <button class="btn btn-danger btn-delete" data-id="${distrito.ID_DISTRITO}">Eliminar</button>
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


