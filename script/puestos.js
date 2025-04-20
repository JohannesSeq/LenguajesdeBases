$(document).ready(function () {
    listarpustos();

    // Agregar puesto
    $('#FormularioAgregarPuesto').submit(function (e) {
        e.preventDefault();

        const data = {
            nombre: $('#nombre_puesto').val(),
            salario: $('#salario_base').val(),
            descripcion: $('#descripcion').val()
        };

        $.post('../PHP/Puestos/agregarPuesto_Process.php', data, function () {
            Swal.fire("Éxito", "Puesto agregado correctamente", "success").then(() => location.reload());
        });
    });

    // Modificar puesto
    $('#FormularioEditarPuesto').submit(function (e) {
        e.preventDefault();

        const data = {
            id: $('#editar_id').val(),
            nombre: $('#editar_nombre').val(),
            salario: $('#editar_salario').val(),
            descripcion: $('#editar_descripcion').val()
        };

        $.post('../PHP/Puestos/modificarPuesto_Process.php', data, function () {
            Swal.fire("Actualizado", "Puesto modificado correctamente", "success").then(() => location.reload());
        });
    });

    // Botón Modificar
    $(document).on('click', '.btn-modify', function () {
        const id = $(this).data('id');

        $.get('../PHP/Puestos/listadoindividualpuesto_process.php', { id }, function (res) {
            const puesto = res[0]; // 👈 aquí está el objeto real
        
            $('#editar_id').val(puesto.ID_PUESTO);
            $('#editar_nombre').val(puesto.NOMBRE_PUESTO);
            $('#editar_salario').val(puesto.SALARIO_BASE);
            $('#editar_descripcion').val(puesto.DESCRIPCION);
            $('#modalEditarPuesto').modal('show');
        });
    });

    // Botón Eliminar
    $(document).on('click', '.btn-delete', function () {
        const id = $(this).data('id');

        Swal.fire({
            title: '¿Eliminar puesto?',
            text: 'Esta acción desactivará el puesto (eliminación lógica)',
            icon: 'warning',
            showCancelButton: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('../PHP/Puestos/eliminarPuesto_Process.php', { id }, function () {
                    Swal.fire("Eliminado", "El puesto ha sido desactivado", "success").then(() => location.reload());
                });
            }
        });
    });
});

// Cargar tabla de puestos
function listarpustos() {
    $.get('../PHP/Puestos/listarPuestos_Process.php', function (data) {
        const tbody = $('#puestosTable tbody');
        tbody.empty();

        data.forEach(p => {
            tbody.append(`
                <tr>
                    <td>${p.ID_PUESTO}</td>
                    <td>${p.NOMBRE_PUESTO}</td>
                    <td>${p.SALARIO_BASE}</td>
                    <td>${p.DESCRIPCION}</td>
                    <td>
                        <button class="btn btn-primary btn-modify" data-id="${p.ID_PUESTO}">Modificar</button>
                        <button class="btn btn-danger btn-delete" data-id="${p.ID_PUESTO}">Eliminar</button>
                    </td>
                </tr>
            `);
        });
    });
}
