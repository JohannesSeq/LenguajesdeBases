<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reservaciones - Restaurante Playa Cacao</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style/style.css">
</head>

<body onload="Check_Permissions('Empleado'); listarreservaciones(); ">
<?php include_once 'header.php'; ?>

<div class="container-fluid mt-3">
    <div class="jumbotron">
        <h1 class="display-4">Reservaciones</h1>
        <p class="lead">Consulta y gestiona las reservaciones realizadas.</p>
        <hr class="my-4">
        <a class="button-62" href="#" data-toggle="modal" data-target="#modalAgregarReservacion">Agregar nueva reservación</a>
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

<!-- Modal Agregar Reservación -->
<div class="modal fade" id="modalAgregarReservacion" tabindex="-1" role="dialog">
    <div class="modal-dialog"><div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Agregar Reservación</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="FormularioAgregarReservacion">
                <div class="form-group">
                    <label for="cedula_cliente">Cédula del Cliente</label>
                    <input type="number" class="form-control" id="cedula_cliente" readonly required>
                </div>
                <div class="form-group">
                    <label for="mesa">Mesa disponible</label>
                    <select class="form-control" id="mesa" required></select>
                </div>
                <div class="form-group">
                    <label for="horario_mesa">Horario asignado</label>
                    <input type="text" class="form-control" id="horario_mesa" disabled>
                </div>
                <button type="submit" class="btn btn-primary">Confirmar Reservación</button>
            </form>
        </div>
    </div></div>
</div>

<!-- Modal Editar Reservación -->
<div class="modal fade" id="modalEditarReservacion" tabindex="-1" role="dialog">
    <div class="modal-dialog"><div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Modificar Reservación</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="FormularioEditarReservacion">
                <input type="hidden" id="editar_id">
                <div class="form-group">
                    <label for="editar_confirmacion">Confirmación</label>
                    <select class="form-control" id="editar_confirmacion">
                        <option value="Confirmado">Confirmado</option>
                        <option value="Cancelado">Cancelado</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="editar_mesa">Mesa</label>
                    <select class="form-control" id="editar_mesa" required></select>
                </div>
                <div class="form-group">
                    <label for="editar_horario">Horario</label>
                    <input type="text" class="form-control" id="editar_horario" disabled>
                </div>
                <button type="submit" class="btn btn-success">Guardar Cambios</button>
            </form>
        </div>
    </div></div>
</div>

<?php include_once 'footer.php'; ?>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="../script/permissions.js"></script>
<script src="../script/cookie_management.js"></script>
<script src="../script/reservaciones.js?v=1.0"></script>
</body>
</html>
