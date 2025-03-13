<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurante Playa Cacao</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style/style.css">
    <style>
        .sobre-nosotros {
            background-color: #f8f9fa;
            padding: 50px 0;
        }

        .sobre-nosotros .container {
            max-width: 800px;
            margin: 0 auto;
            text-align: center;
        }

        .sobre-nosotros h2 {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }

        .sobre-nosotros p {
            font-size: 1.2rem;
            line-height: 1.6;
        }
    </style>
</head>

<body>

    <?php include_once 'header.php'; ?>

        <div class="container-fluid mt-3">
            <div class="jumbotron">
                <h1 class="display-4">Bienvenido a Restaurante Playa Cacao</h1>
                <p class="lead">Una experiencia culinaria tropical que te encantará.</p>
                <hr class="my-4">

                <?php
                    if (isset($_COOKIE["email"]) && $_COOKIE["email"] != "") {
                            echo "<p>¡Bienvenido, " . $_COOKIE["nombre"] . "!</p>";
                    } else
                        { 
                            echo '<p>Por favor, inicia sesión para acceder a todas las funcionalidades de la plataforma.</p>';
                            echo '<a class="button-62" href="login.php" role="button" id="loginBtn">Iniciar Sesión</a>';
                        }
                ?>
                
            </div>
        </div>

        <section class="sobre-nosotros">
            <div class="container">
                <h2>Sobre Nosotros</h2>
                <p>En Restaurante Playa Cacao, nos enorgullecemos de ofrecer una experiencia culinaria única, fusionando los sabores tropicales con una atmósfera acogedora y relajante. Nuestro compromiso es brindar a nuestros clientes platillos deliciosos y un servicio excepcional. Visítanos y descubre por qué somos el lugar preferido para disfrutar de la mejor comida junto al mar.</p>
            </div>
        </section>

        <section class="nuestros-servicios">
            <div class="container">
                <h2>Nuestros Servicios</h2>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <img src="../img/img1.jpg" class="card-img-top" alt="Servicio 1">
                            <div class="card-body">
                                <h5 class="card-title">Servicio de Catering</h5>
                                <p class="card-text">Ofrecemos servicios de catering para eventos especiales, asegurando una experiencia gastronómica inolvidable para tus invitados.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <img src="../img/img2.jfif" class="card-img-top" alt="Servicio 2">
                            <div class="card-body">
                                <h5 class="card-title">Clases de Cocina</h5>
                                <p class="card-text">Únete a nuestras clases de cocina y aprende a preparar platillos exquisitos de la mano de nuestros chefs profesionales.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <img src="../img/img3.jpg" class="card-img-top" alt="Servicio 3">
                            <div class="card-body">
                                <h5 class="card-title">Entregas a Domicilio</h5>
                                <p class="card-text">Disfruta de tus platillos favoritos sin salir de casa con nuestro eficiente servicio de entrega a domicilio.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <?php include_once 'footer.php'; ?>

        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="../script/cookie_management.js"></script>

    </body>

</html>
