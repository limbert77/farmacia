@extends('layouts.designerHome')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-xl font-bold mb-4">Reporte de Usuarios</h1>
        <a href="{{ route('reportes.exportUsuariosPDF') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Exportar PDF</a>
        <table class="table-auto w-full mt-4 border-collapse border border-gray-200">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border border-gray-300 px-4 py-2">Nombre</th>
                    <th class="border border-gray-300 px-4 py-2">Apellido</th>
                    <th class="border border-gray-300 px-4 py-2">Email</th>
                    <th class="border border-gray-300 px-4 py-2">Rol</th>
                    <th class="border border-gray-300 px-4 py-2">Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($usuarios as $usuario)
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">{{ $usuario->nombre }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $usuario->apellido }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $usuario->email }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $usuario->rol }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $usuario->estado ? 'Activo' : 'Inactivo' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
