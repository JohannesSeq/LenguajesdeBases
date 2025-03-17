<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Cliente - Restaurante Playa Cacao</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style/style.css">
    <style>
        .cliente-form {
            padding: 50px 0;
        }

        .cliente-form .container {
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
            <h1 class="display-4">Agregar Cliente</h1>
            <p class="lead">Añade nuevos clientes.</p>
            <hr class="my-4">
        </div>
    </div>

    <section class="cliente-form">
        <div class="container">
            <form id="Agregar_Cliente_Form">
                <div class="form-group">
                    <label for="nombre_cliente">Nombre del cliente</label>
                    <input type="text" class="form-control" id="nombre_cliente" placeholder="Ingresa el nombre del cliente">
                </div>
                <div class="form-group">
                    <label for="telefono_cliente">Numero telefónico del cliente</label>
                    <input type="text" class="form-control" id="telefono_cliente" placeholder="Ingresa el numero telefónico del cliente">
                </div>
                <div class="form-group">
                    <label for="direccion_cliente">Dirección del cliente</label>
                    <textarea class="form-control" id="direccion_cliente" rows="5" placeholder="Agrege la direccion donde vive el cliente."></textarea>
                </div>
                <button type="submit" class="btn btn-primary">¡Agregar Cliente!</button>
            </form>
        </div>
    </section>

    <?php include_once 'footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="../script/cookie_management.js"></script>
    <script src="../script/agregar_cliente.js"></script>
    <script src="../script/permissions.js"></script>
    

</body>

</html>
