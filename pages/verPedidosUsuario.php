<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Pedidos - Restaurante Playa Cacao</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style/style.css">
</head>
<body onload="Check_Permissions('Cliente'); cargarPedidosUsuario();">
<?php include_once 'header.php'; ?>

<div class="container-fluid mt-3">
    <div class="jumbotron">
        <h1 class="display-4">Mis Pedidos</h1>
        <p class="lead">Aquí puedes consultar tus pedidos realizados.</p>
        <hr class="my-4">
    </div>
</div>

<section class="pedidos-usuario-form">
    <div class="container">
        <table id="pedidosUsuarioTable" class="table table-bordered">
            <thead>
                <tr>
                    <th>ID Pedido</th>
                    <th>Monto Estimado</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <!-- JS llenará esta sección -->
            </tbody>
        </table>
    </div>
</section>

<?php include_once 'footer.php'; ?>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="../script/permissions.js"></script>
<script src="../script/cookie_management.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="../script/pedidos_usuario.js"></script>
</body>
</html>
