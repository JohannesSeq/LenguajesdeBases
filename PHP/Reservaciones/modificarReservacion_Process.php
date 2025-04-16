<?php
$conn = oci_connect("PlayaCacaoDB", "PlayaCacao12345", "localhost/XE");

$id = $_POST['id'];
$confirmacion = $_POST['confirmacion'];
$mesa = $_POST['mesa'];
$horario = $_POST['horario'];

$query = "BEGIN PKT_RESERVACIONES.ACTUALIZAR_RESERVACION(:id, :confirmacion, :mesa, :horario); END;";

$stmt = oci_parse($conn, $query);
oci_bind_by_name($stmt, ":id", $id);
oci_bind_by_name($stmt, ":confirmacion", $confirmacion);
oci_bind_by_name($stmt, ":mesa", $mesa);
oci_bind_by_name($stmt, ":horario", $horario);

oci_execute($stmt);
oci_free_statement($stmt);
oci_close($conn);
?>
