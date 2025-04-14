function Check_Permissions(permiso_minimo) {

    console.log('Prueba');
    console.log(leer_cookie('rol'));
    console.log(valor_rol(permiso_minimo));
    console.log(valor_rol(leer_cookie('rol')));
    
    if(valor_rol(permiso_minimo) > valor_rol(leer_cookie('permiso'))){
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

function valor_rol(perm){

    if(perm == 'Completo'){
        return 3;
    } else if (perm == 'Parcial'){
        return 2;
    } else if(perm == 'Limitado'){
        return 1;
    }
    return 0;
}