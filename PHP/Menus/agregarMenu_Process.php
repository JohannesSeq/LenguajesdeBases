<?php
if (isset($_POST['nombre']) && isset($_POST['descripcion']) && isset($_POST['platillos'])) {
    $conn = oci_connect("PlayaCacaoDB", "PlayaCacao12345", "localhost/XE");

    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $comentario = 'Agregado desde el sistema';
    $platillos = $_POST['platillos']; // array

    // Crear menú
    $query = "BEGIN CREAR_MENU(:nombre, :descripcion, :comentario); END;";
    $stmt = oci_parse($conn, $query);
    oci_bind_by_name($stmt, ":nombre", $nombre);
    oci_bind_by_name($stmt, ":descripcion", $descripcion);
    oci_bind_by_name($stmt, ":comentario", $comentario);
    oci_execute($stmt);

    // Obtener ID del menú creado
    $get_id = oci_parse($conn, "SELECT MAX(ID_MENU) AS ID FROM MENU");
    oci_execute($get_id);
    $row = oci_fetch_assoc($get_id);
    $id_menu = $row['ID'];

    // Asociar platillos
    foreach ($platillos as $id_platillo) {
        $query2 = "BEGIN CREAR_PLATILLO_MENU(:id_platillo, :id_menu, :comentario); END;";
        $stmt2 = oci_parse($conn, $query2);
        oci_bind_by_name($stmt2, ":id_platillo", $id_platillo);
        oci_bind_by_name($stmt2, ":id_menu", $id_menu);
        oci_bind_by_name($stmt2, ":comentario", $comentario);
        oci_execute($stmt2);
    }

    echo "Menú agregado correctamente.";
    oci_close($conn);
}
?>
