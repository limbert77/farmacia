<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\MedicamentoModel;
use App\Models\ProveedorModel;
use Livewire\WithFileUploads;

class CrudMedicamentos extends Component
{
    use WithFileUploads;

    public $imagen;
    public $medicamentos;
    public $proveedores;
    public $nombre, $descripcion, $precio, $stock, $requiere_receta, $id_proveedor, $fecha_vencimiento, $categoria;
    public $modalOpen = false;
    public $editMode = false;
    public $medicamentoId;
    public $imagenActual;


    public function mount()
    {
        $this->medicamentos = MedicamentoModel::with('proveedor')->get();
        $this->proveedores = ProveedorModel::all();
    }
    public function registrarMedicamento()
    {
        $this->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:500',
            'precio' => 'required|numeric',
            'requiere_receta' => 'nullable|boolean',
            'id_proveedor' => 'required|exists:proveedores,id',
            'fecha_vencimiento' => 'nullable|date',
            'categoria' => 'required|string|in:analgésico,antibiótico,antigripal,antiinflamatorio',
            'imagen' => 'nullable|mimes:jpeg,png,jpg,webp,avif|max:10240',
        ]);


        $imagenPath = $this->imagen ? $this->imagen->store('medicamentos', 'public') : null;

        MedicamentoModel::create([
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'precio' => $this->precio,
            'stock' => 0,
            'requiere_receta' => $this->requiere_receta ?? 0,
            'id_proveedor' => $this->id_proveedor,
            'fecha_vencimiento' => $this->fecha_vencimiento,
            'categoria' => $this->categoria,
            'imagen' => $imagenPath,
        ]);

        $this->resetForm();
        $this->medicamentos = MedicamentoModel::with('proveedor')->get();
        $this->modalOpen = false;
    }



    public function editMedicamento($id)
    {
        $this->editMode = true;
        $medicamento = MedicamentoModel::find($id);
        $this->medicamentoId = $medicamento->id;
        $this->nombre = $medicamento->nombre;
        $this->descripcion = $medicamento->descripcion;
        $this->precio = $medicamento->precio;
        $this->stock = $medicamento->stock;
        $this->requiere_receta = (bool) $medicamento->requiere_receta;
        $this->id_proveedor = $medicamento->id_proveedor;
        $this->fecha_vencimiento = $medicamento->fecha_vencimiento;
        $this->categoria = $medicamento->categoria;
        $this->imagenActual = $medicamento->imagen;


        $this->modalOpen = true;
    }
    public function seleccionarProveedor($id)
    {
        $this->id_proveedor = $id;
    }
    public function updateMedicamento()
    {
        $this->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:500',
            'precio' => 'required|numeric',
            'stock' => 'required|integer',
            'requiere_receta' => 'boolean',
            'id_proveedor' => 'required|exists:proveedores,id',
            'fecha_vencimiento' => 'nullable|date',
            'categoria' => 'required|string|in:analgésico,antibiótico,antigripal,antiinflamatorio',
            'imagen' => 'nullable|mimes:jpeg,png,jpg,webp,avif|max:10240',
        ]);


        $medicamento = MedicamentoModel::find($this->medicamentoId);

        if ($medicamento) {
            if ($this->imagen) {
                $imagenPath = $this->imagen->store('medicamentos', 'public');
                $medicamento->imagen = $imagenPath;
            }

            $medicamento->update([
                'nombre' => $this->nombre,
                'descripcion' => $this->descripcion,
                'precio' => $this->precio,
                'stock' => $this->stock,
                'requiere_receta' => $this->requiere_receta ? 1 : 0,
                'id_proveedor' => $this->id_proveedor,
                'fecha_vencimiento' => $this->fecha_vencimiento,
                'categoria' => $this->categoria,
                'imagen' => $medicamento->imagen,
            ]);
        }

        $this->medicamentos = MedicamentoModel::with('proveedor')->get();
        $this->resetForm();
        $this->modalOpen = false;
        $this->editMode = false;
    }


    protected function resetForm()
    {
        $this->reset([
            'nombre', 'descripcion', 'precio', 'stock',
            'requiere_receta', 'id_proveedor', 'fecha_vencimiento',
            'categoria', 'imagen', 'imagenActual'
        ]);
    }

    public function abrirModalRegistro()
    {
        $this->resetForm();
        $this->editMode = false;
        $this->modalOpen = true;
    }

    public function cancelarEdicion()
    {
        $this->resetForm();
        $this->modalOpen = false;
        $this->editMode = false;
    }

    public function render()
    {
        return view('livewire.crud-medicamentos', [
            'medicamentos' => $this->medicamentos,
            'proveedores' => $this->proveedores,
        ]);
    }
}
