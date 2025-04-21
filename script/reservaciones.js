$(document).ready(function () {
    cargarCedulaDesdeEmail();
    cargarHorariosDisponibles('#horario');
    listarreservaciones();

    // Agregar reservación
    $('#FormularioAgregarReservacion').submit(function (e) {
        e.preventDefault();

        const data = {
            cedula: $('#cedula_cliente').val(),
            mesa: $('#mesa').val(),
            confirmacion: "Confirmado"
        };

        $.post('../PHP/Reservaciones/agregarReservacion_Process.php', data, function () {
            Swal.fire("Éxito", "Reservación agregada correctamente", "success").then(() => location.reload());
        });
    });

    // Al cambiar el horario (agregar), cargar mesas para ese horario
    $('#horario').on('change', function () {
        const idHorario = $(this).val();
        cargarMesasPorHorario(idHorario, '#mesa');
    });

    // Editar reservación
    $('#FormularioEditarReservacion').submit(function (e) {
        e.preventDefault();

        const data = {
            id: $('#editar_id').val(),
            confirmacion: $('#editar_confirmacion').val(),
            mesa: $('#editar_mesa').val()
        };

        $.post('../PHP/Reservaciones/modificarReservacion_Process.php', data, function () {
            Swal.fire("Actualizado", "Reservación modificada correctamente", "success").then(() => location.reload());
        });
    });

    // Lógica del modal de editar
    $('#editar_horario').on('change', function () {
        const idHorario = $(this).val();
        cargarMesasPorHorario(idHorario, '#editar_mesa');
    });

    // Abrir modal y precargar datos
    $(document).on('click', '.btn-modify', function () {
        const id = $(this).data('id');
        $.get('../PHP/Reservaciones/listadoReservacionIndividual_Process.php', { id }, function (res) {
            const reserva = JSON.parse(res)[0];
            $('#editar_id').val(reserva.ID_RESERVA);
            $('#editar_confirmacion').val(reserva.CONFIRMACION);

            // Cargar horarios y preseleccionar
            cargarHorariosDisponibles('#editar_horario');
            setTimeout(() => {
                $('#editar_horario').val(reserva.ID_HORARIO).trigger('change');

                // Esperar a que se carguen mesas disponibles antes de seleccionar
                setTimeout(() => {
                    $('#editar_mesa').val(reserva.MESA);
                }, 300);

            }, 300);

            $('#modalEditarReservacion').modal('show');
        });
    });

    // Eliminar reservación
    // Eliminar reservación con respuesta detallada
    $(document).on('click', '.btn-delete', function () {
        const id = $(this).data('id');
        Swal.fire({
            title: '¿Eliminar reservación?',
            text: 'Esta acción no se puede deshacer.',
            icon: 'warning',
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
                $.post('../PHP/Reservaciones/eliminarReservacion_Process.php', {
                    id,
                    comentario: result.value
                }, function (res) {
                    const data = JSON.parse(res);

                    switch (data.resultado) {
                        case 'BORRADO_LOGICO':
                            Swal.fire("Eliminado", "Reservación marcada como inactiva.", "success").then(() => location.reload());
                            break;
                        case 'BORRADO_FISICO':
                            Swal.fire("Eliminado", "Reservación eliminada permanentemente.", "success").then(() => location.reload());
                            break;
                        case 'NO_EXISTE_RESERVA':
                            Swal.fire("Aviso", "La reservación no existe o ya fue eliminada.", "warning");
                            break;
                        case 'TIPO_INVALIDO':
                            Swal.fire("Error", "Tipo de borrado inválido.", "error");
                            break;
                        default:
                            Swal.fire("Error", "Resultado inesperado: " + data.resultado, "error");
                    }
                }).fail(() => {
                    Swal.fire("Error", "Ocurrió un problema al eliminar la reservación.", "error");
                });
            }
        });
    });

});

function listarreservaciones() {
    $.get('../PHP/Reservaciones/listarReservaciones_Process.php', function (data) {
        const reservas = JSON.parse(data);
        const tbody = $('#reservacionesTable tbody');
        tbody.empty();
        reservas.forEach(reserva => {
            tbody.append(`<tr>
                <td>${reserva.ID_RESERVA}</td>
                <td>${reserva.CONFIRMACION}</td>
                <td>${reserva.CLIENTE}</td>
                <td>${reserva.MESA}</td>
                <td>${reserva.HORARIO}</td>
                <td>
                    <button class="btn btn-primary btn-modify" data-id="${reserva.ID_RESERVA}">Modificar</button>
                    <button class="btn btn-danger btn-delete" data-id="${reserva.ID_RESERVA}">Eliminar</button>
                </td>
            </tr>`);
        });
    });
}

function getEmailFromCookie() {
    const match = document.cookie.match(/(?:^|; )email=([^;]*)/);
    return match ? decodeURIComponent(match[1]) : null;
}

function cargarCedulaDesdeEmail() {
    const email = getEmailFromCookie();
    if (!email) return;

    fetch(`../PHP/Personas/listadoindividualcliente_process.php?email=${encodeURIComponent(email)}`)
        .then(res => res.json())
        .then(data => {
            if (data && data[0] && data[0].CEDULA) {
                $('#cedula_cliente').val(data[0].CEDULA);
            } else {
                Swal.fire("Error", "No se pudo obtener la cédula del cliente", "error");
            }
        })
        .catch(() => {
            Swal.fire("Error", "Fallo la consulta del cliente", "error");
        });
}

// selectId puede ser #horario o #editar_horario
function cargarHorariosDisponibles(selectId = '#horario') {
    $.get('../PHP/Horarios/listarHorariosDisponibles.php', function (data) {
        const horarios = JSON.parse(data);
        const select = $(selectId);
        select.empty().append('<option value="" disabled selected>Seleccione un horario</option>');
        horarios.forEach(h => {
            select.append(`<option value="${h.ID_HORARIO}">${h.HORA_EXACTA}</option>`);
        });
    });
}

// selectId puede ser #mesa o #editar_mesa
function cargarMesasPorHorario(idHorario, selectId = '#mesa') {
    $.get(`../PHP/Mesas/listarMesasPorHorario.php?id_horario=${idHorario}`, function (data) {
        const mesas = JSON.parse(data);
        const select = $(selectId);
        select.empty();
        mesas.forEach(m => {
            select.append(`<option value="${m.ID_MESA}">${m.NOMBRE_MESA}</option>`);
        });
    });
}
