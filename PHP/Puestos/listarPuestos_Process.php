<?php
header("Content-Type: application/json");
$conn = oci_connect("PlayaCacaoDB", "PlayaCacao12345", "localhost/XE");

$sql = "BEGIN PKG_PUESTOS.ENVIO_TOTAL_PUESTOS(:cursor); END;";
$stmt = oci_parse($conn, $sql);

$cursor = oci_new_cursor($conn);
oci_bind_by_name($stmt, ":cursor", $cursor, -1, OCI_B_CURSOR);

oci_execute($stmt);
oci_execute($cursor);

$puestos = [];
while (($row = oci_fetch_assoc($cursor)) != false) {
    $puestos[] = $row;
}

echo json_encode($puestos);

oci_free_statement($stmt);
oci_free_statement($cursor);
oci_close($conn);
?>
