<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Facturas - Restaurante Playa Cacao</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style/style.css">
</head>
<body onload="Check_Permissions('Cliente'); listarFacturasCliente();">
<?php include_once 'header.php'; ?>

<div class="container mt-4">
    <h1 class="mb-4">Mis Facturas</h1>
    <table class="table table-bordered" id="tablaFacturasUsuario">
        <thead>
            <tr>
                <th>ID</th>
                <th>Pedido</th>
                <th>Método Pago</th>
                <th>Total</th>
                <th>Vuelto</th>
                <th>Descuento</th>
                <th>IVA</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <!-- JS llenará aquí -->
        </tbody>
    </table>
</div>

<?php include_once 'footer.php'; ?>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="../script/permissions.js"></script>
<script src="../script/cookie_management.js"></script>

<script>
function getEmailFromCookie() {
    const match = document.cookie.match(/(?:^|; )email=([^;]*)/);
    return match ? decodeURIComponent(match[1]) : null;
}

function listarFacturasCliente() {
    const email = getEmailFromCookie();
    if (!email) return;

    $.get(`../PHP/Personas/listadoindividualcliente_process.php?email=${encodeURIComponent(email)}`, function (cliente) {
        const cedula = JSON.parse(cliente)[0].CEDULA;

        $.get(`../PHP/Facturas/listarFacturasCliente_Process.php?cedula=${cedula}`, function (data) {
            const facturas = JSON.parse(data);
            const tbody = $('#tablaFacturasUsuario tbody');
            tbody.empty();

            facturas.forEach(f => {
                tbody.append(`<tr>
                    <td>${f.ID_FACTURA}</td>
                    <td>${f.ID_PEDIDO}</td>
                    <td>${f.METODO_PAGO}</td>
                    <td>${f.MONTO_TOTAL}</td>
                    <td>${f.VUELTO}</td>
                    <td>${f.DESCUENTO}</td>
                    <td>${f.IVA}</td>
                    <td>${f.ESTADO}</td>
                </tr>`);
            });
        });
    });
}
</script>
</body>
</html>
