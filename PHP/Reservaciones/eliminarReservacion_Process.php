<?php
$conn = oci_connect("PlayaCacaoDB", "PlayaCacao12345", "localhost/XE");

$id = $_POST['id'];

$query = "BEGIN BORRADO_LOGICO('RESERVACIONES', :id, 'Borrando reservación'); END;";

$stmt = oci_parse($conn, $query);
oci_bind_by_name($stmt, ":id", $id);

oci_execute($stmt);
oci_free_statement($stmt);
oci_close($conn);
?>
