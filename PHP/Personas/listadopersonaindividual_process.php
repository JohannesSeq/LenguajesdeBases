<?php 
    $conn = oci_connect("PlayaCacaoDB", "PlayaCacao12345", "localhost/XE");

    $persona_id = $_GET['id'];

    $query = "BEGIN " .
    "PKT_PERSONAS.ENVIO_PERSONA(:P_ID,:P_CURSOR); " .
    "END;";

    //Guardamos el query
    $stmt = oci_parse($conn, $query);                 

    //Vinculamos los parametros necesarios para el procedimiento almacenado
    oci_bind_by_name($stmt, ":P_ID", $persona_id);

    //Creamos un cursor para almacenar la informacion de la tabla que estamos consultando
    $cursor = oci_new_cursor($conn);
    oci_bind_by_name($stmt, ":P_CURSOR", $cursor, -1, OCI_B_CURSOR);

    // Ejecutar el procedimiento y el cursor
    oci_execute($stmt);
    oci_execute($cursor);

    $persona = array();

    while ($row = oci_fetch_assoc($cursor)) {
        $persona[] = $row;
    }

    // Devolver los pedidos en formato JSON
    echo json_encode($persona);

    // Cerramos la conexion con la DB
    oci_free_statement($stmt);
    oci_free_statement($cursor);
    oci_close($conn);

?>

