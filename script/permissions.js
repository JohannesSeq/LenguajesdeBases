function Check_Permissions(rol_minimo) {

    console.log('Prueba');
    console.log(leer_cookie('rol'));
    console.log(valor_rol(rol_minimo));
    console.log(valor_rol(leer_cookie('rol')));
    
    if(valor_rol(rol_minimo) > valor_rol(leer_cookie('rol'))){
        window.location.href = "unauthorized.php";
    }

}


function leer_cookie(nombre_cookie) {

    let valor = nombre_cookie + "=";
    let ca = document.cookie.split(';');
    for(let i = 0; i < ca.length; i++) {
      let c = ca[i];
      while (c.charAt(0) == ' ') {
        c = c.substring(1);
      }
      if (c.indexOf(nombre_cookie) == 0) {
        return c.substring(valor.length, c.length);
      }
    }
    return "";
}

function valor_rol(rol){

    if(rol == 'Gerente'){
        return 3;
    } else if (rol == 'Empleado'){
        return 2;
    } else if(rol == 'Cliente'){
        return 1;
    }
    return 0;
}