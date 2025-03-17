<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Pedidos - Restaurante Playa Cacao</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Restaurante Playa Cacao</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="usuarioDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Usuario
                    </a>
                    <div class="dropdown-menu" aria-labelledby="usuarioDropdown">
                        <a class="dropdown-item" href="#" id="login">Iniciar Sesión</a>
                        <a class="dropdown-item" href="#" id="logout">Cerrar Sesión</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="jumbotron">
            <h1 class="display-4">Gestión de Pedidos</h1>
            <p class="lead">Seleccione una opción para gestionar sus pedidos.</p>
            <hr class="my-4">
            <div class="d-flex justify-content-around">
                <a class="btn button-62" href="#" role="button">Hacer Pedido</a>
                <a class="btn button-62" href="#" role="button">Ver Pedidos</a>
                <a class="btn button-62" href="#" role="button">Modificar Pedido</a>
                <a class="btn button-62" href="#" role="button">Eliminar Pedido</a>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            function toggleProtectedContent(show) {
                if (show) {
                    $('.jumbotron').hide();
                    $('#navbarNav').append(`
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="pedidosDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Pedidos
                                </a>
                                <div class="dropdown-menu" aria-labelledby="pedidosDropdown">
                                    <a class="dropdown-item" href="#">Hacer Pedido</a>
                                    <a class="dropdown-item" href="#">Ver Pedidos</a>
                                    <a class="dropdown-item" href="#">Modificar Pedido</a>
                                    <a class="dropdown-item" href="#">Eliminar Pedido</a>
                                </div>
                            </li>
                        </ul>
                    `);
                } else {
                    $('.jumbotron').show();
                    $('#navbarNav ul.navbar-nav.ml-auto').last().remove();
                }
            }

            $('#login').click(function() {
                toggleProtectedContent(true);
            });

            $('#logout').click(function() {
                toggleProtectedContent(false);
            });

            toggleProtectedContent(false);
        });
    </script>
</body>
</html>