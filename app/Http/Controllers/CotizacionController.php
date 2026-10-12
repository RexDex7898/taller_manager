<?php

namespace App\Http\Controllers;

use App\Models\Cotizacion;
use App\Models\Reparacion;
use Illuminate\Http\Request;

class CotizacionController extends Controller
{
    public function index()
    {
        $cotizaciones = Cotizacion::with('reparacion.equipo.cliente')
            ->latest()
            ->get();

        return view('cotizaciones.index', compact('cotizaciones'));
    }

    public function create()
    {
        $reparaciones = Reparacion::with('equipo.cliente')
            ->whereDoesntHave('cotizacion')
            ->latest()
            ->get();

        return view('cotizaciones.create', compact('reparaciones'));
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'reparacion_id' => 'required|exists:reparaciones,id',
            'subtotal' => 'required|numeric|min:0',
            'descuento' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'estado' => 'required|string|max:50',
            'notas' => 'nullable|string',
            'fecha_emision' => 'nullable|date',
        ]);

        Cotizacion::create($datos);

        return redirect()
            ->route('cotizaciones.index')
            ->with('success', 'Cotización registrada correctamente.');
    }

    public function show(Cotizacion $cotizacion)
{
    $cotizacion->load([
        'reparacion.equipo.cliente',
        'detalles',
    ]);

    return view('cotizaciones.show', compact('cotizacion'));
}

    public function edit(Cotizacion $cotizacion)
    {
        $reparaciones = Reparacion::with('equipo.cliente')
            ->where(function ($query) use ($cotizacion) {
                $query->whereDoesntHave('cotizacion')
                    ->orWhere('id', $cotizacion->reparacion_id);
            })
            ->latest()
            ->get();

        return view('cotizaciones.edit', compact(
            'cotizacion',
            'reparaciones'
        ));
    }

    public function update(Request $request, Cotizacion $cotizacion)
    {
        $datos = $request->validate([
            'reparacion_id' => 'required|exists:reparaciones,id',
            'subtotal' => 'required|numeric|min:0',
            'descuento' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'estado' => 'required|string|max:50',
            'notas' => 'nullable|string',
            'fecha_emision' => 'nullable|date',
            'fecha_autorizacion' => 'nullable|date',
        ]);

        $cotizacion->update($datos);

        return redirect()
            ->route('cotizaciones.show', $cotizacion)
            ->with('success', 'Cotización actualizada correctamente.');
    }

    public function destroy(Cotizacion $cotizacion)
    {
        $cotizacion->delete();

        return redirect()
            ->route('cotizaciones.index')
            ->with('success', 'Cotización eliminada correctamente.');
    }
}