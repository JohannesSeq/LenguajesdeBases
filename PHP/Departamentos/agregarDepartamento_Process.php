<?php
$conn = oci_connect("PlayaCacaoDB", "PlayaCacao12345", "localhost/XE");

$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$comentario = $_POST['comentario'];

$sql = "BEGIN PKG_DEPARTAMENTOS.AGREGAR_DEPARTAMENTO(:nombre, :descripcion, :comentario); END;";
$stmt = oci_parse($conn, $sql);

oci_bind_by_name($stmt, ":nombre", $nombre);
oci_bind_by_name($stmt, ":descripcion", $descripcion);
oci_bind_by_name($stmt, ":comentario", $comentario);

oci_execute($stmt);
oci_free_statement($stmt);
oci_close($conn);
?>
