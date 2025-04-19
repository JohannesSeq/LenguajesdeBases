<?php
header('Content-Type: application/json');

$conn = oci_connect("PlayaCacaoDB", "PlayaCacao12345", "localhost/XE");

$query = "SELECT * FROM VISTA_PEDIDOS_CLIENTES";
$stmt = oci_parse($conn, $query);
oci_execute($stmt);

$results = [];
while (($row = oci_fetch_assoc($stmt)) != false) {
    $results[] = [
        "ID_PEDIDO" => $row["ID_PEDIDO"],
        "NOMBRE_COMPLETO_CLIENTE" => $row["NOMBRE_COMPLETO_CLIENTE"],
        "CEDULA" => $row["CEDULA"],
        "MONTO_ESTIMADO" => $row["MONTO_ESTIMADO"],
        "ESTADO_PEDIDO" => $row["ESTADO_PEDIDO"]
    ];
}

oci_free_statement($stmt);
oci_close($conn);

echo json_encode($results);
?>
