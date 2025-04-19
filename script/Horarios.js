$(document).ready(function () {

    // Agregar horario
    $('#Agregar_Horario_Form').submit(function (e) {
        e.preventDefault();

        const formData = $(this).serialize();

        $.ajax({
            url: '../PHP/Horarios/AgregarHorario_Process.php',
            method: 'POST',
            data: formData,
            success: function (response) {
                dispararAlertaExito("Horario agregado correctamente");
            },
            error: function (error) {
                dispararAlertaError("Error agregando el horario");
                console.error(error);
            }
        });
    });

    // Abrir modal de modificación
    $(document).on('click', '.btn-modify', function () {
        const idHorario = $(this).data('id');

        $.ajax({
            url: '../PHP/Horarios/listarHorarios_process.php',
            method: 'GET',
            data: { id: idHorario },
            success: function (response) {
                const horario = JSON.parse(response)[0];
                $('#modificar_id_horario').val(idHorario);
                $('input[name="disponibilidad"]').val(horario.DISPONIBILIDAD);
                $('input[name="hora_exacta"]').val(horario.HORA_EXACTA.replace(' ', 'T'));
                $('input[name="comentario"]').val("Actualización de horario");

                $('#modificarhorariomodal').modal('show');
            },
            error: function (error) {
                dispararAlertaError("No se pudo cargar el horario.");
                console.error(error);
            }
        });
    });

    // Guardar cambios (modificar horario)
    $('#ModificarHorarioForm').submit(function (e) {
        e.preventDefault();

        const formData = $(this).serialize();

        $.ajax({
            url: '../PHP/Horarios/modificarhorario_process.php',
            method: 'POST',
            data: formData,
            success: function (response) {
                try {
                    const res = JSON.parse(response);
                    if (res.error) {
                        dispararAlertaError("Error al modificar: " + res.error);
                    } else {
                        dispararAlertaExito("Horario modificado correctamente");
                        $('#modificarhorariomodal').modal('hide');
                    }
                } catch (err) {
                    console.error("Respuesta inesperada:", response);
                    dispararAlertaExito("Horario modificado (sin error)");
                    $('#modificarhorariomodal').modal('hide');
                }
            },
            error: function (error) {
                dispararAlertaError("Error modificando el horario");
                console.error(error);
            }
        });
    });

    // Cargar lista de horarios
    listahorarios();
});

// Cargar tabla de horarios
function listahorarios() {
    $.ajax({
        url: '../PHP/Horarios/listarHorarios_process.php',
        method: 'GET',
        success: function (data) {
            const horarios = JSON.parse(data);
            const tbody = $('#HorariosTable tbody');
            tbody.empty();

            horarios.forEach(h => {
                const row = `
                    <tr>
                        <td>${h.ID_HORARIO}</td>
                        <td>${h.DISPONIBILIDAD}</td>
                        <td>${h.HORA_EXACTA}</td>
                        <td>
                            <button class="btn btn-primary btn-modify" data-id="${h.ID_HORARIO}">Modificar</button>
                        </td>
                    </tr>
                `;
                tbody.append(row);
            });
        },
        error: function (error) {
            dispararAlertaError("No se pudo cargar la tabla de horarios");
            console.error(error);
        }
    });
}

// Alertas
function dispararAlertaExito(mensaje) {
    Swal.fire({
        icon: "success",
        title: mensaje,
        confirmButtonText: 'Ok'
    }).then(() => location.reload());
}

function dispararAlertaError(mensaje) {
    Swal.fire({
        icon: "error",
        title: mensaje,
        confirmButtonText: 'Ok'
    });
}
