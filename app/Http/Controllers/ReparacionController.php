<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Reparacion;
use Illuminate\Http\Request;

class ReparacionController extends Controller
{
    public function index()
    {
        // Agrupamos las reparaciones por estado para hacer el tablero Kanban
        $reparaciones = Reparacion::with(['equipo.cliente', 'tecnico'])
                                  ->where('estado', '!=', 'entregado')
                                  ->get()
                                  ->groupBy('estado');
                                  
        return view('reparaciones.index', compact('reparaciones'));
    }

    // Método para re-ingresar un equipo existente al taller
    public function ingresarExistente(Request $request, Equipo $equipo)
    {
        Reparacion::create([
            'equipo_id'     => $equipo->id,
            'user_id'       => auth()->id(),
            'estado'        => 'recepcion',
            'fecha_ingreso' => now(),
        ]);

        return redirect()
            ->route('reparaciones.index')
            ->with('success', 'Equipo ingresado al flujo del taller.');
    }

    // Método para mover el estado del teléfono en el Kanban
    public function actualizarEstado(Request $request, Reparacion $reparacion)
    {
        $request->validate(['estado' => 'required|string']);
        
        $datos = ['estado' => $request->estado];
        
        if (!$reparacion->user_id && $request->estado != 'recepcion') {
            $datos['user_id'] = auth()->id();
        }

        if ($request->estado == 'listo_entrega') {
            $datos['fecha_entrega'] = now();
        }

        $reparacion->update($datos);

        return redirect()->route('reparaciones.index')->with('success', 'Estado actualizado correctamente.');
    }
}