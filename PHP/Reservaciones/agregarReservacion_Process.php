<?php
$conn = oci_connect("PlayaCacaoDB", "PlayaCacao12345", "localhost/XE");

$cedula = $_POST['cedula'];
$mesa = $_POST['mesa'];
$confirmacion = $_POST['confirmacion']; // debería llegar como "Confirmado"

$query = "BEGIN PKT_RESERVACIONES.CREAR_RESERVACION(:confirmacion, :cedula, :mesa); END;";
$stmt = oci_parse($conn, $query);

oci_bind_by_name($stmt, ":confirmacion", $confirmacion);
oci_bind_by_name($stmt, ":cedula", $cedula);
oci_bind_by_name($stmt, ":mesa", $mesa);

oci_execute($stmt);
oci_free_statement($stmt);
oci_close($conn);
?>
