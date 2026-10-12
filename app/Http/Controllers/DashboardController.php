<?php

namespace App\Http\Controllers;

use App\Models\Reparacion;
use App\Models\Cliente;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Contar las métricas de las tarjetas superiores
        $reparacionesActivas = Reparacion::where('estado', '!=', 'entregado')->count();
        $pendientesDiagnostico = Reparacion::whereIn('estado', ['recepcion', 'diagnostico'])->count();
        $listasEntregar = Reparacion::where('estado', 'listo_entrega')->count();
        $totalClientes = Cliente::count();

        // 2. Obtener las últimas 5 reparaciones para la tabla
        $reparacionesRecientes = Reparacion::with(['equipo.cliente'])
            ->latest() // Ordenar por las más recientes
            ->take(5)  // Tomar solo 5
            ->get();

        // 3. Enviar todo a la vista
        return view('dashboard', compact(
            'reparacionesActivas',
            'pendientesDiagnostico',
            'listasEntregar',
            'totalClientes',
            'reparacionesRecientes'
        ));
    }
}