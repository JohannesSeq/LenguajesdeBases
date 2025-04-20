<?php
$conn = oci_connect("PlayaCacaoDB", "PlayaCacao12345", "localhost/XE");

$id = $_GET['id'];

$sql = "BEGIN PKG_FACTURAS.ENVIO_FACTURA_INDIVIDUAL(:id, :cursor); END;";
$stmt = oci_parse($conn, $sql);
$cursor = oci_new_cursor($conn);

oci_bind_by_name($stmt, ":id", $id);
oci_bind_by_name($stmt, ":cursor", $cursor, -1, OCI_B_CURSOR);

oci_execute($stmt);
oci_execute($cursor);

$data = [];
while (($row = oci_fetch_assoc($cursor)) != false) {
    $data[] = $row;
}

oci_free_statement($stmt);
oci_free_statement($cursor);
oci_close($conn);

echo json_encode($data);
?>
