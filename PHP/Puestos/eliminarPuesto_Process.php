<?php
$conn = oci_connect("PlayaCacaoDB", "PlayaCacao12345", "localhost/XE");

$id = $_POST['id'];

$sql = "BEGIN PKG_PUESTOS.ELIMINAR_PUESTO(:id); END;";
$stmt = oci_parse($conn, $sql);
oci_bind_by_name($stmt, ":id", $id);

oci_execute($stmt);
oci_free_statement($stmt);
oci_close($conn);
?>
