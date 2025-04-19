<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Hacer Reservación - Restaurante Playa Cacao</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style/style.css">
</head>

<body onload="Check_Permissions('Cliente')">
<?php include_once 'header.php'; ?>

<div class="container mt-5">
    <div class="jumbotron">
        <h1 class="display-4">Nueva Reservación</h1>
        <p class="lead">Selecciona un horario y una mesa disponible para confirmar tu reservación.</p>
        <hr class="my-4">
    </div>

    <div class="card p-4">
        <form id="FormularioAgregarReservacionUsuario">
            <div class="form-group">
                <label for="cedula_cliente">Cédula del Cliente</label>
                <input type="number" class="form-control" id="cedula_cliente" readonly required>
            </div>
            <div class="form-group">
                <label for="horario">Horario disponible</label>
                <select class="form-control" id="horario" required></select>
            </div>
            <div class="form-group">
                <label for="mesa">Mesa disponible</label>
                <select class="form-control" id="mesa" required></select>
            </div>
            <button type="submit" class="btn btn-primary">Confirmar Reservación</button>
        </form>
    </div>
</div>

<?php include_once 'footer.php'; ?>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="../script/permissions.js"></script>
<script src="../script/cookie_management.js"></script>
<script src="../script/reservaciones.js"></script>

<script>
    $(document).ready(function () {
        cargarCedulaDesdeEmail();
        cargarHorariosDisponibles('#horario');

        $('#horario').on('change', function () {
            const idHorario = $(this).val();
            if (idHorario) {
                cargarMesasPorHorario(idHorario, '#mesa');
            }
        });

        $('#FormularioAgregarReservacionUsuario').submit(function (e) {
            e.preventDefault();

            const data = {
                cedula: $('#cedula_cliente').val(),
                mesa: $('#mesa').val(),
                confirmacion: "Confirmado"
            };

            $.post('../PHP/Reservaciones/agregarReservacion_Process.php', data, function () {
                Swal.fire("Reservación Confirmada", "Tu reservación se ha guardado correctamente", "success")
                    .then(() => window.location.href = "verReservacionesUsuario.php");
            });
        });
    });
</script>
</body>
</html>
