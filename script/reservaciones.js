$(document).ready(function () {
    console.log("reservaciones.js cargado");
    cargarCedulaDesdeEmail();
    cargarMesas('#mesa', '#horario_mesa');
    cargarMesas('#editar_mesa', '#editar_horario');

    $('#FormularioAgregarReservacion').submit(function (e) {
        e.preventDefault();

        const data = {
            cedula: $('#cedula_cliente').val(),
            mesa: $('#mesa').val(),
            confirmacion: "Confirmado" // por defecto
        };

        $.post('../PHP/Reservaciones/agregarReservacion_Process.php', data, function () {
            Swal.fire("Éxito", "Reservación agregada correctamente", "success").then(() => location.reload());
        });
    });

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

    $(document).on('click', '.btn-modify', function () {
        const id = $(this).data('id');
        $.get('../PHP/Reservaciones/listadoReservacionIndividual_Process.php', { id }, function (res) {
            const reserva = JSON.parse(res)[0];
            $('#editar_id').val(reserva.ID_RESERVA);
            $('#editar_confirmacion').val(reserva.CONFIRMACION);
            $('#editar_mesa').val(reserva.MESA).trigger('change');
            $('#modalEditarReservacion').modal('show');
        });
    });

    $(document).on('click', '.btn-delete', function () {
        const id = $(this).data('id');
        Swal.fire({
            title: '¿Eliminar reservación?',
            text: 'Esta acción no se puede deshacer.',
            icon: 'warning',
            showCancelButton: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('../PHP/Reservaciones/eliminarReservacion_Process.php', { id }, function () {
                    Swal.fire("Eliminado", "La reservación ha sido eliminada.", "success").then(() => location.reload());
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
                <td>${reserva.ID_HORARIO}</td>
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
            console.log(data);
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

function cargarMesas(selectMesaId, inputHorarioId) {
    $.get('../PHP/Mesas/listarMesasDisponibles.php', function (data) {
        const mesas = JSON.parse(data);
        const select = $(selectMesaId);
        select.empty();
        mesas.forEach(m => {
            select.append(`<option value="${m.ID_MESA}" data-horario="${m.HORA_EXACTA}">${m.NOMBRE_MESA}</option>`);
        });

        // Cargar horario inicial
        const horarioInicial = select.find(':selected').data('horario');
        $(inputHorarioId).val(horarioInicial);

        select.on('change', function () {
            const horario = $(this).find(':selected').data('horario');
            $(inputHorarioId).val(horario);
        });
    });
}
