<?php 
    $conn = oci_connect("PlayaCacaoDB", "PlayaCacao12345", "localhost/XE");

    $id = $_POST['id'];
    
    $query = "BEGIN " .
                "BORRADO_LOGICO('DISTRITO',:P_ID,'Borrando canton'); " .
             "END;";

    //Guardamos el query
    $stmt = oci_parse($conn, $query);                 

    //Vinculamos los parametros necesarios para el procedimiento almacenado
    oci_bind_by_name($stmt, ":P_ID", $id);

    // Ejecutar el procedimiento
    oci_execute($stmt);

    // Cerramos la conexion con la DB
    oci_free_statement($stmt);
    oci_close($conn);

?>
