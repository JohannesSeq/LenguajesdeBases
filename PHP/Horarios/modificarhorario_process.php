<?php 
$conn = oci_connect("PlayaCacaoDB", "PlayaCacao12345", "localhost/XE");

if (
    !isset($_POST['id_horario'], $_POST['disponibilidad'], $_POST['hora_exacta'])
) {
    echo json_encode(["error" => "Faltan datos requeridos"]);
    exit;
}

$id_horario = $_POST['id_horario'];
$disponibilidad = $_POST['disponibilidad'];
$hora_exacta = $_POST['hora_exacta']; // Formato: 2025-04-19T14:00

$hora_exacta = str_replace('T', ' ', $hora_exacta) . ":00";

$query = "
    BEGIN 
        ACTUALIZAR_HORARIO_MESA(
            :P_ID_HORARIO, 
            :P_DISPONIBILIDAD, 
            TO_DATE(:P_HORA_EXACTA, 'YYYY-MM-DD HH24:MI:SS')
        ); 
    END;
";

$stmt = oci_parse($conn, $query);

oci_bind_by_name($stmt, ":P_ID_HORARIO", $id_horario);
oci_bind_by_name($stmt, ":P_DISPONIBILIDAD", $disponibilidad);
oci_bind_by_name($stmt, ":P_HORA_EXACTA", $hora_exacta);

if (oci_execute($stmt)) {
    echo json_encode(["success" => true]);
} else {
    $e = oci_error($stmt);
    echo json_encode(["error" => $e['message']]);
}

oci_free_statement($stmt);
oci_close($conn);
?>
