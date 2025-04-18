$(document).ready(function () {
    cargarFacturas();

    // Ver detalle
    $(document).on('click', '.btn-ver', function () {
        const idFactura = $(this).data('id');

        $.ajax({
            url: '../PHP/Facturas/listadoFacturaIndividual_Process.php',
            method: 'GET',
            data: { id: idFactura },
            success: function (data) {
                const factura = JSON.parse(data)[0];

                $('#detalleFacturaModal #detalle_id').text(factura.ID_FACTURA);
                $('#detalleFacturaModal #detalle_fecha').text(factura.FECHA);
                $('#detalleFacturaModal #detalle_monto').text(factura.MONTO_TOTAL);
                $('#detalleFacturaModal #detalle_cliente').text(factura.NOMBRE_CLIENTE);
                $('#detalleFacturaModal #detalle_vuelto').text(factura.VUELTO);

                $('#detalleFacturaModal').modal('show');
            }
        });
    });

    // Descargar PDF
    $(document).on('click', '.btn-pdf', function () {
        const row = $(this).closest('tr');
        const doc = new jspdf.jsPDF();

        const factura = {
            id: row.find('td:eq(0)').text(),
            fecha: row.find('td:eq(1)').text(),
            monto: row.find('td:eq(2)').text(),
            cliente: row.find('td:eq(3)').text(),
            direccion: row.find('td:eq(4)').text(),
            telefono: row.find('td:eq(5)').text()
        };

        doc.text('Factura', 20, 20);
        doc.text(`ID: ${factura.id}`, 20, 40);
        doc.text(`Fecha: ${factura.fecha}`, 20, 50);
        doc.text(`Cliente: ${factura.cliente}`, 20, 60);
        doc.text(`Monto: ${factura.monto}`, 20, 70);
        doc.text(`Dirección: ${factura.direccion}`, 20, 80);
        doc.text(`Teléfono: ${factura.telefono}`, 20, 90);

        doc.save(`factura_${factura.id}.pdf`);
    });
});

function cargarFacturas() {
    $.ajax({
        url: '../PHP/Facturas/listarFacturas_Process.php',
        method: 'GET',
        success: function (data) {
            const facturas = JSON.parse(data);
            const tbody = $('#facturaList');
            tbody.empty();

            facturas.forEach(f => {
                const fila = `<tr>
                    <td>${f.ID_FACTURA}</td>
                    <td>${f.FECHA}</td>
                    <td>${f.MONTO_TOTAL}</td>
                    <td>${f.NOMBRE_CLIENTE}</td>
                    <td>${f.DIRECCION}</td>
                    <td>${f.TELEFONO}</td>
                    <td>${f.ID_PEDIDO}</td>
                    <td>
                        <button class="btn btn-info btn-ver" data-id="${f.ID_FACTURA}">Ver</button>
                        <button class="btn btn-success btn-pdf">PDF</button>
                    </td>
                </tr>`;
                tbody.append(fila);
            });
        }
    });
}
