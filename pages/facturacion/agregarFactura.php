<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar Factura - Restaurante Playa Cacao</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style/style.css">
    <style>
        .factura-form {
            padding: 50px 0;
        }

        .factura-form .container {
            max-width: 800px;
            margin: 0 auto;
        }

        footer {
            background-color: #343a40;
            color: white;
            padding: 20px 0;
            text-align: center;
        }

        footer a {
            color: #ffc107;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>


<body onload = "Check_Permissions('Vendedor')" >

    <?php include_once 'header.php'; ?>

    <div class="container-fluid mt-3">
        <div class="jumbotron">
            <h1 class="display-4">Generar Factura</h1>
            <p class="lead">Selecciona un pedido para generar la factura.</p>
            <hr class="my-4">
        </div>
    </div>

    <section class="pedido-list">
        <div class="container">
            <h2>Pedidos</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Detalles</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody id="pedidoList">
                    <!-- Pedidos will be loaded here by JavaScript -->
                </tbody>
            </table>
        </div>
    </section>

    <section class="factura-form" style="display: none;">
        <div class="container">
            <button type="button" class="btn btn-secondary mb-3" id="backToPedidoList">&larr; Volver a Pedidos</button>

            <form id="formAgregarFactura">
                <input type="hidden" id="pedidoID" name="pedidoID">

                <div class="form-group">
                    <label for="nombreCliente">Nombre del Cliente</label>
                    <input type="text" class="form-control" id="nombreCliente" name="nombreCliente" readonly>
                </div>

                <div class="form-group">
                    <label for="direccionCliente">Dirección del Cliente</label>
                    <input type="text" class="form-control" id="direccionCliente" name="direccionCliente" readonly>
                </div>

                <div class="form-group">
                    <label for="telefonoCliente">Teléfono del Cliente</label>
                    <input type="tel" class="form-control" id="telefonoCliente" name="telefonoCliente" readonly>
                </div>

                <div class="form-group">
                    <label for="detallesPedido">Detalles del Pedido</label>
                    <textarea class="form-control" id="detallesPedido" name="detallesPedido" rows="5" readonly></textarea>
                </div>

                <div class="form-group">
                    <label for="montoTotal">Monto Total</label>
                    <input type="number" class="form-control" id="montoTotal" name="montoTotal"
                        placeholder="Ingresa el monto total a pagar" required>
                </div>

                <button type="submit" class="btn btn-primary">Generar Factura</button>
            </form>
        </div>
    </section>

    <?php include_once 'footer.php'; ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="module" src="../script/facturaController.js"></script>
    <script src="../script/cookie_management.js"></script>
    <script src="../script/permissions.js"></script>
</body>

</html>
