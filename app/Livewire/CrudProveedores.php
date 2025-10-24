<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ProveedorModel;

class CrudProveedores extends Component
{
    public $nombre, $telefono, $email, $direccion;
    public $editMode = false;
    public $createMode = false;
    public $proveedorId;

    protected $rules = [
        'nombre' => 'required|string|max:255',
        'telefono' => 'required|string|max:20',
        'email' => 'required|email|unique:proveedores,email',
        'direccion' => 'required|string',
    ];

    public function save()
    {
        $this->validate();

        ProveedorModel::create([
            'nombre' => $this->nombre,
            'telefono' => $this->telefono,
            'email' => $this->email,
            'direccion' => $this->direccion,
        ]);

        session()->flash('message', 'Proveedor registrado correctamente.');
        $this->reset(['nombre', 'telefono', 'email', 'direccion']);
        $this->createMode = false;
    }

    public function editProveedor($id)
    {
        $this->editMode = true;
        $proveedor = ProveedorModel::find($id);
        $this->proveedorId = $proveedor->id;
        $this->nombre = $proveedor->nombre;
        $this->telefono = $proveedor->telefono;
        $this->email = $proveedor->email;
        $this->direccion = $proveedor->direccion;
    }

    public function updateProveedor()
    {
        $this->validate();

        $proveedor = ProveedorModel::find($this->proveedorId);
        $proveedor->update([
            'nombre' => $this->nombre,
            'telefono' => $this->telefono,
            'email' => $this->email,
            'direccion' => $this->direccion,
        ]);

        session()->flash('message', 'Proveedor actualizado correctamente.');
        $this->reset(['nombre', 'telefono', 'email', 'direccion']);
        $this->editMode = false;
    }

    public function render()
    {
        $proveedores = ProveedorModel::all();

        return view('livewire.crud-proveedores', [
            'proveedores' => $proveedores,
        ]);
    }
}
