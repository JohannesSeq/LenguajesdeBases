<?php
$conn = oci_connect("PlayaCacaoDB", "PlayaCacao12345", "localhost/XE");

$nombre = $_POST['nombre'];
$salario = $_POST['salario'];
$descripcion = $_POST['descripcion'];

$sql = "BEGIN PKG_PUESTOS.AGREGAR_PUESTO(:nombre, :salario, :descripcion); END;";
$stmt = oci_parse($conn, $sql);

oci_bind_by_name($stmt, ":nombre", $nombre);
oci_bind_by_name($stmt, ":salario", $salario);
oci_bind_by_name($stmt, ":descripcion", $descripcion);

oci_execute($stmt);
oci_free_statement($stmt);
oci_close($conn);
?>
