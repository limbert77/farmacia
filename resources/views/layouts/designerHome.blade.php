<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    @livewireStyles
    <title>Farmacia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
</head>
<body class="bg-gray-100 hover:text-black flex">
    <aside class="w-55 shadow-lg h-screen fixed">
        <div class="p-4 flex flex-col items-center">
            <img src="/img/Logo3.png" alt="Logo" class="h-32 w-auto mb-2">
        </div>
        <nav class="mt-6 text-black">
            <ul>
                <li class="flex items-center p-2 hover:bg-blue-600 hover:text-white rounded-lg">
                    <a href="{{ route('inicio.index') }}" class="flex-1 text-left font-bold">Inicio</a>
                    <i class="fas fa-home text-xl ml-auto"></i>
                </li>
                @if(auth()->check() && auth()->user()->rol === 'admin')
                    <li class="flex items-center p-2 hover:bg-blue-600 hover:text-white rounded-lg">
                        <a href="{{ route('usuario.index') }}" class="flex-1 text-left font-bold">Usuarios</a>
                        <i class="fas fa-users text-xl ml-auto"></i>
                    </li>
                @endif
                @if(auth()->check() && (auth()->user()->rol === 'admin' || auth()->user()->rol === 'farmacéutico'))
                    <li class="flex items-center p-2 hover:bg-blue-600 hover:text-white rounded-lg">
                        <a href="{{ route('proveedores.index') }}" class="flex-1 text-left font-bold">Proveedores</a>
                        <i class="fas fa-truck text-xl ml-auto"></i>
                    </li>
                @endif
                @if(auth()->check() && (auth()->user()->rol === 'admin' || auth()->user()->rol === 'farmacéutico'))
                    <li class="flex items-center p-2 hover:bg-blue-600 hover:text-white rounded-lg">
                        <a href="{{ route('medicamento.index') }}" class="flex-1 text-left font-bold">Medicamentos</a>
                        <i class="fas fa-pills text-xl ml-auto"></i>
                    </li>
                @endif
                <li class="flex items-center p-2 hover:bg-blue-600 hover:text-white rounded-lg">
                    <a href="{{ route('ventas') }}" class="flex-1 text-left font-bold">Ventas</a>
                    <i class="fas fa-cash-register text-xl ml-auto"></i>
                </li>
                @if(auth()->check() && (auth()->user()->rol === 'admin' || auth()->user()->rol === 'farmacéutico'))
                    <li class="flex items-center p-2 hover:bg-blue-600 hover:text-white rounded-lg">
                        <a href="{{ route('compra.index') }}" class="flex-1 text-left font-bold">Compras</a>
                        <i class="fas fa-boxes text-xl ml-auto"></i>
                    </li>
                @endif
                @if(auth()->check() && auth()->user()->rol === 'admin')
                    <li class="flex items-center p-2 hover:bg-blue-600 hover:text-white rounded-lg relative group">
                        <a href="#" class="flex-1 text-left font-bold">Reportes</a>
                        <i class="fas fa-file-alt text-xl ml-auto"></i>
                        <ul class="absolute left-0 mt-2 space-y-2 pl-4 bg-white shadow-md rounded-lg opacity-0 group-hover:opacity-100 group-hover:visible invisible transition-all">
                            <li>
                                <a href="{{ route('reportes.ventas') }}" class="flex items-center p-2 hover:bg-blue-600 hover:text-white text-black rounded-lg">
                                    <i class="fas fa-file-invoice-dollar mr-3"></i> Reportes de Ventas
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('reportes.compras') }}" class="flex items-center p-2 hover:bg-blue-600 hover:text-white text-black rounded-lg">
                                    <i class="fas fa-file-invoice mr-3"></i> Reportes de Compras
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('reportes.inventario') }}" class="flex items-center p-2 hover:bg-blue-600 hover:text-white text-black rounded-lg">
                                    <i class="fas fa-cogs mr-3"></i> Reportes de Inventario
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('reportes.proveedores') }}" class="flex items-center p-2 hover:bg-blue-600 hover:text-white text-black rounded-lg">
                                    <i class="fas fa-truck mr-3"></i> Reportes de Proveedores
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('reportes.usuarios') }}" class="flex items-center p-2 hover:bg-blue-600 hover:text-white text-black rounded-lg">
                                    <i class="fas fa-users-cog mr-3"></i> Reportes de Usuarios
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('reportes.clientes') }}" class="flex items-center p-2 hover:bg-blue-600 hover:text-white text-black rounded-lg">
                                    <i class="fas fa-user-friends mr-3"></i> Reportes de Clientes
                                </a>
                            </li>
                        </ul>

                    </li>
                @endif
            </ul>
        </nav>
    </aside>
    <style>
        .group:hover .absolute {
            visibility: visible;
            opacity: 1;
        }
        .absolute {
            visibility: hidden;
            opacity: 0;
            transition: visibility 0s, opacity 0.2s ease-in-out;
        }
    </style>

    <div class="ml-64 flex-1">
        <header class="p-4 flex justify-between items-center w-full">
            <h1 class="text-4xl font-bold text-blue-600">Farmacia "LimbertPool"</h1>

            @if(auth()->check())
                <div class="flex items-center space-x-4">
                    <span class="text-lg font-semibold text-gray-700">
                        {{ ucfirst(auth()->user()->rol) }}: {{ auth()->user()->nombre }} {{ auth()->user()->apellido }}
                    </span>
                    <div class="w-10 h-10 bg-blue-600 text-white flex items-center justify-center rounded-full font-bold">
                        {{ auth()->user()->initials() }}
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white px-4 py-2 rounded-lg">
                            Cerrar sesión
                        </button>
                    </form>
                </div>
            @endif
        </header>

        <div class="p-4">
            @yield('content')
        </div>
    </div>


    @livewireScripts
</body>
</html>
