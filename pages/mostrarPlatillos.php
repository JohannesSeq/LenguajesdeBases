<!DOCTYPE html>
<html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Platillos - Restaurante Playa Cacao</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="../style/style.css">
        <style>
            .platillos-form {
                padding: 50px 0;
            }

            .platillos-form .container {
                max-width: 800px;
                margin: 0 auto;
            }

        </style>
    </head>

    <body onload = "Check_Permissions('Empleado'); listadoplatillos()" >
        <?php include_once 'header.php'; ?>
        

        <div class="container-fluid mt-3">
            <div class="jumbotron">
                <h1 class="display-4">Platillos</h1>
                <p class="lead">Revisa los platillos desde aca.</p>
                
                <hr class="my-4">
                <a class="button-62" href="#" role="button" id="loginBtn" data-toggle="modal" data-target="#modalAgregarPlatillo">Agregar un nuevo platillo</a>
            </div>
            
        </div>

        <section class="platillos-form">

            <div class="container">
                <table id="platillosTable" class="table">
                    <thead>
                        <tr>
                            <th>Id Platillo</th>
                            <th>Nombre</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Las filas se van a popular por medio del JS -->
                    </tbody>
                </table>
        </div>

        </section>

        <!--Modal para modificar el platillo-->
        <div class="modal fade" id="modificarplatillomodal" tabindex="-1" role="dialog" aria-labelledby="modificarplatillomodalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modificarplatillomodalLabel">Modificar Platillo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="ModificarPlatilloForm">
                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <input type="text" class="form-control" value="" name="nombre" required >
                            </div>
                            <div class="form-group">
                                <label for="precio">Precio</label>
                                <input type="number" class="form-control" name="precio" required>
                            </div>
                            <div class="form-group">
                                <label for="cantidad">Cantidad</label>
                                <input type="number" class="form-control" name="cantidad" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Guardar cambios</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>            


    <!-- Modal para Agregar platillo -->
    <div class="modal fade" id="modalAgregarPlatillo" tabindex="-1" role="dialog" aria-labelledby="modalAgregarPlatilloLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAgregarPlatilloLabel">Agregar un nuevo platillo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="Agregar_Platillo_Form">
                        <div class="form-group">
                            <label for="nombre_platillo">Nombre del Platillo</label>
                            <input type="text" class="form-control" id="nombre_platillo" placeholder="Ingresa el nombre del platillo." required>
                        </div>
                        <div class="form-group">
                            <label for="precio">Precio</label>
                            <input type="number" class="form-control" id="precio" placeholder="Ingresa el precio del platillo." required>
                        </div>
                        <div class="form-group">
                            <label for="cantidad">Cantidad</label>
                            <input type="number" class="form-control" id="cantidad" placeholder="La candidad de stock del platillo." required>
                        </div>
                        <button type="submit" class="btn btn-primary">Agregar Platillo</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


        <?php include_once 'footer.php'; ?>
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="../script/platillos.js"></script>
        <script src="../script/permissions.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="../script/cookie_management.js"></script>
       


    </body>

</html>
