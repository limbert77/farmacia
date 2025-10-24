<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProveedorModel extends Model
{
    //
    use HasFactory;
    protected $table = 'proveedores';
    protected $fillable = [
        'nombre',
        'telefono',
        'email',
        'direccion',
    ];

    public function medicamentos()
    {
        return $this->hasMany(MedicamentoModel::class, 'id_proveedor');
    }
}
