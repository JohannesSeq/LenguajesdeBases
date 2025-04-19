<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Pedidos - Restaurante Playa Cacao</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style/style.css">
</head>

<body onload="Check_Permissions('Cliente'); cargarPedidosUsuario()">
    <?php include_once 'header.php'; ?>

    <div class="container-fluid mt-3">
        <div class="jumbotron">
            <h1 class="display-4">Mis Pedidos</h1>
            <p class="lead">Aquí puedes consultar tus pedidos realizados.</p>
            <hr class="my-4">
        </div>
    </div>

    <section class="pedidos-usuario-form">
        <div class="container">
            <table id="pedidosUsuarioTable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID Pedido</th>
                        <th>Monto Estimado</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- JS llenará esta sección -->
                </tbody>
            </table>
        </div>
    </section>

    <?php include_once 'footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="../script/permissions.js"></script>
    <script src="../script/cookie_management.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        function getEmailFromCookie() {
            const match = document.cookie.match(/(?:^|; )email=([^;]*)/);
            return match ? decodeURIComponent(match[1]) : null;
        }

        function cargarPedidosUsuario() {
            const email = getEmailFromCookie();
            if (!email) {
                Swal.fire("Error", "No se encontró la sesión del usuario", "error");
                return;
            }

            // Obtener cédula usando email
            fetch(`../PHP/Personas/listadoindividualcliente_process.php?email=${encodeURIComponent(email)}`)
                .then(res => res.json())
                .then(data => {
                    if (data && data[0] && data[0].CEDULA) {
                        const cedula = data[0].CEDULA;
                        consultarPedidosPorCedula(cedula);
                    } else {
                        Swal.fire("Error", "No se encontró la cédula del usuario", "error");
                    }
                });
        }

        function consultarPedidosPorCedula(cedula) {
            fetch("../PHP/Pedidos/listarPedidosUsuario_Process.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ cedula_cliente: cedula })
            })
                .then(res => res.json())
                .then(pedidos => {
                    const tbody = document.querySelector("#pedidosUsuarioTable tbody");
                    tbody.innerHTML = "";

                    pedidos.forEach(p => {
                        const row = `
                            <tr>
                                <td>${p.ID_PEDIDO}</td>
                                <td>₡${p.MONTO_ESTIMADO}</td>
                                <td>${p.ESTADO_PEDIDO}</td>
                            </tr>`;
                        tbody.innerHTML += row;
                    });
                })
                .catch(() => {
                    Swal.fire("Error", "No se pudieron cargar tus pedidos", "error");
                });
        }
    </script>
</body>

</html>
