<?php
$conn = oci_connect("PlayaCacaoDB", "PlayaCacao12345", "localhost/XE");

$pedido = $_POST['pedido'];
$cedula = $_POST['cedula'];
$cliente = $_POST['cliente'];
$metodo = $_POST['metodo'];
$monto = $_POST['monto'];
$vuelto = $_POST['vuelto'];
$descuento = $_POST['descuento'];
$iva = $_POST['iva'];
$comentario = $_POST['comentario'];

$sql = "BEGIN PKG_FACTURAS.CREAR_FACTURA(
    :cedula, :pedido, :metodo, :monto, :cliente, :vuelto, :descuento, :iva, :comentario
); END;";

$stmt = oci_parse($conn, $sql);

oci_bind_by_name($stmt, ":cedula", $cedula);
oci_bind_by_name($stmt, ":pedido", $pedido);
oci_bind_by_name($stmt, ":metodo", $metodo);
oci_bind_by_name($stmt, ":monto", $monto);
oci_bind_by_name($stmt, ":cliente", $cliente);
oci_bind_by_name($stmt, ":vuelto", $vuelto);
oci_bind_by_name($stmt, ":descuento", $descuento);
oci_bind_by_name($stmt, ":iva", $iva);
oci_bind_by_name($stmt, ":comentario", $comentario);

oci_execute($stmt);
oci_free_statement($stmt);
oci_close($conn);
?>
