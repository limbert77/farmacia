@extends('layouts.designerHome')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Reporte de Clientes</h1>
        <div class="mb-4">
            <form action="{{ route('reportes.exportClientesPDF') }}" method="GET">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Descargar PDF
                </button>
            </form>
        </div>
        <table class="table-auto w-full border-collapse border border-gray-200">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border p-2">Nombre</th>
                    <th class="border p-2">Apellido</th>
                    <th class="border p-2">Teléfono</th>
                    <th class="border p-2">Email</th>
                    <th class="border p-2">Total Gastado</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clientes as $cliente)
                    <tr class="text-center">
                        <td class="border p-2">{{ $cliente->nombre }}</td>
                        <td class="border p-2">{{ $cliente->apellido }}</td>
                        <td class="border p-2">{{ $cliente->telefono }}</td>
                        <td class="border p-2">{{ $cliente->email }}</td>
                        <td class="border p-2">
                            Bs. {{ number_format(optional($cliente->ventas->first())->total_gastado ?? 0, 2) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
