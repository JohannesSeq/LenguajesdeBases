$(document).ready(function(){

    // Manejador para el botón de reactivar estado
    $(document).on('click', '.btn-modify', function () {
        var estadoId = $(this).data('id'); // Obtiene el ID del estado a eliminar
        console.log(estadoId);

        // Muestra una alerta de confirmación usando SweetAlert2
        Swal.fire({
            title: '¿Estás seguro?',
            text: "No podrás revertir esta acción!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminarlo!'

        }).then((result) => {
            if (result.isConfirmed) {
                // Si el usuario confirma, realiza una petición AJAX para eliminar el estado
                $.ajax({
                    url: '../PHP/estados/reactivarEstado_process.php', // URL del archivo PHP que procesará la eliminación
                    method: 'POST', // Método HTTP para enviar la solicitud de eliminación
                    data: { 
                        id: estadoId 
                    }, // Envía el ID del estado como parámetro
                    success: function (response) {
                        if (response.error) {
                            Swal.fire('Error', 'No se pudo reactivar el estado.', 'error');

                        } else {

                            dispararAlertaExito("El estado ha sido reactivado."); // Muestra un mensaje de éxito
                            listadoestados();  // Recarga la lista de estados

                        }
                    },
                    error: function (error) {
                        console.error('Error deleting order:', error);
                    }
                });
            }
        });
    });

});

function listadoestados() {
    $.ajax({
        url: '../PHP/estados/listadoEstados_process.php', // URL del archivo PHP que devolverá la lista de estados
        method: 'GET', // Método HTTP para solicitar los datos

        success: function (data) {
            var estados = JSON.parse(data); // Parse la respuesta JSON
            var tbody = $('#estadosTable tbody');
            tbody.empty(); // Limpia la tabla antes de añadir nuevos datos

            estados.forEach(function (estado) {
                // Construye una fila de la tabla con los datos del pedid
                var row = `<tr>
                    <td>${estado.ID_ESTADO}</td>
                    <td>${estado.TABLA_ENTRADA}</td>
                    <td>${estado.ESTADO}</td>
                    <td>
                        <button class="btn btn-primary btn-modify" data-id="${estado.ID_ESTADO}">Reactivar</button>
                    </td>
                </tr>`;
                tbody.append(row); // Añade la fila a la tabla
            });
        },
        error: function (error) {
            console.error('Error cargando los estados:', error); // Muestra el error en la consola
        }
    });
}

// Función para mostrar una alerta de éxito usando SweetAlert2
function dispararAlertaExito(mensaje) {
    Swal.fire({
        icon: "success", // Icono de éxito
        title: mensaje, // Título de la alerta
        confirmButtonText: 'Ok' // Texto del botón de confirmación
    }).then(() => {
        //location.reload();  // Recarga la página después de cerrar la alerta
    });
}
// Función para mostrar una alerta de error usando SweetAlert2
function dispararAlertaError(mensaje) {
    Swal.fire({
        icon: "error", // Icono de error
        title: mensaje,
        confirmButtonText: 'Ok' // Texto del botón de confirmación
    }).then(() => {
        location.reload(); // Recarga la página después de cerrar la alerta
    });
}

