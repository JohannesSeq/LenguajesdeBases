<!DOCTYPE html>
<html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Personas - Restaurante Playa Cacao</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="../style/style.css">
        <style>
            .personas-form {
                padding: 50px 0;
            }

            .personas-form .container {
                max-width: 800px;
                margin: 0 auto;
            }

        </style>
    </head>

    <body onload = "Check_Permissions('Empleado'); listadopersonas()" >
        <?php include_once 'header.php'; ?>
        

        <div class="container-fluid mt-3">
            <div class="jumbotron">
                <h1 class="display-4">Personas</h1>
                <p class="lead">Revisa las personas desde aca.</p>
                
                <hr class="my-4">
                <a class="button-62" href="#" role="button" id="loginBtn" data-toggle="modal" data-target="#modalAgregarPersona">Agregar una nueva persona</a>
            </div>
            
        </div>

        <section class="personas-form">

            <div class="container">
                <table id="personasTable" class="table">
                    <thead>
                        <tr>
                            <th>Cedula Persona</th>
                            <th>Nombre Completo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Las filas se van a popular por medio del JS -->
                    </tbody>
                </table>
        </div>

        </section>

    <!-- Modal para Agregar persona -->
    <div class="modal fade" id="modalAgregarPersona" tabindex="-1" role="dialog" aria-labelledby="modalAgregarPersonaLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAgregarPersonaLabel">Agregar una nueva persona</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="Agregar_Persona_Form">

                    </br>
                    <h6 class="modal-title">Informacion de la persona</h6>
                    <hr class="my-3">

                    <div class="form-group">
                            <label for="cedula">Cedula de la persona</label>
                            <input type="text" class="form-control" id="cedula" placeholder="Ingresa la cedula de la persona." required>
                        </div>

                        <div class="form-group">
                            <label for="nombre_persona">Nombre de la Persona</label>
                            <input type="text" class="form-control" id="nombre_persona" placeholder="Ingresa el nombre de la persona." required>
                        </div>

                        <div class="form-group">
                            <label for="apellidos_persona">Apellidos de la Persona</label>
                            <input type="text" class="form-control" id="apellidos_persona" placeholder="Ingresa los apellidos de la persona." required>
                        </div>

                        <div class="form-group">
                            <label for="numero_telefono">Numero de telefono de la persona</label>
                            <input type="text" class="form-control" id="numero_telefono" placeholder="Ingresa el numero de telefono de la persona." required>
                        </div>

                        </br>
                        <h6>Rol y permisos de la persona</h6>
                        <hr class="my-3">

                        <div class="form-group">
                            <label for="rol">Rol de la persona</label>
                            <select class="form-control" id="rol">
                            <?php include '../PHP/Personas/listado_roles.php' ?>
                            </select>
                        </div>

                        </br>
                        <h6>Direccion de la persona</h6>
                        <hr class="my-3">

                        <div class="form-group">
                            <label for="provincia">Provincia</label>
                            <select class="form-control" id="provincia">
                            <?php include '../PHP/Personas/listado_provincia.php' ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="canton">Canton</label>
                            <select class="form-control" id="canton">
                            <?php include '../PHP/Personas/listado_canton.php' ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="distrito">Distrito</label>
                            <select class="form-control" id="distrito">
                            <?php include '../PHP/Personas/listado_distrito.php' ?>
                            </select>
                        </div>

                        </br>
                        <h6>Cuenta de la persona</h6>
                        <hr class="my-3">


                        <div class="form-group">
                            <label for="correo">Correo electronico</label>
                            <input type="text" class="form-control" id="correo" placeholder="Ingresa el correo electronico de la persona." required>
                        </div>

                        <div class="form-group">
                            <label for="correo_respaldo">Correo de respaldo</label>
                            <input type="text" class="form-control" id="correo_respaldo" placeholder="Ingresa el correo de respaldo de la persona." required>
                        </div>

                        <div class="form-group">
                            <label for="password_persona">Contraseña</label>
                            <input type="password" class="form-control" id="password_persona" placeholder="Ingresa la contraseña">
                        </div>

                        </br>

                        <button type="submit" class="btn btn-primary">Agregar Persona</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



        <!--Modal para modificar el persona-->
        <div class="modal fade" id="modificarpersonamodal" tabindex="-1" role="dialog" aria-labelledby="modificarpersonamodalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modificarpersonamodalLabel">Modificar Persona</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="ModificarPersonaForm">


                            <h6 class="modal-title">Informacion de la persona</h6>
                            <hr class="my-3">
        
                                <div class="form-group">
                                    <label for="nombre_persona">Nombre de la Persona</label>
                                    <input type="text" class="form-control" name="nombre_persona" placeholder="Ingresa el nombre de la persona." required>
                                </div>
        
                                <div class="form-group">
                                    <label for="apellidos_persona">Apellidos de la Persona</label>
                                    <input type="text" class="form-control" name="apellidos_persona" placeholder="Ingresa los apellidos de la persona." required>
                                </div>
        
                                <div class="form-group">
                                    <label for="numero_telefono">Numero de telefono de la persona</label>
                                    <input type="text" class="form-control" name="numero_telefono" placeholder="Ingresa el numero de telefono de la persona." required>
                                </div>
        
                                </br>
                                <h6>Rol y permisos de la persona</h6>
                                <hr class="my-3">
        
                                <div class="form-group">
                                    <label for="rol">Rol de la persona</label>
                                    <select class="form-control" name="rol">
                                    <?php include '../PHP/Personas/listado_roles.php' ?>
                                    </select>
                                </div>
        
                                </br>
                                <h6>Direccion de la persona</h6>
                                <hr class="my-3">
        
                                <div class="form-group">
                                    <label for="provincia">Provincia</label>
                                    <select class="form-control" name="provincia">
                                    <?php include '../PHP/Personas/listado_provincia.php' ?>
                                    </select>
                                </div>
        
                                <div class="form-group">
                                    <label for="canton">Canton</label>
                                    <select class="form-control" name="canton">
                                    <?php include '../PHP/Personas/listado_canton.php' ?>
                                    </select>
                                </div>
        
                                <div class="form-group">
                                    <label for="distrito">Distrito</label>
                                    <select class="form-control" name="distrito">
                                    <?php include '../PHP/Personas/listado_distrito.php' ?>
                                    </select>
                                </div>
        
                                </br>
                                <h6>Cuenta de la persona</h6>
                                <hr class="my-3">
        
        
                                <div class="form-group">
                                    <label for="correo">Correo electronico</label>
                                    <input type="text" class="form-control" name="correo" placeholder="Ingresa el correo electronico de la persona." required>
                                </div>
        
                                <div class="form-group">
                                    <label for="correo_respaldo">Correo de respaldo</label>
                                    <input type="text" class="form-control" name="correo_respaldo" placeholder="Ingresa el correo de respaldo de la persona." required>
                                </div>
        
                                </br>

                            <button type="submit" class="btn btn-primary">Guardar cambios</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>           





        <?php include_once 'footer.php'; ?>
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="../script/personas.js"></script>
        <script src="../script/permissions.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="../script/cookie_management.js"></script>
       


    </body>

</html>
