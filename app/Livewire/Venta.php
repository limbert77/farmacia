<?php

namespace App\Livewire;

use App\Models\clienteModel;
use App\Models\detalleVentaModel;
use App\Models\MedicamentoModel;
use App\Models\ventaModel;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;



class Venta extends Component
{
    public $categoria = null;
    public $proveedor = null;
    public $nombre;
    public $apellido;
    public $telefono;
    public $email;
    public $cinit;
    public $clienteSeleccionado = null;
    public $medicamento_id;
    public $cliente_id;
    public $busqueda = '';
    public $clientes = [];
    public $cantidad;
    public $costo_unitario;
    public $subtotal = 0;
    public $total = 0;
    public $carrito = [];
    public $modalVisible = false;
    public $categorias = ['analgésico', 'antibiótico', 'antigripal', 'antiinflamatorio'];
    public function filtrarPorCategoria($categoria)
    {
        $this->categoria = $categoria;
    }
    public function filtrarPorProveedor($proveedor)
    {
        $this->proveedor = $proveedor;
    }
    public function render()
    {
        $medicamentos = MedicamentoModel::query();

        if ($this->categoria) {
            $medicamentos->where('categoria', $this->categoria);
        }

        $clientes = clienteModel::all();

        return view('livewire.venta', [
            'medicamentos' => $medicamentos->get(), 'clientes' => $clientes
        ]);
    }
    public function selectMedicamento($medicamentoId)
    {
        $medicamento = MedicamentoModel::find($medicamentoId);
        if (!$medicamento) return;
        if (isset($this->carrito[$medicamentoId])) {
            $this->carrito[$medicamentoId]['cantidad'] += 1;
            $this->carrito[$medicamentoId]['subtotal'] = $medicamento->precio * $this->carrito[$medicamentoId]['cantidad'];
        } else {
            $this->carrito[$medicamentoId] = [
                'id' => $medicamento->id,
                'nombre' => $medicamento->nombre,
                'precio' => $medicamento->precio,
                'cantidad' => 1,
                'subtotal' => $medicamento->precio,
            ];
        }

        $this->calcularTotal();
    }
    public function generarFacturaPDF($ventaId)
    {
        $venta = ventaModel::with('cliente', 'detalleVentas.medicamento')->findOrFail($ventaId);
        $usuario = Auth::user();
        $pdf = Pdf::loadView('factura', compact('venta', 'usuario'));
        $path = 'facturas/factura_' . $venta->id . '.pdf';
        Storage::put('public/' . $path, $pdf->output());
        return response()->streamDownload(
            fn () => print($pdf->output()),
            'factura_' . $venta->id . '.pdf'
        );
    }
    public function aumentarCantidad($medicamentoId)
    {
        if (isset($this->carrito[$medicamentoId])) {
            $medicamento = MedicamentoModel::find($medicamentoId);
            if ($medicamento && $this->carrito[$medicamentoId]['cantidad'] < $medicamento->stock) {
                $this->carrito[$medicamentoId]['cantidad']++;
                $this->carrito[$medicamentoId]['subtotal'] = $this->carrito[$medicamentoId]['cantidad'] * $medicamento->precio;
                $this->calcularTotal();
            } else {
                session()->flash('message', 'No hay suficiente stock para aumentar la cantidad.');
            }
        }
    }
    public function disminuirCantidad($medicamentoId)
    {
        if (isset($this->carrito[$medicamentoId]) && $this->carrito[$medicamentoId]['cantidad'] > 1) {
            $this->carrito[$medicamentoId]['cantidad']--;
            $this->carrito[$medicamentoId]['subtotal'] = $this->carrito[$medicamentoId]['cantidad'] * $this->carrito[$medicamentoId]['precio'];
            $this->calcularTotal();
        } else {
            $this->eliminarDelCarrito($medicamentoId);
        }
    }
    public function eliminarDelCarrito($medicamentoId)
    {
        unset($this->carrito[$medicamentoId]);
        $this->calcularTotal();
    }
    public function calcularTotal()
    {
        $this->total = array_sum(array_column($this->carrito, 'subtotal'));
    }
    public function showModal()
    {
        $this->modalVisible = true;
    }
    public function closeModal()
    {
        $this->modalVisible = false;
    }
    public function resetModalFields()
    {
        $this->reset(['nombre', 'apellido', 'telefono', 'email', 'cinit']);
    }
    public function guardarVenta(){
        if (empty($this->carrito) || empty($this->clienteSeleccionado)) {
            session()->flash('message', 'El carrito está vacío o no se ha seleccionado un cliente.');
            return;
        }
        $venta = new ventaModel();
        $venta->id_cliente = $this->clienteSeleccionado->id;
        $venta->id_usuario = Auth::user()->id;
        $venta->total = $this->total;
        $venta->save();
        foreach ($this->carrito as $item) {
            $detalleVenta = new detalleVentaModel();
            $detalleVenta->id_venta = $venta->id;
            $detalleVenta->id_medicamento = $item['id'];
            $detalleVenta->cantidad = $item['cantidad'];
            $detalleVenta->subtotal = $item['subtotal'];
            $detalleVenta->save();
            $medicamento = MedicamentoModel::find($item['id']);
            if ($medicamento) {
                $medicamento->stock -= $item['cantidad'];
                $medicamento->save();
            }
        }
        session()->flash('message', 'Venta registrada correctamente.');
        $this->reset(['clienteSeleccionado', 'total', 'carrito']);
        return $this->generarFacturaPDF($venta->id);
    }
    public function buscarCliente()
    {
        $this->clientes = clienteModel::whereRaw('LOWER(nombre) LIKE ?', ['%' . strtolower($this->busqueda) . '%'])
            ->orWhereRaw('LOWER(apellido) LIKE ?', ['%' . strtolower($this->busqueda) . '%'])
            ->orWhereRaw('LOWER(telefono) LIKE ?', ['%' . strtolower($this->busqueda) . '%'])
            ->orWhereRaw('LOWER(email) LIKE ?', ['%' . strtolower($this->busqueda) . '%'])
            ->orWhereRaw('LOWER(cinit) LIKE ?', ['%' . strtolower($this->busqueda) . '%'])
            ->get();
    }
    public function seleccionarCliente($id)
    {
        $this->clienteSeleccionado = clienteModel::find($id);
        $this->busqueda = '';
        $this->clientes = [];
    }
    public function deseleccionarCliente()
    {
        $this->clienteSeleccionado = null;
    }
    public function saveCliente(){
        $cliente = new clienteModel();
        $cliente->nombre = $this->nombre;
        $cliente->apellido = $this->apellido;
        $cliente->telefono = $this->telefono;
        $cliente->email = $this->email;
        $cliente->cinit = $this->cinit;
        $cliente->save();
        $this->modalVisible = false;
        $this->resetModalFields();
    }
}
