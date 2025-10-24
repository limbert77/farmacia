<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura Farmacia</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
            margin: 0;
            padding: 2rem;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 2.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 2rem;
            border-bottom: 2px solid #3b82f6;
            padding-bottom: 1.5rem;
        }
        .pharmacy-name {
            color: #3b82f6;
            font-size: 2.2rem;
            margin: 0;
            font-weight: 600;
        }
        .subheader {
            color: #64748b;
            font-size: 0.9rem;
            margin: 0.5rem 0;
        }
        .details-table {
            width: 100%;
            margin: 1.5rem 0;
            border-collapse: collapse;
        }
        .details-table th {
            background-color: #f8fafc;
            color: #64748b;
            padding: 0.8rem;
            text-align: left;
            width: 30%;
            border-bottom: 1px solid #e2e8f0;
        }
        .details-table td {
            padding: 0.8rem;
            border-bottom: 1px solid #e2e8f0;
            color: #1e293b;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 2rem 0;
        }
        .items-table thead {
            background-color: #3b82f6;
            color: white;
        }
        .items-table th {
            padding: 1rem;
            text-align: left;
            font-weight: 500;
        }
        .items-table td {
            padding: 1rem;
            border-bottom: 1px solid #e2e8f0;
        }
        .total-section {
            background-color: #f8fafc;
            padding: 1.5rem;
            border-radius: 8px;
            margin-top: 2rem;
            text-align: right;
        }
        .total-amount {
            color: #3b82f6;
            font-size: 1.5rem;
            font-weight: 600;
            margin-left: 1rem;
        }
        .text-right {
            text-align: right;
        }
        .footer {
            margin-top: 3rem;
            text-align: center;
            color: #64748b;
            font-size: 0.9rem;
            border-top: 1px solid #e2e8f0;
            padding-top: 1.5rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 class="pharmacy-name">FARMACIA "SANA SANA"</h1>
            <div class="subheader">
                <p>Av. Salud 1234 • Tel: 555-1234 • RUC: 123456789-1</p>
                <p>Fecha: {{ date('d/m/Y') }} </p>
            </div>
        </div>

        <table class="details-table">
            <tr>
                <th>Cliente</th>
                <td>{{ $venta->cliente->nombre }} {{ $venta->cliente->apellido }}</td>
            </tr>
            <tr>
                <th>CI/NIT</th>
                <td>{{ $venta->cliente->cinit }}</td>
            </tr>
            <tr>
                <th>Atendido por</th>
                <td>{{ $usuario->nombre }} {{ $usuario->apellido }}</td>
            </tr>
        </table>

        <table class="items-table">
            <thead>
                <tr>
                    <th>Medicamento</th>
                    <th class="text-right">Cantidad</th>
                    <th class="text-right">P. Unitario</th>
                    <th class="text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($venta->detalleVentas as $detalle)
                <tr>
                    <td>{{ $detalle->medicamento->nombre }}</td>
                    <td class="text-right">{{ $detalle->cantidad }}</td>
                    <td class="text-right">Bs. {{ number_format($detalle->medicamento->precio, 2) }}</td>
                    <td class="text-right">Bs. {{ number_format($detalle->subtotal, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total-section">
            <span>Total a pagar:</span>
            <span class="total-amount">Bs. {{ number_format($venta->total, 2) }}</span>
        </div>

        <div class="footer">
            <p>¡Gracias por su compra! • Horario de atención: Lunes a Sábado 8:00 - 20:00</p>
            <p>Válida como factura legal • Sistema automatizado de gestión farmacéutica</p>
        </div>
    </div>
</body>
</html>
