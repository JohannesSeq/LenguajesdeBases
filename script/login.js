$(document).ready(function(){
    
    $('#formulario_login').submit(function(e){
        e.preventDefault();

        //Variables obtenidas del formulario de login.
        let correo = $('#email_field').val();
        let password = $('#password_field').val();

        $.ajax({
            
            url: '../PHP/Login/login_process.php',
            method: 'GET',
            data: {
                correo: correo,
                password: password
            },

            success: function(response){


                if(response.startsWith('Success')){


                    console.log("Usuario logueado")
                    window.location.href = "index.php";

                } else {
                    //clear_cookie();
                    escribir_error();
                }

            }

        });

    });

    $('#formulario_registro').submit(function(e){
        // Previene el comportamiento por defecto del formulario (recarga de página)
        e.preventDefault();

        // Obtiene los valores de los campos del formulario
        var cedula = $('#cedula').val();
        var nombre = $('#nombre_persona').val();
        var apellidos = $('#apellidos_persona').val();
        var numero_telefono = $('#numero_telefono').val();
        var rol = 'Cliente';
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
                write_cookie(correo,'Limitado',nombre)
                dispararAlertaExito("Se ha creado su cuenta!");
                
            }
        });
    });

});

function escribir_error(){
    let paragraph = document.getElementById("error_text");
    paragraph.textContent = 'Usuario o contraseña incorrectos';
}

function write_cookie(email,permiso,nombre){
    document.cookie = "email=  ; path=/";
    document.cookie = "permiso=  ; path=/";
    document.cookie = "nombre=  ; path=/";

    document.cookie = "email" + "=" + email + ";" + "path=/" + ";";
    document.cookie = "permiso" + "=" + permiso + ";" + "path=/" + ";";
    document.cookie = "nombre" + "=" + nombre + ";" + "path=/" + ";";
}

function clear_cookie(){
    document.cookie = "email= ; path=/";
    document.cookie = "permiso= ; path=/";
    document.cookie = "nombre=  ; path=/";
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

