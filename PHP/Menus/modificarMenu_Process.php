<?php 
$conn = oci_connect("PlayaCacaoDB", "PlayaCacao12345", "localhost/XE");

if (isset($_POST['id']) && isset($_POST['nombre']) && isset($_POST['descripcion'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];

    $query = "BEGIN ACTUALIZAR_MENU(:P_ID, :P_NOMBRE, :P_DESCRIPCION); END;";
    $stmt = oci_parse($conn, $query);

    oci_bind_by_name($stmt, ":P_ID", $id);
    oci_bind_by_name($stmt, ":P_NOMBRE", $nombre);
    oci_bind_by_name($stmt, ":P_DESCRIPCION", $descripcion);

    oci_execute($stmt);

    echo "Menú modificado correctamente.";
}

oci_free_statement($stmt);
oci_close($conn);
?>
