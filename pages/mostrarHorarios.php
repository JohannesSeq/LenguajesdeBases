<!DOCTYPE html>
<html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Horarios - Restaurante Playa Cacao</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="../style/style.css">
        <style>
            .Horarios-form {
                padding: 50px 0;
            }

            .Horarios-form .container {
                max-width: 800px;
                margin: 0 auto;
            }

        </style>
    </head>

    <body onload = "Check_Permissions('Empleado'); listahorarios()" >
        <?php include_once 'header.php'; ?>
        

        <div class="container-fluid mt-3">
            <div class="jumbotron">
                <h1 class="display-4">Horarios</h1>
                <p class="lead">Revisa los Horarios desde aca.</p>
                
                <hr class="my-4">
                <a class="button-62" href="#" role="button" id="loginBtn" data-toggle="modal" data-target="#modalAgregarHorario">Agregar un nuevo Horario</a>
            </div>
            
        </div>

        <section class="HORARIOS_MESA-form">

            <div class="container">
                <table id="HorariosTable" class="table">
                    <thead>
                        <tr>
                            <th>ID HORARIO</th>
                            <th>DISPONIBILIDAD</th>
                            <th>HORA_EXACTA</th>
                            <th>ID_ESTADO</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Las filas se van a popular por medio del JS -->
                    </tbody>
                </table>
        </div>

        </section>

        <!--Modal para modificar el Horarios.-->
        <div class="modal fade" id="modificarhorariomodal" tabindex="-1" role="dialog" aria-labelledby="modificarHorarios.modalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modificarHorariomodalLabel">Modificar Horario</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="modificarHorarioForm">
                            <div class="form-group">
                                <label for="nombre">DISPONIBILIDAD</label>
                                <input type="text" class="form-control" value="" name="disponibilidad" required >
                            </div>
                            <div class="form-group">
                                <label for="precio">HORA</label>
                                <input type="date" class="form-control" name="HORA_EXACTA" required>
                            </div>                           
                            <button type="submit" class="btn btn-primary">Guardar cambios</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>            


    <!-- Modal para Agregar Horario -->
    <div class="modal fade" id="modalAgregarHorario" tabindex="-1" role="dialog" aria-labelledby="modalAgregarHorarioLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAgregarHorarioLabel">Agregar un nuevo Horario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="Agregar_Horario_Form">
                        <div class="form-group">
                            <label for="disponibilidad">disponibilidad</label>
                            <input type="text" class="form-control" id="disponibilidad" placeholder="Ingresa la disponibilidad del Horario." required>
                        </div>
                        <div class="form-group">
                            <label for="Hora">Hora</label>
                            <input type="date" class="form-control" id="Hora" placeholder="Ingresa el precio del Horario." required>
                        </div>                        
                        <button type="submit" class="btn btn-primary">Agregar Horario</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


        <?php include_once 'footer.php'; ?>
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="../script/Horarios.js"></script>
        <script src="../script/permissions.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="../script/cookie_management.js"></script>
       


    </body>

</html>
