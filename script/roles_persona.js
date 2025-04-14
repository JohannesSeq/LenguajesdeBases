$(document).ready(function(){

    $('#Agregar_Rol_persona_Form').submit(function(e){

        // Previene el comportamiento por defecto del formulario (recarga de página)
        e.preventDefault();

        // Obtiene los valores de los campos del formulario
        var id_rol = $('#id_rol_persona').val();
        var nombre = $('#nombre_rol_persona').val();
        var descripcion = $('#descripcion_rol_persona').val();
        var nivel = $('#nivel').val();

        console.log(id_rol, nombre, descripcion, nivel)
        
        // Realiza una petición AJAX para enviar los datos del nuevo rol_persona a agregarRol_persona_Process.php
        $.ajax({
            url: '../php/Roles_persona/agregar_Process.php',
            method: 'POST',

            data: {
                id_rol: id_rol,
                nombre: nombre,
                descripcion: descripcion,
                nivel: nivel,
            },

            // Muestra una alerta de éxito y recarga la página


            success: function (response) {
                // Muestra una alerta de éxito y recarga la página

                if (response.error) {
                    console.log(response);
                    dispararAlertaError("Error creando el rol");
                } else {
                    console.log(response);
                    dispararAlertaExito("Rol agregado correctamente");
                    //location.reload();  
                }


            }
        });
    });

    // Manejador para el botón de modificar Rol_persona
    $(document).on('click', '.btn-modify', function () {
        var rol_persona_id = $(this).data('id'); // Obtiene el ID del rol_persona a modificar
        console.log('id_rol_persona:' + rol_persona_id);
        // Realiza una petición AJAX para obtener los datos del rol_persona según su ID
        $.ajax({
            url: '../PHP/Roles_persona/listadoindividual_process.php', // URL del archivo PHP que devolverá los detalles del rol_persona
            method: 'GET', // Método HTTP para solicitar los datos
            // Envía el ID del rol_persona como parámetro
            data: {
                 id: rol_persona_id  
                }, 
            
            success: function (response) {
                
                var rol_persona = JSON.parse(response); // Parse la respuesta JSON
                console.log(rol_persona);

                if (response.error) {

                    alert(response.error); // Muestra un mensaje de error si lo hay

                } else {
                    // Muestra el modal para modificar el rol_persona
                    
                    $('#modificarrol_personamodal').modal('show'); 
                    // Rellena el formulario modal con los datos del rol_persona para su modificación
                    $('#modificarrol_personamodal input[name="nombre_rol_persona"]').val(rol_persona[0].NOMBRE_LARGO_TIPO);
                    $('#modificarrol_personamodal textarea[name="descripcion"]').val(rol_persona[0].DESCRIPCION);
                    $('#modificarrol_personamodal select[name="nivel"]').val(rol_persona[0].NIVEL_PERMISO);
                    $('#modificarrol_personamodal').data('id', rol_persona_id); // Guarda el ID del rol_persona en el modal
                }
            },
            error: function (error) {
                console.error('Error fetching order details:', error); // Muestra el error en la consola
            }
        });
    });

    // Manejador para el envío del formulario de modificar rol_persona
    $('#ModificarRol_personaForm').on('submit', function (e) {
        e.preventDefault(); // Previene el comportamiento por defecto del formulario

        var rol_persona_id = $('#modificarrol_personamodal').data('id');  // Obtiene el ID del rol_persona a modificar
        var formData = $(this).serialize() + '&id=' + rol_persona_id;  // Serializa los datos del formulario y añade el ID del rol_persona
        
        // Realiza una petición AJAX para actualizar los datos del rol_persona
        $.ajax({
            url: '../PHP/Roles_persona/modificar_process.php', // URL del archivo PHP que procesará la solicitud de actualización
            method: 'POST', // Método HTTP para enviar los datos actualizados
            data: formData, // Envía los datos del formulario
            success: function (response) {
                /*
                if (response.error) {
                    dispararAlertaError("Error actualizando el rol");
                    console.error(response);
                    alert(response); // Muestra la respuesta en un alert
                } else {
                    dispararAlertaExito("Rol actualizado correctamente"); // Muestra un mensaje de éxito
                    //location.reload();  
                    $('#modificarrol_personamodal').modal('hide'); // Oculta el modal
                }*/
            },
            error: function (error) {
                console.error('Error updating order:', error);
            }
        });
    });

    // Manejador para el botón de eliminar rol_persona
    $(document).on('click', '.btn-delete', function () {
        var rol_personaId = $(this).data('id'); // Obtiene el ID del rol_persona a eliminar

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
                // Si el usuario confirma, realiza una petición AJAX para eliminar el rol_persona
                $.ajax({
                    url: '../PHP/Roles_persona/eliminarrol_persona_process.php', // URL del archivo PHP que procesará la eliminación
                    method: 'POST', // Método HTTP para enviar la solicitud de eliminación
                    data: { id: rol_personaId }, // Envía el ID del rol_persona como parámetro
                    success: function (response) {
                        if (response.error) {
                            Swal.fire('Error', 'No se pudo eliminar el rol_persona.', 'error');

                        } else {

                            dispararAlertaExito("El rol ha sido eliminado."); // Muestra un mensaje de éxito
                            location.reload();  // Recarga la lista de Roles_persona

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

// Función para cargar la lista de Roles_persona desde la base de datos
function listadoroles_persona() {
    $.ajax({
        url: '../PHP/Roles_persona/listar_process.php', // URL del archivo PHP que devolverá la lista de Roles_persona
        method: 'GET', // Método HTTP para solicitar los datos

        success: function (data) {
            var roles_persona = JSON.parse(data); // Parse la respuesta JSON
            var tbody = $('#roles_personaTable tbody');
            tbody.empty(); // Limpia la tabla antes de añadir nuevos datos

            roles_persona.forEach(function (rol_persona) {
                // Construye una fila de la tabla con los datos del pedid
                var row = `<tr>
                    <td>${rol_persona.ID_ROL_PERSONA}</td>
                    <td>${rol_persona.NOMBRE_LARGO_TIPO}</td>
                    <td>${rol_persona.DESCRIPCION}</td>
                    <td>${rol_persona.NIVEL_PERMISO}</td>
                    <td>
                        <button class="btn btn-primary btn-modify" data-id="${rol_persona.ID_ROL_PERSONA}">Modificar</button>
                        <button class="btn btn-danger btn-delete" data-id="${rol_persona.ID_ROL_PERSONA}">Eliminar</button>
                    </td>
                </tr>`;
                tbody.append(row); // Añade la fila a la tabla
            });
        },
        error: function (error) {
            console.error('Error cargando los roles:', error); // Muestra el error en la consola
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


