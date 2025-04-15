<?php 
    $conn = oci_connect("PlayaCacaoDB", "PlayaCacao12345", "localhost/XE");
    
    //Passdown de las variables del JS al back end.
    $cedula = $_POST['id'];
    $nombre = $_POST['nombre_persona'];
    $apellidos = $_POST['apellidos_persona'];
    $numero_telefono = $_POST['numero_telefono'];
    $rol = $_POST['rol'];
    $provincia = $_POST['provincia'];
    $canton = $_POST['canton'];
    $distrito = $_POST['distrito'];
    $correo = $_POST['correo'];
    $correo_respaldombre = $_POST['correo_respaldo'];

    $query = "BEGIN " .
                "PKT_PERSONAS.ACTUALIZAR_PERSONA(:cedula, :nombre, :apellidos, :numero, :rol, :provincia, :canton, :distrito, :correo, :correo_r); " .
             "END;";

    //Guardamos el query
    $stmt = oci_parse($conn, $query);                 

    //Vinculamos los parametros necesarios para el procedimiento almacenado
    oci_bind_by_name($stmt, ":cedula", $id);
    oci_bind_by_name($stmt, ":nombre", $nombre);
    oci_bind_by_name($stmt, ":apellidos", $apellidos);
    oci_bind_by_name($stmt, ":numero", $numero_telefono);
    oci_bind_by_name($stmt, ":rol", $rol);
    oci_bind_by_name($stmt, ":provincia", $provincia);
    oci_bind_by_name($stmt, ":canton", $canton);
    oci_bind_by_name($stmt, ":distrito", $distrito);
    oci_bind_by_name($stmt, ":correo", $correo);
    oci_bind_by_name($stmt, ":correo_r", $correo_respaldombre);

    // Ejecutar el procedimiento
    oci_execute($stmt);


    // Cerramos la conexion con la DB
    oci_free_statement($stmt);
    oci_close($conn);

?>
