<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsuarioController extends Controller
{
    //
    public function showRegistrationForm()
    {
        return view('login.registro');
    }
    public function index()
    {
        return view('usuario.index');
    }
}
