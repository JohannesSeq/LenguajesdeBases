<?php
require_once('conexion.php');

$Conexion = new Conexion();
$Get_Conexion = $Conexion->Conectar_Base_De_Datos();


//Passdown de las variables del JS al backend
$correo = $_GET['correo'];
$password = $_GET['password'];

$usuarioOutput = '';

$stmt = $conn->prepare("SELECT * FROM usuario WHERE correo = ?");

$query = "SELECT * FROM USUARIOS WHERE CORREO = ". $correo;

$Query_Result = $stmt = $Get_Conexion->prepare($query);
$stmt->execute();

$UsuarioArray = $Query_Result->fetch_assoc();

if($UsuarioArray['correo'] != null){

    if($UsuarioArray['correo'] == $correo && $UsuarioArray['password'] == $password){

        setcookie('email', $UsuarioArray['correo'], time() + 3600, '/');
        setcookie('ROL_ID', $UsuarioArray['ROL_ID'], time() + 3600, '/');
        setcookie('nombre', $UsuarioArray['nombre'], time() + 3600, '/');

        $usuarioOutput = 'Success';
    }    

} else {
    setcookie('email', '', time() + 3600, '/');
    setcookie('ROL_ID', '', time() + 3600, '/');
    setcookie('nombre', '', time() + 3600, '/');
    $usuarioOutput = 'Failure';
}

echo $usuarioOutput;

$stmt->close();
$conn->close();

?>
