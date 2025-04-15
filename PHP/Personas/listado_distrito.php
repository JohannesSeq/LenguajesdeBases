<?php
    $conn = oci_connect("PlayaCacaoDB", "PlayaCacao12345", "localhost/XE");

    $query = "BEGIN " .
                 "PKT_DISTRITOS.ENVIO_TOTAL_DISTRITOS(:P_CURSOR); " .
            "END;";

    //Guardamos el query
    $stmt = oci_parse($conn, $query);

    //Creamos un cursor para almacenar la informacion de la tabla que estamos consultando
    $cursor = oci_new_cursor($conn);
    oci_bind_by_name($stmt, ":P_CURSOR", $cursor, -1, OCI_B_CURSOR);

    oci_execute($stmt);
    oci_execute($cursor);

    $salida = '';


    while ($row = oci_fetch_assoc($cursor)) {
        $salida .= '<option value=' . $row['ID_DISTRITO'] . '>'. $row['NOMBRE_DISTRITO'] . '</option>';
    }

    // Ejecutar el procedimiento y el cursor
    oci_execute($stmt);
    oci_execute($cursor);

    echo $salida;
?>