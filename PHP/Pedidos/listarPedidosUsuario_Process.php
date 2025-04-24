<?php
    header('Content-Type: application/json');
    $input = json_decode(file_get_contents("php://input"), true);
    $cedula = $input["cedula_cliente"];

    $conn = oci_connect("PlayaCacaoDB", "PlayaCacao12345", "localhost/XE");

    $cursor = oci_new_cursor($conn);
    $stmt = oci_parse($conn, "BEGIN OBTENER_PEDIDOS_CLIENTE(:cedula, :cursor); END;");
    oci_bind_by_name($stmt, ":cedula", $cedula);
    oci_bind_by_name($stmt, ":cursor", $cursor, -1, OCI_B_CURSOR);

    oci_execute($stmt);
    oci_execute($cursor);

    $results = [];
    while (($row = oci_fetch_assoc($cursor)) != false) {
        $results[] = $row;
    }

    oci_free_statement($stmt);
    oci_free_statement($cursor);
    oci_close($conn);

    echo json_encode($results);
    ?>
