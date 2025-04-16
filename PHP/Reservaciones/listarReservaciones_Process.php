<?php
$conn = oci_connect("PlayaCacaoDB", "PlayaCacao12345", "localhost/XE");

$query = "BEGIN PKT_RESERVACIONES.ENVIO_TOTAL_RESERVACIONES(:cursor); END;";
$stmt = oci_parse($conn, $query);

$cursor = oci_new_cursor($conn);
oci_bind_by_name($stmt, ":cursor", $cursor, -1, OCI_B_CURSOR);

oci_execute($stmt);
oci_execute($cursor);

$reservaciones = array();
while ($row = oci_fetch_assoc($cursor)) {
    $reservaciones[] = $row;
}

echo json_encode($reservaciones);

oci_free_statement($stmt);
oci_free_statement($cursor);
oci_close($conn);
?>
