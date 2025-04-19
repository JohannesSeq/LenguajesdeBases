<?php
header('Content-Type: application/json');

$email = $_GET['email'];
$conn = oci_connect("PlayaCacaoDB", "PlayaCacao12345", "localhost/XE");

$stmt = oci_parse($conn, "BEGIN OBTENER_CEDULA_DESDE_CORREO(:email, :cursor); END;");
$cursor = oci_new_cursor($conn);

oci_bind_by_name($stmt, ":email", $email);
oci_bind_by_name($stmt, ":cursor", $cursor, -1, OCI_B_CURSOR);

oci_execute($stmt);
oci_execute($cursor);

$results = [];
while (($row = oci_fetch_assoc($cursor)) != false) {
    $results[] = $row;
}

oci_free_statement($stmt);
oci_free_statement($cursor);
oci_close($conn);

echo json_encode($results);
?>
