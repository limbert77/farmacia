<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold text-blue-600 mb-6 text-center">Lista de Medicamentos</h2>
    <div class="text-center mb-6">
        <button wire:click="abrirModalRegistro" class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow-md">
            Registrar Medicamento
        </button>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4 gap-6">
        @foreach($medicamentos as $medicamento)
        <div class="bg-white shadow-lg rounded-lg p-5 border border-blue-200">
            @if ($medicamento->imagen)
                <div class="flex justify-center mb-2">
                    <img src="{{ asset('storage/' . $medicamento->imagen) }}" class="w-32 h-32 object-cover">
                </div>
            @endif

            <h3 class="text-xl font-semibold text-blue-600 mb-2">{{ $medicamento->nombre }}</h3>
            <p class="text-gray-700 text-sm mb-2">{{ $medicamento->descripcion ?? 'Sin descripción' }}</p>
            <div class="flex justify-between items-center mb-2">
                <span class="text-sm font-medium text-gray-500">Precio:</span>
                <span class="text-lg font-bold text-blue-600">Bs. {{ number_format($medicamento->precio, 2) }}</span>
            </div>
            <div class="flex justify-between items-center mb-2">
                <span class="text-sm font-medium text-gray-500">Stock:</span>
                <span class="text-sm font-semibold text-gray-700">{{ $medicamento->stock }}</span>
            </div>
            <div class="flex justify-between items-center mb-2">
                <span class="text-sm font-medium text-gray-500">Proveedor:</span>
                <span class="text-sm font-semibold text-gray-700">{{ $medicamento->proveedor->nombre ?? 'N/A' }}</span>
            </div>
            <div class="flex justify-between items-center mb-2">
                <span class="text-sm font-medium text-gray-500">Fecha de Vencimiento:</span>
                <span class="text-sm font-semibold text-gray-700">{{ $medicamento->fecha_vencimiento ?? 'N/A' }}</span>
            </div>
            <div class="flex justify-between items-center mb-2">
                <span class="text-sm font-medium text-gray-500">Categoría:</span>
                <span class="px-2 py-1 text-sm font-semibold text-white bg-blue-600 rounded">
                    {{ ucfirst($medicamento->categoria) }}
                </span>
            </div>
            <div class="mb-2">
                <span class="text-sm font-medium">
                    Requiere Receta:
                    <span class="{{ $medicamento->requiere_receta ? 'text-green-500' : 'text-gray-600' }}">
                        {{ $medicamento->requiere_receta ? 'Sí' : 'No' }}
                    </span>
                </span>
            </div>

            <div class="text-right">
                <button wire:click="editMedicamento({{ $medicamento->id }})" class="bg-yellow-500 text-white px-4 py-2 rounded-lg shadow-md">Editar</button>
            </div>
        </div>
        @endforeach
    </div>


    <!-- Modal para registrar o editar medicamento -->
<div x-data="{ open: @entangle('modalOpen') }"
    x-show="open"
    @click.away="open = false"
    class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50">

    <div class="bg-white p-6 rounded-lg shadow-lg w-[800px]">
    <h3 class="text-xl font-semibold text-blue-600 mb-4 text-center">
        @if($editMode) Editar Medicamento @else Registrar Medicamento @endif
    </h3>

    <form wire:submit.prevent="{{ $editMode ? 'updateMedicamento' : 'registrarMedicamento' }}">
        <div class="grid grid-cols-2 gap-6">

            <!-- Columna Izquierda -->
            <div>
                <div class="mb-4">
                    <label class="block text-sm text-gray-700">Nombre</label>
                    <input type="text" wire:model="nombre" class="w-full px-4 py-2 border rounded-md" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm text-gray-700">Descripción</label>
                    <textarea wire:model="descripcion" class="w-full px-4 py-2 border rounded-md" rows="3"></textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-sm text-gray-700">Imagen</label>
                    <input type="file" wire:model="imagen" class="w-full px-4 py-2 border rounded-md">
                    @if ($imagen)
                        <img src="{{ $imagen->temporaryUrl() }}" class="mt-2 w-32 h-32 object-cover">
                    @elseif ($editMode && $imagenActual)
                        <img src="{{ asset('storage/' . $imagenActual) }}" class="mt-2 w-32 h-32 object-cover">
                    @endif
                </div>

                <div class="mb-4">
                    <label class="block text-sm text-gray-700">Precio</label>
                    <input type="number" wire:model="precio" class="w-full px-4 py-2 border rounded-md" step="0.01" required>
                </div>
            </div>

            <!-- Columna Derecha -->
            <div>
                <div class="mb-4">
                    <label class="block text-sm text-gray-700">Requiere Receta</label>
                    <input type="checkbox" wire:model="requiere_receta" class="mr-2">
                    <span class="text-sm text-gray-600">Sí</span>
                </div>

                <div class="mb-4">
                    <label class="block text-sm text-gray-700 mb-2">Proveedor</label>
                    <div class="grid grid-cols-2 gap-4 max-h-48 overflow-y-auto">
                        @foreach($proveedores as $proveedor)
                        <div wire:click="seleccionarProveedor({{ $proveedor->id }})"
                            class="cursor-pointer border p-3 rounded-lg shadow-md
                                    {{ $id_proveedor == $proveedor->id ? 'bg-blue-500 text-white' : 'bg-white' }}">
                            <h4 class="font-semibold">{{ $proveedor->nombre }}</h4>
                            <p class="text-sm">{{ $proveedor->direccion }}</p>
                        </div>
                        @endforeach
                    </div>
                    @error('id_proveedor') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm text-gray-700">Fecha de Vencimiento</label>
                    <input type="date" wire:model="fecha_vencimiento" class="w-full px-4 py-2 border rounded-md">
                </div>

                <div class="mb-4">
                    <label class="block text-sm text-gray-700">Categoría</label>
                    <select wire:model="categoria" class="w-full px-4 py-2 border rounded-md" required>
                        <option value="">Seleccione una categoría...</option>
                        <option value="analgésico">Analgésico</option>
                        <option value="antibiótico">Antibiótico</option>
                        <option value="antigripal">Antigripal</option>
                        <option value="antiinflamatorio">Antiinflamatorio</option>
                    </select>
                </div>
            </div>

        </div>

        <!-- Botones -->
        <div class="flex justify-end mt-4">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg">
                @if($editMode) Actualizar @else Registrar @endif
            </button>
            <button type="button" wire:click="cancelarEdicion" class="ml-2 text-gray-500">Cancelar</button>
        </div>
    </form>
    </div>
</div>


</div>
