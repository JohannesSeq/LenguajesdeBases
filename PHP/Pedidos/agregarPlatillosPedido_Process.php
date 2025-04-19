<?php
$data = json_decode(file_get_contents("php://input"), true);
$cedula = $data["cedula_cliente"];
$comentario = $data["comentario"];
$platillos = $data["platillos"];

$conn = oci_connect("PlayaCacaoDB", "PlayaCacao12345", "localhost/XE");

// Obtener ID del último pedido
$query = "SELECT MAX(ID_PEDIDO) AS ID FROM PEDIDOS WHERE CEDULA_CLIENTE = :cedula";
$stmt = oci_parse($conn, $query);
oci_bind_by_name($stmt, ":cedula", $cedula);
oci_execute($stmt);
$row = oci_fetch_assoc($stmt);
$id_pedido = $row["ID"];
oci_free_statement($stmt);

// Insertar cada platillo con su cantidad
foreach ($platillos as $id_platillo => $cantidad) {
    for ($i = 0; $i < $cantidad; $i++) {
        $stmt = oci_parse($conn, "BEGIN CREAR_ENTRADA_LISTA_PLATILLOS(:platillo, :pedido, :comentario); END;");
        oci_bind_by_name($stmt, ":platillo", $id_platillo);
        oci_bind_by_name($stmt, ":pedido", $id_pedido);
        oci_bind_by_name($stmt, ":comentario", $comentario);
        oci_execute($stmt);
        oci_free_statement($stmt);
    }
}

oci_close($conn);
echo json_encode(["success" => true]);
?>
