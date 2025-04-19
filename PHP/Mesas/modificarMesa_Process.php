<?php
$conn = oci_connect("PlayaCacaoDB", "PlayaCacao12345", "localhost/XE");

$id_mesa = $_POST['id_mesa'];
$nombre_mesa = $_POST['nombre_mesa'];
$id_horario = $_POST['id_horario'];

$query = "BEGIN PKT_MESAS.ACTUALIZAR_MESA(:id_mesa, :nombre_mesa, :id_horario); END;";
$stmt = oci_parse($conn, $query);

oci_bind_by_name($stmt, ":id_mesa", $id_mesa);
oci_bind_by_name($stmt, ":nombre_mesa", $nombre_mesa);
oci_bind_by_name($stmt, ":id_horario", $id_horario);

oci_execute($stmt);
oci_free_statement($stmt);
oci_close($conn);
?>
