<?php
$conn = oci_connect("PlayaCacaoDB", "PlayaCacao12345", "localhost/XE");

$query = "SELECT M.ID_MESA, M.NOMBRE_MESA, H.HORA_EXACTA
          FROM VISTA_MESAS_DISPONIBLES M
          JOIN HORARIOS_MESA H ON M.ID_HORARIO = H.ID_HORARIO";
$stmt = oci_parse($conn, $query);
oci_execute($stmt);

$mesas = [];
while ($row = oci_fetch_assoc($stmt)) {
    $mesas[] = $row;
}

echo json_encode($mesas);

oci_free_statement($stmt);
oci_close($conn);
?>
