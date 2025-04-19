<?php 
$conn = oci_connect("PlayaCacaoDB", "PlayaCacao12345", "localhost/XE");

$id = $_GET['id'];

$query = "BEGIN PKT_MESAS.ENVIO_MESA_INDIVIDUAL(:P_ID, :P_CURSOR); END;";
$stmt = oci_parse($conn, $query);                 

oci_bind_by_name($stmt, ":P_ID", $id);

$cursor = oci_new_cursor($conn);
oci_bind_by_name($stmt, ":P_CURSOR", $cursor, -1, OCI_B_CURSOR);

oci_execute($stmt);
oci_execute($cursor);

$mesa = array();

while ($row = oci_fetch_assoc($cursor)) {
    $mesa[] = $row;
}

echo json_encode($mesa);

oci_free_statement($stmt);
oci_free_statement($cursor);
oci_close($conn);
?>
