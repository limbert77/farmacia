<div>
    <div class="min-h-screen bg-gray-50 p-4">
      <div class="max-w-7xl mx-auto">
        <div class="mb-8">
          <div class="flex space-x-6 border-b-2 border-gray-200 pb-4 overflow-x-auto">
            <button wire:click="filtrarPorCategoria(null)" class="px-6 py-2 text-blue-600 font-medium hover:bg-blue-50 rounded-lg focus:outline-none whitespace-nowrap">Todos</button>
            <button wire:click="filtrarPorCategoria('analgésico')" class="px-6 py-2 text-gray-500 font-medium hover:bg-blue-50 rounded-lg focus:outline-none whitespace-nowrap">Analgésico</button>
            <button wire:click="filtrarPorCategoria('antibiótico')" class="px-6 py-2 text-gray-500 font-medium hover:bg-blue-50 rounded-lg focus:outline-none whitespace-nowrap">Antibiótico</button>
            <button wire:click="filtrarPorCategoria('antigripal')" class="px-6 py-2 text-gray-500 font-medium hover:bg-blue-50 rounded-lg focus:outline-none whitespace-nowrap">Antigripal</button>
            <button wire:click="filtrarPorCategoria('antiinflamatorio')" class="px-6 py-2 text-gray-500 font-medium hover:bg-blue-50 rounded-lg focus:outline-none whitespace-nowrap">Antiinflamatorio</button>
          </div>
        </div>
        <div class="flex flex-col lg:flex-row gap-12">
          <div class="w-full lg:w-2/3 min-h-[400px]">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
              @forelse ($medicamentos as $medicamento)
                @php
                  $fechaActual = now()->toDateString();
                  $vencido = $medicamento->fecha_vencimiento && $medicamento->fecha_vencimiento <= $fechaActual;
                @endphp
                @if ($medicamento->stock > 0)
                <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow">
                  <div class="bg-blue-100 h-40 rounded-lg mb-4 flex items-center justify-center">
                    @if ($medicamento->imagen)
                      <img src="{{ asset('storage/' . $medicamento->imagen) }}" class="w-full h-full object-cover rounded-lg">
                    @else
                      <span class="text-gray-500">Sin imagen</span>
                    @endif
                  </div>
                  <h3 class="font-semibold text-lg text-gray-800 mb-2">{{ $medicamento->nombre }}</h3>
                  <p class="text-gray-600 mb-4">{{ $medicamento->descripcion ?? 'Sin descripción' }}</p>
                  <h3 class="font-semibold text-lg text-gray-800 mb-2">Stock: {{ $medicamento->stock }}</h3>
                  @if ($medicamento->requiere_receta == true)
                    <div class="bg-red-600 m-2"><h2 class="text-white">Necesita receta</h2></div>
                  @endif
                  <div class="flex justify-between items-center">
                    <span class="font-semibold text-blue-600">Bs. {{ number_format($medicamento->precio, 2) }}</span>
                    <button wire:click="selectMedicamento({{ $medicamento->id }})" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 focus:outline-none">Agregar</button>
                  </div>
                </div>
                @endif
              @empty
                <div class="col-span-full text-center py-12">
                  <div class="bg-white p-8 rounded-xl shadow-md max-w-md mx-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">No hay productos disponibles</h3>
                    <p class="mt-2 text-gray-500">No encontramos medicamentos en esta categoría.</p>
                    <button wire:click="filtrarPorCategoria(null)" class="mt-6 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                      Ver todos los productos
                    </button>
                  </div>
                </div>
              @endforelse
            </div>
          </div>
          <div class="w-full lg:w-1/3 bg-white p-6 rounded-xl shadow-lg">
            <div class="space-y-6">
              <div>
                <div class="flex justify-between">
                  <input type="text" wire:model.debounce.300ms="busqueda" wire:keydown.enter="buscarCliente" class="mr-2 w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600" placeholder="Buscar cliente...">
                  <button wire:click="buscarCliente" class="mb-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 focus:outline-none">
                    Buscar
                  </button>
                  <button wire:click="showModal" class="mb-2 bg-blue-600 text-white ml-2 px-4 py-2 rounded-lg hover:bg-blue-700 focus:outline-none">
                    <i class="fa-solid fa-user-plus"></i>
                  </button>
                </div>
                @if($busqueda && $clientes != null)
                  <div class="mt-2 bg-white border border-gray-200 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                    @foreach($clientes as $c)
                      <div wire:click="seleccionarCliente({{ $c->id }})" class="p-3 hover:bg-blue-50 cursor-pointer {{ $clienteSeleccionado?->id == $c->id ? 'bg-blue-100' : '' }}">
                        {{ $c->nombre }} {{ $c->apellido }}
                        @if($c->cinit)
                          <span class="text-sm text-gray-500">({{ $c->cinit }})</span>
                        @endif
                      </div>
                    @endforeach
                  </div>
                @elseif($busqueda && !$clientes->isEmpty())
                  <p class="mt-2 text-gray-500">No se encontraron clientes</p>
                @endif
                @if($clienteSeleccionado)
                  <div class="mt-4 p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                    <div class="flex items-center space-x-4">
                      <i class="fas fa-user-circle text-4xl text-blue-600 mb-2"></i>
                      <div>
                        <p class="font-medium text-lg text-gray-800">{{ $clienteSeleccionado->nombre }} {{ $clienteSeleccionado->apellido }}</p>
                        <p class="text-sm text-gray-600">Teléfono: {{ $clienteSeleccionado->telefono }}</p>
                        <p class="text-sm text-gray-600">Email: {{ $clienteSeleccionado->email }}</p>
                        <p class="text-sm text-gray-600">CI/NIT: {{ $clienteSeleccionado->cinit }}</p>
                      </div>
                    </div>
                    <button wire:click="deseleccionarCliente" class="mt-2 text-sm text-red-600 hover:text-red-800">
                      Cambiar cliente
                    </button>
                  </div>
                @endif
              </div>
              <h2 class="text-xl font-semibold text-gray-800 mb-4">Carrito de Compras</h2>
              @foreach ($carrito as $item)
                <div class="bg-gray-50 p-4 rounded-lg">
                  <div class="flex justify-between items-center">
                    <div>
                      <h3 class="font-medium text-gray-800">{{ $item['nombre'] }}</h3>
                      <td class="p-2">
                        <button wire:click="disminuirCantidad({{ $item['id'] }})" class="px-2 bg-gray-300 rounded">-</button>
                        {{ $item['cantidad'] }}
                        <button wire:click="aumentarCantidad({{ $item['id'] }})" class="px-2 bg-gray-300 rounded">+</button>
                        <button wire:click="eliminarDelCarrito({{ $item['id'] }})" class="px-2 bg-red-600 rounded text-white">x</button>
                      </td>
                    </div>
                    <div class="text-right">
                      <p class="font-medium text-gray-800">Bs. {{ $item['precio']}}</p>
                      <p class="text-sm text-gray-500">SubTotal: {{ $item['subtotal'] }}</p>
                    </div>
                  </div>
                </div>
              @endforeach
              <div class="pt-4 border-t-2 border-gray-200">
                <div class="flex justify-between font-semibold text-lg text-gray-800">
                  <span>Total:</span>
                  <span>Bs. {{ $total }}</span>
                </div>
                <button
                  wire:click="guardarVenta"
                  class="w-full py-3 rounded-lg mt-4 focus:outline-none
                    {{ empty($carrito) || empty($clienteSeleccionado->id) ? 'bg-gray-400 cursor-not-allowed' : 'bg-blue-600 hover:bg-blue-700 text-white' }}"
                  @if (empty($carrito) || empty($clienteSeleccionado->id))
                    disabled
                  @endif
                >
                  Finalizar Compra
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @if($modalVisible)
      <div class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
          <h3 class="text-xl font-semibold text-blue-600 mb-4">Registrar cliente</h3>

          <form wire:submit.prevent="saveCliente">
            <div class="mb-4">
              <label class="block text-sm text-gray-700">Nombre</label>
              <input type="text" wire:model="nombre" class="w-full px-4 py-2 border rounded-md" required>
            </div>
            <div class="mb-4">
              <label class="block text-sm text-gray-700">Apellido</label>
              <input type="text" wire:model="apellido" class="w-full px-4 py-2 border rounded-md" required>
            </div>
            <div class="mb-4">
              <label class="block text-sm text-gray-700">Telefono</label>
              <input type="text" wire:model="telefono" class="w-full px-4 py-2 border rounded-md" required>
            </div>
            <div class="mb-4">
              <label class="block text-sm text-gray-700">Email</label>
              <input type="email" wire:model="email" class="w-full px-4 py-2 border rounded-md">
            </div>
            <div class="mb-4">
              <label class="block text-sm text-gray-700">CI/NIT</label>
              <input type="text" wire:model="cinit" class="w-full px-4 py-2 border rounded-md">
            </div>
            <div class="flex justify-end">
              <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg">Registrar</button>
              <button type="button" wire:click="closeModal" class="ml-2 text-gray-500">Cancelar</button>
            </div>
          </form>
        </div>
      </div>
    @endif
</div>
