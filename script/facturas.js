$(document).ready(function () {
    listarFacturas();

    // Editar Factura
    $(document).on('click', '.btn-edit', function () {
        const id = $(this).data('id');

        $.get('../PHP/Facturas/listadoFacturaIndividual_Process.php', { id }, function (res) {
            const f = JSON.parse(res)[0];
            $('#editar_id_factura').val(f.ID_FACTURA);
            $('#editar_vuelto').val(f.VUELTO);
            $('#editar_descuento').val(f.DESCUENTO);
            $('#editar_iva').val(f.IVA);
            cargarMetodosPago('#editar_metodo', f.METODO_PAGO);
            $('#modalEditarFactura').modal('show');
        });
    });

    $('#formEditarFactura').submit(function (e) {
        e.preventDefault();

        const data = {
            id: $('#editar_id_factura').val(),
            metodo: $('#editar_metodo').val(),
            vuelto: $('#editar_vuelto').val(),
            descuento: $('#editar_descuento').val(),
            iva: $('#editar_iva').val()
        };

        $.post('../PHP/Facturas/modificarFactura_Process.php', data, function () {
            Swal.fire("Actualizado", "Factura modificada correctamente", "success").then(() => location.reload());
        });
    });

    // Eliminar Factura
    $(document).on('click', '.btn-delete', function () {
        const id = $(this).data('id');

        Swal.fire({
            title: '¿Eliminar factura?',
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
                $.post('../PHP/Facturas/eliminarFactura_Process.php', {
                    id: id,
                    comentario: result.value
                }, function (res) {
                    const data = JSON.parse(res);

                    switch (data.resultado) {
                        case 'BORRADO_LOGICO':
                            Swal.fire("Eliminado", "Factura marcada como inactiva.", "success")
                                .then(() => location.reload());
                            break;
                        case 'BORRADO_FISICO':
                            Swal.fire("Eliminado", "Factura eliminada permanentemente.", "success")
                                .then(() => location.reload());
                            break;
                        case 'NO_EXISTE_FACTURA':
                            Swal.fire("Aviso", "La factura no existe o ya fue eliminada.", "warning");
                            break;
                        case 'TIPO_INVALIDO':
                            Swal.fire("Error", "Tipo de borrado inválido en configuración.", "error");
                            break;
                        default:
                            Swal.fire("Error", "Resultado inesperado: " + data.resultado, "error");
                            break;
                    }
                }).fail(() => {
                    Swal.fire("Error", "Ocurrió un problema al eliminar la factura.", "error");
                });
            }
        });
    });

});

function listarFacturas() {
    $.get('../PHP/Facturas/listarFacturas_Process.php', function (data) {
        const facturas = JSON.parse(data);
        const tbody = $('#tablaFacturas tbody');
        tbody.empty();

        facturas.forEach(f => {
            const fila = `<tr>
                <td>${f.ID_FACTURA}</td>
                <td>${f.CLIENTE}</td>
                <td>${f.ID_PEDIDO}</td>
                <td>${f.METODO_PAGO}</td>
                <td>${f.MONTO_TOTAL}</td>
                <td>${f.VUELTO}</td>
                <td>${f.DESCUENTO}</td>
                <td>${f.IVA}</td>
                <td>${f.ESTADO}</td>
                <td>
                    <button class="btn btn-primary btn-edit" data-id="${f.ID_FACTURA}">Modificar</button>
                    <button class="btn btn-danger btn-delete" data-id="${f.ID_FACTURA}">Eliminar</button>
                </td>
            </tr>`;
            tbody.append(fila);
        });
    });
}

function cargarMetodosPago(selectId, valorSeleccionado) {
    $.get('../PHP/MetodoPago/listarMetodoPago_Process.php', function (data) {
        const metodos = JSON.parse(data);
        const select = $(selectId);
        select.empty();
        metodos.forEach(m => {
            select.append(`<option value="${m.ID_METODO}" ${m.NOMBRE_METODO === valorSeleccionado ? 'selected' : ''}>${m.NOMBRE_METODO}</option>`);
        });
    });
}
