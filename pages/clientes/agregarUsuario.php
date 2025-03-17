<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Usuario - Sistema</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style/style.css">
</head>

<body onload = "Check_Permissions('Gerente')" >
    <?php include_once 'header.php'; ?>

    <div class="container-fluid mt-3">
        <div class="jumbotron">
            <h1 class="display-4">Agregar Usuario</h1>
            <p class="lead">Agrege un usuario al sistema.</p>
            <hr class="my-4">
        </div>
    </div>

    <div class="container mt-5">
        <h1 class="text-center">Registrar Usuario</h1>
        <form id="Agregar_Usuario_Form">
            <div class="form-group">
                <label for="nombre">Nombre Completo</label>
                <input type="text" class="form-control" id="nombre" name="nombre"
                    placeholder="Ingresa tu nombre completo" required>
            </div>
            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <input type="email" class="form-control" id="email" name="email"
                    placeholder="Ingresa tu correo electrónico" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password"
                    placeholder="Ingresa tu contraseña" required>
            </div>
            <div class="form-group">
                <label for="rol">Rol</label>
                <select class="form-control" id="rol" name="rol" required>
                    <option value="Cliente">Cliente</option>
                    <option value="Vendedor">Vendedor</option>
                    <option value="Gerente">Gerente</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Registrar</button>
        </form>
    </div>
    <br>

    <?php include_once 'footer.php'; ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../script/usuarioController.js"></script>
    <script src="../script/permissions.js"></script>
    <script src="../script/cookie_management.js"></script>

</body>

</html>