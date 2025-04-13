<?php 
    $conn = oci_connect("PlayaCacaoDB", "PlayaCacao12345", "localhost/XE");

    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];
    
    $query = "BEGIN " .
    "ACTUALIZAR_PLATILLO(:P_ID,:P_NOMBRE, :P_PRECIO, :P_CANTIDAD); " .
    "END;";

    //Guardamos el query
    $stmt = oci_parse($conn, $query);                 

    //Vinculamos los parametros necesarios para el procedimiento almacenado
    oci_bind_by_name($stmt, ":P_ID", $id);
    oci_bind_by_name($stmt, ":P_NOMBRE", $nombre);
    oci_bind_by_name($stmt, ":P_PRECIO", $precio);
    oci_bind_by_name($stmt, ":P_CANTIDAD", $cantidad);

    // Ejecutar el procedimiento
    oci_execute($stmt);


    // Cerramos la conexion con la DB
    oci_free_statement($stmt);
    oci_close($conn);

?>
