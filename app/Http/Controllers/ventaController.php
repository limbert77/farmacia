<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ventaController extends Controller
{
    public function index()
    {
        return view('venta.index');
    }
}
