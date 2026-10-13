<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Equipo;
use App\Models\Producto;
use App\Models\Reparacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    public function index(Request $request)
    {
        // Rango de fechas (por defecto este mes)
        $mesActual = now()->month;
        $anioActual = now()->year;

        // KPI Métricas Principales
        $totalClientes = Cliente::count();
        $totalEquipos = Equipo::count();
        $reparacionesMes = Reparacion::whereMonth('created_at', $mesActual)
            ->whereYear('created_at', $anioActual)
            ->count();

        // Finanzas del inventario
        $totalProductos = Producto::count();
        $valorInventario = Producto::sum(DB::raw('precio_venta * stock'));
        $productosStockBajo = Producto::whereColumn('stock', '<=', 'stock_minimo')->count();

        // Desglose por Estado de Reparaciones
        $reparacionesPorEstado = Reparacion::select('estado', DB::raw('count(*) as total'))
            ->groupBy('estado')
            ->get();

        // Equipos más comunes
        $equiposPorTipo = Equipo::select('tipo', DB::raw('count(*) as total'))
            ->groupBy('tipo')
            ->orderBy('total', 'desc')
            ->take(5)
            ->get();

        // Últimas reparaciones entregadas o concluidas
        $ultimasEntregas = Reparacion::with(['equipo.cliente'])
            ->whereIn('estado', ['Entregado', 'Listo', 'Completado'])
            ->orderBy('updated_at', 'desc')
            ->take(8)
            ->get();

        return view('reportes.index', compact(
            'totalClientes',
            'totalEquipos',
            'reparacionesMes',
            'totalProductos',
            'valorInventario',
            'productosStockBajo',
            'reparacionesPorEstado',
            'equiposPorTipo',
            'ultimasEntregas'
        ));
    }
}