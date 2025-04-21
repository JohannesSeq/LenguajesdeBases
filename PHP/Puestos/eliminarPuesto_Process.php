<?php 
    // Cargar archivo .env (dos niveles arriba)
    $envPath = __DIR__ . '/../../.env';

    if (file_exists($envPath)) {
        $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) continue;
            list($key, $value) = explode('=', $line, 2);
            putenv(trim("$key=$value"));
        }
    } else {
        echo json_encode(['error' => 'Archivo .env no encontrado']);
        exit;
    }

    $tipo = getenv("BORRADO_PLATILLO");

    if (!$tipo) {
        echo json_encode(['error' => 'Variable BORRADO_PLATILLO no configurada en el .env']);
        exit;
    }

    if (isset($_POST['id'])) {

        $conn = oci_connect("PlayaCacaoDB", "PlayaCacao12345", "localhost/XE");
        $id = (int) $_POST['id'];

        $query = "BEGIN 
                    :resultado := EJECUTAR_BORRADO_PUESTO(:P_ID_PUESTO, :P_TIPO, :P_COMENTARIO); 
                  END;";

        $stmt = oci_parse($conn, $query);
        
        oci_bind_by_name($stmt, ":P_ID_PUESTO", $id);
        oci_bind_by_name($stmt, ":P_TIPO", $tipo);
        oci_bind_by_name($stmt, ":P_COMENTARIO", $comentario);
        oci_bind_by_name($stmt, ":resultado", $resultado, 50);

        oci_execute($stmt);

        echo json_encode([
            'resultado' => $resultado,
            'mensaje' => $resultado === 'TIPO_INVALIDO' 
                ? 'Tipo de borrado inválido' 
                : 'PUESTO eliminado correctamente (' . $resultado . ')'
        ]);

        oci_free_statement($stmt);
        oci_close($conn);

    } else {
        echo json_encode(['error' => 'Falta parámetro: id']);
    }

?>
