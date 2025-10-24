<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MedicamentoController extends Controller
{
    //
    public function index(){
        return view('medicamentos.index');
    }
}
