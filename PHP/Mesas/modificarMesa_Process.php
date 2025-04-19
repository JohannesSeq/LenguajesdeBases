<?php
$conn = oci_connect("PlayaCacaoDB", "PlayaCacao12345", "localhost/XE");
$id_mesa = $_POST['id_mesa'];
$id_horario = $_POST['id_horario'];
$id_estado = $_POST['id_estado'];
$query = "BEGIN PKT_MESAS.ACTUALIZAR_MESA(:id_mesa, :id_horario, :id_estado); END;";
$stmt = oci_parse($conn, $query);
oci_bind_by_name($stmt, ":id_mesa", $id_mesa);
oci_bind_by_name($stmt, ":id_horario", $id_horario);
oci_bind_by_name($stmt, ":id_estado", $id_estado);
oci_execute($stmt);
oci_free_statement($stmt);
oci_close($conn);
?>
