<?php
require_once('conexion.php');
$Conexion = new Conexion();
$Get_Conexion = $Conexion->Conectar_Base_De_Datos();

//Passdown de las variables del JS al backend
$correo = $_GET['correo'];
$password = $_GET['password'];

$usuarioOutput = '';

$query = "SELECT * FROM USUARIOS WHERE CORREO = '".$correo."'";
$Query_Result = $stmt = $Get_Conexion->prepare($query);
$stmt->execute();

$UsuarioCorreoQuery = '';
$UsuarioPasswordQuery = '';
$usuarioRolQuery = '';

$UserArray = array();


while($row = $Query_Result->fetch(PDO::FETCH_ASSOC)) {
    $UserArray[] = $row;
    $UsuarioCorreoQuery = $row["correo"];
    $UsuarioPasswordQuery = $row["password"];
    $usuarioRolQuery = $row["rol_id"];
    
}

if($UsuarioCorreoQuery != null){

    if($UsuarioCorreoQuery == $correo && $UsuarioPasswordQuery == $password){

        setcookie('email', $UsuarioCorreoQuery, time() + 3600, '/');
        setcookie('rol_id', $usuarioRolQuery, time() + 3600, '/');
        setcookie('nombre', $UsuarioCorreoQuery, time() + 3600, '/');

        $usuarioOutput = 'Success';
    }    

} else {
    setcookie('email', '', time() + 3600, '/');
    setcookie('rol_id', '', time() + 3600, '/');
    setcookie('nombre', '', time() + 3600, '/');
    $usuarioOutput = 'Failure';
}

echo $usuarioOutput;

?>
