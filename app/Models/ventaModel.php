<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ventaModel extends Model
{
    protected $table = 'ventas';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_cliente',
        'id_usuario',
        'fecha_venta',
        'total',
    ];
    public function cliente()
    {
        return $this->belongsTo(clienteModel::class, 'id_cliente');
    }
    public function usuario()
    {
        return $this->belongsTo(UserModel::class, 'id_usuario');
    }
    public function detalleVentas()
    {
        return $this->hasMany(detalleVentaModel::class, 'id_venta');
    }

}
