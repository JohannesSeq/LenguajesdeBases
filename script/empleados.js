$(document).ready(function () {
    listarempleados();

    $('#FormularioAgregarEmpleado').submit(function (e) {
        e.preventDefault();
        const data = {
            cedula: $('#cedula_empleado').val(),
            departamento: $('#departamento_empleado').val(),
            puesto: $('#puesto_empleado').val(),
            salario: $('#salario_empleado').val(),
            comentario: $('#comentario_empleado').val()
        };

        $.ajax({
            url: '../PHP/Empleados/agregarEmpleado_Process.php',
            method: 'POST',
            data: data,
            success: function () {
                Swal.fire("Éxito", "Empleado agregado correctamente", "success").then(() => listarempleados());
                $('#modalAgregarEmpleado').modal('hide');
            },
            error: function () {
                Swal.fire("Error", "No se pudo agregar el empleado", "error");
                $('#modalAgregarEmpleado').modal('hide');
            }
        });
    });

    $('#FormularioEditarEmpleado').submit(function (e) {
        e.preventDefault();
        const data = {
            id: $('#editar_id_empleado').val(),
            departamento: $('#editar_departamento_empleado').val(),
            puesto: $('#editar_puesto_empleado').val(),
            salario: $('#editar_salario_empleado').val()
        };

        $.ajax({
            url: '../PHP/Empleados/modificarEmpleado_Process.php',
            method: 'POST',
            data: data,
            success: function () {
                Swal.fire("Éxito", "Empleado modificado correctamente", "success").then(() => listarempleados());
            },
            error: function () {
                Swal.fire("Error", "No se pudo modificar el empleado", "error");
            }
        });
    });

    $(document).on('click', '.btn-modify', function () {
        const id = $(this).data('id');

        $.ajax({
            url: '../PHP/Empleados/listadoindividualEmpleado_Process.php',
            method: 'GET',
            data: { id },
            dataType: 'json',
            success: function (res) {
                const e = res[0];
                $('#editar_id_empleado').val(e.ID_EMPLEADO);
                $('#editar_departamento_empleado').val(e.ID_DEPARTAMENTO);
                $('#editar_puesto_empleado').val(e.ID_PUESTO);
                $('#editar_salario_empleado').val(e.SALARIO);
                $('#modalEditarEmpleado').modal('show');
            }
        });
    });

    $(document).on('click', '.btn-delete', function () {
        const id = $(this).data('id');
        Swal.fire({
            title: '¿Eliminar empleado?',
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
                $.ajax({
                    url: '../PHP/Empleados/eliminarEmpleado_Process.php',
                    method: 'POST',
                    data: {
                        id: id,
                        comentario: result.value
                    },
                    success: function () {
                        Swal.fire("Eliminado", "Empleado eliminado correctamente", "success").then(() => listarempleados());
                    }
                });
            }
        });
    });
});

function listarempleados() {
    $.ajax({
        url: '../PHP/Empleados/listarEmpleados_Process.php',
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            const tbody = $('#empleadosTable tbody');
            tbody.empty();
            data.forEach(e => {
                tbody.append(`
                    <tr>
                        <td>${e.ID_EMPLEADO}</td>
                        <td>${e.NOMBRE_COMPLETO}</td>
                        <td>${e.ROL}</td>
                        <td>${e.NOMBRE_DEPARTAMENTO}</td>
                        <td>${e.NOMBRE_PUESTO}</td>
                        <td>₡${e.SALARIO}</td>
                        <td>
                            <button class="btn btn-primary btn-modify" data-id="${e.ID_EMPLEADO}">Modificar</button>
                            <button class="btn btn-danger btn-delete" data-id="${e.ID_EMPLEADO}">Eliminar</button>
                        </td>
                    </tr>
                `);
            });
        }
    });
}

// Cargar personas con rol 'Empleado' o 'Gerente'
function cargarPersonasEmpleables() {
    $.ajax({
        url: '../PHP/Empleados/listarPersonasEmpleables.php',
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            const select = $('#cedula_empleado');
            select.empty();
            data.forEach(p => {
                select.append(`<option value="${p.CEDULA}">${p.NOMBRE} ${p.APELLIDO} (${p.ROL})</option>`);
            });
        }
    });
}

// Cargar departamentos
function cargarDepartamentos() {
    $.ajax({
        url: '../PHP/Departamentos/listarDepartamentos_Process.php',
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            $('#departamento_empleado, #editar_departamento_empleado').empty();
            data.forEach(d => {
                $('#departamento_empleado, #editar_departamento_empleado').append(
                    `<option value="${d.ID_DEPARTAMENTO}">${d.NOMBRE_DEPARTAMENTO}</option>`
                );
            });
        }
    });
}

// Cargar puestos
function cargarPuestos() {
    $.ajax({
        url: '../PHP/Puestos/listarPuestos_Process.php',
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            $('#puesto_empleado, #editar_puesto_empleado').empty();
            data.forEach(p => {
                $('#puesto_empleado, #editar_puesto_empleado').append(
                    `<option value="${p.ID_PUESTO}">${p.NOMBRE_PUESTO}</option>`
                );
            });
        }
    });
}
