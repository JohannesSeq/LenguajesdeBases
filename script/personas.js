$(document).ready(function(){

    $('#Agregar_Persona_Form').submit(function(e){

        // Previene el comportamiento por defecto del formulario (recarga de página)
        e.preventDefault();

        // Obtiene los valores de los campos del formulario
        var cedula = $('#cedula').val();
        var nombre = $('#nombre_persona').val();
        var apellidos = $('#apellidos_persona').val();
        var numero_telefono = $('#numero_telefono').val();
        var rol = $('#rol').val();
        var provincia = $('#provincia').val();
        var canton = $('#canton').val();
        var distrito = $('#distrito').val();
        var correo = $('#correo').val();
        var correo_respaldo = $('#correo_respaldo').val();
        var password_persona = $('#password_persona').val();

        
        // Realiza una petición AJAX para enviar los datos de la nueva persona a agregarPersona_Process.php
        $.ajax({
            url: '../php/Personas/agregarPersona_Process.php',
            method: 'POST',

            data: {
                cedula: cedula,
                nombre: nombre,
                apellidos: apellidos,
                numero_telefono: numero_telefono,
                rol: rol,
                provincia: provincia,
                canton: canton,
                distrito: distrito,
                correo: correo,
                correo_respaldo: correo_respaldo,
                password_persona: password_persona,
            },

            // Muestra una alerta de éxito y recarga la página
            success: function (response) {
                // Muestra una alerta de éxito y recarga la página
                dispararAlertaExito("Persona agregada correctamente");
            }
        });
    });

    // Manejador para el botón de modificar persona
    $(document).on('click', '.btn-modify', function () {
        var persona_id = $(this).data('id'); // Obtiene el ID del persona a modificar
        console.log('id_persona:' + persona_id);
        // Realiza una petición AJAX para obtener los datos de la persona según su ID
        $.ajax({
            url: '../PHP/Personas/listadopersonaindividual_process.php', // URL del archivo PHP que devolverá los detalles de la persona
            method: 'GET', // Método HTTP para solicitar los datos
            // Envía el ID de la persona como parámetro
            data: {
                 id: persona_id  
                }, 
            
            success: function (response) {
                
                var persona = JSON.parse(response); // Parse la respuesta JSON
                console.log(persona);

                if (response.error) {

                    alert(response.error); // Muestra un mensaje de error si lo hay

                } else {
                    // Muestra el modal para modificar la persona
                    $('#modificarpersonamodal').modal('show'); 
                    // Rellena el formulario modal con los datos de la persona para su modificación
                    $('#modificarpersonamodal input[name="cedula"]').val(persona_id);
                    $('#modificarpersonamodal input[name="nombre_persona"]').val(persona[0].NOMBRE);
                    $('#modificarpersonamodal input[name="apellidos_persona"]').val(persona[0].APELLIDO);
                    $('#modificarpersonamodal input[name="numero_telefono"]').val(persona[0].NUMERO_DE_TELEFONO);
                    $('#modificarpersonamodal select[name="rol"]').val(persona[0].ID_ROL);
                    $('#modificarpersonamodal select[name="provincia"]').val(persona[0].ID_PROVINCIA);
                    $('#modificarpersonamodal select[name="canton"]').val(persona[0].ID_CANTON);
                    $('#modificarpersonamodal select[name="distrito"]').val(persona[0].ID_DISTRITO);
                    $('#modificarpersonamodal input[name="correo_respaldo"]').val(persona[0].CORREO_DE_RESPALDO);
                    $('#modificarpersonamodal input[name="correo"]').val(persona[0].DIRECCION_DE_CORREO);
                    $('#modificarpersonamodal').data('id', persona_id); // Guarda el ID de la persona en el modal

                }
            },
            error: function (error) {
                console.error('Error fetching order details:', error); // Muestra el error en la consola
            }
        });
    });

    // Manejador para el envío del formulario de modificar persona
    $('#ModificarPersonaForm').on('submit', function (e) {
        e.preventDefault(); // Previene el comportamiento por defecto del formulario

        var persona_id = $('#modificarpersonamodal').data('id');  // Obtiene el ID de la persona a modificar
        var formData = $(this).serialize() + '&id=' + persona_id;  // Serializa los datos del formulario y añade el ID del persona

        // Realiza una petición AJAX para actualizar los datos del persona
        $.ajax({
            url: '../PHP/Personas/modificarpersona_process.php', // URL del archivo PHP que procesará la solicitud de actualización
            method: 'POST', // Método HTTP para enviar los datos actualizados
            data: formData, // Envía los datos del formulario
            success: function (response) {
                console.log(formData);
                console.log(response);
                
                if (response.error) {
                    dispararAlertaError("Error actualizando la persona");
                    console.error(response);
                    alert(response); // Muestra la respuesta en un alert
                } else {
                    dispararAlertaExito("Persona actualizada correctamente"); // Muestra un mensaje de éxito
                    
                    location.reload();  
                    $('#modificarpersonamodal').modal('hide'); // Oculta el modal
                }
            },
            error: function (error) {
                console.error('Error updating order:', error);
            }
        });
    });

    // Manejador para el botón de eliminar persona
    $(document).on('click', '.btn-delete', function () {
        var personaId = $(this).data('id'); // Obtiene el ID del persona a eliminar

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
                // Si el usuario confirma, realiza una petición AJAX para eliminar el persona
                $.ajax({
                    url: '../PHP/Personas/eliminarpersona_process.php', // URL del archivo PHP que procesará la eliminación
                    method: 'POST', // Método HTTP para enviar la solicitud de eliminación
                    data: { id: personaId }, // Envía el ID del persona como parámetro
                    success: function (response) {
                        if (response.error) {
                            Swal.fire('Error', 'No se pudo eliminar la persona.', 'error');

                        } else {

                            dispararAlertaExito("La persona ha sido eliminado."); // Muestra un mensaje de éxito
                            //location.reload();  // Recarga la lista de personas

                        }
                    },
                    error: function (error) {
                        console.error('Error deleting order:', error);
                    }
                });
            }
        });
    });








    // Manejador para el botón de reiniciar contraseña
    $(document).on('click', '.btn-rst', function () {
        var persona_id = $(this).data('id'); // Obtiene el ID del persona a modificar
        console.log('id_persona:' + persona_id);
        // Realiza una petición AJAX para obtener los datos de la persona según su ID
        $.ajax({
            url: '../PHP/Personas/listadopersonaindividual_process.php', // URL del archivo PHP que devolverá los detalles de la persona
            method: 'GET', // Método HTTP para solicitar los datos
            // Envía el ID de la persona como parámetro
            data: {
                    id: persona_id  
                }, 
            
            success: function (response) {
                
                var persona = JSON.parse(response); // Parse la respuesta JSON
                console.log(persona);

                if (response.error) {

                    alert(response.error); // Muestra un mensaje de error si lo hay

                } else {
                    // Muestra el modal para modificar la persona
                    $('#reiniciarpassmodal').modal('show'); 
                    $('#reiniciarpassmodal').data('id', persona_id); // Guarda el ID de la persona en el modal
                    // Rellena el formulario modal con los datos de la persona para su modificación
                }
            },
            error: function (error) {
                console.error('Error fetching person details:', error); // Muestra el error en la consola
            }
        });
    });

    // Manejo del envio de la contraseña
    $('#ReiniciarPassForm').on('submit', function (e) {
        e.preventDefault(); // Previene el comportamiento por defecto del formulario

        var persona_id = $('#reiniciarpassmodal').data('id');  // Obtiene el ID de la persona a modificar
        var formData = $(this).serialize() + '&id=' + persona_id;  // Serializa los datos del formulario y añade el ID del persona

        // Realiza una petición AJAX para actualizar los datos del persona
        $.ajax({
            url: '../PHP/Personas/reiniciarpass_process.php', // URL del archivo PHP que procesará la solicitud de actualización
            method: 'POST', // Método HTTP para enviar los datos actualizados
            data: formData, // Envía los datos del formulario
            success: function (response) {
                console.log(formData);
                console.log(response);
                
                if (response.error) {
                    dispararAlertaError("Error actualizando la contraseña");
                    console.error(response);
                    alert(response); // Muestra la respuesta en un alert
                } else {
                    dispararAlertaExito("Contraseña actualizada correctamente"); // Muestra un mensaje de éxito
                    
                    //location.reload();  
                    $('#reiniciarpassmodal').modal('hide'); // Oculta el modal
                }
            },
            error: function (error) {
                console.error('Error updating order:', error);
            }
        });
    });





});

