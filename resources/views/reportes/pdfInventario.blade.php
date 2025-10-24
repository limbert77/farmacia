<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Inventario</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; margin: 0; padding: 0; }
        .container { width: 100%; padding: 2rem; }
        .header { text-align: center; margin-bottom: 2rem; }
        h1 { font-size: 2rem; font-weight: bold; }
        .table { width: 100%; border-collapse: collapse; margin-top: 1.5rem; }
        .table th, .table td { padding: 0.8rem; text-align: left; border: 1px solid #ddd; }
        .table th { background-color: #f4f4f4; font-weight: bold; }
        .table tr:nth-child(even) { background-color: #f9f9f9; }
        .footer { text-align: center; margin-top: 2rem; font-size: 0.9rem; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Farmacia "Sana Sana"</h1>
            <p>Reporte de Inventario</p>
            @if(request('proveedor_id'))
                <p>Filtrado por Proveedor:
                    {{ $proveedores->where('id', request('proveedor_id'))->first()->nombre ?? 'N/A' }}
                </p>
            @endif
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Requiere Receta</th>
                    <th>Proveedor</th>
                    <th>Fecha de Vencimiento</th>
                    <th>Categoría</th>
                </tr>
            </thead>
            <tbody>
                @foreach($medicamentos as $medicamento)
                    <tr>
                        <td>{{ $medicamento->nombre }}</td>
                        <td>{{ $medicamento->descripcion }}</td>
                        <td>Bs. {{ number_format($medicamento->precio, 2) }}</td>
                        <td>{{ $medicamento->stock }}</td>
                        <td>{{ $medicamento->requiere_receta ? 'Sí' : 'No' }}</td>
                        <td>{{ $medicamento->proveedor->nombre ?? 'N/A' }}</td>
                        <td>{{ \Carbon\Carbon::parse($medicamento->fecha_vencimiento)->format('d/m/Y') }}</td>
                        <td>{{ $medicamento->categoria }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Farmacia "Sana Sana" | Todos los derechos reservados</p>
        </div>
    </div>
</body>
</html>
