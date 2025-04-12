<?php
// Procedimiento backend para crear un platillo
if (isset($_POST['nombre']) && isset($_POST['precio']) && isset($_POST['cantidad'])) {

    //Inciamos la conexion con la base de datos.
    $conn = oci_connect("PlayaCacaoDB", "PlayaCacao12345", "localhost/XE");

    //Passdown de las variables del JS al back end.
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];

    //Establecemos el Query de SQL que queramos ejecutar
    $query = "BEGIN " . 
             "CREAR_PLATILLO(:nombre, :precio, :cantidad, 'Insertando Platillo'); " .  
             "END;";
    
    
    $stmt = oci_parse($conn, $query);

    //Asignamos los valores
    oci_bind_by_name($stmt, ":nombre", $nombre);
    oci_bind_by_name($stmt, ":precio", $precio);
    oci_bind_by_name($stmt, ":cantidad", $cantidad);

    //Ejecutamos la insersion
    $Operacion = oci_execute($stmt);
}
?>
