<?php
header('Content-Type: application/json');

if (isset($_POST['disponibilidad']) && isset($_POST['Hora'])) {

    // Iniciamos la conexión
    $conn = oci_connect("PlayaCacaoDB", "PlayaCacao12345", "localhost/XE");

    if (!$conn) {
        $error = oci_error();
        echo json_encode(["success" => false, "message" => "Error en la conexión de la base de datos", "error" => $error['message']]);
        exit;
    }

    // Recuperamos las variables de POST
    $disponibilidad = $_POST['disponibilidad'];
    $hora = $_POST['Hora'];  // Se espera el formato 'YYYY-MM-DD HH24:MI' o similar

    // Query para ejecutar el procedimiento almacenado
    $query = "BEGIN 
                CREAR_HORARIO_MESA(:DISPONIBILIDAD, TO_DATE(:HORA_EXACTA, 'YYYY-MM-DD HH24:MI'), NULL); 
              END;";

    // Preparamos la consulta
    $stmt = oci_parse($conn, $query);

    // Vinculamos los parámetros
    oci_bind_by_name($stmt, ":DISPONIBILIDAD", $disponibilidad);
    oci_bind_by_name($stmt, ":HORA_EXACTA", $hora);

    // Ejecutamos la consulta
    $Operacion = oci_execute($stmt);

    // Comprobamos si la ejecución fue exitosa
    if ($Operacion) {
        echo json_encode(["success" => true, "message" => "Horario creado exitosamente"]);
    } else {
        $e = oci_error($stmt);
        echo json_encode(["success" => false, "message" => "Error al crear horario", "error" => $e['message']]);
    }

    // Liberamos los recursos
    oci_free_statement($stmt);
    oci_close($conn);

} else {
    echo json_encode(["success" => false, "message" => "Parámetros incompletos"]);
}
?>
