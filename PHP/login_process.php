<?php
include('connection.php');

//Passdown de las variables del JS al backend
$correo = $_GET['correo'];
$user_pass = $_GET['user_pass'];

$usuarioOutput = '';

$stmt = $conn->prepare("SELECT * FROM usuario WHERE correo = ?");

$stmt->bind_param("s", $correo);
$stmt->execute();

$result = $stmt->get_result();

$UsuarioArray = $result->fetch_assoc();

if($UsuarioArray['correo'] != null){

    if($UsuarioArray['correo'] == $correo){
        if(password_verify($user_pass,$UsuarioArray['user_pass'])){

            setcookie('email', $UsuarioArray['correo'], time() + 3600, '/');
            setcookie('rol', $UsuarioArray['rol'], time() + 3600, '/');
            setcookie('nombre', $UsuarioArray['nombre'], time() + 3600, '/');

            $usuarioOutput = 'Success';
        }
    }    

} else {
    setcookie('email', '', time() + 3600, '/');
    setcookie('rol', '', time() + 3600, '/');
    setcookie('nombre', '', time() + 3600, '/');
    $usuarioOutput = 'Failure';
}

echo $usuarioOutput;

$stmt->close();
$conn->close();

?>
