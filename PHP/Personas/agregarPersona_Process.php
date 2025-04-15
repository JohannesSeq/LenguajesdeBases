<?php
// Procedimiento backend para crear un provincia
if (isset($_POST['cedula'])) {

    //Inciamos la conexion con la base de datos.
    $conn = oci_connect("PlayaCacaoDB", "PlayaCacao12345", "localhost/XE");

    //Passdown de las variables del JS al back end.
    $cedula = $_POST['cedula'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $numero_telefono = $_POST['numero_telefono'];
    $rol = $_POST['rol'];
    $provincia = $_POST['provincia'];
    $canton = $_POST['canton'];
    $distrito = $_POST['distrito'];
    $correo = $_POST['correo'];
    $correo_respaldombre = $_POST['correo_respaldo'];
    $password_persona = $_POST['password_persona'];


    //Establecemos el Query de SQL que queramos ejecutar
    $query = "BEGIN " . 
                 "PKT_PERSONAS.CREAR_PERSONA(:cedula, :nombre, :apellidos, :numero, :rol, :provincia, :canton, :distrito, :correo, :correo_r, :password, 'Insertando persona nueva'); " .  
             "END;";
    
    
    $stmt = oci_parse($conn, $query);

    //Asignamos los valores
    oci_bind_by_name($stmt, ":cedula", $cedula);
    oci_bind_by_name($stmt, ":nombre", $nombre);
    oci_bind_by_name($stmt, ":apellidos", $apellidos);
    oci_bind_by_name($stmt, ":numero", $numero_telefono);
    oci_bind_by_name($stmt, ":rol", $rol);
    oci_bind_by_name($stmt, ":provincia", $provincia);
    oci_bind_by_name($stmt, ":canton", $canton);
    oci_bind_by_name($stmt, ":distrito", $distrito);
    oci_bind_by_name($stmt, ":correo", $correo);
    oci_bind_by_name($stmt, ":correo_r", $correo_respaldombre);
    oci_bind_by_name($stmt, ":password", $password_persona);

    //Ejecutamos la insersion
    $Operacion = oci_execute($stmt);
}
?>
