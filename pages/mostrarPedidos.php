<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos - Restaurante Playa Cacao</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" type="image/x-icon" href="../img/FavIcon.png">
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

<!-- Modal para mostrar el desglose de un pedido -->
<div class="modal fade" id="modalDesglose" tabindex="-1" role="dialog" aria-labelledby="modalDesgloseLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">

        <div class="modal-content">
       
            <div class="modal-header">
                <h5 class="modal-title" id="modalModificarLabel">Desglose del pedido</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                
            <table id="desgloseTable" class="table table-striped">

                <thead>
                    <tr>
                        <th>Nombre del platillo</th>
                        <th>Precio unitario</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- JS llenará esta sección -->
                </tbody>
            </table>     
            </div>
        </div>
    </div>
</div>


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
        $(document).ready(function(){

            $(document).on('click', '.btn-desglose', function () {
                var Pedidoid = $(this).data('id'); // Obtiene el ID del distrito a eliminar

                $.ajax({

      
                    url: '../PHP/Pedidos/listarPlatillosPedido_Process.php', // URL del archivo PHP que devolverá los detalles del distrito
                    method: 'GET', // Método HTTP para solicitar los datos
                    // Envía el ID del distrito como parámetro
                    data: 
                    {
                        id: Pedidoid  
                    },                     

                    success: function (response) {
                
                    var platillos = JSON.parse(response); // Parse la respuesta JSON
                    console.log(distrito);

                    if (response.error) {

                        alert(response.error); // Muestra un mensaje de error si lo hay

                    } else {

                        var tbody = $('#desgloseTable tbody');
                        tbody.empty(); // Limpia la tabla antes de añadir nuevos datos

                        // Muestra el modal para modificar el distrito
                        $('#modalDesglose').modal('show');

                        platillos.forEach(function (platillo) {

                        // Construye una fila de la tabla con los datos del pedid
                        var row = `<tr>
                            <td>${platillo.NOMBRE_PLATILLO}</td>
                            <td>${platillo.PRECIO_DEL_PLATILLO}</td>
                        </tr>`;

                tbody.append(row); // Añade la fila a la tabla
            });

                    }
                },
                error: function (error) {
                    console.error('Error fetching order details:', error); // Muestra el error en la consola
                }


                });

                
            });
        
        });
        
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
                                    <button class="btn btn-secondary btn-desglose btn-sm" data-id="${pedido.ID_PEDIDO}">Desglose</button>
                                    <button class="btn btn-sm btn-warning" onclick="abrirModalModificar(${pedido.ID_PEDIDO}, '${pedido.ESTADO_PEDIDO}')">Modificar</button>
                                    <button class="btn btn-sm btn-danger" onclick="eliminarPedido(${pedido.ID_PEDIDO})">Eliminar</button>
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


        function eliminarPedido(id) {
            Swal.fire({
                title: '¿Eliminar pedido?',
                text: 'Esta acción eliminará el pedido y su lista de platillos.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post('../PHP/Pedidos/eliminarPedido_Process.php', { id }, function (data) {
                        const res = JSON.parse(data);

                        if (res.resultado === "REFERENCIAS_ACTIVAS") {
                            Swal.fire("Error", "No se puede eliminar: el pedido tiene una factura asociada.", "error");
                        } else if (res.resultado === "TIPO_INVALIDO") {
                            Swal.fire("Error", "Tipo de borrado inválido.", "error");
                        } else {
                            Swal.fire("Eliminado", `Pedido eliminado correctamente (${res.resultado})`, "success");
                            listadoPedidos();
                        }
                    }).fail(() => {
                        Swal.fire("Error", "Hubo un problema al intentar eliminar el pedido.", "error");
                    });
                }
            });
        }
    </script>
</body>

</html>
