function getEmailFromCookie() {
    const match = document.cookie.match(/(?:^|; )email=([^;]*)/);
    return match ? decodeURIComponent(match[1]) : null;
}

function cargarPedidosUsuario() {
    const email = getEmailFromCookie();
    if (!email) {
        Swal.fire("Error", "No se encontró la sesión del usuario", "error");
        return;
    }

    fetch(`../PHP/Personas/listadoindividualcliente_process.php?email=${encodeURIComponent(email)}`)
        .then(res => res.json())
        .then(data => {
            if (data && data[0] && data[0].CEDULA) {
                consultarPedidosPorCedula(data[0].CEDULA);
            } else {
                Swal.fire("Error", "No se encontró la cédula del usuario", "error");
            }
        });
}

function consultarPedidosPorCedula(cedula) {
    fetch("../PHP/Pedidos/listarPedidosUsuario_Process.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ cedula_cliente: cedula })
    })
    .then(res => res.json())
    .then(pedidos => {
        const tbody = document.querySelector("#pedidosUsuarioTable tbody");
        tbody.innerHTML = "";

        pedidos.forEach(p => {
            const row = `
                <tr>
                    <td>${p.ID_PEDIDO}</td>
                    <td>₡${p.MONTO_ESTIMADO}</td>
                    <td>${p.ESTADO_PEDIDO}</td>
                </tr>`;
            tbody.innerHTML += row;
        });
    })
    .catch(() => {
        Swal.fire("Error", "No se pudieron cargar tus pedidos", "error");
    });
}
