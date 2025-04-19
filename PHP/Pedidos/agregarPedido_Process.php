<?php
$data = json_decode(file_get_contents("php://input"), true);

$conn = oci_connect("PlayaCacaoDB", "PlayaCacao12345", "localhost/XE");

$query = "BEGIN CREAR_PEDIDO(:cedula, :monto, :estado, :comentario); END;";
$stmt = oci_parse($conn, $query);

oci_bind_by_name($stmt, ":cedula", $data["cedula_cliente"]);
oci_bind_by_name($stmt, ":monto", $data["monto_estimado"]);
oci_bind_by_name($stmt, ":estado", $data["estado"]);
oci_bind_by_name($stmt, ":comentario", $data["comentario"]);

oci_execute($stmt);
oci_free_statement($stmt);
oci_close($conn);

echo json_encode(["success" => true]);
?>
