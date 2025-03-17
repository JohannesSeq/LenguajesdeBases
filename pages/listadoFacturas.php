<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Facturas - Restaurante Playa Cacao</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style/style.css">
    <style>
        .factura-list {
            padding: 50px 0;
        }

        .factura-list .container {
            max-width: 1200px;
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


<?php include_once 'header.php'; ?>
    <body onload = "Check_Permissions('Vendedor')" ></body>

    <div class="container-fluid mt-3">
        <div class="jumbotron">
            <h1 class="display-4">Listado de Facturas</h1>
            <p class="lead">Visualiza todas las facturas junto con la información del pedido asociado.</p>
            <hr class="my-4">
        </div>
    </div>

    <section class="factura-list">
        <div class="container">
            <h2>Facturas</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID Factura</th>
                        <th>Fecha</th>
                        <th>Monto Total</th>
                        <th>Cliente</th>
                        <th>Dirección</th>
                        <th>Teléfono</th>
                        <th>Detalle Pedido</th>
                        <th>Acciones</th> <!-- Added column for actions -->
                    </tr>
                </thead>
                <tbody id="facturaList">
                    <!-- Facturas will be loaded here by JavaScript -->
                </tbody>
            </table>
        </div>
    </section>

    <?php include_once 'footer.php'; ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script> <!-- Added jsPDF library -->
    <script src="../script/facturaController.js"></script>
    <script src="../script/permissions.js"></script>
    <script src="../script/cookie_management.js"></script>
</body>

</html>
