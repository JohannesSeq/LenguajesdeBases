<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Mi Carrito</title>
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <?php include_once 'header.php'; ?>

    <div class="container mt-4">
        <h2>Carrito de Compras</h2>
        <table class="table" id="tablaCarrito">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Precio Unitario</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Rellenado por JS -->
            </tbody>
        </table>

        <!-- Botón que activa el modal -->
        <button class="btn btn-success" data-toggle="modal" data-target="#modalPedido">Realizar Pedido</button>
    </div>

    <!-- Modal para Confirmar Pedido -->
    <div class="modal fade" id="modalPedido" tabindex="-1" role="dialog" aria-labelledby="modalPedidoLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPedidoLabel">Confirmar Pedido</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formPedido">
                        <div class="form-group">
                            <label for="cedula_cliente">Cédula del Cliente</label>
                            <input type="number" class="form-control" id="cedula_cliente" readonly required>
                        </div>
                        <div class="form-group">
                            <label for="comentario">Comentario del Pedido</label>
                            <input type="text" class="form-control" id="comentario">
                        </div>
                        <button type="submit" class="btn btn-primary">Confirmar Pedido</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include_once 'footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="../script/permissions.js"></script>
    <script src="../script/cookie_management.js"></script>

    <script>
        function cargarCarrito() {
            let carrito = JSON.parse(localStorage.getItem("carrito")) || {};
            const tbody = document.querySelector("#tablaCarrito tbody");
            tbody.innerHTML = "";

            Object.entries(carrito).forEach(([id, cantidad]) => {
                fetch(`../PHP/Platillos/listadoplatilloindividual_process.php?id=${id}`)
                    .then(res => res.json())
                    .then(data => {
                        const p = data[0];
                        const total = p.PRECIO_UNITARIO * cantidad;
                        const row = `
                            <tr>
                                <td>${p.NOMBRE_PLATILLO}</td>
                                <td>${p.PRECIO_UNITARIO}</td>
                                <td>${cantidad}</td>
                                <td>${total}</td>
                                <td>
                                    <button class="btn btn-danger btn-sm" onclick="eliminarDelCarrito(${p.ID_PLATILLO})">Eliminar</button>
                                </td>
                            </tr>`;
                        tbody.innerHTML += row;
                    });
            });
        }

        function eliminarDelCarrito(id) {
            let carrito = JSON.parse(localStorage.getItem("carrito")) || {};
            delete carrito[id];
            localStorage.setItem("carrito", JSON.stringify(carrito));
            cargarCarrito();
        }

        // Nuevo manejador del modal de pedido
        document.getElementById("formPedido").addEventListener("submit", function (e) {
            e.preventDefault();

            const cedula = document.getElementById("cedula_cliente").value;
            const comentario = document.getElementById("comentario").value;
            const carrito = JSON.parse(localStorage.getItem("carrito")) || {};

            if (Object.keys(carrito).length === 0 || !cedula) {
                Swal.fire("Error", "Complete los datos y agregue platillos", "error");
                return;
            }

            let total = 0;
            let promesas = [];

            Object.entries(carrito).forEach(([id, cantidad]) => {
                promesas.push(
                    fetch(`../PHP/Platillos/listadoplatilloindividual_process.php?id=${id}`)
                        .then(res => res.json())
                        .then(data => {
                            total += data[0].PRECIO_UNITARIO * cantidad;
                        })
                );
            });

            Promise.all(promesas).then(() => {
                // 1. Crear el pedido
                fetch("../PHP/Pedidos/agregarPedido_Process.php", {
                    method: "POST",
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        cedula_cliente: cedula,
                        monto_estimado: total,
                        estado: "Pendiente",
                        comentario: comentario
                    })
                }).then(() => {
                    // 2. Insertar platillos
                    fetch("../PHP/Pedidos/agregarPlatillosPedido_Process.php", {
                        method: "POST",
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({
                            cedula_cliente: cedula,
                            platillos: carrito,
                            comentario: comentario
                        })
                    }).then(() => {
                        $('#modalPedido').modal('hide'); // Cierra el modal
                        Swal.fire("Pedido Realizado", "Gracias por tu pedido", "success");
                        localStorage.removeItem("carrito");
                        setTimeout(() => {
                            location.href = "mostrarPedidos.php";
                        }, 1500);
                    });
                });
            });
        });

        // Evitar que se abra el modal si el carrito está vacío
        $('#modalPedido').on('show.bs.modal', function (e) {
            const carrito = JSON.parse(localStorage.getItem("carrito")) || {};

            if (Object.keys(carrito).length === 0) {
                e.preventDefault(); // Evita la apertura del modal
                Swal.fire("Carrito vacío", "Agrega productos antes de realizar el pedido", "warning");
            }
        });

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
                        document.getElementById("cedula_cliente").value = data[0].CEDULA;
                    } else {
                        Swal.fire("Error", "No se pudo obtener la cédula del cliente", "error");
                    }
                })
                .catch((error) => {
                    Swal.fire("Error", "Fallo la consulta del cliente", "error");
                });
        }

        cargarCarrito();
        cargarCedulaDesdeEmail(); // Cargar cédula al abrir el modal
    </script>
</body>

</html>