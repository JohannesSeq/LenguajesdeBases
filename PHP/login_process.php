<?php
    //Passdown de las variables del JS al back end.
    $correo = $_GET['correo'];;
    $password = $_GET['password'];

    //String que almacena el estado final de la operacion
    $usuarioOutput = '';

    //Variables para almacenar los valores del usuario una vez la autenticacion termine
    $usuarioNombreQuery = "";
    $usuarioRolQuery = "";
    $usuarioCorreoQuery = "";

    //Iniciamos la conexion con la DB
    $conn = oci_connect("PlayaCacaoDB", "PlayaCacao12345", "localhost/XE");

    //Establecemos el Query de SQL que queramos ejecutar
    $query = "BEGIN " .
        "ENVIO_AUTENTICACION(:P_COR,:P_PASS,:P_CURSOR); " .
        "END;";

    //Guardamos el query
        $stmt = oci_parse($conn, $query);


    //Vinculamos los parametros necesarios para el procedimiento almacenado
    oci_bind_by_name($stmt, ":P_COR", $correo);
    oci_bind_by_name($stmt, ":P_PASS", $password);

    //Creamos un cursor para almacenar la informacion de la tabla que estamos consultando
    $cursor = oci_new_cursor($conn);
    oci_bind_by_name($stmt, ":P_CURSOR", $cursor, -1, OCI_B_CURSOR);

    // Ejecutar el procedimiento y el cursor
    oci_execute($stmt);
    oci_execute($cursor);

    // Obtener los resultados
    while ($row = oci_fetch_assoc($cursor)) {
        $usuarioNombreQuery = $row['NOMBRE'];
        $usuarioRolQuery = $row['ROL'];
        $usuarioCorreoQuery = $row['DIRECCION_DE_CORREO'];
    }

    //ECHO $usuarioNombreQuery;
    //ECHO $usuarioRolQuery;
    //ECHO $usuarioCorreoQuery;
    
    if ($usuarioCorreoQuery != "Invalid"){
        //Seteamos los valores de la cookie para que almacene la info del usuario
        setcookie('email', $usuarioCorreoQuery, time() + 3600, '/');
        setcookie('rol_id', $usuarioRolQuery, time() + 3600, '/');
        setcookie('nombre', $usuarioNombreQuery, time() + 3600, '/');

        //Confirmamos que la autenticacion fue exitosa
        $usuarioOutput = "Success";

    } else {
        //Seteamos los valores de la cookie
        setcookie('email', '', time() + 3600, '/');
        setcookie('rol_id', '', time() + 3600, '/');
        setcookie('nombre', '', time() + 3600, '/');

        $usuarioOutput = "Faulure";
        
    }
    
    //Devolvemos el resultado de la operacion
    ECHO $usuarioOutput;

    // Cerramos la conexion con la DB
    oci_free_statement($stmt);
    oci_free_statement($cursor);
    oci_close($conn);
?>
