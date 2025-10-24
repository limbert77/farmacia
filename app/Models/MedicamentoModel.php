<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicamentoModel extends Model
{
    //
    use HasFactory;

    protected $table = 'medicamentos';

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'stock',
        'requiere_receta',
        'id_proveedor',
        'fecha_vencimiento',
        'categoria',
        'imagen',
    ];

    /**
     * Relación con ProveedorModel: Un medicamento pertenece a un proveedor.
     */
    public function proveedor()
    {
        return $this->belongsTo(ProveedorModel::class, 'id_proveedor');
    }
}
