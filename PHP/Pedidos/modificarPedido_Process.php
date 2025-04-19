<?php
$data = json_decode(file_get_contents("php://input"), true);

$id_pedido = $data["id_pedido"];
$estado = $data["estado"];
$comentario = $data["comentario"];

$conn = oci_connect("PlayaCacaoDB", "PlayaCacao12345", "localhost/XE");

$stmt = oci_parse($conn, "UPDATE PEDIDOS SET ESTADO_PEDIDO = :estado WHERE ID_PEDIDO = :id");
oci_bind_by_name($stmt, ":estado", $estado);
oci_bind_by_name($stmt, ":id", $id_pedido);
oci_execute($stmt);

// Registrar nuevo comentario como estado también (opcional)
$stmt2 = oci_parse($conn, "BEGIN
    INSERT INTO ESTADOS(ID_OBJETO, TIPO_OBJETO, COMENTARIO, ESTADO, FECHA_CAMBIO)
    VALUES (:id, 'PEDIDOS', :comentario, :estado, SYSDATE);
END;");
oci_bind_by_name($stmt2, ":id", $id_pedido);
oci_bind_by_name($stmt2, ":comentario", $comentario);
oci_bind_by_name($stmt2, ":estado", $estado);
oci_execute($stmt2);

oci_free_statement($stmt);
oci_free_statement($stmt2);
oci_close($conn);

echo json_encode(["success" => true]);
?>
