<?php
$envPath = __DIR__ . '/../../.env';

if (file_exists($envPath)) {
    $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        list($key, $value) = explode('=', $line, 2);
        putenv(trim("$key=$value"));
    }
}

$tipo = getenv("TIPO_BORRADO");

if (isset($_POST['id_menu']) && isset($_POST['id_platillo']) && $tipo) {
    $conn = oci_connect("PlayaCacaoDB", "PlayaCacao12345", "localhost/XE");

    // Obtener ID_PLATILLOS_MENU
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
        $proc = "BEGIN :res := EJECUTAR_BORRADO_PLATILLO_MENU(:ID, :TIPO, :COMENTARIO); END;";
        $delStmt = oci_parse($conn, $proc);

        $comentario = "Removiendo platillo del menú";
        $resultado = '';

        oci_bind_by_name($delStmt, ":ID", $id_platillos_menu);
        oci_bind_by_name($delStmt, ":TIPO", $tipo);
        oci_bind_by_name($delStmt, ":COMENTARIO", $comentario);
        oci_bind_by_name($delStmt, ":res", $resultado, 50);

        oci_execute($delStmt);

        echo json_encode(['resultado' => $resultado]);
    }

    oci_close($conn);
} else {
    echo json_encode(['error' => 'Faltan parámetros o TIPO_BORRADO']);
}
?>
