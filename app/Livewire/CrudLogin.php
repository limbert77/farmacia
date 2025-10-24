<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use App\Models\UserModel;

class CrudLogin extends Component
{
    public $email;
    public $password;

    protected $rules = [
        'email' => 'required|email|exists:usuarios,email',
        'password' => 'required|string',
    ];

    public function login()
    {
        $this->validate();
        $usuario = UserModel::where('email', $this->email)->first();
        if (!$usuario || !Hash::check($this->password, $usuario->contraseña)) {
            session()->flash('error', 'Usuario o contraseña incorrectos');
            return;
        }
        session([
            'user_id' => $usuario->id,
            'username' => $usuario->nombre . ' ' . $usuario->apellido,
            'is_admin' => $usuario->rol === 'admin',
        ]);
        auth()->login($usuario);
        return $usuario->rol === 'admin' ? redirect()->route('inicio.index') : redirect()->route('inicio.index');
    }

    public function render()
    {
        return view('livewire.crud-login');
    }
}
