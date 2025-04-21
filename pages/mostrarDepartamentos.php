<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Departamentos - Restaurante Playa Cacao</title>
    <link rel="icon" type="image/x-icon" href="../img/FavIcon.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style/style.css">
</head>

<body onload="Check_Permissions('Administrador'); listardepartamentos();">
    <?php include_once 'header.php'; ?>

    <div class="container-fluid mt-3">
        <div class="jumbotron">
            <h1 class="display-4">Gestión de Departamentos</h1>
            <p class="lead">Administra los departamentos del restaurante.</p>
            <hr class="my-4">
            <a class="button-62" href="#" data-toggle="modal" data-target="#modalAgregarDepartamento">Agregar nuevo
                departamento</a>
        </div>
    </div>

    <section class="departamentos-form">
        <div class="container">
            <table id="departamentosTable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre del Departamento</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- JS llenará los datos -->
                </tbody>
            </table>
        </div>
    </section>

    <!-- Modal Agregar Departamento -->
    <div class="modal fade" id="modalAgregarDepartamento" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar Departamento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="FormularioAgregarDepartamento">
                        <div class="form-group">
                            <label for="nombre_departamento">Nombre del Departamento</label>
                            <input type="text" class="form-control" id="nombre_departamento" required>
                        </div>
                        <div class="form-group">
                            <label for="descripcion_departamento">Descripción</label>
                            <textarea class="form-control" id="descripcion_departamento" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="comentario_departamento">Comentario</label>
                            <input type="text" class="form-control" id="comentario_departamento" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Agregar Departamento</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Editar Departamento -->
    <div class="modal fade" id="modalEditarDepartamento" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modificar Departamento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="FormularioEditarDepartamento">
                        <input type="hidden" id="editar_id">
                        <div class="form-group">
                            <label for="editar_nombre_departamento">Nombre del Departamento</label>
                            <input type="text" class="form-control" id="editar_nombre_departamento" required>
                        </div>
                        <div class="form-group">
                            <label for="editar_descripcion_departamento">Descripción</label>
                            <textarea class="form-control" id="editar_descripcion_departamento" rows="3"
                                required></textarea>
                        </div>
                        <button type="submit" class="btn btn-success">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include_once 'footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="../script/permissions.js"></script>
    <script src="../script/departamentos.js"></script>
</body>

</html>