<div>
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold text-blue-600 mb-6 text-center">Lista de Usuarios</h2>
        @if(session()->has('message'))
            <div class="bg-green-500 text-white p-2 rounded mb-4">
                {{ session('message') }}
            </div>
        @endif

        <div class="text-center mb-6">
            <button wire:click="openCreateModal" class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow-md">
                Registrar Usuario
            </button>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($usuarios as $usuario)
                <div class="bg-white shadow-md rounded-lg p-6">
                    <div class="flex justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-16 h-16 text-blue-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 12c2.755 0 5-2.245 5-5S14.755 2 12 2s-5 2.245-5 5 2.245 5 5 5zM12 14c-4.418 0-8 2.239-8 5v2h16v-2c0-2.761-3.582-5-8-5z"/>
                        </svg>
                    </div>
                    <div class="text-center">
                        <h3 class="text-xl font-semibold text-blue-600 mb-2">{{ $usuario->nombre }} {{ $usuario->apellido }}</h3>
                        <p class="text-sm text-gray-500">{{ $usuario->email }}</p>
                        <p class="text-sm text-gray-500 mt-2 mb-2">
                            <span class="px-3 py-1 rounded-full
                                @if($usuario->rol == 'admin') bg-blue-500 text-white @endif
                                @if($usuario->rol == 'vendedor') bg-yellow-500 text-white @endif
                                @if($usuario->rol == 'farmacéutico') bg-green-500 text-white @endif">
                                {{ ucfirst($usuario->rol) }}
                            </span>
                        </p>
                        <p class="text-sm text-gray-500">
                            <span class="w-3 h-3 inline-block rounded-full
                                @if($usuario->estado) bg-green-500 @else bg-red-500 @endif"></span>
                            {{ $usuario->estado ? 'Activo' : 'Inactivo' }}
                        </p>
                    </div>
                    <div class="text-right mt-4">
                        <button wire:click="openEditModal({{ $usuario->id }})" class="bg-yellow-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-yellow-600 transition-all duration-300">Editar</button>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
    @if($createMode || $editMode)
        <div class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                <h3 class="text-xl font-semibold text-blue-600 mb-4">{{ $editMode ? 'Editar Usuario' : 'Registrar Usuario' }}</h3>

                <form wire:submit.prevent="save">
                    <div class="mb-4">
                        <label class="block text-sm text-gray-700">Nombre</label>
                        <input type="text" wire:model="nombre" class="w-full px-4 py-2 border rounded-md" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm text-gray-700">Apellido</label>
                        <input type="text" wire:model="apellido" class="w-full px-4 py-2 border rounded-md" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm text-gray-700">Correo Electrónico</label>
                        <input type="email" wire:model="email" class="w-full px-4 py-2 border rounded-md" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm text-gray-700">Contraseña</label>
                        <input type="password" wire:model="contraseña" class="w-full px-4 py-2 border rounded-md" {{ $editMode ? '' : 'required' }}>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm text-gray-700">Rol</label>
                        <select wire:model="rol" class="w-full px-4 py-2 border rounded-md" required>
                            <option value="admin">Admin</option>
                            <option value="vendedor">Vendedor</option>
                            <option value="farmacéutico">Farmacéutico</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm text-gray-700">Estado</label>
                        <select wire:model="estado" class="w-full px-4 py-2 border rounded-md">
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg">{{ $editMode ? 'Actualizar' : 'Registrar' }}</button>
                        <button type="button" wire:click="closeModal" class="ml-2 text-gray-500">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>

