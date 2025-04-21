$(document).ready(function () {
    listarMetodosPago();

    $('#FormularioAgregarMetodoPago').submit(function (e) {
        e.preventDefault();
        const data = {
            nombre: $('#nombre_metodo').val(),
            descripcion: $('#descripcion_metodo').val(),
            comentario: $('#comentario_metodo').val()
        };

        $.post('../PHP/MetodoPago/agregarMetodoPago_Process.php', data, function () {
            Swal.fire("Éxito", "Método de pago agregado correctamente", "success").then(() => location.reload());
        });
    });

    $('#FormularioEditarMetodoPago').submit(function (e) {
        e.preventDefault();
        const data = {
            id: $('#editar_id_metodo').val(),
            nombre: $('#editar_nombre_metodo').val(),
            descripcion: $('#editar_descripcion_metodo').val()
        };

        $.post('../PHP/MetodoPago/modificarMetodoPago_Process.php', data, function () {
            Swal.fire("Actualizado", "Método de pago modificado correctamente", "success").then(() => location.reload());
        });
    });

    $(document).on('click', '.btn-modify', function () {
        const id = $(this).data('id');
        $.get('../PHP/MetodoPago/listadoindividualMetodoPago_Process.php', { id }, function (res) {
            const metodo = JSON.parse(res)[0];
            $('#editar_id_metodo').val(metodo.ID_METODO);
            $('#editar_nombre_metodo').val(metodo.NOMBRE_METODO);
            $('#editar_descripcion_metodo').val(metodo.DESCRIPCION);
            $('#modalEditarMetodoPago').modal('show');
        });
    });

    $(document).on('click', '.btn-delete', function () {
        const id = $(this).data('id');
        Swal.fire({
            title: '¿Eliminar método de pago?',
            input: 'text',
            inputLabel: 'Comentario',
            inputPlaceholder: 'Motivo de eliminación',
            showCancelButton: true,
            confirmButtonText: 'Eliminar',
            preConfirm: (comentario) => {
                if (!comentario) {
                    Swal.showValidationMessage('El comentario es obligatorio');
                }
                return comentario;
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('../PHP/MetodoPago/eliminarMetodoPago_Process.php', { id, comentario: result.value }, function (res) {
                    const data = JSON.parse(res);

                    if (data.resultado === 'REFERENCIAS_ACTIVAS') {
                        Swal.fire("Error", "No se puede eliminar: el método está en uso por facturas.", "error");
                    } else if (data.resultado === 'TIPO_INVALIDO') {
                        Swal.fire("Error", "Tipo de borrado inválido en configuración.", "error");
                    } else {
                        Swal.fire("Eliminado", `Método eliminado correctamente (${data.resultado}).`, "success")
                            .then(() => location.reload());
                    }
                }).fail(() => {
                    Swal.fire("Error", "Ocurrió un problema con la eliminación.", "error");
                });
            }
        });
    });

});

function listarMetodosPago() {
    $.get('../PHP/MetodoPago/listarMetodoPago_Process.php', function (data) {
        const metodos = JSON.parse(data);
        const tbody = $('#metodosPagoTable tbody');
        tbody.empty();
        metodos.forEach(m => {
            tbody.append(`<tr>
                <td>${m.ID_METODO}</td>
                <td>${m.NOMBRE_METODO}</td>
                <td>${m.DESCRIPCION}</td>
                <td>${m.ESTADO}</td>
                <td>
                    <button class="btn btn-primary btn-modify" data-id="${m.ID_METODO}">Modificar</button>
                    <button class="btn btn-danger btn-delete" data-id="${m.ID_METODO}">Eliminar</button>
                </td>
            </tr>`);
        });
    });
}
