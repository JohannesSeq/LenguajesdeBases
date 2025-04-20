<?php
header("Content-Type: application/json");
$conn = oci_connect("PlayaCacaoDB", "PlayaCacao12345", "localhost/XE");

$id = $_GET['id'];

$sql = "BEGIN PKG_PUESTOS.ENVIO_PUESTO_INDIVIDUAL(:id, :cursor); END;";
$stmt = oci_parse($conn, $sql);

$cursor = oci_new_cursor($conn);
oci_bind_by_name($stmt, ":id", $id);
oci_bind_by_name($stmt, ":cursor", $cursor, -1, OCI_B_CURSOR);

oci_execute($stmt);
oci_execute($cursor);

$puesto = [];
while (($row = oci_fetch_assoc($cursor)) != false) {
    $puesto[] = $row;
}

echo json_encode($puesto);

oci_free_statement($stmt);
oci_free_statement($cursor);
oci_close($conn);
?>
