<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProveedoresController extends Controller
{
    //
    public function index()
    {
        return view('proveedor.index');
    }
    public function update()
    {
        return view('proveedor.updateProveedor');
    }
}
