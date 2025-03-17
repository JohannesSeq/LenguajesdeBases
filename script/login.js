$(document).ready(function(){
    
    $('#formulario_login').submit(function(e){
        e.preventDefault();

        //Variables obtenidas del formulario de login.
        let correo = $('#email_field').val();
        let user_pass = $('#password_field').val();

        $.ajax({
            
            url: '../PHP/login_process.php',
            method: 'GET',
            data: {
                correo: correo,
                user_pass: user_pass
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
});

function escribir_error(){
    let paragraph = document.getElementById("error_text");
    paragraph.textContent = 'Usuario o contraseña incorrectos';
}

function write_cookie(email,rol,nombre){
    document.cookie = "email=  ; path=/";
    document.cookie = "rol=  ; path=/";
    document.cookie = "nombre=  ; path=/";

    document.cookie = "email" + "=" + email + ";" + "path=/" + ";";
    document.cookie = "rol" + "=" + rol + ";" + "path=/" + ";";
    document.cookie = "nombre" + "=" + nombre + ";" + "path=/" + ";";
}

function clear_cookie(){
    document.cookie = "email= ; path=/";
    document.cookie = "rol= ; path=/";
    document.cookie = "nombre=  ; path=/";
}
