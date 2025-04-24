<?php

    $conn = oci_connect("PlayaCacaoDB", "PlayaCacao12345", "localhost/XE");

    $pedido_id = $_GET['id'];

    $query = "BEGIN " .
                "OBTENER_PLATILLOS_PEDIDO(:P_ID,:P_CURSOR); " .
             "END;";

    //Guardamos el query
    $stmt = oci_parse($conn, $query);                 

    //Vinculamos los parametros necesarios para el procedimiento almacenado
    oci_bind_by_name($stmt, ":P_ID", $pedido_id);


    //Creamos un cursor para almacenar la informacion de la tabla que estamos consultando
    $cursor = oci_new_cursor($conn);
    oci_bind_by_name($stmt, ":P_CURSOR", $cursor, -1, OCI_B_CURSOR);

    // Ejecutar el procedimiento y el cursor
    oci_execute($stmt);
    oci_execute($cursor);

    $platillos_pedido = array();

    while ($row = oci_fetch_assoc($cursor)) {
        $platillos_pedido[] = $row;
    }

    // Devolver los pedidos en formato JSON
    echo json_encode($platillos_pedido);

    // Cerramos la conexion con la DB
    oci_free_statement($stmt);
    oci_free_statement($cursor);
    oci_close($conn);
?>
