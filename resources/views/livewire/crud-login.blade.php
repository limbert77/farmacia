<div>
    <div class="flex justify-center items-center mt-10">
        <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-md">
            <h1 class="text-2xl font-semibold text-center text-blue-600 mb-6">Iniciar Sesión</h1>
            <form wire:submit.prevent="login">
                @csrf
                <div class="mb-4 relative">
                    <label for="email" class="block text-lg font-medium text-gray-700">Correo Electrónico</label>
                    <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <input type="email" id="email" wire:model="email" placeholder="Ingrese su correo electrónico"
                        class="w-full p-3 pl-10 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600">
                    @error('email') <span class="text-blue-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-6 relative">
                    <label for="password" class="block text-lg font-medium text-gray-700">Contraseña</label>
                    <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                        <i class="fas fa-lock"></i>
                    </div>
                    <input type="password" id="password" wire:model="password" placeholder="Ingrese su contraseña"
                        class="w-full p-3 pl-10 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600">
                    @error('password') <span class="text-blue-600 text-sm">{{ $message }}</span> @enderror
                </div>

                @if(session()->has('error'))
                    <div class="text-blue-600 text-sm text-center mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="mb-4">
                    <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-md font-semibold hover:bg-white hover:text-blue-600 transition">
                        <i class="fas fa-sign-in-alt mr-2"></i> Iniciar Sesión
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
