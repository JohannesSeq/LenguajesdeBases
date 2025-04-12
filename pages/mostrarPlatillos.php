<!DOCTYPE html>
<html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Platillos - Restaurante Playa Cacao</title>
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

        </style>
    </head>

    <!--body onload = "Check_Permissions('Empleado')" -->
        <?php include_once 'header.php'; ?>
        

        <div class="container-fluid mt-3">
            <div class="jumbotron">
                <h1 class="display-4">Platillos</h1>
                <p class="lead">Revisa los platillos desde aca.</p>
                <hr class="my-4">
            </div>
        </div>

        <section class="inventario-form">

            <?php 
                 $conn = oci_connect("PlayaCacaoDB", "PlayaCacao12345", "localhost/XE");
                 
                 $query = "BEGIN " .
                 "ENVIO_TOTAL_PLATILLOS(:P_CURSOR); " .
                 "END;";

                //Guardamos el query
                $stmt = oci_parse($conn, $query);                 

                //Creamos un cursor para almacenar la informacion de la tabla que estamos consultando
                $cursor = oci_new_cursor($conn);
                oci_bind_by_name($stmt, ":P_CURSOR", $cursor, -1, OCI_B_CURSOR);

                // Ejecutar el procedimiento y el cursor
                oci_execute($stmt);
                oci_execute($cursor);


                $productos = 
                '<table class="table">'.
                
                '<tr>'.
                    '<th scope="col">id</th>'.
                    '<th scope="col">nombre</th>'.
                    '<th scope="col">precio</th>'.
                    '<th scope="col">cantidad</th>'.
            '</tr>'.
            '</thead>'.
            '<tbody>'
            ;

                while ($row = oci_fetch_assoc($cursor)) {
                    $productos .= 
                    '<tr>' . 
                        '<th scope="row">'.$row['ID_PLATILLO'].'</th>'.
                        '<th scope="row">'.$row['NOMBRE_PLATILLO'].'</th>'.
                        '<th scope="row">'.$row['PRECIO_UNITARIO'].'</th>'.
                        '<th scope="row">'.$row['CANTIDAD'].'</th>'.
                    '</tr>';
                }

                $productos .=    
                    ' </tr>'.
                '</tbody>'.
            '</table>';

            echo $productos;
            // Cerramos la conexion con la DB
            oci_free_statement($stmt);
            oci_free_statement($cursor);
            oci_close($conn);


            ?>


        </section>

        <?php include_once 'footer.php'; ?>

        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="../script/cookie_management.js"></script>
        <script src="../script/platillos.js"></script>
        <!--script src="../script/permissions.js"></script-->

    </body>

</html>
