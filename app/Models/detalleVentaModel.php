<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class detalleVentaModel extends Model
{
    protected $table = 'detalle_ventas';
    protected $primaryKey = 'id_detalle';
    protected $fillable = [
        'id_venta',
        'id_medicamento',
        'cantidad',
        'subtotal',
    ];
    public function venta()
    {
        return $this->belongsTo(ventaModel::class, 'id_venta');
    }
    public function medicamento()
    {
        return $this->belongsTo(medicamentoModel::class, 'id_medicamento');
    }
 
}
