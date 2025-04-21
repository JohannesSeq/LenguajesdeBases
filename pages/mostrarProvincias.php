<!DOCTYPE html>
<html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Provincias - Restaurante Playa Cacao</title>
        <link rel="icon" type="image/x-icon" href="../img/FavIcon.png">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="../style/style.css">
        <style>
            .provincias-form {
                padding: 50px 0;
            }

            .provincias-form .container {
                max-width: 800px;
                margin: 0 auto;
            }

        </style>
    </head>

    <body onload = "Check_Permissions('Empleado'); listadoprovincias()" >
        <?php include_once 'header.php'; ?>
        

        <div class="container-fluid mt-3">
            <div class="jumbotron">
                <h1 class="display-4">Provincias</h1>
                <p class="lead">Revisa las provincias desde aca.</p>
                
                <hr class="my-4">
                <a class="button-62" href="#" role="button" id="loginBtn" data-toggle="modal" data-target="#modalAgregarProvincia">Agregar una nueva provincia</a>
            </div>
            
        </div>

        <section class="provincias-form">

            <div class="container">
                <table id="provinciasTable" class="table">
                    <thead>
                        <tr>
                            <th>Id Provincia</th>
                            <th>Nombre</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Las filas se van a popular por medio del JS -->
                    </tbody>
                </table>
        </div>

        </section>

        <!--Modal para modificar el provincia-->
        <div class="modal fade" id="modificarprovinciamodal" tabindex="-1" role="dialog" aria-labelledby="modificarprovinciamodalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modificarprovinciamodalLabel">Modificar Provincia</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="ModificarProvinciaForm">
                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <input type="text" class="form-control" value="" name="nombre" required >
                            </div>
                            <button type="submit" class="btn btn-primary">Guardar cambios</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>            


    <!-- Modal para Agregar provincia -->
    <div class="modal fade" id="modalAgregarProvincia" tabindex="-1" role="dialog" aria-labelledby="modalAgregarProvinciaLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAgregarProvinciaLabel">Agregar una nuevo provincia</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="Agregar_Provincia_Form">
                        <div class="form-group">
                            <label for="nombre_provincia">Nombre de la Provincia</label>
                            <input type="text" class="form-control" id="nombre_provincia" placeholder="Ingresa el nombre de la provincia." required>
                        </div>
                        <button type="submit" class="btn btn-primary">Agregar Provincia</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


        <?php include_once 'footer.php'; ?>
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="../script/provincias.js"></script>
        <script src="../script/permissions.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="../script/cookie_management.js"></script>
       


    </body>

</html>
