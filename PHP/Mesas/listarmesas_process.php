<?php 
$conn = oci_connect("PlayaCacaoDB", "PlayaCacao12345", "localhost/XE");

$query = "BEGIN PKT_MESAS.ENVIO_TOTAL_MESAS(:P_CURSOR); END;";
$stmt = oci_parse($conn, $query);                 

$cursor = oci_new_cursor($conn);
oci_bind_by_name($stmt, ":P_CURSOR", $cursor, -1, OCI_B_CURSOR);

oci_execute($stmt);
oci_execute($cursor);

$mesas = array();

while ($row = oci_fetch_assoc($cursor)) {
    $mesas[] = $row;
}

echo json_encode($mesas);

oci_free_statement($stmt);
oci_free_statement($cursor);
oci_close($conn);
?>
