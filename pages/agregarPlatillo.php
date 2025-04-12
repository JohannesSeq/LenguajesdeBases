<!DOCTYPE html>
<html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Agregar Platillo - Restaurante Playa Cacao</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="../style/style.css">
        <style>
            .inventario-form {
                padding: 50px 0;
            }

            .inventario-form .container {
                max-width: 800px;
                margin: 0 auto;
            }
        </style>
    </head>

    <body onload = "Check_Permissions('Empleado')" >
        <?php include_once 'header.php'; ?>

        <div class="container-fluid mt-3">
            <div class="jumbotron">
                <h1 class="display-4">Agregar Platillo</h1>
                <p class="lead">Añade nuevos platillos a tu inventario.</p>
                <hr class="my-4">
            </div>
        </div>

        <section class="inventario-form">
            <div class="container">
                <form id="Agregar_Platillo_Form">
                    <div class="form-group">
                        <label for="nombre_platillo">Nombre del Platillo</label>
                        <input type="text" class="form-control" id="nombre_platillo" placeholder="Ingresa el nombre del platillo.">
                    </div>
                    <div class="form-group">
                        <label for="precio">Precio</label>
                        <input type="number" class="form-control" id="precio" placeholder="Ingresa el precio del platillo.">
                    </div>
                    <div class="form-group">
                        <label for="cantidad">Cantidad</label>
                        <input type="number" class="form-control" id="cantidad" placeholder="La candidad de stock del platillo.">
                    </div>
                    <button type="submit" class="btn btn-primary">Agregar Platillo</button>
                </form>
            </div>
        </section>

        <?php include_once 'footer.php'; ?>

        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="../script/cookie_management.js"></script>
        <script src="../script/platillos.js"></script>
        <script src="../script/permissions.js"></script>

    </body>

</html>
