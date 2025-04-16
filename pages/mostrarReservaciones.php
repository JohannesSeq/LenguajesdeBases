<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservaciones - Restaurante Playa Cacao</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style/style.css">
</head>

<body onload="Check_Permissions('Empleado'); listarreservaciones()">
<?php include_once 'header.php'; ?>

<div class="container-fluid mt-3">
    <div class="jumbotron">
        <h1 class="display-4">Reservaciones</h1>
        <p class="lead">Consulta y gestiona las reservaciones realizadas.</p>
        <hr class="my-4">
        <a class="button-62" href="#" role="button" id="agregarBtn" data-toggle="modal" data-target="#modalAgregarReserva">Agregar nueva reservación</a>
    </div>
</div>

<section class="reservaciones-form">
    <div class="container">
        <table id="reservacionesTable" class="table">
            <thead>
                <tr>
                    <th>ID Reserva</th>
                    <th>Confirmación</th>
                    <th>Cédula Cliente</th>
                    <th>Mesa</th>
                    <th>Horario</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Llenado dinámico por JS -->
            </tbody>
        </table>
    </div>
</section>

<?php include_once 'footer.php'; ?>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="../script/permissions.js"></script>
<script src="../script/cookie_management.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../script/reservaciones.js"></script>
</body>
</html>
