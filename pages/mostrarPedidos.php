<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos - Restaurante Playa Cacao</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style/style.css">
</head>

<body onload="Check_Permissions('Empleado'); listadoPedidos()">
    <?php include_once 'header.php'; ?>

    <div class="container-fluid mt-3">
        <div class="jumbotron">
            <h1 class="display-4">Pedidos</h1>
            <p class="lead">Lista de pedidos realizados por los clientes.</p>
            <hr class="my-4">
        </div>
    </div>

    <section class="pedidos-form">
        <div class="container">
            <table id="pedidosTable" class="table table-striped">
                <thead>
                    <tr>
                        <th>ID Pedido</th>
                        <th>Cliente</th>
                        <th>Cédula</th>
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

    <!-- Modal para Modificar Pedido -->
    <div class="modal fade" id="modalModificarPedido" tabindex="-1" role="dialog" aria-labelledby="modalModificarLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="formModificarPedido">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalModificarLabel">Modificar Pedido</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="modificar_id_pedido">
                        <div class="form-group">
                            <label for="modificar_estado">Estado del Pedido</label>
                            <select class="form-control" id="modificar_estado" required>
                                <option value="Pendiente">Pendiente</option>
                                <option value="En preparación">En preparación</option>
                                <option value="Entregado">Entregado</option>
                                <option value="Cancelado">Cancelado</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="modificar_comentario">Comentario</label>
                            <input type="text" class="form-control" id="modificar_comentario">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include_once 'footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="../script/permissions.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="../script/cookie_management.js"></script>

    <script>
        function listadoPedidos() {
            $.ajax({
                url: '../PHP/Pedidos/listarPedidos_Process.php',
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    const tbody = $('#pedidosTable tbody');
                    tbody.empty();

                    response.forEach(pedido => {
                        const row = `
                            <tr>
                                <td>${pedido.ID_PEDIDO}</td>
                                <td>${pedido.NOMBRE_COMPLETO_CLIENTE}</td>
                                <td>${pedido.CEDULA}</td>
                                <td>₡${pedido.MONTO_ESTIMADO}</td>
                                <td>${pedido.ESTADO_PEDIDO}</td>
                                <td>
                                    <button class="btn btn-sm btn-warning" onclick="abrirModalModificar(${pedido.ID_PEDIDO}, '${pedido.ESTADO_PEDIDO}')">
                                        Modificar
                                    </button>
                                </td>
                            </tr>`;
                        tbody.append(row);
                    });
                },
                error: function (err) {
                    console.error("Error cargando pedidos:", err);
                    Swal.fire("Error", "No se pudieron cargar los pedidos", "error");
                }
            });
        }

        function abrirModalModificar(idPedido, estadoActual) {
            $('#modificar_id_pedido').val(idPedido);
            $('#modificar_estado').val(estadoActual);
            $('#modificar_comentario').val("");
            $('#modalModificarPedido').modal('show');
        }

        $('#formModificarPedido').on('submit', function (e) {
            e.preventDefault();

            const id = $('#modificar_id_pedido').val();
            const estado = $('#modificar_estado').val();
            const comentario = $('#modificar_comentario').val();

            $.ajax({
                url: '../PHP/Pedidos/modificarPedido_Process.php',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                    id_pedido: id,
                    estado: estado,
                    comentario: comentario
                }),
                success: function () {
                    $('#modalModificarPedido').modal('hide');
                    Swal.fire("Éxito", "Pedido modificado correctamente", "success");
                    listadoPedidos();
                },
                error: function () {
                    Swal.fire("Error", "No se pudo modificar el pedido", "error");
                }
            });
        });
    </script>
</body>

</html>
