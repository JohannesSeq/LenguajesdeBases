<?php
if (isset($_POST['id_menu']) && isset($_POST['id_platillo'])) {
    $conn = oci_connect("PlayaCacaoDB", "PlayaCacao12345", "localhost/XE");

    $id_menu = $_POST['id_menu'];
    $id_platillo = $_POST['id_platillo'];
    $comentario = "Agregando platillo a menú";

    $query = "BEGIN CREAR_PLATILLO_MENU(:ID_PLATILLO, :ID_MENU, :COMENTARIO); END;";
    $stmt = oci_parse($conn, $query);

    oci_bind_by_name($stmt, ":ID_PLATILLO", $id_platillo);
    oci_bind_by_name($stmt, ":ID_MENU", $id_menu);
    oci_bind_by_name($stmt, ":COMENTARIO", $comentario);

    oci_execute($stmt);
    oci_close($conn);
}
?>
