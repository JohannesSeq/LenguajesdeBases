<?php
$conn = oci_connect("PlayaCacaoDB", "PlayaCacao12345", "localhost/XE");

if (!$conn) {
    echo json_encode(['error' => 'Error de conexión a la base de datos']);
    exit;
}

$id_menu = $_GET['id_menu'] ?? null;

if (!$id_menu) {
    echo json_encode(['error' => 'Parámetro ID_MENU no proporcionado']);
    exit;
}

$query = "BEGIN OBTENER_PLATILLOS_DISPONIBLES(:ID_MENU, :C_RESULT); END;";
$stmt = oci_parse($conn, $query);
$cursor = oci_new_cursor($conn);

oci_bind_by_name($stmt, ":ID_MENU", $id_menu);
oci_bind_by_name($stmt, ":C_RESULT", $cursor, -1, OCI_B_CURSOR);

oci_execute($stmt);
oci_execute($cursor);

$platillos = [];
while ($row = oci_fetch_assoc($cursor)) {
    $platillos[] = $row;
}

echo json_encode($platillos);

oci_free_statement($stmt);
oci_free_statement($cursor);
oci_close($conn);
?>
