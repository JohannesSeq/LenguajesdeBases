<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menús - Restaurante Playa Cacao</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style/style.css">
</head>

<body onload="Check_Permissions('Empleado'); listadomenus(); cargarPlatillos();">
    <?php include_once 'header.php'; ?>

    <div class="container-fluid mt-3">
        <div class="jumbotron">
            <h1 class="display-4">Menús</h1>
            <p class="lead">Revisa los menús disponibles.</p>
            <hr class="my-4">
            <a class="button-62" href="#" role="button" data-toggle="modal" data-target="#modalAgregarMenu">Agregar un nuevo menú</a>
        </div>
    </div>

    <section class="menu-form">
        <div class="container">
            <table id="menusTable" class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Se llena por JavaScript -->
                </tbody>
            </table>
        </div>
    </section>

    <!-- Modal Agregar Menú -->
    <div class="modal fade" id="modalAgregarMenu" tabindex="-1" role="dialog" aria-labelledby="modalAgregarMenuLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar un nuevo menú</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="Agregar_Menu_Form">
                        <div class="form-group">
                            <label for="nombre_menu">Nombre del Menú</label>
                            <input type="text" class="form-control" id="nombre_menu" required>
                        </div>
                        <div class="form-group">
                            <label for="descripcion_menu">Descripción</label>
                            <input type="text" class="form-control" id="descripcion_menu" required>
                        </div>
                        <div class="form-group">
                            <label for="platillos_menu">Selecciona platillos</label>
                            <select multiple class="form-control" id="platillos_menu">
                                <!-- Se llenará desde JS -->
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Agregar Menú</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Modificar Menú -->
    <div class="modal fade" id="modificarMenuModal" tabindex="-1" role="dialog" aria-labelledby="modificarMenuModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modificar Menú</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="Modificar_Menu_Form">
                        <input type="hidden" id="menu_id">
                        <div class="form-group">
                            <label for="mod_nombre_menu">Nombre</label>
                            <input type="text" class="form-control" id="mod_nombre_menu" required>
                        </div>
                        <div class="form-group">
                            <label for="mod_descripcion_menu">Descripción</label>
                            <input type="text" class="form-control" id="mod_descripcion_menu" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include_once 'footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="../script/permissions.js"></script>
    <script src="../script/cookie_management.js"></script>

    <script>
        function listadomenus() {
            $.get("../PHP/Menus/listarMenus_Process.php", function (data) {
                const menus = JSON.parse(data);
                const tbody = $("#menusTable tbody");
                tbody.empty();

                menus.forEach(menu => {
                    const row = `
                        <tr>
                            <td>${menu.ID_MENU}</td>
                            <td>${menu.NOMBRE_MENU}</td>
                            <td>${menu.DESCRIPCION}</td>
                            <td>
                                <button class="btn btn-info" onclick="abrirModalModificarMenu(${menu.ID_MENU}, '${menu.NOMBRE_MENU}', '${menu.DESCRIPCION}')">Modificar</button>
                                <button class="btn btn-danger" onclick="eliminarMenu(${menu.ID_MENU})">Eliminar</button>
                            </td>
                        </tr>
                    `;
                    tbody.append(row);
                });
            });
        }

        function cargarPlatillos() {
            $.get("../PHP/Platillos/listarplatillos_process.php", function (data) {
                const platillos = JSON.parse(data);
                const select = $("#platillos_menu");
                select.empty();

                platillos.forEach(p => {
                    select.append(`<option value="${p.ID_PLATILLO}">${p.NOMBRE}</option>`);
                });
            });
        }

        $("#Agregar_Menu_Form").submit(function (e) {
            e.preventDefault();

            const nombre = $("#nombre_menu").val();
            const descripcion = $("#descripcion_menu").val();
            const platillos = $("#platillos_menu").val();

            if (!platillos || platillos.length === 0) {
                Swal.fire("Error", "Debes seleccionar al menos un platillo", "error");
                return;
            }

            $.post("../PHP/Menus/agregarMenu_Process.php", {
                nombre: nombre,
                descripcion: descripcion,
                platillos: platillos
            }, function () {
                Swal.fire("Éxito", "Menú agregado correctamente", "success");
                $("#modalAgregarMenu").modal("hide");
                listadomenus();
            });
        });

        function abrirModalModificarMenu(id, nombre, descripcion) {
            $("#menu_id").val(id);
            $("#mod_nombre_menu").val(nombre);
            $("#mod_descripcion_menu").val(descripcion);
            $("#modificarMenuModal").modal("show");
        }

        $("#Modificar_Menu_Form").submit(function (e) {
            e.preventDefault();
            const id = $("#menu_id").val();
            const nombre = $("#mod_nombre_menu").val();
            const descripcion = $("#mod_descripcion_menu").val();

            $.post("../PHP/Menus/modificarMenu_Process.php", {
                id: id,
                nombre: nombre,
                descripcion: descripcion
            }, function () {
                Swal.fire("Éxito", "Menú modificado correctamente", "success");
                $("#modificarMenuModal").modal("hide");
                listadomenus();
            });
        });

        function eliminarMenu(id) {
            $.post("../PHP/Menus/eliminarMenu_Process.php", { id: id }, function () {
                Swal.fire("Eliminado", "Menú eliminado", "success");
                listadomenus();
            });
        }
    </script>
</body>

</html>
