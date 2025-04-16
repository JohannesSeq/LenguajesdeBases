function listarreservaciones() {
    fetch('../PHP/Reservaciones/listarReservaciones_Process.php')
        .then(response => response.json())
        .then(data => {
            const tabla = document.querySelector('#reservacionesTable tbody');
            tabla.innerHTML = ''; // Limpiar tabla

            data.forEach(reserva => {
                const fila = document.createElement('tr');

                fila.innerHTML = `
                    <td>${reserva.ID_RESERVA}</td>
                    <td>${reserva.CONFIRMACION}</td>
                    <td>${reserva.CEDULA_CLIENTE}</td>
                    <td>${reserva.MESA}</td>
                    <td>${reserva.ID_HORARIO}</td>
                    <td>
                        <button class="btn btn-warning" onclick="editarReservacion(${reserva.ID_RESERVA})">Editar</button>
                        <button class="btn btn-danger" onclick="eliminarReservacion(${reserva.ID_RESERVA})">Eliminar</button>
                    </td>
                `;

                tabla.appendChild(fila);
            });
        });
}

function editarReservacion(id) {
    fetch(`../PHP/Reservaciones/listadoReservacionIndividual_Process.php?id=${id}`)
        .then(response => response.json())
        .then(data => {
            const reserva = data[0];
            document.querySelector('#editar_id').value = reserva.ID_RESERVA;
            document.querySelector('#editar_confirmacion').value = reserva.CONFIRMACION;
            document.querySelector('#editar_mesa').value = reserva.MESA;
            document.querySelector('#editar_horario').value = reserva.ID_HORARIO;

            $('#modalEditarReservacion').modal('show');
        });
}

document.querySelector('#FormularioEditarReservacion').addEventListener('submit', e => {
    e.preventDefault();

    const formData = new FormData(e.target);

    fetch('../PHP/Reservaciones/modificarReservacion_Process.php', {
        method: 'POST',
        body: formData
    }).then(() => {
        $('#modalEditarReservacion').modal('hide');
        listarreservaciones();
        Swal.fire('¡Modificado!', 'La reservación ha sido actualizada.', 'success');
    });
});

document.querySelector('#FormularioAgregarReservacion').addEventListener('submit', e => {
    e.preventDefault();

    const formData = new FormData(e.target);

    fetch('../PHP/Reservaciones/agregarReservacion_Process.php', {
        method: 'POST',
        body: formData
    }).then(() => {
        $('#modalAgregarReservacion').modal('hide');
        listarreservaciones();
        Swal.fire('¡Agregado!', 'La reservación fue registrada.', 'success');
    });
});

function eliminarReservacion(id) {
    const formData = new FormData();
    formData.append('id', id);

    fetch('../PHP/Reservaciones/eliminarReservacion_Process.php', {
        method: 'POST',
        body: formData
    }).then(() => {
        listarreservaciones();
        Swal.fire('¡Eliminado!', 'La reservación ha sido eliminada.', 'success');
    });
}
