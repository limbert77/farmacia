<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ProveedorModel;

class EditProveedor extends Component
{
    public $proveedores;
    public $isModalOpen = false;
    public $proveedorId, $nombre, $telefono, $email, $direccion;

    public function mount()
    {
        $this->proveedores = ProveedorModel::all();
    }

    public function render()
    {
        return view('livewire.edit-proveedor');
    }

    public function edit($id)
    {
        $proveedor = ProveedorModel::find($id);
        $this->proveedorId = $proveedor->id;
        $this->nombre = $proveedor->nombre;
        $this->telefono = $proveedor->telefono;
        $this->email = $proveedor->email;
        $this->direccion = $proveedor->direccion;
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    public function updateProveedor()
    {
        $proveedor = ProveedorModel::find($this->proveedorId);
        $proveedor->nombre = $this->nombre;
        $proveedor->telefono = $this->telefono;
        $proveedor->email = $this->email;
        $proveedor->direccion = $this->direccion;
        $proveedor->save();

        $this->isModalOpen = false;

        return redirect()->route('proveedores.edit');
    }
}
