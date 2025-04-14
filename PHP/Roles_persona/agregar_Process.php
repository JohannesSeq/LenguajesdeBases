<?php
// Procedimiento backend para crear un distritos
if (isset($_POST['nombre'])) {

    //Inciamos la conexion con la base de datos.
    $conn = oci_connect("PlayaCacaoDB", "PlayaCacao12345", "localhost/XE");

    //Passdown de las variables del JS al back end.

    $id = $_POST['id_rol'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $nivel = $_POST['nivel'];

    //Establecemos el Query de SQL que queramos ejecutar
    $query = "BEGIN " . 
                "PKT_ROL_PERSONA.CREAR_ROL_PERSONA(:P_ID, :P_NOMBRE, :P_DESCRIPCION, :P_NIVEL, 'Insertando distritos'); " .  
             "END;";
    
    
    $stmt = oci_parse($conn, $query);

    //Asignamos los valores
    oci_bind_by_name($stmt, ":P_ID", $id);
    oci_bind_by_name($stmt, ":P_NOMBRE", $nombre);
    oci_bind_by_name($stmt, ":P_DESCRIPCION", $descripcion);
    oci_bind_by_name($stmt, ":P_NIVEL", $nivel);

    //Ejecutamos la insersion
    $Operacion = oci_execute($stmt);
}
?>
