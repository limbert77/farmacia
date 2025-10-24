<div class="p-4">
    <h2 class="text-xl font-semibold mb-4">Registrar Compra</h2>

    @if (session()->has('message'))
        <div class="bg-green-500 text-white p-2 my-4 rounded">
            {{ session('message') }}
        </div>
    @endif

    <button wire:click="showModal" class="bg-green-500 text-white px-4 py-2 rounded-md mb-4">Registrar Medicamento</button>

    <div class="flex flex-col md:flex-row md:space-x-4">
        <div class="md:w-1/2">
            <form wire:submit.prevent="save">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Proveedor</label>
                    <div class="grid grid-cols-3 gap-4 mt-2">
                        @foreach($proveedores as $proveedor)
                            <div class="bg-white p-4 rounded shadow-md text-center border {{ $selectedProveedor == $proveedor->id ? 'border-blue-500' : '' }}">
                                <div class="text-center">
                                    <i class="fas fa-user-circle text-4xl text-blue-600 mb-2"></i>
                                    <h3 class="text-xl font-semibold text-blue-600 mb-2">{{ $proveedor->nombre }}</h3>
                                    <p class="text-sm text-gray-500">{{ $proveedor->telefono }}</p>
                                    <p class="text-sm text-gray-500">{{ $proveedor->email }}</p>
                                    <p class="text-sm text-gray-500">{{ $proveedor->direccion }}</p>
                                </div>
                                <button type="button" wire:click="selectProveedor({{ $proveedor->id }})" class="bg-blue-500 text-white px-4 py-2 mt-2 rounded">Seleccionar</button>
                            </div>
                        @endforeach
                    </div>
                </div>
                @if($selectedProveedor)
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Selecciona un Medicamento</label>
                        @if(count($medicamentos) > 0)
                            <div class="grid grid-cols-3 gap-4 mt-2">
                                @foreach($medicamentos as $medicamento)
                                    <div class="bg-white p-4 rounded shadow-md text-center border {{ $medicamento_id == $medicamento->id ? 'border-blue-500' : '' }}">
                                        <img src="{{ asset('storage/' . $medicamento->imagen) }}" class="w-full h-32 object-cover rounded" alt="{{ $medicamento->nombre }}">
                                        <h3 class="text-lg font-bold">{{ $medicamento->nombre }}</h3>
                                        <p class="text-sm text-gray-500">{{ $medicamento->descripcion }}</p>
                                        <p class="font-semibold">Precio: Bs.{{ number_format($medicamento->precio, 2) }}</p>
                                        <button type="button" wire:click="selectMedicamento({{ $medicamento->id }})" class="bg-blue-500 text-white px-4 py-2 mt-2 rounded">
                                            Agregar
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-600 text-center mt-4">No hay medicamentos disponibles para este proveedor.</p>
                        @endif
                    </div>
                @endif
            </form>
        </div>

        <!--Carrito de Compras -->
        <div class="md:w-1/2 mt-4 md:mt-0 border-l border-gray-300 pl-4 bg-white shadow">
            @if(count($carrito) > 0)
                <h2 class="text-lg font-semibold mb-2 flex items-center">
                    <i class="fas fa-shopping-cart text-xl mr-2 text-gray-700"></i>
                    Carrito de Compras
                </h2>
                <table class="w-full border">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="p-2">Medicamento</th>
                            <th class="p-2">Precio</th>
                            <th class="p-2">Cantidad</th>
                            <th class="p-2">Subtotal</th>
                            <th class="p-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($carrito as $item)
                            <tr>
                                <td class="p-2">{{ $item['nombre'] }}</td>
                                <td class="p-2">Bs.{{ number_format($item['precio'], 2) }}</td>
                                <td class="p-2">
                                    <button wire:click="disminuirCantidad({{ $item['id'] }})" class="px-2 bg-gray-300 rounded">-</button>
                                    {{ $item['cantidad'] }}
                                    <button wire:click="aumentarCantidad({{ $item['id'] }})" class="px-2 bg-gray-300 rounded">+</button>
                                </td>
                                <td class="p-2">Bs.{{ number_format($item['subtotal'], 2) }}</td>
                                <td class="p-2">
                                    <button wire:click="eliminarDelCarrito({{ $item['id'] }})" class="bg-red-500 text-white px-2 py-1 rounded">Eliminar</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <h3 class="text-lg font-semibold mt-2">Total: Bs.{{ number_format($total, 2) }}</h3>

                <button wire:click="confirmarCompra" class="bg-green-500 text-white px-4 py-2 rounded-md mt-2">Confirmar Compra</button>
            @else
                <p class="text-gray-600">El carrito está vacío.</p>
            @endif
        </div>
    </div>

    <!-- Registrar Medicamento -->
    @if($modalVisible)
        <div class="fixed inset-0 bg-gray-500 bg-opacity-50 flex justify-center items-center">
            <div class="bg-white p-6 rounded-md w-1/3">
                <h3 class="text-xl font-semibold mb-4">Registrar Medicamento</h3>

                <form wire:submit.prevent="saveMedicamento">
                    <div class="mb-4">
                        <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                        <input wire:model="nombre" type="text" id="nombre" class="mt-1 block w-full border-gray-300 rounded-md">
                    </div>
                    <div class="mb-4">
                        <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
                        <input wire:model="descripcion" type="text" id="descripcion" class="mt-1 block w-full border-gray-300 rounded-md">
                    </div>
                    <div class="mb-4">
                        <label for="imagen" class="block text-sm font-medium text-gray-700">Imagen</label>
                        <input type="file" wire:model="imagen" id="imagen" class="mt-1 block w-full border-gray-300 rounded-md">
                        @error('imagen') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    @if ($imagen)
                        <div class="mt-2">
                            <p>Vista previa:</p>
                            <img src="{{ $imagen->temporaryUrl() }}" class="w-full h-32 object-cover rounded">
                        </div>
                    @endif
                    <div class="mb-4">
                        <label for="precio" class="block text-sm font-medium text-gray-700">Precio</label>
                        <input wire:model="precio" type="number" id="precio" class="mt-1 block w-full border-gray-300 rounded-md" step="0.01">
                    </div>
                    <div class="mb-4">
                        <label for="fecha_vencimiento" class="block text-sm font-medium text-gray-700">Fecha de Vencimiento</label>
                        <input wire:model="fecha_vencimiento" type="date" id="fecha_vencimiento" class="mt-1 block w-full border-gray-300 rounded-md">
                    </div>
                    <div class="mb-4">
                        <label for="categoria" class="block text-sm font-medium text-gray-700">Categoría</label>
                        <select wire:model="categoria" id="categoria" class="mt-1 block w-full border-gray-300 rounded-md">
                            <option value="">Seleccione una categoría...</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria }}">{{ ucfirst($categoria) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Proveedor</label>
                        <div class="grid grid-cols-3 gap-4 mt-2">
                            @foreach($proveedores as $proveedor)
                                <div class="bg-white p-4 rounded shadow-md text-center border {{ $proveedor_modal_id == $proveedor->id ? 'border-blue-500' : '' }}">
                                    <h3 class="text-lg font-bold">{{ $proveedor->nombre }}</h3>
                                    <button type="button" wire:click="selectProveedorModal({{ $proveedor->id }})" class="bg-blue-500 text-white px-4 py-2 mt-2 rounded">Seleccionar</button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex justify-between">
                        <button type="button" wire:click="closeModal" class="bg-gray-500 text-white px-4 py-2 rounded-md">Cerrar</button>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
