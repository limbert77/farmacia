<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\UserModel;
use Illuminate\Support\Facades\Hash;

class NewUser extends Component
{
    public $nombre, $apellido, $email, $password, $password_confirmation, $estado, $rol;
    protected $rules = [
        'nombre' => 'required|string|max:255',
        'apellido' => 'required|string|max:255',
        'email' => 'required|email|unique:usuarios,email',
        'password' => 'required|string|min:8|confirmed',
        'estado' => 'required|in:0,1',
        'rol' => 'required|in:admin,vendedor,farmacéutico',
    ];


    public function saveUser()
    {
        $this->validate();
        $user = UserModel::create([
            'nombre' => $this->nombre,
            'apellido' => $this->apellido,
            'email' => $this->email,
            'contraseña' => Hash::make($this->password),
            'estado' => filter_var($this->estado, FILTER_VALIDATE_BOOLEAN),
            'rol' => $this->rol,
        ]);
        session()->flash('message', 'Usuario registrado correctamente.');
    }

    public function render()
    {
        return view('livewire.new-user');
    }
}

