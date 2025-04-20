<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Empleados - Restaurante Playa Cacao</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style/style.css">
</head>
<body onload="Check_Permissions('Administrador'); listarempleados(); cargarPuestos(); cargarDepartamentos(); cargarPersonasEmpleables();">

<?php include_once 'header.php'; ?>

<div class="container-fluid mt-3">
    <div class="jumbotron">
        <h1 class="display-4">Gestión de Empleados</h1>
        <p class="lead">Administra los empleados del restaurante.</p>
        <hr class="my-4">
        <a class="button-62" href="#" data-toggle="modal" data-target="#modalAgregarEmpleado">Agregar nuevo empleado</a>
    </div>
</div>

<section class="empleados-form">
    <div class="container">
        <table id="empleadosTable" class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre completo</th>
                    <th>Rol</th>
                    <th>Departamento</th>
                    <th>Puesto</th>
                    <th>Salario</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- JS llenará los datos -->
            </tbody>
        </table>
    </div>
</section>

<!-- Modal Agregar Empleado -->
<div class="modal fade" id="modalAgregarEmpleado" tabindex="-1" role="dialog">
    <div class="modal-dialog"><div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Agregar Empleado</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="FormularioAgregarEmpleado">
                <div class="form-group">
                    <label for="cedula_empleado">Persona</label>
                    <select class="form-control" id="cedula_empleado" required></select>
                </div>
                <div class="form-group">
                    <label for="departamento_empleado">Departamento</label>
                    <select class="form-control" id="departamento_empleado" required></select>
                </div>
                <div class="form-group">
                    <label for="puesto_empleado">Puesto</label>
                    <select class="form-control" id="puesto_empleado" required></select>
                </div>
                <div class="form-group">
                    <label for="salario_empleado">Salario</label>
                    <input type="number" class="form-control" id="salario_empleado" required>
                </div>
                <div class="form-group">
                    <label for="comentario_empleado">Comentario</label>
                    <input type="text" class="form-control" id="comentario_empleado" required>
                </div>
                <button type="submit" class="btn btn-primary">Agregar Empleado</button>
            </form>
        </div>
    </div></div>
</div>

<!-- Modal Editar Empleado -->
<div class="modal fade" id="modalEditarEmpleado" tabindex="-1" role="dialog">
    <div class="modal-dialog"><div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Modificar Empleado</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="FormularioEditarEmpleado">
                <input type="hidden" id="editar_id_empleado">
                <div class="form-group">
                    <label for="editar_departamento_empleado">Departamento</label>
                    <select class="form-control" id="editar_departamento_empleado" required></select>
                </div>
                <div class="form-group">
                    <label for="editar_puesto_empleado">Puesto</label>
                    <select class="form-control" id="editar_puesto_empleado" required></select>
                </div>
                <div class="form-group">
                    <label for="editar_salario_empleado">Salario</label>
                    <input type="number" class="form-control" id="editar_salario_empleado" required>
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
<script src="../script/empleados.js"></script>
</body>
</html>
