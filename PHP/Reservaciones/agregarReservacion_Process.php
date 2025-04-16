<?php
if (isset($_POST['confirmacion']) && isset($_POST['cedula']) && isset($_POST['mesa']) && isset($_POST['horario'])) {
    $conn = oci_connect("PlayaCacaoDB", "PlayaCacao12345", "localhost/XE");

    $confirmacion = $_POST['confirmacion'];
    $cedula = $_POST['cedula'];
    $mesa = $_POST['mesa'];
    $horario = $_POST['horario'];

    $query = "BEGIN PKT_RESERVACIONES.CREAR_RESERVACION(:confirmacion, :cedula, :mesa, :horario); END;";
    
    $stmt = oci_parse($conn, $query);
    oci_bind_by_name($stmt, ":confirmacion", $confirmacion);
    oci_bind_by_name($stmt, ":cedula", $cedula);
    oci_bind_by_name($stmt, ":mesa", $mesa);
    oci_bind_by_name($stmt, ":horario", $horario);
    
    oci_execute($stmt);
}
?>
