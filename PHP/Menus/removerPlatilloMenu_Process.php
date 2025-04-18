<?php
if (isset($_POST['id_menu']) && isset($_POST['id_platillo'])) {
    $conn = oci_connect("PlayaCacaoDB", "PlayaCacao12345", "localhost/XE");

    // Primero buscamos el ID_PLATILLOS_MENU correspondiente
    $query = "SELECT ID_PLATILLOS_MENU FROM PLATILLOS_MENU WHERE ID_MENU = :ID_MENU AND ID_PLATILLO = :ID_PLATILLO";
    $stmt = oci_parse($conn, $query);

    oci_bind_by_name($stmt, ":ID_MENU", $_POST['id_menu']);
    oci_bind_by_name($stmt, ":ID_PLATILLO", $_POST['id_platillo']);

    oci_execute($stmt);

    $id_platillos_menu = null;
    if ($row = oci_fetch_assoc($stmt)) {
        $id_platillos_menu = $row['ID_PLATILLOS_MENU'];
    }

    if ($id_platillos_menu !== null) {
        $delQuery = "BEGIN BORRADO_LOGICO('PLATILLOS_MENU', :ID, 'Removiendo platillo del menú'); END;";
        $delStmt = oci_parse($conn, $delQuery);
        oci_bind_by_name($delStmt, ":ID", $id_platillos_menu);
        oci_execute($delStmt);
    }

    oci_close($conn);
}
?>
