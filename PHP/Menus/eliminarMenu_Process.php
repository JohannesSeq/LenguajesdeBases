<?php
$conn = oci_connect("PlayaCacaoDB", "PlayaCacao12345", "localhost/XE");

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $query = "BEGIN BORRADO_LOGICO('MENU', :P_ID, 'Eliminando menú'); END;";
    $stmt = oci_parse($conn, $query);
    oci_bind_by_name($stmt, ":P_ID", $id);
    oci_execute($stmt);
    echo "Menú eliminado.";
}

oci_close($conn);
?>
