
<body>
    <header></header>

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
                        
                        if ($_COOKIE["rol"] == "Gerente" || $_COOKIE["rol"] == "Vendedor"){

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
                            '<a class="dropdown-item" href="agregarProducto.php">Agregar producto al inventario</a>'.
                            '<a class="dropdown-item" href="modificarProducto.php">Modificar producto del inventario</a>'.
                            '<a class="dropdown-item" href="mostrarInventario.php">Mostrar Inventario</a>'.
                            '<a class="dropdown-item" href="eliminarProducto.php">Eliminar un producto del inventario</a>'.
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
                
                
            '</li>'
                
                ;
                    } else {

                        echo
                        '<li class="nav-item dropdown">'.
                        '<a class="nav-link dropdown-toggle" href="#" id="pedidosDropdown" role="button"'.
                            'data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.
                            'Pedidos'.
                        '</a>'.
                        '<div class="dropdown-menu" aria-labelledby="pedidosDropdown">'.
                            '<a class="dropdown-item" href="agregarPedido.php">Hacer Pedido</a>'.
                        '</div>'.
                    '</li>';
                    }


                        if ($_COOKIE["rol"] == "Gerente"){

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
                    ?>
                    
                </ul>
            </div>
        </nav>
    </header>
</body>

</html>
