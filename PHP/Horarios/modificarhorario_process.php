<?php 
    $conn = oci_connect("PlayaCacaoDB", "PlayaCacao12345", "localhost/XE");

    $id_horario = $_POST['id_horario'];
    $disponibilidad = $_POST['disponibilidad'];
    $hora_exacta = $_POST['hora_exacta']; // Formato esperado: 'YYYY-MM-DD HH24:MI:SS'

    $query = "BEGIN ACTUALIZAR_HORARIO_MESA(:P_ID_HORARIO, :P_DISPONIBILIDAD, TO_DATE(:P_HORA_EXACTA, 'YYYY-MM-DD HH24:MI:SS')); END;";

    $stmt = oci_parse($conn, $query);

    oci_bind_by_name($stmt, ":P_ID_HORARIO", $id_horario);
    oci_bind_by_name($stmt, ":P_DISPONIBILIDAD", $disponibilidad);
    oci_bind_by_name($stmt, ":P_HORA_EXACTA", $hora_exacta);

    oci_execute($stmt);

    oci_free_statement($stmt);
    oci_close($conn);
?>
