<?php
$id_menu = $_GET['id'];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Detalles del Menú</title>
    <link rel="icon" type="image/x-icon" href="../img/FavIcon.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style/style.css">
</head>

<body onload="cargarPlatillosMenu(<?= $id_menu ?>); cargarPlatillosDisponibles(<?= $id_menu ?>);">
<?php include_once 'header.php'; ?>

<div class="container mt-4">
    <h2>Platillos del Menú #<?= $id_menu ?></h2>

    <table class="table" id="tablaPlatillosMenu">
        <thead>
            <tr>
                <th>ID Platillo</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <!-- Rellenado por JS -->
        </tbody>
    </table>

    <hr>
    <h4>Agregar Platillo al Menú</h4>
    <form id="formAgregarPlatillo">
        <div class="form-group">
            <label for="platilloSelect">Platillo disponible:</label>
            <select class="form-control" id="platilloSelect" name="id_platillo">
                <!-- Cargado por JS -->
            </select>
        </div>
        <button type="submit" class="btn btn-success">Agregar</button>
    </form>
</div>

<?php include_once 'footer.php'; ?>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="../script/permissions.js"></script>
<script src="../script/cookie_management.js"></script>
<script>
    
function cargarPlatillosMenu(idMenu) {
    $.get(`../PHP/Menus/listadoMenuindividual_Process.php?id=${idMenu}`, function (data) {
        const platillos = JSON.parse(data);
        const tbody = $("#tablaPlatillosMenu tbody");
        tbody.empty();

        platillos.forEach(p => {
            const row = `
                <tr>
                    <td>${p.ID_PLATILLO}</td>
                    <td>${p.NOMBRE_PLATILLO}</td>
                    <td>
                        <button class="btn btn-danger" onclick="removerPlatillo(${idMenu}, ${p.ID_PLATILLO})">Eliminar</button>
                        <button class="btn btn-info" onclick="window.location.href='detallesPlatillo.php?id=${p.ID_PLATILLO}'">Detalles</button>
                        <button class="btn btn-primary" onclick="agregarAlCarrito(${p.ID_PLATILLO})">Agregar al carrito</button>
                    </td>
                </tr>
            `;
            tbody.append(row);
        });
    });
}

function cargarPlatillosDisponibles(idMenu) {
    $.get(`../PHP/Menus/platillosDisponibles_Process.php?id_menu=${idMenu}`, function (data) {
        const platillos = JSON.parse(data);
        const select = $("#platilloSelect");
        select.empty();

        platillos.forEach(p => {
            select.append(`<option value="${p.ID_PLATILLO}">${p.NOMBRE_PLATILLO}</option>`);
        });
    });
}

$("#formAgregarPlatillo").submit(function (e) {
    e.preventDefault();
    const idMenu = <?= $id_menu ?>;
    const idPlatillo = $("#platilloSelect").val();

    $.post("../PHP/Menus/agregarPlatilloMenu_Process.php", {
        id_menu: idMenu,
        id_platillo: idPlatillo
    }, function () {
        Swal.fire("Agregado", "Platillo agregado al menú", "success");
        cargarPlatillosMenu(idMenu);
        cargarPlatillosDisponibles(idMenu);
    });
});

function removerPlatillo(idMenu, idPlatillo) {
    $.post("../PHP/Menus/removerPlatilloMenu_Process.php", {
        id_menu: idMenu,
        id_platillo: idPlatillo
    }, function () {
        Swal.fire("Removido", "Platillo eliminado del menú", "success");
        cargarPlatillosMenu(idMenu);
        cargarPlatillosDisponibles(idMenu);
    });
}

function agregarAlCarrito(idPlatillo) {
    let carrito = JSON.parse(localStorage.getItem("carrito")) || {};
    
    if (carrito[idPlatillo]) {
        carrito[idPlatillo] += 1;
    } else {
        carrito[idPlatillo] = 1;
    }

    localStorage.setItem("carrito", JSON.stringify(carrito));
    Swal.fire("Agregado", "Platillo agregado al carrito", "success");
}
</script>
</body>
</html>