// Función para cargar la lista de personas desde la base de datos
function listadopersonas() {
    $.ajax({
        url: '../PHP/Personas/listarpersonas_process.php', // URL del archivo PHP que devolverá la lista de personas
        method: 'GET', // Método HTTP para solicitar los datos

        success: function (data) {
            var personas = JSON.parse(data); // Parse la respuesta JSON
            var tbody = $('#personasTable tbody');
            tbody.empty(); // Limpia la tabla antes de añadir nuevos datos

            personas.forEach(function (persona) {
                // Construye una fila de la tabla con los datos del pedid
                var row = `<tr>
                    <td>${persona.CEDULA}</td>
                    <td>${persona.NOMBRE} ${persona.APELLIDO}</td>
                    <td>
                        <button class="btn btn-primary btn-modify" data-id="${persona.CEDULA}">Modificar y ver propiedades</button>
                        <button class="btn btn-primary btn-rst" data-id="${persona.CEDULA}">Reiniciar Contraseña</button>
                        <button class="btn btn-danger btn-delete" data-id="${persona.CEDULA}">Eliminar</button>
                    </td>
                </tr>`;
                tbody.append(row); // Añade la fila a la tabla
            });
        },
        error: function (error) {
            console.error('Error cargando las persona :', error); // Muestra el error en la consola
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


