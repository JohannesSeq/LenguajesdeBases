<?php
header("Content-Type: application/json");
$conn = oci_connect("PlayaCacaoDB", "PlayaCacao12345", "localhost/XE");

// Obtener JSON desde el cuerpo del POST
$input = json_decode(file_get_contents("php://input"), true);
$cedula = $input['cedula_cliente'] ?? null;

if (!$cedula) {
    http_response_code(400);
    echo json_encode(["error" => "Cédula no proporcionada"]);
    exit;
}

// Consulta basada en la vista VISTA_RESERVACIONES
$query = "SELECT ID_RESERVA, CONFIRMACION, MESA, HORARIO 
          FROM VISTA_RESERVACIONES 
          WHERE CEDULA_CLIENTE = :cedula";

$stmt = oci_parse($conn, $query);
oci_bind_by_name($stmt, ":cedula", $cedula);
oci_execute($stmt);

$reservas = [];
while ($row = oci_fetch_assoc($stmt)) {
    $reservas[] = $row;
}

echo json_encode($reservas);

oci_free_statement($stmt);
oci_close($conn);
?>
