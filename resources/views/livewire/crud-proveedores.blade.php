<div class="bg-white shadow-lg rounded-lg p-6">
    <h2 class="text-2xl font-bold text-blue-600 mb-6 text-center">Lista de Proveedores</h2>
    @if(session()->has('message'))
        <div class="bg-green-500 text-white p-2 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif
    <div class="text-center mb-6">
        <button wire:click="$set('createMode', true)" class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow-md">
            Registrar Proveedor
        </button>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($proveedores as $proveedor)
            <div class="bg-white shadow-lg rounded-lg p-6 hover:shadow-xl transition-all duration-300">
                <div class="flex justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-16 h-16 text-blue-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 12c2.755 0 5-2.245 5-5S14.755 2 12 2s-5 2.245-5 5 2.245 5 5 5zM12 14c-4.418 0-8 2.239-8 5v2h16v-2c0-2.761-3.582-5-8-5z"/>
                    </svg>
                </div>
                <div class="text-center">
                    <h3 class="text-xl font-semibold text-blue-600 mb-2">{{ $proveedor->nombre }}</h3>
                    <p class="text-sm text-gray-500">{{ $proveedor->telefono }}</p>
                    <p class="text-sm text-gray-500">{{ $proveedor->email }}</p>
                    <p class="text-sm text-gray-500">{{ $proveedor->direccion }}</p>
                </div>
                <div class="text-right mt-4">
                    <button wire:click="editProveedor({{ $proveedor->id }})" class="bg-yellow-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-yellow-600 transition-all duration-300">Editar</button>
                </div>
            </div>
        @endforeach
    </div>



    <!-- Modal para Registrar Proveedor -->
    @if($createMode)
        <div x-data="{ open: true }" x-show="open" @click.away="open = false" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                <h3 class="text-xl font-semibold text-blue-600 mb-4">Registrar Proveedor</h3>

                <form wire:submit.prevent="save">
                    <div class="mb-4">
                        <label class="block text-sm text-gray-700">Nombre</label>
                        <input type="text" wire:model="nombre" class="w-full px-4 py-2 border rounded-md" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm text-gray-700">Teléfono</label>
                        <input type="text" wire:model="telefono" class="w-full px-4 py-2 border rounded-md" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm text-gray-700">Email</label>
                        <input type="email" wire:model="email" class="w-full px-4 py-2 border rounded-md" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm text-gray-700">Dirección</label>
                        <input type="text" wire:model="direccion" class="w-full px-4 py-2 border rounded-md" required>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg">Registrar</button>
                        <button type="button" wire:click="$set('createMode', false)" class="ml-2 text-gray-500">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Modal de Edición de Proveedor -->
    @if($editMode)
        <div x-data="{ open: true }" x-show="open" @click.away="open = false" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                <h3 class="text-xl font-semibold text-blue-600 mb-4">Editar Proveedor</h3>

                <form wire:submit.prevent="updateProveedor">
                    <div class="mb-4">
                        <label class="block text-sm text-gray-700">Nombre</label>
                        <input type="text" wire:model="nombre" class="w-full px-4 py-2 border rounded-md" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm text-gray-700">Teléfono</label>
                        <input type="text" wire:model="telefono" class="w-full px-4 py-2 border rounded-md" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm text-gray-700">Email</label>
                        <input type="email" wire:model="email" class="w-full px-4 py-2 border rounded-md" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm text-gray-700">Dirección</label>
                        <input type="text" wire:model="direccion" class="w-full px-4 py-2 border rounded-md" required>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg">Actualizar</button>
                        <button type="button" @click="open = false" class="ml-2 text-gray-500">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
