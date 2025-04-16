<?php
$conn = oci_connect("PlayaCacaoDB", "PlayaCacao12345", "localhost/XE");

$id = $_GET['id'];

$query = "BEGIN PKT_RESERVACIONES.ENVIO_RESERVACION_INDIVIDUAL(:id, :cursor); END;";
$stmt = oci_parse($conn, $query);

oci_bind_by_name($stmt, ":id", $id);
$cursor = oci_new_cursor($conn);
oci_bind_by_name($stmt, ":cursor", $cursor, -1, OCI_B_CURSOR);

oci_execute($stmt);
oci_execute($cursor);

$reservacion = array();
while ($row = oci_fetch_assoc($cursor)) {
    $reservacion[] = $row;
}

echo json_encode($reservacion);

oci_free_statement($stmt);
oci_free_statement($cursor);
oci_close($conn);
?>
