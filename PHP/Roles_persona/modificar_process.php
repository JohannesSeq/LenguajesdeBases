<?php 
    $conn = oci_connect("PlayaCacaoDB", "PlayaCacao12345", "localhost/XE");

    $id = $_POST['id'];
    $nombre = $_POST['nombre_rol_persona'];
    $descripcion = $_POST['descripcion'];
    $nivel = $_POST['nivel'];
    
    $query = "BEGIN " .
                "PKT_ROL_PERSONA.ACTUALIZAR_ROL_PERSONA(:P_ID, :P_NOMBRE, :P_DESCRIPCION, :P_NIVEL); " .
             "END;";

    //Guardamos el query
    $stmt = oci_parse($conn, $query);                 

    //Vinculamos los parametros necesarios para el procedimiento almacenado
    oci_bind_by_name($stmt, ":P_ID", $id);
    oci_bind_by_name($stmt, ":P_NOMBRE", $nombre);
    oci_bind_by_name($stmt, ":P_DESCRIPCION", $descripcion);
    oci_bind_by_name($stmt, ":P_NIVEL", $nivel);

    // Ejecutar el procedimiento
    oci_execute($stmt);


    // Cerramos la conexion con la DB
    oci_free_statement($stmt);
    oci_close($conn);

?>
