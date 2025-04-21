$(document).ready(function(){

    $('#Agregar_Provincia_Form').submit(function(e){

        // Previene el comportamiento por defecto del formulario (recarga de página)
        e.preventDefault();

        // Obtiene los valores de los campos del formulario
        var nombre = $('#nombre_provincia').val();
        
        // Realiza una petición AJAX para enviar los datos de la nueva provincia a agregarProvincia_Process.php
        $.ajax({
            url: '../php/Provincias/agregarProvincia_Process.php',
            method: 'POST',

            data: {
                nombre: nombre,
            },

            // Muestra una alerta de éxito y recarga la página
            success: function (response) {
                // Muestra una alerta de éxito y recarga la página
                $('#Agregar_Provincia_Form').modal('hide');
                dispararAlertaExito("Provincia agregada correctamente");
            }
        });
    });

    // Manejador para el botón de modificar provincia
    $(document).on('click', '.btn-modify', function () {
        var provincia_id = $(this).data('id'); // Obtiene el ID del provincia a modificar
        console.log('id_provincia:' + provincia_id);
        // Realiza una petición AJAX para obtener los datos de la provincia según su ID
        $.ajax({
            url: '../PHP/Provincias/listadoprovinciaindividual_process.php', // URL del archivo PHP que devolverá los detalles de la provincia
            method: 'GET', // Método HTTP para solicitar los datos
            // Envía el ID de la provincia como parámetro
            data: {
                 id: provincia_id  
                }, 
            
            success: function (response) {
                
                var provincia = JSON.parse(response); // Parse la respuesta JSON
                console.log(provincia);

                if (response.error) {

                    alert(response.error); // Muestra un mensaje de error si lo hay

                } else {
                    // Muestra el modal para modificar la provincia
                    $('#modificarprovinciamodal').modal('show'); 
                    // Rellena el formulario modal con los datos de la provincia para su modificación
                    $('#modificarprovinciamodal input[name="nombre"]').val(provincia[0].NOMBRE_PROVINCIA);
                    $('#modificarprovinciamodal').data('id', provincia_id); // Guarda el ID de la provincia en el modal

                }
            },
            error: function (error) {
                console.error('Error fetching order details:', error); // Muestra el error en la consola
            }
        });
    });

    // Manejador para el envío del formulario de modificar provincia
    $('#ModificarProvinciaForm').on('submit', function (e) {
        e.preventDefault(); // Previene el comportamiento por defecto del formulario

        var provincia_id = $('#modificarprovinciamodal').data('id');  // Obtiene el ID de la provincia a modificar
        var formData = $(this).serialize() + '&id=' + provincia_id;  // Serializa los datos del formulario y añade el ID del provincia

        // Realiza una petición AJAX para actualizar los datos del provincia
        $.ajax({
            url: '../PHP/Provincias/modificarprovincia_process.php', // URL del archivo PHP que procesará la solicitud de actualización
            method: 'POST', // Método HTTP para enviar los datos actualizados
            data: formData, // Envía los datos del formulario
            success: function (response) {
                if (response.error) {
                    dispararAlertaError("Error actualizando el provincia");
                    console.error(response);
                    alert(response); // Muestra la respuesta en un alert
                } else {
                    dispararAlertaExito("Provincia actualizado correctamente"); // Muestra un mensaje de éxito
                    location.reload();  
                    $('#modificarprovinciamodal').modal('hide'); // Oculta el modal
                }
            },
            error: function (error) {
                console.error('Error updating order:', error);
            }
        });
    });

    // Manejador para el botón de eliminar provincia
    $(document).on('click', '.btn-delete', function () {
        var provinciaId = $(this).data('id'); // Obtiene el ID del provincia a eliminar

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
                // Si el usuario confirma, realiza una petición AJAX para eliminar el provincia
                $.ajax({
                    url: '../PHP/Provincias/eliminarprovincia_process.php', // URL del archivo PHP que procesará la eliminación
                    method: 'POST', // Método HTTP para enviar la solicitud de eliminación
                    data: { id: provinciaId }, // Envía el ID del provincia como parámetro
                    success: function (response) {
                        if (response.error) {
                            Swal.fire('Error', 'No se pudo eliminar la provincia.', 'error');

                        } else {

                            dispararAlertaExito("La provincia ha sido eliminado."); // Muestra un mensaje de éxito
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

// Función para cargar la lista de provincias desde la base de datos
function listadoprovincias() {
    $.ajax({
        url: '../PHP/Provincias/listarprovincias_process.php', // URL del archivo PHP que devolverá la lista de provincias
        method: 'GET', // Método HTTP para solicitar los datos

        success: function (data) {
            var provincias = JSON.parse(data); // Parse la respuesta JSON
            var tbody = $('#provinciasTable tbody');
            tbody.empty(); // Limpia la tabla antes de añadir nuevos datos

            provincias.forEach(function (provincia) {
                // Construye una fila de la tabla con los datos del pedid
                var row = `<tr>
                    <td>${provincia.ID_PROVINCIA}</td>
                    <td>${provincia.NOMBRE_PROVINCIA}</td>
                    <td>
                        <button class="btn btn-primary btn-modify" data-id="${provincia.ID_PROVINCIA}">Modificar</button>
                        <button class="btn btn-danger btn-delete" data-id="${provincia.ID_PROVINCIA}">Eliminar</button>
                    </td>
                </tr>`;
                tbody.append(row); // Añade la fila a la tabla
            });
        },
        error: function (error) {
            console.error('Error cargando las provincia :', error); // Muestra el error en la consola
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
        listadoprovincias();  // Recarga la página después de cerrar la alerta
    });
}
// Función para mostrar una alerta de error usando SweetAlert2
function dispararAlertaError(mensaje) {
    Swal.fire({
        icon: "error", // Icono de error
        title: mensaje,
        confirmButtonText: 'Ok' // Texto del botón de confirmación
    }).then(() => {
        listadoprovincias(); // Recarga la página después de cerrar la alerta
    });
}


