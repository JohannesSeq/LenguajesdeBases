<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Mis Pedidos - Restaurante Playa Cacao</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style/style.css">
</head>

<body onload="Check_Permissions('Cliente'); cargarPedidosUsuario();">
    <?php include_once 'header.php'; ?>

    <div class="container-fluid mt-3">
        <div class="jumbotron">
            <h1 class="display-4">Mis Pedidos</h1>
            <p class="lead">Aquí puedes consultar tus pedidos realizados.</p>
            <hr class="my-4">
        </div>
    </div>

    <section class="pedidos-usuario-form">
        <div class="container">
            <table id="pedidosUsuarioTable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID Pedido</th>
                        <th>Monto Estimado</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- JS llenará esta sección -->
                </tbody>
            </table>
        </div>
    </section>

    <!-- Modal para realizar pago -->
    <div class="modal fade" id="modalPagarFactura" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Realizar Pago</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <form id="formPagarFactura">
                        <input type="hidden" id="factura_pedido_id">
                        <input type="hidden" id="factura_cedula">
                        <input type="hidden" id="factura_monto_total">
                        <input type="hidden" id="factura_cliente">
                        <input type="hidden" id="factura_vuelto" value="0">
                        <input type="hidden" id="factura_descuento" value="0">

                        <div class="form-group">
                            <label for="factura_metodo_pago">Método de Pago</label>
                            <select class="form-control" id="factura_metodo_pago" required></select>
                        </div>

                        <div class="form-group">
                            <label for="factura_iva">IVA (13%)</label>
                            <input type="number" class="form-control" id="factura_iva" value="13" readonly>
                        </div>

                        <button type="submit" class="btn btn-primary">Confirmar Pago</button>
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
    <script src="../script/cookie_management.js"></script>
    <script src="../script/pedidos_usuario.js"></script>

    <script>
        function cargarMetodosPago() {
            $.get('../PHP/MetodoPago/listarMetodoPago_Process.php', function (data) {
                const metodos = JSON.parse(data);
                const select = $('#factura_metodo_pago');
                select.empty();
                metodos.forEach(m => {
                    select.append(`<option value="${m.ID_METODO}">${m.NOMBRE_METODO}</option>`);
                });
            });
        }

        $(document).on('click', '.btn-pagar', function () {
            const pedidoId = $(this).data('id');
            const cedula = $(this).data('cliente');
            const cliente = $(this).data('nombre');
            const monto = $(this).data('monto');

            $('#factura_pedido_id').val(pedidoId);
            $('#factura_cedula').val(cedula);
            $('#factura_cliente').val(cliente);
            $('#factura_monto_total').val(monto);

            cargarMetodosPago();
            $('#modalPagarFactura').modal('show');
        });

        $('#formPagarFactura').submit(function (e) {
            e.preventDefault();
            const data = {
                pedido: $('#factura_pedido_id').val(),
                cedula: $('#factura_cedula').val(),
                cliente: $('#factura_cliente').val(),
                metodo: $('#factura_metodo_pago').val(),
                monto: $('#factura_monto_total').val(),
                vuelto: $('#factura_vuelto').val(),
                descuento: $('#factura_descuento').val(),
                iva: $('#factura_iva').val(),
                comentario: 'Factura generada desde pedido'
            };

            $.post('../PHP/Facturas/crearFactura_Process.php', data, function () {
                Swal.fire("Pagado", "Factura generada correctamente", "success").then(() => location.reload());
            });
        });
    </script>
</body>

</html>