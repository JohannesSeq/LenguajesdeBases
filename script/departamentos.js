$(document).ready(function () {
    listardepartamentos();

    // Agregar departamento
    $('#FormularioAgregarDepartamento').submit(function (e) {
        e.preventDefault();

        const data = {
            nombre: $('#nombre_departamento').val(),
            descripcion: $('#descripcion_departamento').val(),
            comentario: "Creación de departamento"
        };

        $.ajax({
            url: '../PHP/Departamentos/agregarDepartamento_Process.php',
            method: 'POST',
            data: data,
            success: function (response) {
                Swal.fire("Éxito", "Departamento agregado correctamente", "success").then(() => location.reload());
            },
            error: function (xhr, status, error) {
                console.error("Error al agregar departamento:", error);
                Swal.fire("Error", "No se pudo agregar el departamento", "error");
            }
        });
    });

    // Modificar departamento
    $('#FormularioEditarDepartamento').submit(function (e) {
        e.preventDefault();

        const data = {
            id: $('#editar_id').val(),
            nombre: $('#editar_nombre_departamento').val(),
            descripcion: $('#editar_descripcion_departamento').val()
        };

        $.ajax({
            url: '../PHP/Departamentos/modificarDepartamento_Process.php',
            method: 'POST',
            data: data,
            success: function () {
                Swal.fire("Actualizado", "Departamento modificado correctamente", "success").then(() => location.reload());
            },
            error: function (xhr, status, error) {
                console.error("Error al modificar departamento:", error);
                Swal.fire("Error", "No se pudo modificar el departamento", "error");
            }
        });
    });

    // Botón Modificar
    $(document).on('click', '.btn-modify', function () {
        const id = $(this).data('id');

        $.ajax({
            url: '../PHP/Departamentos/listadoindividualdepartamento_process.php',
            method: 'GET',
            dataType: 'json',
            data: { id: id },
            success: function (res) {
                if (res.length > 0) {
                    const departamento = res[0];
                    $('#editar_id').val(departamento.ID_DEPARTAMENTO);
                    $('#editar_nombre_departamento').val(departamento.NOMBRE_DEPARTAMENTO);
                    $('#editar_descripcion_departamento').val(departamento.DESCRIPCION);
                    $('#modalEditarDepartamento').modal('show');
                } else {
                    Swal.fire("Error", "Departamento no encontrado", "error");
                }
            },
            error: function (xhr, status, error) {
                console.error("Error al cargar departamento:", error);
                Swal.fire("Error", "No se pudo cargar el departamento", "error");
            }
        });
    });

    // Botón Eliminar
    $(document).on('click', '.btn-delete', function () {
        const id = $(this).data('id');

        Swal.fire({
            title: '¿Eliminar departamento?',
            text: 'Esta acción desactivará el departamento (eliminación lógica)',
            icon: 'warning',
            showCancelButton: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '../PHP/Departamentos/eliminarDepartamento_Process.php',
                    method: 'POST',
                    data: {
                        id: id,
                        comentario: 'Eliminación de departamento'
                    },
                    success: function () {
                        Swal.fire("Eliminado", "El departamento ha sido desactivado", "success").then(() => location.reload());
                    },
                    error: function (xhr, status, error) {
                        console.error("Error al eliminar departamento:", error);
                        Swal.fire("Error", "No se pudo eliminar el departamento", "error");
                    }
                });
            }
        });
    });
});

// Cargar todos los departamentos activos
function listardepartamentos() {
    $.ajax({
        url: '../PHP/Departamentos/listarDepartamentos_Process.php',
        method: 'GET',
        dataType: 'json',
        success: function (departamentos) {
            const tbody = $('#departamentosTable tbody');
            tbody.empty();

            departamentos.forEach(dep => {
                tbody.append(`
                    <tr>
                        <td>${dep.ID_DEPARTAMENTO}</td>
                        <td>${dep.NOMBRE_DEPARTAMENTO}</td>
                        <td>${dep.DESCRIPCION}</td>
                        <td>
                            <button class="btn btn-primary btn-modify" data-id="${dep.ID_DEPARTAMENTO}">Modificar</button>
                            <button class="btn btn-danger btn-delete" data-id="${dep.ID_DEPARTAMENTO}">Eliminar</button>
                        </td>
                    </tr>
                `);
            });
        },
        error: function (xhr, status, error) {
            console.error("Error al listar departamentos:", error);
            Swal.fire("Error", "No se pudieron cargar los departamentos", "error");
        }
    });
}
