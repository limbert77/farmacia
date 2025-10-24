<div class="container mx-auto mt-10">
    <div class="max-w-lg mx-auto bg-white p-6 rounded shadow-lg">
        <h2 class="text-2xl font-bold text-center mb-4">Registrar Usuario</h2>
        @if (session()->has('message'))
            <div class="mb-4 p-3 text-green-700 bg-green-100 rounded">
                {{ session('message') }}
            </div>
        @endif

        <form wire:submit.prevent="saveUser">
            <div class="mb-4">
                <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                <input type="text" id="nombre" wire:model="nombre" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                @error('nombre') <span class="text-blue-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="apellido" class="block text-sm font-medium text-gray-700">Apellidos</label>
                <input type="text" id="apellido" wire:model="apellido" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                @error('apellido') <span class="text-blue-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" wire:model="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                @error('email') <span class="text-blue-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                <input type="password" id="password" wire:model="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                @error('password') <span class="text-blue-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar Contraseña</label>
                <input type="password" id="password_confirmation" wire:model="password_confirmation" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
            </div>

            <div class="mb-4">
                <label for="estado" class="block text-sm font-medium text-gray-700">Estado</label>
                <select wire:model="estado" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                    <option value="1">Seleccione el estado...</option>
                    <option value="1">Activo</option>
                    <option value="0">Inactivo</option>
                </select>
                @error('estado') <span class="text-blue-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="rol" class="block text-sm font-medium text-gray-700">Rol</label>
                <select wire:model="rol" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                    <option value="...">Seleccione el rol...</option>
                    <option value="admin">Administrador</option>
                    <option value="vendedor">Vendedor</option>
                    <option value="farmacéutico">Farmacéutico</option>
                </select>
                @error('rol') <span class="text-blue-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 text-white rounded bg-blue-600">Guardar</button>
            </div>
        </form>
    </div>
</div>
