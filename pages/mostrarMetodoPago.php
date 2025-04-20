<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Métodos de Pago - Restaurante Playa Cacao</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style/style.css">
</head>
<body onload="Check_Permissions('Administrador'); listarMetodosPago();">
<?php include_once 'header.php'; ?>

<div class="container-fluid mt-3">
    <div class="jumbotron">
        <h1 class="display-4">Métodos de Pago</h1>
        <p class="lead">Administra los métodos de pago disponibles en el restaurante.</p>
        <hr class="my-4">
        <a class="button-62" href="#" data-toggle="modal" data-target="#modalAgregarMetodoPago">Agregar nuevo método</a>
    </div>
</div>

<section class="metodos-pago-form">
    <div class="container">
        <table id="metodosPagoTable" class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Llenado dinámico por JS -->
            </tbody>
        </table>
    </div>
</section>

<!-- Modal Agregar -->
<div class="modal fade" id="modalAgregarMetodoPago" tabindex="-1" role="dialog">
    <div class="modal-dialog"><div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Agregar Método de Pago</h5>
            <button type="button" class="close" data-dismiss="modal">
                <span>&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="FormularioAgregarMetodoPago">
                <div class="form-group">
                    <label for="nombre_metodo">Nombre</label>
                    <input type="text" class="form-control" id="nombre_metodo" required>
                </div>
                <div class="form-group">
                    <label for="descripcion_metodo">Descripción</label>
                    <textarea class="form-control" id="descripcion_metodo" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label for="comentario_metodo">Comentario</label>
                    <input type="text" class="form-control" id="comentario_metodo" required>
                </div>
                <button type="submit" class="btn btn-primary">Agregar</button>
            </form>
        </div>
    </div></div>
</div>

<!-- Modal Editar -->
<div class="modal fade" id="modalEditarMetodoPago" tabindex="-1" role="dialog">
    <div class="modal-dialog"><div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Modificar Método de Pago</h5>
            <button type="button" class="close" data-dismiss="modal">
                <span>&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="FormularioEditarMetodoPago">
                <input type="hidden" id="editar_id_metodo">
                <div class="form-group">
                    <label for="editar_nombre_metodo">Nombre</label>
                    <input type="text" class="form-control" id="editar_nombre_metodo" required>
                </div>
                <div class="form-group">
                    <label for="editar_descripcion_metodo">Descripción</label>
                    <textarea class="form-control" id="editar_descripcion_metodo" rows="3" required></textarea>
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
<script src="../script/metodo_pago.js"></script>
</body>
</html>
