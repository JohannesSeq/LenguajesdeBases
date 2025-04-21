<?php 
    // Cargar archivo .env (dos niveles arriba)
    $envPath = __DIR__ . '/../../.env';

    if (file_exists($envPath)) {
        $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) continue; // Ignorar comentarios
            list($key, $value) = explode('=', $line, 2);
            putenv(trim("$key=$value"));
        }
    } else {
        echo json_encode(['error' => 'Archivo .env no encontrado']);
        exit;
    }

    // Obtener tipo de borrado desde la variable de entorno
    $tipo = getenv("BORRADO_PLATILLO");

    if (!$tipo) {
        echo json_encode(['error' => 'La variable BORRADO_PLATILLO no está definida en el .env']);
        exit;
    }

    // Procesar eliminación
    if (isset($_POST['id'])) {
        $id = $_POST['id']; // ID del platillo

        $conn = oci_connect("PlayaCacaoDB", "PlayaCacao12345", "localhost/XE");

        $query = "BEGIN 
                    :resultado := EJECUTAR_BORRADO_PLATILLO(:P_ID_PLATILLO, :P_TIPO, :P_COMENTARIO); 
                  END;";

        $stmt = oci_parse($conn, $query);

        $comentario = 'Eliminando platillo desde proceso PHP';
        $resultado = '';

        oci_bind_by_name($stmt, ":P_ID_PLATILLO", $id);
        oci_bind_by_name($stmt, ":P_TIPO", $tipo);
        oci_bind_by_name($stmt, ":P_COMENTARIO", $comentario);
        oci_bind_by_name($stmt, ":resultado", $resultado, 50);

        oci_execute($stmt);

        echo json_encode([
            'resultado' => $resultado,
            'mensaje' => $resultado === 'TIPO_INVALIDO' 
                ? 'Tipo de borrado inválido' 
                : 'Platillo eliminado correctamente (' . $resultado . ')'
        ]);

        oci_free_statement($stmt);
        oci_close($conn);
    } else {
        echo json_encode([
            'error' => 'Falta parámetro: id'
        ]);
    }
?>
