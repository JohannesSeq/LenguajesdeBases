<?php
include 'conexion.php'; // tu archivo de conexión a la BD

// Crear un platillo
if (isset($_POST['nombre']) && isset($_POST['precio']) && isset($_POST['cantidad'])) {
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];

    $query = "BEGIN CREAR_PLATILLO(:nombre, :precio, :cantidad, 'Insertando Platillo'); END;";
    $stmt = oci_parse($conn, $query);

    oci_bind_by_name($stmt, ":nombre", $nombre);
    oci_bind_by_name($stmt, ":precio", $precio);
    oci_bind_by_name($stmt, ":cantidad", $cantidad);

    if (oci_execute($stmt)) {
        echo "Platillo creado correctamente.";
    } else {
        echo "Error al crear el platillo.";
    }
}
?>
