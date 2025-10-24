@extends('layouts.designerHome')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">Reporte de Proveedores</h2>

    <div class="mb-4">
        <a href="{{ route('reportes.proveedores.pdf') }}" class="p-2 bg-blue-600 text-white rounded">Descargar PDF</a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full table-auto">
            <thead>
                <tr>
                    <th class="px-4 py-2">Nombre</th>
                    <th class="px-4 py-2">Teléfono</th>
                    <th class="px-4 py-2">Email</th>
                    <th class="px-4 py-2">Dirección</th>
                </tr>
            </thead>
            <tbody>
                @foreach($proveedores as $proveedor)
                    <tr>
                        <td class="px-4 py-2">{{ $proveedor->nombre }}</td>
                        <td class="px-4 py-2">{{ $proveedor->telefono }}</td>
                        <td class="px-4 py-2">{{ $proveedor->email }}</td>
                        <td class="px-4 py-2">{{ $proveedor->direccion }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
