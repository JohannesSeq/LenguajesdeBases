
<body>
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
                                } else
                                    { 
                                        echo '<a class="dropdown-item" href="login.php" id="login">Iniciar Sesión</a>';
                                    }
                            ?>

                        </div>

                    </li>
                    <?php                 
                    if (isset($_COOKIE["email"]) && $_COOKIE["email"] != "") {

                        if($_COOKIE["rol_id"] == "1") {

                            echo
                            '<li class="nav-item dropdown">'.
                            '<a class="nav-link dropdown-toggle" href="#" id="MenuDropDown" role="button"'.
                                'data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.
                                'Menu'.
                            '</a>'.
                            '<div class="dropdown-menu" aria-labelledby="MenuDropDown">'.
                                '<a class="dropdown-item" href="mostrarMenu.php">Mostrar Menus</a>'.
                            '</div>'.
                        '</li>'.
                            '<li class="nav-item dropdown">'.
                            '<a class="nav-link dropdown-toggle" href="#" id="pedidosDropdown" role="button"'.
                                'data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.
                                'Pedidos'.
                            '</a>'.
                            '<div class="dropdown-menu" aria-labelledby="pedidosDropdown">'.
                                '<a class="dropdown-item" href="agregarPedido.php">Hacer Pedido</a>'.
                            '</div>'.
                        '</li>'.
                        '<li class="nav-item dropdown">'.
                        '<a class="nav-link dropdown-toggle" href="#" id="ReservacionesDropdown" role="button"'.
                            'data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.
                            'Administrar reservaciones'.
                        '</a>'.
                        '<div class="dropdown-menu" aria-labelledby="ReservacionesDropdown">'.
                            '<a class="dropdown-item" href="agregarProducto.php">Agregar Reservacion</a>'.
                        '</div>'.
                    '</li>'
                            ;
                        } else if ($_COOKIE["rol_id"] == "2" || $_COOKIE["rol_id"] == "3"){



                            echo 
                            '<li class="nav-item dropdown">'.
                                '<a class="nav-link dropdown-toggle" href="#" id="facturasDropdown" role="button"'.
                                    'data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.
                                    'Facturas'.
                                '</a>'.
                                '<div class="dropdown-menu" aria-labelledby="facturasDropdown">'.
                                    '<a class="dropdown-item" href="agregarFactura.php">Generar Factura</a>'.
                                    '<a class="dropdown-item" href="listadoFacturas.php">Historial de Facturas</a>'.
                                '</div>'.
                                '</li>'.

                                '<li class="nav-item dropdown">'.
                                '<a class="nav-link dropdown-toggle" href="#" id="inventarioDropdown" role="button"'.
                                    'data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.
                                    'Inventario'.
                                '</a>'.
                                '<div class="dropdown-menu" aria-labelledby="inventarioDropdown">'.
                                    '<a class="dropdown-item" href="agregarProducto.php">Agregar platillo al inventario</a>'.
                                    '<a class="dropdown-item" href="modificarProducto.php">Modificar platillo del inventario</a>'.
                                    '<a class="dropdown-item" href="mostrarInventario.php">Mostrar productos disponibles</a>'.
                                    '<a class="dropdown-item" href="eliminarProducto.php">Eliminar un platillo del inventario</a>'.
                                '</div>'.
                            '</li>'.

                            '<li class="nav-item dropdown">'.
                            '<a class="nav-link dropdown-toggle" href="#" id="MenuDropDown" role="button"'.
                                'data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.
                                'Menu'.
                            '</a>'.
                            '<div class="dropdown-menu" aria-labelledby="MenuDropDown">'.
                                '<a class="dropdown-item" href="agregarMenu.php">Agregar Menu</a>'.
                                '<a class="dropdown-item" href="modificarMenu.php">Modificar Menu</a>'.
                                '<a class="dropdown-item" href="mostrarMenu.php">Mostrar Menus</a>'.
                                '<a class="dropdown-item" href="eliminarMenu.php">Eliminar un menu</a>'.
                            '</div>'.
                        '</li>'.
                            
                            '<li class="nav-item dropdown">'.
                            '<a class="nav-link dropdown-toggle" href="#" id="pedidosDropdown" role="button"'.
                                'data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.
                                'Pedidos'.
                            '</a>'.
                            '<div class="dropdown-menu" aria-labelledby="pedidosDropdown">'.
                                '<a class="dropdown-item" href="agregarPedido.php">Hacer Pedido</a>'.
                                '<a class="dropdown-item" href="modificarPedido.php">Gestionar Pedidos</a>'.
                            '</div>'.
                            '</li>'.

                            '<li class="nav-item dropdown">'.
                                '<a class="nav-link dropdown-toggle" href="#" id="ClientesDropdown" role="button"'.
                                    'data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.
                                    'Administrar clientes'.
                                '</a>'.
                                '<div class="dropdown-menu" aria-labelledby="ClientesDropdown">'.
                                    '<a class="dropdown-item" href="agregarProducto.php">Agregar Cliente</a>'.
                                    '<a class="dropdown-item" href="modificarProducto.php">Modificar cliente</a>'.
                                    '<a class="dropdown-item" href="mostrarInventario.php">Mostrar clientes</a>'.
                                    '<a class="dropdown-item" href="eliminarProducto.php">Eliminar un cliente</a>'.
                                '</div>'.
                            '</li>'.

                            '<li class="nav-item dropdown">'.
                                '<a class="nav-link dropdown-toggle" href="#" id="ReservacionesDropdown" role="button"'.
                                    'data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.
                                    'Administrar reservaciones'.
                                '</a>'.
                                '<div class="dropdown-menu" aria-labelledby="ReservacionesDropdown">'.
                                    '<a class="dropdown-item" href="agregarProducto.php">Agregar Reservacion</a>'.
                                    '<a class="dropdown-item" href="modificarProducto.php">Modificar reservacion</a>'.
                                    '<a class="dropdown-item" href="mostrarInventario.php">Mostrar reservaciones</a>'.
                                    '<a class="dropdown-item" href="eliminarProducto.php">Eliminar una reservacion</a>'.
                                '</div>'.
                            '</li>'.

                        '</li>'
                        ;

                        if ($_COOKIE["rol_id"] == "3"){

                            echo
                                '<li class="nav-item dropdown">'.
                                '<a class="nav-link dropdown-toggle" href="#" id="PersonalDropdown" role="button"'.
                                    'data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.
                                    'Administrar cuentas'.
                                '</a>'.
                                '<div class="dropdown-menu" aria-labelledby="PersonalDropdown">'.
                                    '<a class="dropdown-item" href="agregarUsuario.php">Agregar Usuario</a>'.
                                    '<a class="dropdown-item" href="modificarUsuario.php">Gestionar Usuarios</a>'.                              
                                '</div>'.
                            '</li>';
                        }
                    } 
                    }                 
                    ?>
                    
                </ul>
            </div>
        </nav>
    </header>
</body>

</html>
