@extends('layouts.designerHome')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Reporte de Compras</h1>
        <form action="{{ route('reportes.compras') }}" method="GET" class="mb-4">
            <div class="flex items-center">
                <label for="proveedor_id" class="mr-2">Proveedor:</label>
                <select name="proveedor_id" id="proveedor_id" class="border p-2 rounded">
                    <option value="">Seleccionar Proveedor</option>
                    <option value="" @if(request()->get('proveedor_id') === '') selected @endif>Todos los Proveedores</option>
                    @foreach ($proveedores as $proveedor)
                        <option value="{{ $proveedor->id }}"
                            @if(request()->get('proveedor_id') == $proveedor->id) selected @endif>
                            {{ $proveedor->nombre }}
                        </option>
                    @endforeach
                </select>
                <label for="fecha_inicio" class="mr-2 ml-4">Fecha Inicio:</label>
                <input type="date" name="fecha_inicio" id="fecha_inicio" class="border p-2 rounded" value="{{ request()->get('fecha_inicio') }}">
                <label for="fecha_fin" class="mr-2 ml-4">Fecha Fin:</label>
                <input type="date" name="fecha_fin" id="fecha_fin" class="border p-2 rounded" value="{{ request()->get('fecha_fin') }}">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700 ml-4">Filtrar</button>
            </div>
        </form>

        <div class="mb-4">
            <a href="{{ route('reportes.compras', ['sort_by' => 'asc']) }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-700">
                Ordenar Ascendente
            </a>
            <a href="{{ route('reportes.compras', ['sort_by' => 'desc']) }}" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700 ml-4">
                Ordenar Descendente
            </a>
            <form action="{{ route('reportes.exportComprasPDF') }}" method="GET" class="inline-block ml-4">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Descargar PDF
                </button>
            </form>
        </div>

        <table class="table-auto w-full border-collapse border border-gray-200">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border p-2">Proveedor</th>
                    <th class="border p-2">Fecha de Compra</th>
                    <th class="border p-2">Medicamentos Comprados</th>
                    <th class="border p-2">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($compras as $compra)
                    <tr class="text-center">
                        <td class="border p-2">{{ $compra->proveedor->nombre }}</td>
                        <td>{{ $compra->fecha_compra->format('d-m-Y') }}</td>
                        <td class="border p-2">
                            @foreach ($compra->detalleCompras as $detalle)
                                <div>{{ $detalle->medicamento->nombre }} - Cantidad:{{ $detalle->cantidad }} x Bs.{{ number_format($detalle->costo_unitario, 2) }}</div>
                            @endforeach
                        </td>
                        <td class="border p-2">Bs. {{ number_format($compra->total, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
