<div>
    <h1 class="text-2xl font-bold mb-6">Proveedores Registrados</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($proveedores as $proveedor)
            <div class="bg-white shadow-md rounded-lg p-4">
                <div class="flex justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-16 h-16 text-gray-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 12c2.755 0 5-2.245 5-5S14.755 2 12 2s-5 2.245-5 5 2.245 5 5 5zM12 14c-4.418 0-8 2.239-8 5v2h16v-2c0-2.761-3.582-5-8-5z"/>
                    </svg>
                </div>
                <div class="text-center">
                    <h3 class="text-xl font-semibold text-gray-700">{{ $proveedor->nombre }}</h3>
                    <p class="text-sm text-gray-500">{{ $proveedor->telefono }}</p>
                    <p class="text-sm text-gray-500">{{ $proveedor->email }}</p>
                    <p class="text-sm text-gray-500">{{ $proveedor->direccion }}</p>
                </div>
                <div class="text-right">
                    <button wire:click="editProveedor({{ $proveedor->id }})" class="bg-yellow-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-yellow-600 transition-all duration-300">Editar</button>
                </div>
            </div>
        @endforeach
    </div>

    @if($isModalOpen)
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg w-96">
                <h2 class="text-xl font-semibold mb-4">Editar Proveedor</h2>

                <form wire:submit.prevent="updateProveedor">
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700">Nombre</label>
                        <input type="text" wire:model="nombre" class="mt-1 p-2 w-full border rounded-md">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700">Teléfono</label>
                        <input type="text" wire:model="telefono" class="mt-1 p-2 w-full border rounded-md">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700">Email</label>
                        <input type="email" wire:model="email" class="mt-1 p-2 w-full border rounded-md">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700">Dirección</label>
                        <input type="text" wire:model="direccion" class="mt-1 p-2 w-full border rounded-md">
                    </div>

                    <div class="flex justify-end space-x-4">
                        <button type="button" wire:click="closeModal" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg">Cerrar</button>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
