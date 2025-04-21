$(document).ready(function(){

    $('#Agregar_Canton_Form').submit(function(e){

        // Previene el comportamiento por defecto del formulario (recarga de página)
        e.preventDefault();

        // Obtiene los valores de los campos del formulario
        var nombre = $('#nombre_canton').val();
        
        // Realiza una petición AJAX para enviar los datos del nuevo canton a agregarCanton_Process.php
        $.ajax({
            url: '../php/Cantones/agregarCanton_Process.php',
            method: 'POST',

            data: {
                nombre: nombre,
            },

            // Muestra una alerta de éxito y recarga la página
            success: function (response) {
                // Muestra una alerta de éxito y recarga la página
                dispararAlertaExito("Canton agregado correctamente");
                $('#modalAgregarCanton').modal('hide'); 
            }
        });
    });

    // Manejador para el botón de modificar canton
    $(document).on('click', '.btn-modify', function () {
        var canton_id = $(this).data('id'); // Obtiene el ID del canton a modificar
        console.log('id_canton:' + canton_id);
        // Realiza una petición AJAX para obtener los datos del canton según su ID
        $.ajax({
            url: '../PHP/Cantones/listadocantonindividual_process.php', // URL del archivo PHP que devolverá los detalles del canton
            method: 'GET', // Método HTTP para solicitar los datos
            // Envía el ID del canton como parámetro
            data: {
                 id: canton_id  
                }, 
            
            success: function (response) {
                
                var canton = JSON.parse(response); // Parse la respuesta JSON
                console.log(canton);

                if (response.error) {

                    alert(response.error); // Muestra un mensaje de error si lo hay

                } else {
                    // Muestra el modal para modificar el canton
                    $('#modificarcantonmodal').modal('show'); 
                    // Rellena el formulario modal con los datos del canton para su modificación
                    $('#modificarcantonmodal input[name="nombre"]').val(canton[0].NOMBRE_CANTON);
                    $('#modificarcantonmodal').data('id', canton_id); // Guarda el ID del canton en el modal

                }
            },
            error: function (error) {
                console.error('Error fetching order details:', error); // Muestra el error en la consola
            }
        });
    });

    // Manejador para el envío del formulario de modificar canton
    $('#ModificarCantonForm').on('submit', function (e) {
        e.preventDefault(); // Previene el comportamiento por defecto del formulario

        var canton_id = $('#modificarcantonmodal').data('id');  // Obtiene el ID del canton a modificar
        var formData = $(this).serialize() + '&id=' + canton_id;  // Serializa los datos del formulario y añade el ID del canton

        // Realiza una petición AJAX para actualizar los datos del canton
        $.ajax({
            url: '../PHP/Cantones/modificarcanton_process.php', // URL del archivo PHP que procesará la solicitud de actualización
            method: 'POST', // Método HTTP para enviar los datos actualizados
            data: formData, // Envía los datos del formulario
            success: function (response) {
                if (response.error) {
                    dispararAlertaError("Error actualizando el canton");
                    console.error(response);
                    alert(response); // Muestra la respuesta en un alert
                } else {
                    dispararAlertaExito("canton actualizado correctamente"); // Muestra un mensaje de éxito
                    $('#modificarcantonmodal').modal('hide'); // Oculta el modal
                }
            },
            error: function (error) {
                console.error('Error updating order:', error);
            }
        });
    });

    // Manejador para el botón de eliminar canton
    $(document).on('click', '.btn-delete', function () {
        var cantonId = $(this).data('id'); // Obtiene el ID del canton a eliminar

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
                // Si el usuario confirma, realiza una petición AJAX para eliminar el canton
                $.ajax({
                    url: '../PHP/Cantones/eliminarcanton_process.php', // URL del archivo PHP que procesará la eliminación
                    method: 'POST', // Método HTTP para enviar la solicitud de eliminación
                    data: { id: cantonId }, // Envía el ID del canton como parámetro
                    success: function (response) {
                        if (response.error) {
                            Swal.fire('Error', 'No se pudo eliminar la canton.', 'error');

                        } else {

                            dispararAlertaExito("El canton ha sido eliminado."); // Muestra un mensaje de éxito

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

// Función para cargar la lista de cantones desde la base de datos
function listadocantones() {
    $.ajax({
        url: '../PHP/Cantones/listarcantones_process.php', // URL del archivo PHP que devolverá la lista de cantones
        method: 'GET', // Método HTTP para solicitar los datos

        success: function (data) {
            var cantones = JSON.parse(data); // Parse la respuesta JSON
            var tbody = $('#cantonesTable tbody');
            tbody.empty(); // Limpia la tabla antes de añadir nuevos datos

            cantones.forEach(function (canton) {
                // Construye una fila de la tabla con los datos del pedid
                var row = `<tr>
                    <td>${canton.ID_CANTON}</td>
                    <td>${canton.NOMBRE_CANTON}</td>
                    <td>
                        <button class="btn btn-primary btn-modify" data-id="${canton.ID_CANTON}">Modificar</button>
                        <button class="btn btn-danger btn-delete" data-id="${canton.ID_CANTON}">Eliminar</button>
                    </td>
                </tr>`;
                tbody.append(row); // Añade la fila a la tabla
            });
        },
        error: function (error) {
            console.error('Error cargando los cantones:', error); // Muestra el error en la consola
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
        listadocantones();  // Recarga la página después de cerrar la alerta
    });
}
// Función para mostrar una alerta de error usando SweetAlert2
function dispararAlertaError(mensaje) {
    Swal.fire({
        icon: "error", // Icono de error
        title: mensaje,
        confirmButtonText: 'Ok' // Texto del botón de confirmación
    }).then(() => {
        listadocantones(); // Recarga la página después de cerrar la alerta
    });
}


