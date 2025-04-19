<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mesas - Restaurante Playa Cacao</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style/style.css">
</head>
<body onload="Check_Permissions('Empleado'); listadomesas();">
<?php include_once 'header.php'; ?>

<div class="container-fluid mt-3">
    <div class="jumbotron">
        <h1 class="display-4">Mesas</h1>
        <p class="lead">Gestión de mesas del restaurante.</p>
        <hr class="my-4">
        <a class="button-62" href="#" data-toggle="modal" data-target="#modalAgregarMesa">Agregar nueva mesa</a>
    </div>
</div>

<section class="platillos-form">
    <div class="container">
        <table id="mesasTable" class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre de Mesa</th>
                    <th>ID Horario</th>
                    <th>ID Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</section>

<!-- Modal Agregar Mesa -->
<div class="modal fade" id="modalAgregarMesa" tabindex="-1" role="dialog">
  <div class="modal-dialog"><div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">Agregar Mesa</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
      <form id="Agregar_Mesa_Form">
        <div class="form-group">
          <label for="nombre_mesa">Nombre de la Mesa</label>
          <input type="text" class="form-control" id="nombre_mesa" required>
        </div>
        <div class="form-group">
          <label for="id_horario">Horario disponible</label>
          <select class="form-control" id="id_horario" required></select>
        </div>
        <button type="submit" class="btn btn-primary">Agregar Mesa</button>
      </form>
    </div>
  </div></div>
</div>


<!-- Modal Modificar Mesa -->
<div class="modal fade" id="modalModificarMesa" tabindex="-1" role="dialog">
  <div class="modal-dialog"><div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">Modificar Mesa</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
      <form id="Modificar_Mesa_Form">
        <input type="hidden" id="mesa_id_modificar">
        <div class="form-group">
          <label for="mod_nombre_mesa">Nombre de la Mesa</label>
          <input type="text" class="form-control" id="mod_nombre_mesa" required>
        </div>
        <div class="form-group">
          <label for="mod_id_horario">Horario disponible</label>
          <select class="form-control" id="mod_id_horario" required></select>
        </div>
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
      </form>
    </div>
  </div></div>
</div>

<?php include_once 'footer.php'; ?>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="../script/mesas.js"></script>
<script src="../script/permissions.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
