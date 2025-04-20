<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Facturación - Restaurante Playa Cacao</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style/style.css">
</head>

<body onload="Check_Permissions('Administrador'); listarFacturas();">
    <?php include_once 'header.php'; ?>

    <div class="container mt-4">
        <h1 class="mb-4">Facturas Generadas</h1>
        <table class="table table-striped" id="tablaFacturas">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Pedido</th>
                    <th>Método Pago</th>
                    <th>Total</th>
                    <th>Vuelto</th>
                    <th>Descuento</th>
                    <th>IVA</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- JS llenará dinámicamente -->
            </tbody>
        </table>
    </div>

    <!-- Modal Editar Factura -->
    <div class="modal fade" id="modalEditarFactura" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modificar Factura</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <form id="formEditarFactura">
                        <input type="hidden" id="editar_id_factura">
                        <div class="form-group">
                            <label for="editar_metodo">Método de Pago</label>
                            <select class="form-control" id="editar_metodo" required></select>
                        </div>
                        <div class="form-group">
                            <label for="editar_vuelto">Vuelto</label>
                            <input type="number" class="form-control" id="editar_vuelto" required>
                        </div>
                        <div class="form-group">
                            <label for="editar_descuento">Descuento</label>
                            <input type="number" class="form-control" id="editar_descuento">
                        </div>
                        <div class="form-group">
                            <label for="editar_iva">IVA</label>
                            <input type="number" class="form-control" id="editar_iva">
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
    <script src="../script/facturas.js"></script>
</body>

</html>