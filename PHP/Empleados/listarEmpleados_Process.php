<?php
$conn = oci_connect("PlayaCacaoDB", "PlayaCacao12345", "localhost/XE");

$sql = "BEGIN PKG_EMPLEADOS.ENVIO_TOTAL_EMPLEADOS(:cursor); END;";
$stmt = oci_parse($conn, $sql);

$cursor = oci_new_cursor($conn);
oci_bind_by_name($stmt, ":cursor", $cursor, -1, OCI_B_CURSOR);
oci_execute($stmt);
oci_execute($cursor);

$empleados = [];
while (($row = oci_fetch_assoc($cursor)) != false) {
    $empleados[] = $row;
}

oci_free_statement($stmt);
oci_free_statement($cursor);
oci_close($conn);

echo json_encode($empleados);
?>
