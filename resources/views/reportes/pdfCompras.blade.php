<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Compras</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        h1 {
            text-align: center;
        }
    </style>
</head>
<body>

    <h1>Reporte de Compras</h1>

    @foreach ($compras as $compra)
        <h2>Proveedor: {{ $compra->proveedor->nombre }}</h2>
        <p><strong>Fecha de Compra:</strong> {{ $compra->fecha_compra->format('d/m/Y') }}</p>
        <p><strong>Total:</strong> Bs. {{ number_format($compra->total, 2) }}</p>

        <h3>Medicamentos Comprados:</h3>
        <table>
            <thead>
                <tr>
                    <th>Medicamento</th>
                    <th>Cantidad</th>
                    <th>Costo Unitario</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($compra->detalleCompras as $detalle)
                    <tr>
                        <td>{{ $detalle->medicamento->nombre }}</td>
                        <td>{{ $detalle->cantidad }}</td>
                        <td>Bs. {{ number_format($detalle->costo_unitario, 2) }}</td>
                        <td>Bs. {{ number_format($detalle->subtotal, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <hr>
    @endforeach

</body>
</html>
