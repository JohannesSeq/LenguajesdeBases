<?php
$conn = oci_connect("PlayaCacaoDB", "PlayaCacao12345", "localhost/XE");

$id = $_GET['id'];

$query = "BEGIN ENVIO_MENU_INDIVIDUAL(:P_ID_MENU, :P_CURSOR); END;";
$stmt = oci_parse($conn, $query);
$cursor = oci_new_cursor($conn);

oci_bind_by_name($stmt, ":P_ID_MENU", $id);
oci_bind_by_name($stmt, ":P_CURSOR", $cursor, -1, OCI_B_CURSOR);

oci_execute($stmt);
oci_execute($cursor);

$resultado = [];
while ($row = oci_fetch_assoc($cursor)) {
    $resultado[] = $row;
}

echo json_encode($resultado);

oci_free_statement($stmt);
oci_free_statement($cursor);
oci_close($conn);
?>
