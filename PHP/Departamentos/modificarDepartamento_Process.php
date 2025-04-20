<?php
$conn = oci_connect("PlayaCacaoDB", "PlayaCacao12345", "localhost/XE");

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];

$sql = "BEGIN PKG_DEPARTAMENTOS.MODIFICAR_DEPARTAMENTO(:id, :nombre, :descripcion); END;";
$stmt = oci_parse($conn, $sql);

oci_bind_by_name($stmt, ":id", $id);
oci_bind_by_name($stmt, ":nombre", $nombre);
oci_bind_by_name($stmt, ":descripcion", $descripcion);

oci_execute($stmt);
oci_free_statement($stmt);
oci_close($conn);
?>
