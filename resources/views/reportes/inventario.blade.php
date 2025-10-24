@extends('layouts.designerHome')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">Reporte de Inventario</h2>

    <form method="GET" action="{{ route('reportes.inventario') }}" class="mb-4 flex space-x-4">
        <select name="proveedor_id" class="p-2 border rounded">
            <option value="">Todos los Proveedores</option>
            @foreach($proveedores as $proveedor)
                <option value="{{ $proveedor->id }}" {{ request('proveedor_id') == $proveedor->id ? 'selected' : '' }}>
                    {{ $proveedor->nombre }}
                </option>
            @endforeach
        </select>
        <button type="submit" class="p-2 bg-blue-600 text-white rounded">Filtrar</button>
    </form>

    <div class="mb-4">
        <a href="{{ route('reportes.inventario.pdf', ['proveedor_id' => request('proveedor_id')]) }}" class="p-2 bg-blue-600 text-white rounded">
            Descargar PDF
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full table-auto">
            <thead>
                <tr>
                    <th class="px-4 py-2">Nombre</th>
                    <th class="px-4 py-2">Descripción</th>
                    <th class="px-4 py-2">Precio</th>
                    <th class="px-4 py-2">Stock</th>
                    <th class="px-4 py-2">Requiere Receta</th>
                    <th class="px-4 py-2">Proveedor</th>
                    <th class="px-4 py-2">Fecha de Vencimiento</th>
                    <th class="px-4 py-2">Categoría</th>
                </tr>
            </thead>
            <tbody>
                @foreach($medicamentos as $medicamento)
                    <tr>
                        <td class="px-4 py-2">{{ $medicamento->nombre }}</td>
                        <td class="px-4 py-2">{{ $medicamento->descripcion }}</td>
                        <td class="px-4 py-2">Bs. {{ number_format($medicamento->precio, 2) }}</td>
                        <td class="px-4 py-2">{{ $medicamento->stock }}</td>
                        <td class="px-4 py-2">{{ $medicamento->requiere_receta ? 'Sí' : 'No' }}</td>
                        <td class="px-4 py-2">{{ $medicamento->proveedor->nombre ?? 'N/A' }}</td>
                        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($medicamento->fecha_vencimiento)->format('d/m/Y') }}</td>
                        <td class="px-4 py-2">{{ $medicamento->categoria }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
