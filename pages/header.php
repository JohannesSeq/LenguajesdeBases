<body>
    <!-- Menu del header para el sistema de restaurante -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="index.php">Restaurante Playa Cacao</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto" style="margin-right: 100px;">

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="usuarioDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Usuario
                        </a>
                        <div class="dropdown-menu" aria-labelledby="usuarioDropdown">
                            <?php
                                if (isset($_COOKIE["email"]) && $_COOKIE["email"] != "") {
                                    echo '<a class="dropdown-item" href="verPedidosUsuario.php">Ver Pedidos</a>';
                                    echo '<a class="dropdown-item" href="verReservacionesUsuario.php">Ver Reservaciones</a>';
                                    echo '<a class="dropdown-item" href="mostrarCarrito.php">Ver Carrito</a>';
                                    echo '<a class="dropdown-item" href="index.php" id="logout">Cerrar Sesión</a>';
                                } else {
                                    echo '<a class="dropdown-item" href="#" data-toggle="modal" data-target="#loginModal">Iniciar Sesión</a>';
                                    echo '<a class="dropdown-item" href="#" data-toggle="modal" data-target="#RegistroModal">Registrarse</a>';
                                }
                            ?>
                        </div>
                    </li>

                    <?php                 
                    if (isset($_COOKIE["email"]) && $_COOKIE["email"] != "") {
                        if($_COOKIE["permiso"] == "Limitado" || $_COOKIE["permiso"] == "Completo" ) {
                            echo '
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="MenuDropDown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Menu
                                </a>
                                <div class="dropdown-menu" aria-labelledby="MenuDropDown">
                                    <a class="dropdown-item" href="mostrarMenu.php">Mostrar Menus</a>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="pedidosDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Pedidos
                                </a>
                                <div class="dropdown-menu" aria-labelledby="pedidosDropdown">
                                    <a class="dropdown-item" href="mostrarCarrito.php">Ver Carrito</a>
                                    <a class="dropdown-item" href="usuarioAgregarReservacion.php">Hacer Reservación</a>
                                </div>
                            </li>';
                        } 
                        if ($_COOKIE["permiso"] == "Parcial" || $_COOKIE["permiso"] == "Completo") {
                            echo '
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="facturasyPedidosDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Gestiones
                                </a>
                                <div class="dropdown-menu" aria-labelledby="facturasyPedidosDropdown">
                                    <a class="dropdown-item" href="mostrarPedidos.php">Manejar pedidos</a>
                                    <a class="dropdown-item" href="mostrarMetodoPago.php">Manejar metodos de pago</a>
                                    <a class="dropdown-item" href="mostrarFacturas.php">Manejar Facturas</a>
                                    <a class="dropdown-item" href="mostrarReservaciones.php">Manejar Reservaciones</a>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="inventarioDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Inventario
                                </a>
                                <div class="dropdown-menu" aria-labelledby="inventarioDropdown">
                                    <a class="dropdown-item" href="mostrarPlatillos.php">Manejar platillos</a>
                                    <a class="dropdown-item" href="mostrarMenu.php">Manejar menus</a>
                                    <a class="dropdown-item" href="mostrarHorarios.php">Manejar Horarios</a>
                                    <a class="dropdown-item" href="mostrarMesas.php">Manejar Mesas</a>
                                </div>
                            </li>';
                        }

                        if ($_COOKIE["permiso"] == "Completo") {
                            echo '
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="PersonalDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Opciones Gerenciales
                                </a>
                                <div class="dropdown-menu" aria-labelledby="PersonalDropdown">
                                    <a class="dropdown-item" href="mostrarPersonas.php">Manejar Personas</a>
                                    <a class="dropdown-item" href="mostrarProvincias.php">Manejar Provincias</a>
                                    <a class="dropdown-item" href="mostrarCantones.php">Manejar Cantones</a>
                                    <a class="dropdown-item" href="mostrarDistritos.php">Manejar Distritos</a>
                                    <a class="dropdown-item" href="mostrarRol_persona.php">Manejar los roles de acceso</a>
                                    <a class="dropdown-item" href="mostrarPuestos.php">Manejar Puestos</a>
                                    <a class="dropdown-item" href="mostrarDepartamentos.php">Manejar Departamentos</a>
                                    <a class="dropdown-item" href="mostrarEmpleados.php">Manejar Empleados</a>
                                    <a class="dropdown-item" href="mostrarEstados_Inactivos.php">Reactivar entradas</a>
                                    <a class="dropdown-item" href="MostrarReporte.php">Reporte PowerBI</a>
                                </div>
                            </li>';
                        }
                    }
                    ?>
                </ul>
            </div>
        </nav>
    </header>

    <!-- Login Modal-->
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Iniciar Sesión</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formulario_login">
                        <div class="form-group">
                            <label for="email">Correo Electrónico</label>
                            <input type="email" class="form-control" id="email_field" placeholder="Ingresa tu correo electrónico">
                        </div>
                        <div class="form-group">
                            <label for="password">Contraseña</label>
                            <input type="password" class="form-control" id="password_field" placeholder="Ingresa tu contraseña">
                        </div>
                        <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                        <p id="error_text" class="Error_Message"></p>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--Registro Modal -->
    <?php 
        if (!isset($_COOKIE["email"]) || $_COOKIE["email"] == "") {

        echo '
        <div class="modal fade" id="RegistroModal" tabindex="-1" role="dialog" aria-labelledby="RegistroModallLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="RegistroModallLabel">Registrarse en Playa Cacao</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formulario_registro">


                        </br>
                        <h6 class="modal-title">Informacion personal</h6>
                        <hr class="my-3">

                        <div class="form-group">
                                <label for="cedula">Cedula de identidad</label>
                                <input type="text" class="form-control" id="cedula" placeholder="Ingrese su cedula de identidad." required>
                            </div>

                            <div class="form-group">
                                <label for="nombre_persona">Nombre</label>
                                <input type="text" class="form-control" id="nombre_persona" placeholder="Ingrese su nombre." required>
                            </div>

                            <div class="form-group">
                                <label for="apellidos_persona">Apellidos</label>
                                <input type="text" class="form-control" id="apellidos_persona" placeholder="Ingrese sus apellidos." required>
                            </div>

                            <div class="form-group">
                                <label for="numero_telefono">Numero de telefono</label>
                                <input type="text" class="form-control" id="numero_telefono" placeholder="Ingrese su numero de telefono." required>
                            </div>

                            </br>
                            <h6>Direccion</h6>
                            <hr class="my-3">

                            <div class="form-group">
                                <label for="provincia">Provincia</label>
                                <select class="form-control" id="provincia">';
                                include '../PHP/Personas/listado_provincia.php';
                                echo '
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="canton">Canton</label>
                                <select class="form-control" id="canton">';

                                include "../PHP/Personas/listado_canton.php";

                                echo '
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="distrito">Distrito</label>
                                <select class="form-control" id="distrito">';
                                include '../PHP/Personas/listado_distrito.php';
                                
                                echo '
                                </select>
                            </div>

                            </br>
                            <h6>Mi Cuenta</h6>
                            <hr class="my-3">

                            <div class="form-group">
                                <label for="correo">Correo electronico</label>
                                <input type="email" class="form-control" id="correo" placeholder="Ingrese su direccion de correo electronico." required>
                            </div>

                            <div class="form-group">
                                <label for="correo_respaldo">Correo de respaldo</label>
                                <input type="email" class="form-control" id="correo_respaldo" placeholder="Ingrese su direccion correo de respaldo de la persona." required>
                            </div>

                            <div class="form-group">
                                <label for="password_persona">Contraseña</label>
                                <input type="password" class="form-control" id="password_persona" placeholder="Ingrese su contraseña">
                            </div>

                            </br>


                            <button type="submit" class="btn btn-primary">Registrarme!</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>';

    }
        ?>



</body>
