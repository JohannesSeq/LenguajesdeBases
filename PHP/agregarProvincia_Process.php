<?php
// Procedimiento backend para crear un provincia
if (isset($_POST['nombre'])) {

    //Inciamos la conexion con la base de datos.
    $conn = oci_connect("PlayaCacaoDB", "PlayaCacao12345", "localhost/XE");

    //Passdown de las variables del JS al back end.
    $nombre = $_POST['nombre'];

    //Establecemos el Query de SQL que queramos ejecutar
    $query = "BEGIN " . 
             "PKT_PROVINCIAS.CREAR_PROVINCIA(:nombre, 'Insertando provincia'); " .  
             "END;";
    
    
    $stmt = oci_parse($conn, $query);

    //Asignamos los valores
    oci_bind_by_name($stmt, ":nombre", $nombre);

    //Ejecutamos la insersion
    $Operacion = oci_execute($stmt);
}
?>
