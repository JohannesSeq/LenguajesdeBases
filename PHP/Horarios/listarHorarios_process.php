<?php 
$conn = oci_connect("PlayaCacaoDB", "PlayaCacao12345", "localhost/XE");

$query = "SELECT * FROM VISTA_HORARIOS";

// Preparar el statement
$stmt = oci_parse($conn, $query);

// Ejecutar el query
oci_execute($stmt);

// Crear el arreglo para almacenar los datos
$Horarios = array();

// Recorrer los resultados y agregarlos al arreglo
while (($row = oci_fetch_assoc($stmt)) != false) {
    $Horarios[] = $row;
}

// Devolver los resultados en formato JSON
echo json_encode($Horarios);

// Liberar recursos
oci_free_statement($stmt);
oci_close($conn);
?>

