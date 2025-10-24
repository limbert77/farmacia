<?php

namespace App\Exports;

use App\Models\ventaModel;
use Maatwebsite\Excel\Concerns\FromCollection;

class VentasExport implements FromCollection
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = ventaModel::query();
        if ($this->request->has('semana')) {
            $semana = $this->request->input('semana');
            $startOfWeek = \Carbon\Carbon::now()->startOfWeek(\Carbon\Carbon::MONDAY)->subWeeks($semana - 1);
            $endOfWeek = $startOfWeek->copy()->endOfWeek();
            $query->whereBetween('fecha_venta', [$startOfWeek, $endOfWeek]);
        }
        if ($this->request->has('usuario_id')) {
            $usuarioId = $this->request->input('usuario_id');
            $query->where('id_usuario', $usuarioId);
        }
        return $query->get(['fecha_venta', 'total', 'id_usuario', 'id_cliente']);
    }
}
