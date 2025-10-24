<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\MedicamentoModel;

class CrudHome extends Component
{
    public $categoria = null;
    public $proveedor = null;

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

        if ($this->proveedor) {
            $medicamentos->where('id_proveedor', $this->proveedor);
        }

        return view('livewire.crud-home', [
            'medicamentos' => $medicamentos->get()
        ]);
    }
}
