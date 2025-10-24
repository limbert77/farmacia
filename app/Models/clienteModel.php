<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class clienteModel extends Model
{
    protected $table = 'clientes';

    protected $fillable = [
        'nombre',
        'apelldio',
        'telefono',
        'email',
        'cinit'
    ];
    public function ventas()
    {
        return $this->hasMany(ventaModel::class, 'id_cliente');
    }
}
