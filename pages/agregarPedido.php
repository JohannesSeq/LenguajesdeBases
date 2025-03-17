<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hacer Pedido - Restaurante Playa Cacao</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style/style.css">
    <style>
        .pedido-form {
            padding: 50px 0;
        }

        .pedido-form .container {
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

<body onload = "Check_Permissions('Cliente')" >

    <?php include_once 'header.php'; ?>

    <div class="container-fluid mt-3">
        <div class="jumbotron">
            <h1 class="display-4">Hacer Pedido</h1>
            <p class="lead">Ordena tus platillos favoritos fácilmente.</p>
            <hr class="my-4">
        </div>
    </div>

    <section class="pedido-form">
        <div class="container">
            <form id="Agregar_Pedido_Form">
                <div class="form-group">
                    <label for="nombre">Nombre Completo</label>
                    <input type="text" class="form-control" id="nombre" placeholder="Ingresa tu nombre completo">
                </div>
                <div class="form-group">
                    <label for="direccion">Dirección de Entrega</label>
                    <input type="text" class="form-control" id="direccion" placeholder="Ingresa tu dirección de entrega">
                </div>
                <div class="form-group">
                    <label for="telefono">Teléfono</label>
                    <input type="tel" class="form-control" id="telefono" placeholder="Ingresa tu número de teléfono">
                </div>
                <div class="form-group">
                    <label for="pedido">Detalles del Pedido</label>
                    <textarea class="form-control" id="pedido" rows="5" placeholder="Describe los platillos que deseas ordenar"></textarea>
                </div>
                <button type="submit" class="button-62">Enviar Pedido</button>
            </form>
        </div>
    </section>

    <?php include_once 'footer.php'; ?>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="module" src="../script/pedidoController.js"></script>
    <script src="../script/cookie_management.js"></script>
    <script src="../script/permissions.js"></script>

</body>

</html>
