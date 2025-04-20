<?php
$conn = oci_connect("PlayaCacaoDB", "PlayaCacao12345", "localhost/XE");

$cedula = $_GET['cedula'];

$sql = "BEGIN PKG_FACTURAS.ENVIO_FACTURAS_CLIENTE(:cedula, :cursor); END;";
$stmt = oci_parse($conn, $sql);
$cursor = oci_new_cursor($conn);

oci_bind_by_name($stmt, ":cedula", $cedula);
oci_bind_by_name($stmt, ":cursor", $cursor, -1, OCI_B_CURSOR);

oci_execute($stmt);
oci_execute($cursor);

$facturas = [];
while (($row = oci_fetch_assoc($cursor)) != false) {
    $facturas[] = $row;
}

oci_free_statement($stmt);
oci_free_statement($cursor);
oci_close($conn);

echo json_encode($facturas);
?>
