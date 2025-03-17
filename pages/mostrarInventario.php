<!DOCTYPE html>
<html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Inventario - Restaurante Playa Cacao</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="../style/style.css">
        <style>
            .inventario-form {
                padding: 50px 0;
            }

            .inventario-form .container {
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
                <h1 class="display-4">Inventario</h1>
                <p class="lead">Revisa tu inventario desde aca.</p>
                <hr class="my-4">
            </div>
        </div>

        <section class="inventario-form">

            <?php 
                include('../php/connection.php');
                $query = "SELECT * FROM productos";
                $productos = '';
                $result = $conn->query($query);
                
                if($result != null){

                    $productos = 
                    '<table class="table">'.
                    
                    '<tr>'.
                        '<th scope="col">id</th>'.
                        '<th scope="col">nombre</th>'.
                        '<th scope="col">categoria</th>'.
                        '<th scope="col">cantidad</th>'.
                        '<th scope="col">precio</th>'.
                '</tr>'.
                '</thead>'.
                '<tbody>'
                ;

                    while ($row = $result->fetch_assoc()) {

                        $productos .= 
                        '<tr>' . 
                            '<th scope="row">'.$row['id'].'</th>'.
                            '<th scope="row">'.$row['nombre'].'</th>'.
                            '<th scope="row">'.$row['categoria'].'</th>'.
                            '<th scope="row">'.$row['cantidad'].'</th>'.
                            '<th scope="row">'.$row['precio'].'</th>'.
                        '</tr>';
                    }

                    $productos .=    
                        ' </tr>'.
                    '</tbody>'.
                '</table>';
                }
                echo $productos;
                $conn->close();
            ?>


        </section>

        <?php include_once 'footer.php'; ?>

        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="../script/cookie_management.js"></script>
        <script src="../script/productos.js"></script>
        <script src="../script/permissions.js"></script>

    </body>

</html>
