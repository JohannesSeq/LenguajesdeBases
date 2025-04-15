<?php
    $conn = oci_connect("PlayaCacaoDB", "PlayaCacao12345", "localhost/XE");
    $id = $_POST['id'];
    $pass = $_POST['password_persona'];

    $query = "BEGIN " .
                "PKT_PERSONAS.ACTUALIZAR_PASSWORD(:P_ID, :P_PASS); " .
             "END;";
             
    //Guardamos el query
    $stmt = oci_parse($conn, $query);

    //Asignamos los valores
    oci_bind_by_name($stmt, ":P_ID", $id);
    oci_bind_by_name($stmt, ":P_PASS", $pass);

    // Ejecutar el procedimiento
    oci_execute($stmt);

    // Cerramos la conexion con la DB
    oci_free_statement($stmt);
    oci_close($conn);

?>