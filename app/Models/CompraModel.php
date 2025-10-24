<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompraModel extends Model
{
    //
    use HasFactory;

    protected $table = 'compras';

    protected $fillable = [
        'id_proveedor',
        'fecha_compra',
        'total',
    ];
    public function proveedor()
    {
        return $this->belongsTo(ProveedorModel::class, 'id_proveedor');
    }
    public function detalleCompras()
    {
        return $this->hasMany(DetalleCompraModel::class, 'id_compra');
    }

}
