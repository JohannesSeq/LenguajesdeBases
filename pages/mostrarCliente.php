<!DOCTYPE html>
<html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Clientes - Restaurante Playa Cacao</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="../style/style.css">
        <style>
            .clientes-form {
                padding: 50px 0;
            }

            .clientes-form .container {
                max-width: 800px;
                margin: 0 auto;
            }

            footer {
                background-color: #343a40;
                color: white;
                padding: 20px 0;
                text-align: center;
            }

            footer a {
                color: #ffc107;
                text-decoration: none;
            }

            footer a:hover {
                text-decoration: underline;
            }
        </style>
    </head>

    <body onload = "Check_Permissions('Vendedor')" >

        <?php include_once 'header.php'; ?>

        <div class="container-fluid mt-3">
            <div class="jumbotron">
                <h1 class="display-4">Lista de clientes</h1>
                <p class="lead">Revisa la lista de clientes desde aca.</p>
                <hr class="my-4">
            </div>
        </div>

        <section class="clientes-form">
            <?php 
                include('../php/connection.php');

                $query = "SELECT * FROM clientes";
                $clientes = '';
                $result = $conn->query($query);

                if($result != null){

                    $clientes = 
                    '<table class="table">'.
                    '<tr>'.
                        '<th scope="col">id</th>'.
                        '<th scope="col">nombre</th>'.
                        '<th scope="col">telefono</th>'.
                        '<th scope="col">direccion</th>'.
                '</tr>'.
                '</thead>'.
                '<tbody>'
                ;

                    while ($row = $result->fetch_assoc()) {

                        $clientes .= 
                        '<tr>' . 
                            '<th scope="row">'.$row['id'].'</th>'.
                            '<th scope="row">'.$row['nombre'].'</th>'.
                            '<th scope="row">'.$row['telefono'].'</th>'.
                            '<th scope="row">'.$row['direccion'].'</th>'.
                        '</tr>';
                    }

                    $clientes .=    
                        ' </tr>'.
                    '</tbody>'.
                '</table>';
                }
                echo $clientes;
                $conn->close();
            ?>
        </section>
        <?php include_once 'footer.php'; ?>

        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="../script/cookie_management.js"></script>
        <script src="../script/permissions.js"></script>

    </body>

</html>
