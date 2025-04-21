<!DOCTYPE html>
<html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Roles - Restaurante Playa Cacao</title>
        <link rel="icon" type="image/x-icon" href="../img/FavIcon.png">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="../style/style.css">
        <style>
            .roles_persona-form {
                padding: 50px 0;
            }

            .roles_persona-form .container {
                max-width: 800px;
                margin: 0 auto;
            }

        </style>
    </head>

    <body onload = "Check_Permissions('Empleado'); listadoroles_persona()">
        <?php include_once 'header.php'; ?>

        <div class="container-fluid mt-3">
            <div class="jumbotron">
                <h1 class="display-4">Roles de Acceso</h1>
                <p class="lead">Revisa los roles de acceso desde aca.</p>
                
                <hr class="my-4">
                <a class="button-62" href="#" role="button" id="loginBtn" data-toggle="modal" data-target="#modalAgregarRol_persona">Agregar un nuevo Rol</a>
            </div>
        </div>

        <section class="roles_persona-form">

            <div class="container">
                <table id="roles_personaTable" class="table">
                    <thead>
                        <tr>
                            <th>Id Rol</th>
                            <th>Nombre completo del Rol</th>
                            <th>Descripcion</th>
                            <th>Nivel de acceso</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Las filas se van a popular por medio del JS -->
                    </tbody>
                </table>
        </div>

        </section>

    <!-- Modal para Agregar rol_persona -->
    <div class="modal fade" id="modalAgregarRol_persona" tabindex="-1" role="dialog" aria-labelledby="modalAgregarRol_personaLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAgregarRol_personaLabel">Agregar una nuevo rol</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="Agregar_Rol_persona_Form">

                    <div class="form-group">
                            <label for="id_rol_persona">ID del rol</label>
                            <input type="text" class="form-control" placeholder="Ingresa el id del rol."id="id_rol_persona" required >
                        </div>

                        <div class="form-group">
                            <label for="nombre_rol_persona">Nombre completo del rol</label>
                            <input type="text" class="form-control" placeholder="Ingresa el nombre del rol." id="nombre_rol_persona" required >
                        </div>

                        <div class="form-group">
                            <label for="descripcion_rol_persona">Descripcion</label>
                            <textarea type="text" class="form-control" placeholder="Ingresa la descripcion del rol."  rows="2" id="descripcion_rol_persona" required ></textarea>
                        </div>

                        <div class="form-group">
                            <label for="nivel">Nivel de acceso</label>
                            <select class="form-control" id="nivel">
                                <option value="Completo">Completo</option>
                                <option value="Parcial">Parcial</option>
                                <option value="Limitado">Limitado</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Agregar rol</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

        <!--Modal para modificar el Rol_persona-->
        <div class="modal fade" id="modificarrol_personamodal" tabindex="-1" role="dialog" aria-labelledby="modificarrol_personamodalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modificarrol_personamodalLabel">Modificar Rol</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="Modificarrol_personaForm">

                        <div class="form-group">
                            <label for="nombre_rol_persona">Nombre completo del rol</label>
                            <input type="text" class="form-control" placeholder="Ingresa el nombre del rol." name="nombre_rol_persona" required>
                        </div>

                        <div class="form-group">
                            <label for="descripcion">Descripcion</label>
                            <textarea type="text" class="form-control" placeholder="Ingresa la descripcion del rol."  rows="2" name="descripcion" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="nivel">Nivel de acceso</label>
                            <select class="form-control" name="nivel">
                            <option value="Completo">Completo</option>
                                <option value="Parcial">Parcial</option>
                                <option value="Limitado">Limitado</option>
                            </select>
                        </div>

                            <button type="submit" class="btn btn-primary">Guardar cambios</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>            





        <?php include_once 'footer.php'; ?>
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="../script/roles_persona.js"></script>
        <script src="../script/permissions.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="../script/cookie_management.js"></script>
       


    </body>

</html>
