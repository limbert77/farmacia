<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Proveedores</title>
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
            <p>Reporte de Proveedores</p>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Teléfono</th>
                    <th>Email</th>
                    <th>Dirección</th>
                </tr>
            </thead>
            <tbody>
                @foreach($proveedores as $proveedor)
                    <tr>
                        <td>{{ $proveedor->nombre }}</td>
                        <td>{{ $proveedor->telefono }}</td>
                        <td>{{ $proveedor->email }}</td>
                        <td>{{ $proveedor->direccion }}</td>
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
