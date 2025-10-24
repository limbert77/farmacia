<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\UserModel;
class CrudUsuarios extends Component
{
    public $nombre;
    public $apellido;
    public $email;
    public $contraseña;
    public $rol;
    public $estado = true;
    public $createMode = false;
    public $editMode = false;
    public $usuarioId;

    public function render()
    {
        $usuarios = UserModel::all();

        return view('livewire.crud-usuarios', [
            'usuarios' => $usuarios,
        ]);
    }
    public function openCreateModal()
    {
        $this->resetInputs();
        $this->createMode = true;
        $this->editMode = false;
    }
    public function openEditModal($id)
    {
        $usuario = UserModel::find($id);

        if ($usuario) {
            $this->usuarioId = $usuario->id;
            $this->nombre = $usuario->nombre;
            $this->apellido = $usuario->apellido;
            $this->email = $usuario->email;
            $this->rol = $usuario->rol;
            $this->estado = $usuario->estado;

            $this->createMode = false;
            $this->editMode = true;
        }
    }
    public function closeModal()
    {
        $this->createMode = false;
        $this->editMode = false;
    }
    public function save()
    {
        $this->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email,' . ($this->usuarioId ?? 'NULL') . ',id',
            'contraseña' => 'nullable|string|min:6',
            'rol' => 'required|string|in:admin,vendedor,farmacéutico',
            'estado' => 'required|boolean',
        ]);

        if ($this->usuarioId) {
            $usuario = UserModel::find($this->usuarioId);
            $usuario->update([
                'nombre' => $this->nombre,
                'apellido' => $this->apellido,
                'email' => $this->email,
                'contraseña' => $this->contraseña ? bcrypt($this->contraseña) : $usuario->contraseña,
                'rol' => $this->rol,
                'estado' => $this->estado,
            ]);
        } else {
            UserModel::create([
                'nombre' => $this->nombre,
                'apellido' => $this->apellido,
                'email' => $this->email,
                'contraseña' => bcrypt($this->contraseña),
                'rol' => $this->rol,
                'estado' => $this->estado,
            ]);
        }

        $this->resetInputs();
        $this->closeModal();

        session()->flash('message', 'Usuario guardado con éxito.');
    }


    private function resetInputs()
    {
        $this->nombre = '';
        $this->apellido = '';
        $this->email = '';
        $this->contraseña = '';
        $this->rol = '';
        $this->estado = true;
    }
}
