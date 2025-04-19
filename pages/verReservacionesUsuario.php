<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Reservaciones - Restaurante Playa Cacao</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style/style.css">
</head>

<body onload="Check_Permissions('Cliente'); cargarReservacionesUsuario()">
    <?php include_once 'header.php'; ?>

    <div class="container-fluid mt-3">
        <div class="jumbotron">
            <h1 class="display-4">Mis Reservaciones</h1>
            <p class="lead">Aquí puedes consultar tus reservaciones realizadas.</p>
            <hr class="my-4">
        </div>
    </div>

    <section class="reservaciones-usuario-form">
        <div class="container">
            <table id="reservacionesUsuarioTable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID Reservación</th>
                        <th>Confirmación</th>
                        <th>Mesa</th>
                        <th>Horario</th>
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

        function cargarReservacionesUsuario() {
            const email = getEmailFromCookie();
            if (!email) {
                Swal.fire("Error", "No se encontró la sesión del usuario", "error");
                return;
            }

            fetch(`../PHP/Personas/listadoindividualcliente_process.php?email=${encodeURIComponent(email)}`)
                .then(res => res.json())
                .then(data => {
                    if (data && data[0] && data[0].CEDULA) {
                        const cedula = data[0].CEDULA;
                        consultarReservacionesPorCedula(cedula);
                    } else {
                        Swal.fire("Error", "No se encontró la cédula del usuario", "error");
                    }
                });
        }

        function consultarReservacionesPorCedula(cedula) {
            fetch("../PHP/Reservaciones/listarReservacionesUsuario_Process.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ cedula_cliente: cedula })
            })
                .then(res => res.json())
                .then(reservas => {
                    const tbody = document.querySelector("#reservacionesUsuarioTable tbody");
                    tbody.innerHTML = "";

                    reservas.forEach(r => {
                        const row = `
                            <tr>
                                <td>${r.ID_RESERVA}</td>
                                <td>${r.CONFIRMACION}</td>
                                <td>${r.MESA}</td>
                                <td>${r.HORARIO}</td>
                            </tr>`;
                        tbody.innerHTML += row;
                    });
                })
                .catch(() => {
                    Swal.fire("Error", "No se pudieron cargar tus reservaciones", "error");
                });
        }
    </script>
</body>

</html>
