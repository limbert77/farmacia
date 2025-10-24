<div class="p-4">
    <h2 class="text-2xl font-bold mb-4">Lista de Medicamentos</h2>
    <div class="mb-4 flex gap-2 flex-wrap">
        <button wire:click="filtrarPorCategoria(null)" class="px-4 py-2 bg-gray-300 text-black rounded flex items-center gap-1">
            <i class="fas fa-th-large text-lg"></i>
            Todos
        </button>
        <button wire:click="filtrarPorCategoria('analgésico')" class="px-4 py-2 bg-blue-500 text-white rounded flex items-center gap-1">
            <i class="fas fa-medkit text-lg"></i>
            Analgésico
        </button>
        <button wire:click="filtrarPorCategoria('antibiótico')" class="px-4 py-2 bg-blue-500 text-white rounded flex items-center gap-1">
            <i class="fas fa-pills text-lg"></i>
            Antibiótico
        </button>
        <button wire:click="filtrarPorCategoria('antigripal')" class="px-4 py-2 bg-blue-500 text-white rounded flex items-center gap-1">
            <i class="fas fa-thermometer-half text-lg"></i>
            Antigripal
        </button>
        <button wire:click="filtrarPorCategoria('antiinflamatorio')" class="px-4 py-2 bg-blue-500 text-white rounded flex items-center gap-1">
            <i class="fas fa-fire-alt text-lg"></i>
            Antiinflamatorio
        </button>
    </div>


    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
        @foreach($medicamentos as $medicamento)
            @php
                $fechaActual = now()->toDateString();
                $vencido = $medicamento->fecha_vencimiento && $medicamento->fecha_vencimiento <= $fechaActual;
            @endphp
            <div class="bg-white rounded-lg shadow-lg overflow-hidden border-4 {{ $vencido ? 'border-red-500' : 'border-transparent' }}">
                <div class="p-4">
                    @if ($medicamento->imagen)
                        <div class="flex justify-center mb-2">
                            <img src="{{ asset('storage/' . $medicamento->imagen) }}" class="w-32 h-32 object-cover">
                        </div>
                    @endif
                    <h3 class="text-xl font-bold text-blue-600">{{ $medicamento->nombre }}</h3>
                    <p class="text-gray-700 text-sm mb-2">{{ $medicamento->descripcion }}</p>
                    <p class="text-lg font-semibold text-green-500">${{ number_format($medicamento->precio, 2) }}</p>
                    <p class="text-sm font-bold {{ $medicamento->stock < 3 ? 'text-red-600' : 'text-gray-600' }}">
                        Stock: {{ $medicamento->stock }}
                        @if ($medicamento->stock < 3)
                            ⚠️
                        @endif
                    </p>
                    <p class="text-sm text-gray-600">
                        Fecha de Vencimiento:
                        <span class="font-bold {{ $vencido ? 'text-red-600' : 'text-gray-700' }}">
                            {{ $medicamento->fecha_vencimiento ?? 'N/A' }}
                        </span>
                    </p>
                    <p class="text-sm text-gray-600">
                        Requiere Receta:
                        <span class="{{ $medicamento->requiere_receta ? 'text-green-500' : 'font-bold' }}">
                            {{ $medicamento->requiere_receta ? 'Sí' : 'No' }}
                        </span>
                    </p>
                    <p class="text-sm text-gray-600">Categoría: <span class="font-bold">{{ ucfirst($medicamento->categoria) }}</span></p>
                    <p class="text-sm text-gray-600">Proveedor: <span class="font-bold">{{ $medicamento->proveedor->nombre ?? 'Desconocido' }}</span></p>
                </div>
            </div>
        @endforeach
    </div>
</div>
