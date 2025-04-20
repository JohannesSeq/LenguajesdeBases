<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Puestos - Restaurante Playa Cacao</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style/style.css">
</head>
<body onload="Check_Permissions('Administrador'); listarpustos();">
<?php include_once 'header.php'; ?>

<div class="container-fluid mt-3">
    <div class="jumbotron">
        <h1 class="display-4">Gestión de Puestos</h1>
        <p class="lead">Administra los puestos del restaurante.</p>
        <hr class="my-4">
        <a class="button-62" href="#" data-toggle="modal" data-target="#modalAgregarPuesto">Agregar nuevo puesto</a>
    </div>
</div>

<section class="puestos-form">
    <div class="container">
        <table id="puestosTable" class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre del Puesto</th>
                    <th>Salario Base</th>
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

<!-- Modal Agregar Puesto -->
<div class="modal fade" id="modalAgregarPuesto" tabindex="-1" role="dialog">
    <div class="modal-dialog"><div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Agregar Puesto</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="FormularioAgregarPuesto">
                <div class="form-group">
                    <label for="nombre_puesto">Nombre del Puesto</label>
                    <input type="text" class="form-control" id="nombre_puesto" required>
                </div>
                <div class="form-group">
                    <label for="salario_base">Salario Base</label>
                    <input type="number" class="form-control" id="salario_base" required>
                </div>
                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <textarea class="form-control" id="descripcion" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Agregar Puesto</button>
            </form>
        </div>
    </div></div>
</div>

<!-- Modal Editar Puesto -->
<div class="modal fade" id="modalEditarPuesto" tabindex="-1" role="dialog">
    <div class="modal-dialog"><div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Modificar Puesto</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="FormularioEditarPuesto">
                <input type="hidden" id="editar_id">
                <div class="form-group">
                    <label for="editar_nombre">Nombre del Puesto</label>
                    <input type="text" class="form-control" id="editar_nombre" required>
                </div>
                <div class="form-group">
                    <label for="editar_salario">Salario Base</label>
                    <input type="number" class="form-control" id="editar_salario" required>
                </div>
                <div class="form-group">
                    <label for="editar_descripcion">Descripción</label>
                    <textarea class="form-control" id="editar_descripcion" rows="3" required></textarea>
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
<script src="../script/puestos.js"></script>
</body>
</html>
