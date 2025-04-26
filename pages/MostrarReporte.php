

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Puestos - Restaurante Playa Cacao</title>
    <link rel="icon" type="image/x-icon" href="../img/FavIcon.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style/style.css">
</head>

<body onload="Check_Permissions('Administrador'); listarpustos();">
    <?php include_once 'header.php'; ?>

    <div class="container-fluid mt-3">
        <div class="jumbotron">
            <h1 class="display-4">Reportes</h1>
            <p class="lead">Consulta el reporte de Power BI de nuestra base de datos</p>
            <hr class="my-4">
        </div>
    </div>

    <iframe title="Reporte Playacacao" width="1920" height="1080" src="https://app.powerbi.com/reportEmbed?reportId=d787f32e-698e-4ade-bbf7-3ae7bf09dcd4&autoAuth=true&ctid=dde2fb8f-d8e0-445e-b851-e69c198c1e59" frameborder="0" allowFullScreen="true"></iframe>

<?php include_once 'footer.php'; ?>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="../script/permissions.js"></script>
</body>
</html>
