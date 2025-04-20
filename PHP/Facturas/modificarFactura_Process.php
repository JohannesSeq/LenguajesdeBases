<?php
$conn = oci_connect("PlayaCacaoDB", "PlayaCacao12345", "localhost/XE");

$id = $_POST['id'];
$metodo = $_POST['metodo'];
$vuelto = $_POST['vuelto'];
$descuento = $_POST['descuento'];
$iva = $_POST['iva'];

$sql = "BEGIN PKG_FACTURAS.MODIFICAR_FACTURA(:id, :metodo, :vuelto, :descuento, :iva); END;";
$stmt = oci_parse($conn, $sql);

oci_bind_by_name($stmt, ":id", $id);
oci_bind_by_name($stmt, ":metodo", $metodo);
oci_bind_by_name($stmt, ":vuelto", $vuelto);
oci_bind_by_name($stmt, ":descuento", $descuento);
oci_bind_by_name($stmt, ":iva", $iva);

oci_execute($stmt);
oci_free_statement($stmt);
oci_close($conn);
?>
