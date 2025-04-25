<?php 

    $conn = oci_connect("PlayaCacaoDB", "PlayaCacao12345", "localhost/XE");

    $id =  $_POST['id'];

    $query = "BEGIN
                RESTAURAR(:P_ID);
            END;";

    //Guardamos el query
    $stmt = oci_parse($conn, $query);

    //Vinculamos los parametros necesarios para el procedimiento almacenado
    oci_bind_by_name($stmt, ":P_ID", $id);

    oci_execute($stmt);

    oci_free_statement($stmt);
    oci_close($conn);
?>