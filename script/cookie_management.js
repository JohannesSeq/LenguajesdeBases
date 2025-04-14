function write_cookie(email,permiso,nombre){
    document.cookie = "email= ; path=/";
    document.cookie = "permiso= ; path=/";
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

$(document).ready(function(){
    
    let cookie = document.cookie;

    if(cookie != null){

        var Cookie_Array = cookie.split(";");
        var Usr_Email = Cookie_Array[0].slice(Cookie_Array[0].indexOf('=') + 1, Cookie_Array[0].length);
        
        if(Usr_Email != ""){

            const logout_Click = document.getElementById("logout").addEventListener("click",clear_cookie);

        }

    }
    
});

