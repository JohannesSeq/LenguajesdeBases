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
                        <button class="btn btn-danger" onclick="eliminarMenu(${menu.ID_MENU})">Eliminar</button>
                    </td>
                </tr>
            `;
            tbody.append(row);
        });
    });
}

$("#Agregar_Menu_Form").submit(function (e) {
    e.preventDefault();

    const nombre = $("#nombre_menu").val();
    const descripcion = $("#descripcion_menu").val();
    const platillos = $("#platillos_menu").val(); // IDs

    if (!platillos || platillos.length === 0) {
        Swal.fire("Error", "Debes seleccionar al menos un platillo", "error");
        return;
    }

    $.post("../PHP/Menus/agregarMenu_Process.php", {
        nombre: nombre,
        descripcion: descripcion,
        platillos: platillos
    }, function (response) {
        Swal.fire("Éxito", "Menú agregado correctamente", "success");
        $("#modalAgregarMenu").modal("hide");
        listadomenus();
    });
});

function eliminarMenu(id) {
    $.post("../PHP/Menus/eliminarMenu_Process.php", { id: id }, function () {
        Swal.fire("Eliminado", "Menú eliminado", "success");
        listadomenus();
    });
}


function abrirModalModificarMenu(id, nombre, descripcion) {
    $("#menu_id").val(id);
    $("#mod_nombre_menu").val(nombre);
    $("#mod_descripcion_menu").val(descripcion);
    $("#modificarMenuModal").modal("show");
}

$("#Modificar_Menu_Form").submit(function(e) {
    e.preventDefault();
    const id = $("#menu_id").val();
    const nombre = $("#mod_nombre_menu").val();
    const descripcion = $("#mod_descripcion_menu").val();

    $.post("../PHP/Menus/modificarMenu_Process.php", {
        id: id,
        nombre: nombre,
        descripcion: descripcion
    }, function(response) {
        Swal.fire("Éxito", "Menú modificado correctamente", "success");
        $("#modificarMenuModal").modal("hide");
        listadomenus();
    });
});
