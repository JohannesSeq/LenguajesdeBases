<?php 
    $conn = oci_connect("PlayaCacaoDB", "PlayaCacao12345", "localhost/XE");

    $query = "BEGIN " .
    "PKT_PERSONAS.ENVIO_TOTAL_PERSONAS(:P_CURSOR); " .
    "END;";

    //Guardamos el query
    $stmt = oci_parse($conn, $query);                 

    //Creamos un cursor para almacenar la informacion de la tabla que estamos consultando
    $cursor = oci_new_cursor($conn);
    oci_bind_by_name($stmt, ":P_CURSOR", $cursor, -1, OCI_B_CURSOR);

    // Ejecutar el procedimiento y el cursor
    oci_execute($stmt);
    oci_execute($cursor);

    $personas = array();

    while ($row = oci_fetch_assoc($cursor)) {
        $personas[] = $row;
    }

    // Devolver los pedidos en formato JSON
    echo json_encode($personas);

    // Cerramos la conexion con la DB
    oci_free_statement($stmt);
    oci_free_statement($cursor);
    oci_close($conn);

?>

