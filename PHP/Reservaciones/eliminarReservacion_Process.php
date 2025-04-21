<?php 
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

$tipo = getenv("TIPO_BORRADO");

if (!$tipo) {
    echo json_encode(['error' => 'La variable TIPO_BORRADO no está definida en el .env']);
    exit;
}

if (isset($_POST['id'])) {
    $id = (int) $_POST['id'];

    $conn = oci_connect("PlayaCacaoDB", "PlayaCacao12345", "localhost/XE");

    $query = "BEGIN 
                :resultado := EJECUTAR_BORRADO_RESERVACION(:P_ID_RESERVA, :P_TIPO, :P_COMENTARIO); 
              END;";

    $stmt = oci_parse($conn, $query);

    $comentario = 'Eliminando reservación desde proceso PHP';
    $resultado = '';

    oci_bind_by_name($stmt, ":P_ID_RESERVA", $id);
    oci_bind_by_name($stmt, ":P_TIPO", $tipo);
    oci_bind_by_name($stmt, ":P_COMENTARIO", $comentario);
    oci_bind_by_name($stmt, ":resultado", $resultado, 50);

    oci_execute($stmt);

    echo json_encode([
        'resultado' => $resultado,
        'mensaje' => match($resultado) {
            'BORRADO_LOGICO' => 'Reservación marcada como inactiva.',
            'BORRADO_FISICO' => 'Reservación eliminada permanentemente.',
            'NO_EXISTE_RESERVA' => 'La reservación no existe o ya fue eliminada.',
            'TIPO_INVALIDO' => 'Tipo de borrado inválido.',
            default => 'Resultado desconocido.'
        }
    ]);

    oci_free_statement($stmt);
    oci_close($conn);
} else {
    echo json_encode(['error' => 'Falta parámetro: id']);
}
?>
