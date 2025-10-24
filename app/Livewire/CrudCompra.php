<?php

namespace App\Livewire;

use App\Models\CompraModel;
use App\Models\DetalleCompraModel;
use App\Models\MedicamentoModel;
use App\Models\ProveedorModel;
use Livewire\Component;
use Livewire\WithFileUploads;

class CrudCompra extends Component
{
    use WithFileUploads;

    public $imagen;
    public $proveedor_id;
    public $medicamento_id;
    public $cantidad;
    public $costo_unitario;
    public $subtotal = 0;
    public $total = 0;
    public $proveedores;
    public $medicamentos = [];
    public $carrito = [];
    public $proveedor_modal_id;
    public $categorias = ['analgésico', 'antibiótico', 'antigripal', 'antiinflamatorio'];
    public $selectedProveedor = null;
    public $modalVisible = false;
    public $nombre, $descripcion, $precio, $stock, $fecha_vencimiento, $categoria;
    public function mount()
    {
        $this->proveedores = ProveedorModel::all();
        $this->medicamentos = MedicamentoModel::all();
    }
    public function selectProveedor($proveedorId)
    {
        $this->selectedProveedor = $proveedorId;
        $this->medicamentos = MedicamentoModel::where('id_proveedor', $proveedorId)->get();
    }
    public function selectMedicamento($medicamentoId)
    {
        $medicamento = MedicamentoModel::find($medicamentoId);
        if (!$medicamento) return;
        if (isset($this->carrito[$medicamentoId])) {
            $this->carrito[$medicamentoId]['cantidad'] += 1;
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
    public function aumentarCantidad($medicamentoId)
    {
        if (isset($this->carrito[$medicamentoId])) {
            $this->carrito[$medicamentoId]['cantidad']++;
            $this->carrito[$medicamentoId]['subtotal'] = $this->carrito[$medicamentoId]['cantidad'] * $this->carrito[$medicamentoId]['precio'];
            $this->calcularTotal();
        }
    }
    public function disminuirCantidad($medicamentoId)
    {
        if (isset($this->carrito[$medicamentoId]) && $this->carrito[$medicamentoId]['cantidad'] > 1) {
            $this->carrito[$medicamentoId]['cantidad']--;
            $this->carrito[$medicamentoId]['subtotal'] = $this->carrito[$medicamentoId]['cantidad'] * $this->carrito[$medicamentoId]['precio'];
            $this->calcularTotal();
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
    public function saveMedicamento()
    {
        $this->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:255',
            'precio' => 'required|numeric|min:0',
            'fecha_vencimiento' => 'required|date',
            'categoria' => 'required|string|max:255',
            'proveedor_modal_id' => 'required|exists:proveedores,id',
            'imagen' => 'nullable|image|max:2048',
        ]);

        $imagenPath = $this->imagen ? $this->imagen->store('medicamentos', 'public') : null;

        MedicamentoModel::create([
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'precio' => $this->precio,
            'stock' => 0,
            'fecha_vencimiento' => $this->fecha_vencimiento,
            'categoria' => $this->categoria,
            'id_proveedor' => $this->proveedor_modal_id,
            'imagen' => $imagenPath,
        ]);

        $this->reset(['nombre', 'descripcion', 'precio', 'fecha_vencimiento', 'categoria', 'proveedor_modal_id', 'imagen']);
        $this->modalVisible = false;
        session()->flash('message', 'Medicamento registrado exitosamente');
    }
    public function selectProveedorModal($proveedorId)
    {
        $this->proveedor_modal_id = $proveedorId;
    }
    public function resetModalFields()
    {
        $this->nombre = '';
        $this->descripcion = '';
        $this->precio = '';
        $this->stock = '';
        $this->fecha_vencimiento = '';
        $this->categoria = '';
    }
    public function render()
    {
        return view('livewire.crud-compra');
    }
    public function confirmarCompra()
    {
        if (empty($this->carrito)) {
            session()->flash('message', 'El carrito está vacío.');
            return;
        }

        $compra = CompraModel::create([
            'id_proveedor' => $this->selectedProveedor,
            'fecha_compra' => now(),
            'total' => $this->total,
        ]);

        foreach ($this->carrito as $item) {
            DetalleCompraModel::create([
                'id_compra' => $compra->id,
                'id_medicamento' => $item['id'],
                'cantidad' => $item['cantidad'],
                'costo_unitario' => $item['precio'],
                'subtotal' => $item['subtotal'],
            ]);

            $medicamento = MedicamentoModel::find($item['id']);
            $medicamento->stock += $item['cantidad'];
            $medicamento->save();
        }
        $this->reset(['carrito', 'total']);
        session()->flash('message', 'Compra realizada exitosamente.');
    }

}
