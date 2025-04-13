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
                                    echo '<a class="dropdown-item" href="index.php" id="logout">Cerrar Sesión</a>';
                                } else {
                                    echo '<a class="dropdown-item" href="#" data-toggle="modal" data-target="#loginModal">Iniciar Sesión</a>';
                                    echo '<a class="dropdown-item" href="#" data-toggle="modal" data-target="#signupModal">Registrarse</a>';
                                }
                            ?>
                        </div>
                    </li>

                    <?php                 
                    if (isset($_COOKIE["email"]) && $_COOKIE["email"] != "") {
                        if($_COOKIE["rol_id"] == "Cliente") {
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
                                    <a class="dropdown-item" href="agregarPedido.php">Hacer Pedido</a>
                                </div>
                            </li>';
                        } 
                        elseif ($_COOKIE["rol_id"] == "Empleado" || $_COOKIE["rol_id"] == "Gerente") {
                            echo '
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="facturasyPedidosDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Facturas
                                </a>
                                <div class="dropdown-menu" aria-labelledby="facturasyPedidosDropdown">
                                    <a class="dropdown-item" href="listadoFacturas.php">Manejar pedidos</a>
                                    <a class="dropdown-item" href="listadoFacturas.php">Manejar metodos de pago</a>
                                    <a class="dropdown-item" href="agregarFactura.php">Manejar Facturas</a>
                                    
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="inventarioDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Inventario
                                </a>
                                <div class="dropdown-menu" aria-labelledby="inventarioDropdown">
                                    <a class="dropdown-item" href="mostrarPlatillos.php">Manejar platillos</a>
                                    <a class="dropdown-item" href="mostrarPlatillos.php">Manejar menus</a>
                                </div>
                            </li>';
                        }

                        if ($_COOKIE["rol_id"] == "Gerente") {
                            echo '
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="PersonalDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Opciones Gerenciales
                                </a>
                                <div class="dropdown-menu" aria-labelledby="PersonalDropdown">
                                    <a class="dropdown-item" href="agregarUsuario.php">Manejar Personas</a>
                                    <a class="dropdown-item" href="modificarUsuario.php">Manejar Provincias</a>
                                    <a class="dropdown-item" href="modificarUsuario.php">Manejar Cantones</a>
                                    <a class="dropdown-item" href="modificarUsuario.php">Manejar Distritos</a>
                                    <a class="dropdown-item" href="modificarUsuario.php">Manejar tipos de usuarios</a>
                                    <a class="dropdown-item" href="modificarUsuario.php">Manejar Puestos</a>
                                    <a class="dropdown-item" href="modificarUsuario.php">Manejar Departamentos</a>
                                    <a class="dropdown-item" href="agregarEmpleado.php">Manejar Empleados</a>
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

</body>
