<?php
$conn = oci_connect("PlayaCacaoDB", "PlayaCacao12345", "localhost/XE");

$query = "SELECT ID_HORARIO, HORA_EXACTA FROM VISTA_HORARIOS";
$stmt = oci_parse($conn, $query);
oci_execute($stmt);

$horarios = array();
while ($row = oci_fetch_assoc($stmt)) {
    $horarios[] = $row;
}

echo json_encode($horarios);

oci_free_statement($stmt);
oci_close($conn);
?>
