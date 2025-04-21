<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horarios - Restaurante Playa Cacao</title>
    <link rel="icon" type="image/x-icon" href="../img/FavIcon.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style/style.css">
    <style>
        .Horarios-form {
            padding: 50px 0;
        }
        .Horarios-form .container {
            max-width: 800px;
            margin: 0 auto;
        }
    </style>
</head>
<body onload="Check_Permissions('Empleado'); listahorarios();">
    <?php include_once 'header.php'; ?>

    <div class="container-fluid mt-3">
        <div class="jumbotron">
            <h1 class="display-4">Horarios</h1>
            <p class="lead">Revisa y administra los horarios disponibles.</p>
            <hr class="my-4">
            <a class="button-62" href="#" data-toggle="modal" data-target="#modalAgregarHorario">Agregar nuevo Horario</a>
        </div>
    </div>

    <section class="Horarios-form">
        <div class="container">
            <table id="HorariosTable" class="table">
                <thead>
                    <tr>
                        <th>ID HORARIO</th>
                        <th>DISPONIBILIDAD</th>
                        <th>HORA EXACTA</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- JS insertará aquí las filas -->
                </tbody>
            </table>
        </div>
    </section>

    <!-- Modal MODIFICAR -->
    <div class="modal fade" id="modificarhorariomodal" tabindex="-1" role="dialog" aria-labelledby="modificarHorariosLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="ModificarHorarioForm">
                    <div class="modal-header">
                        <h5 class="modal-title">Modificar Horario</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <!-- ID oculto -->
                        <input type="hidden" name="id_horario" id="modificar_id_horario">

                        <div class="form-group">
                            <label>Disponibilidad</label>
                            <input type="text" class="form-control" name="disponibilidad" required>
                        </div>

                        <div class="form-group">
                            <label>Fecha y Hora exacta</label>
                            <input type="datetime-local" class="form-control" name="hora_exacta" required>
                        </div>

                        <div class="form-group">
                            <label>Comentario</label>
                            <input type="text" class="form-control" name="comentario" placeholder="Ej: Actualización de disponibilidad" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal AGREGAR -->
    <div class="modal fade" id="modalAgregarHorario" tabindex="-1" role="dialog" aria-labelledby="modalAgregarHorarioLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="Agregar_Horario_Form">
                    <div class="modal-header">
                        <h5 class="modal-title">Agregar nuevo Horario</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Disponibilidad</label>
                            <input type="text" class="form-control" name="disponibilidad" required>
                        </div>
                        <div class="form-group">
                            <label>Fecha y Hora exacta</label>
                            <input type="datetime-local" class="form-control" name="hora_exacta" required>
                        </div>
                        <div class="form-group">
                            <label>Comentario</label>
                            <input type="text" class="form-control" name="comentario" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Agregar Horario</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include_once 'footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="../script/Horarios.js"></script>
    <script src="../script/permissions.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../script/cookie_management.js"></script>
</body>
</html>
