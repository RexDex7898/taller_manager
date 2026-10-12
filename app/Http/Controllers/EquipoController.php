<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Equipo;
use App\Models\Reparacion;
use Illuminate\Http\Request;

class EquipoController extends Controller
{
    public function index()
    {
        $equipos = Equipo::with('cliente')->latest()->get();

        return view('equipos.index', compact('equipos'));
    }

    public function create()
    {
        $clientes = Cliente::orderBy('nombre')->get();

        return view('equipos.create', compact('clientes'));
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'cliente_id'   => 'required|exists:clientes,id',
            'tipo'         => 'required|string|max:255',
            'marca'        => 'required|string|max:255',
            'modelo'       => 'required|string|max:255',
            'imei'         => 'nullable|string|max:30',
            'numero_serie' => 'nullable|string|max:100',
            'color'        => 'nullable|string|max:50',
            'contrasena'   => 'nullable|string',
            'descripcion'  => 'nullable|string',
            'notas'        => 'nullable|string',
        ]);

        // 1. Crear el registro del equipo
        $equipo = Equipo::create($datos);

        // 2. Crear automáticamente la orden en Reparaciones (estado inicial: recepcion)
        Reparacion::create([
            'equipo_id'           => $equipo->id,
            'user_id'             => auth()->id(),
            'estado'              => 'recepcion',
            'diagnostico_tecnico' => $equipo->descripcion ?? 'Ingreso inicial a taller',
            'fecha_ingreso'       => now(),
        ]);

        return redirect()
            ->route('reparaciones.index')
            ->with('success', 'Equipo registrado e ingresado al flujo del taller.');
    }

    public function show(Equipo $equipo)
    {
        $equipo->load('cliente');

        return view('equipos.show', compact('equipo'));
    }

    public function edit(Equipo $equipo)
    {
        $clientes = Cliente::orderBy('nombre')->get();

        return view('equipos.edit', compact('equipo', 'clientes'));
    }

    public function update(Request $request, Equipo $equipo)
    {
        $datos = $request->validate([
            'cliente_id'   => 'required|exists:clientes,id',
            'tipo'         => 'required|string|max:255',
            'marca'        => 'required|string|max:255',
            'modelo'       => 'required|string|max:255',
            'imei'         => 'nullable|string|max:30',
            'numero_serie' => 'nullable|string|max:100',
            'color'        => 'nullable|string|max:50',
            'contrasena'   => 'nullable|string',
            'descripcion'  => 'nullable|string',
            'notas'        => 'nullable|string',
        ]);

        $equipo->update($datos);

        return redirect()
            ->route('equipos.index')
            ->with('success', 'Equipo actualizado correctamente.');
    }

    public function destroy(Equipo $equipo)
    {
        $equipo->delete();

        return redirect()
            ->route('equipos.index')
            ->with('success', 'Equipo eliminado correctamente.');
    }
}