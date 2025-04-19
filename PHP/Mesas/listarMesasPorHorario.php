<?php
$conn = oci_connect("PlayaCacaoDB", "PlayaCacao12345", "localhost/XE");

$id_horario = $_GET['id_horario'];

$query = "SELECT ID_MESA, NOMBRE_MESA
          FROM VISTA_MESAS
          WHERE ID_HORARIO = :id_horario AND ID_ESTADO IN (
              SELECT ID_ESTADO FROM ESTADOS WHERE ESTADO = 'Activo'
          )";

$stmt = oci_parse($conn, $query);
oci_bind_by_name($stmt, ":id_horario", $id_horario);
oci_execute($stmt);

$mesas = [];
while ($row = oci_fetch_assoc($stmt)) {
    $mesas[] = $row;
}

echo json_encode($mesas);

oci_free_statement($stmt);
oci_close($conn);
?>
