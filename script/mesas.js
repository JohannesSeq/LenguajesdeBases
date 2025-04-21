$(document).ready(function () {
    cargarHorarios('#id_horario');
    cargarHorarios('#mod_id_horario');

    // Agregar mesa
    $('#Agregar_Mesa_Form').submit(function (e) {
        e.preventDefault();
        $.post('../PHP/Mesas/agregarMesa_Process.php', {
            nombre_mesa: $('#nombre_mesa').val(),
            id_horario: $('#id_horario').val()
        }, function () {
            Swal.fire("Éxito", "Mesa agregada correctamente", "success").then(() => location.reload());
        });
    });

    // Modificar mesa
    $('#Modificar_Mesa_Form').submit(function (e) {
        e.preventDefault();
        $.post('../PHP/Mesas/modificarMesa_Process.php', {
            id_mesa: $('#mesa_id_modificar').val(),
            nombre_mesa: $('#mod_nombre_mesa').val(),
            id_horario: $('#mod_id_horario').val()
        }, function () {
            Swal.fire("Éxito", "Mesa modificada correctamente", "success").then(() => location.reload());
        });
    });

    // Abrir modal de modificación
    $(document).on('click', '.btn-modify', function () {
        const id = $(this).data('id');
        $.get('../PHP/Mesas/listadoindividualmesa_process.php', { id }, function (res) {
            const mesa = JSON.parse(res)[0];
            $('#mesa_id_modificar').val(id);
            $('#mod_nombre_mesa').val(mesa.NOMBRE_MESA);
            $('#mod_id_horario').val(mesa.ID_HORARIO);
            $('#modalModificarMesa').modal('show');
        });
    });

    // Eliminar mesa con confirmación y resultado detallado
    $(document).on('click', '.btn-delete', function () {
        const id = $(this).data('id');
        Swal.fire({
            title: '¿Eliminar mesa?',
            text: 'Esta acción no se puede deshacer.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('../PHP/Mesas/eliminarMesa_Process.php', { id }, function (data) {
                    const res = JSON.parse(data);
                    if (res.resultado === "REFERENCIAS_ACTIVAS") {
                        Swal.fire("Error", "No se puede eliminar: la mesa tiene reservaciones.", "error");
                    } else if (res.resultado === "TIPO_INVALIDO") {
                        Swal.fire("Error", "Tipo de borrado inválido.", "error");
                    } else {
                        Swal.fire("Eliminado", `Mesa eliminada correctamente (${res.resultado})`, "success").then(() => location.reload());
                    }
                }).fail(() => {
                    Swal.fire("Error", "Hubo un problema al intentar eliminar la mesa.", "error");
                });
            }
        });
    });

});

function listadomesas() {
    $.get('../PHP/Mesas/listarmesas_process.php', function (data) {
        const mesas = JSON.parse(data);
        const tbody = $('#mesasTable tbody');
        tbody.empty();
        mesas.forEach(mesa => {
            tbody.append(`<tr>
                <td>${mesa.ID_MESA}</td>
                <td>${mesa.NOMBRE_MESA}</td>
                <td>${mesa.ID_HORARIO}</td>
                <td>${mesa.ID_ESTADO}</td>
                <td>
                    <button class="btn btn-primary btn-modify" data-id="${mesa.ID_MESA}">Modificar</button>
                    <button class="btn btn-danger btn-delete" data-id="${mesa.ID_MESA}">Eliminar</button>
                </td>
            </tr>`);
        });
    });
}

function cargarHorarios(selectId) {
    $.get('../PHP/Horarios/listarHorariosActivos.php', function (data) {
        const horarios = JSON.parse(data);
        const select = $(selectId);
        select.empty();
        horarios.forEach(h => {
            select.append(`<option value="${h.ID_HORARIO}">${h.HORA_EXACTA}</option>`);
        });
    });
}
