<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleCompraModel extends Model
{
    //
    use HasFactory;

    protected $table = 'detalle_compras';
    public $incrementing = false;
    protected $primaryKey = null;

    protected $fillable = [
        'id_compra',
        'id_medicamento',
        'cantidad',
        'costo_unitario',
        'subtotal',
    ];

    public function compra()
    {
        return $this->belongsTo(CompraModel::class, 'id_compra');
    }

    public function medicamento()
    {
        return $this->belongsTo(MedicamentoModel::class, 'id_medicamento');
    }
}
