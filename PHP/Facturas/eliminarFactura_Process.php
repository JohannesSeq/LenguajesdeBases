<?php
$conn = oci_connect("PlayaCacaoDB", "PlayaCacao12345", "localhost/XE");

$id = $_POST['id'];
$comentario = $_POST['comentario'];

$sql = "BEGIN PKG_FACTURAS.ELIMINAR_FACTURA(:id, :comentario); END;";
$stmt = oci_parse($conn, $sql);

oci_bind_by_name($stmt, ":id", $id);
oci_bind_by_name($stmt, ":comentario", $comentario);

oci_execute($stmt);
oci_free_statement($stmt);
oci_close($conn);
?>
