<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ventaModel;
use App\Models\CompraModel;
use App\Models\ProveedorModel;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\VentasExport;
use Dompdf\Dompdf;
use Dompdf\Options;

class ReportesController extends Controller
{
    //
    public function ventas(Request $request)
    {
        $query = ventaModel::with(['cliente', 'usuario', 'detalleVentas.medicamento']);
        if ($request->has('fecha_inicio') && $request->has('fecha_fin')) {
            $fechaInicio = Carbon::parse($request->input('fecha_inicio'))->startOfDay();
            $fechaFin = Carbon::parse($request->input('fecha_fin'))->endOfDay();
            $query->whereBetween('fecha_venta', [$fechaInicio, $fechaFin]);
        }
        if ($request->has('usuario_id') && !empty($request->usuario_id)) {
            $usuarioId = $request->input('usuario_id');
            $query->where('id_usuario', $usuarioId);
        }
        if (empty($request->usuario_id)) {
            $query->orWhereNull('id_usuario');
        }
        $ventas = $query->get();
        $usuarios = \App\Models\UserModel::all();
        return view('reportes.ventas', compact('ventas', 'usuarios'));
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(new VentasExport($request), 'ventas.xlsx');
    }
    public function exportPDF(Request $request)
    {
        $query = ventaModel::with(['cliente', 'usuario', 'detalleVentas.medicamento']); // Cargar relaciones
        if ($request->has('semana')) {
            $semana = $request->input('semana');
            $startOfWeek = Carbon::now()->startOfWeek(Carbon::MONDAY)->subWeeks($semana - 1);
            $endOfWeek = $startOfWeek->copy()->endOfWeek();
            $query->whereBetween('fecha_venta', [$startOfWeek, $endOfWeek]);
        }
        if ($request->has('usuario_id')) {
            $usuarioId = $request->input('usuario_id');
            $query->where('id_usuario', $usuarioId);
        }
        $ventas = $query->get();
        $usuarios = \App\Models\UserModel::all();
        $html = view('reportes.pdfVentas', compact('ventas', 'usuarios'))->render();
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        return $dompdf->stream('ventas.pdf');
    }

    public function compras(Request $request)
    {
        $query = CompraModel::with(['proveedor', 'detalleCompras.medicamento']);
        if ($request->has('proveedor_id') && !empty($request->proveedor_id)) {
            $query->where('id_proveedor', $request->proveedor_id);
        }
        if ($request->has('fecha_inicio') && $request->has('fecha_fin')) {
            $fechaInicio = Carbon::parse($request->input('fecha_inicio'))->startOfDay();
            $fechaFin = Carbon::parse($request->input('fecha_fin'))->endOfDay();
            $query->whereBetween('fecha_compra', [$fechaInicio, $fechaFin]);
        }
        if ($request->has('sort_by') && in_array($request->sort_by, ['asc', 'desc'])) {
            $query->orderBy('fecha_compra', $request->sort_by);
        } else {
            $query->orderBy('fecha_compra', 'desc');
        }
        $compras = $query->get();
        foreach ($compras as $compra) {
            $compra->fecha_compra = Carbon::parse($compra->fecha_compra);
        }
        $proveedores = ProveedorModel::all();
        return view('reportes.compras', compact('compras', 'proveedores'));
    }
    public function exportComprasPDF(Request $request)
    {
        $query = CompraModel::with(['proveedor', 'detalleCompras.medicamento']);
        if ($request->has('proveedor_id') && !empty($request->proveedor_id)) {
            $query->where('id_proveedor', $request->proveedor_id);
        }
        $compras = $query->get();
        $compras = $compras->map(function ($compra) {
            if (is_string($compra->fecha_compra)) {
                $compra->fecha_compra = Carbon::parse($compra->fecha_compra);
            }
            return $compra;
    });

    $html = view('reportes.pdfCompras', compact('compras'))->render();
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();

    return $dompdf->stream('compras.pdf');
    }

    public function inventario(Request $request)
    {
        $query = \App\Models\MedicamentoModel::with('proveedor');

        if ($request->has('proveedor_id') && !empty($request->proveedor_id)) {
            $query->where('id_proveedor', $request->proveedor_id);
        }

        $medicamentos = $query->get();
        $proveedores = \App\Models\ProveedorModel::all();

        return view('reportes.inventario', compact('medicamentos', 'proveedores'));
    }
    public function exportInventarioPDF(Request $request)
    {
        $query = \App\Models\MedicamentoModel::with('proveedor');
        if ($request->has('proveedor_id') && !empty($request->proveedor_id)) {
            $query->where('id_proveedor', $request->proveedor_id);
        }
        $medicamentos = $query->get();
        $proveedores = \App\Models\ProveedorModel::all();
        $html = view('reportes.pdfInventario', compact('medicamentos', 'proveedores'))->render();
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        return $dompdf->stream('inventario.pdf');
    }

    public function proveedores()
    {
        $proveedores = \App\Models\ProveedorModel::all();
        return view('reportes.proveedores', compact('proveedores'));
    }
    public function exportProveedoresPDF()
    {
        $proveedores = \App\Models\ProveedorModel::all();
        $html = view('reportes.pdfProveedores', compact('proveedores'))->render();

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        return $dompdf->stream('proveedores.pdf');
    }

    public function usuarios()
    {
        $usuarios = \App\Models\UserModel::all();
        return view('reportes.usuarios', compact('usuarios'));
    }
    public function exportUsuariosPDF()
    {
        $usuarios = \App\Models\UserModel::all();
        $html = view('reportes.pdfUsuarios', compact('usuarios'))->render();

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        return $dompdf->stream('usuarios.pdf');
    }
    public function clientes()
    {
        $clientes = \App\Models\clienteModel::with(['ventas' => function ($query) {
            $query->selectRaw('id_cliente, SUM(total) as total_gastado')->groupBy('id_cliente');
        }])->get();

        return view('reportes.clientes', compact('clientes'));
    }
    public function exportClientesPDF()
    {
        $clientes = \App\Models\clienteModel::with(['ventas' => function ($query) {
            $query->selectRaw('id_cliente, SUM(total) as total_gastado')->groupBy('id_cliente');
        }])->get();

        $html = view('reportes.pdfClientes', compact('clientes'))->render();

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        return $dompdf->stream('clientes.pdf');
    }

}
