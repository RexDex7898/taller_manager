<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        $query = Producto::query();

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function($q) use ($buscar) {
                $q->where('nombre', 'like', "%{$buscar}%")
                  ->orWhere('codigo', 'like', "%{$buscar}%");
            });
        }

        if ($request->filled('categoria')) {
            $query->where('categoria', $request->categoria);
        }

        if ($request->has('stock_bajo')) {
            $query->whereColumn('stock', '<=', 'stock_minimo');
        }

        $productos = $query->orderBy('nombre', 'asc')->paginate(25);

        return view('inventario.index', compact('productos'));
    }

    public function create()
    {
        return view('inventario.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'categoria' => 'required|string',
            'codigo' => 'nullable|string|max:100',
            'precio_compra' => 'nullable|numeric|min:0',
            'precio_venta' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'stock_minimo' => 'required|integer|min:0',
            'descripcion' => 'nullable|string',
        ]);

        Producto::create($validated);

        return redirect()->route('inventario.index')->with('success', 'Producto registrado correctamente en el inventario.');
    }

    public function edit(Producto $inventario)
    {
        $producto = $inventario;
        return view('inventario.edit', compact('producto'));
    }

    public function update(Request $request, Producto $inventario)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'categoria' => 'required|string',
            'codigo' => 'nullable|string|max:100',
            'precio_compra' => 'nullable|numeric|min:0',
            'precio_venta' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'stock_minimo' => 'required|integer|min:0',
            'descripcion' => 'nullable|string',
        ]);

        $inventario->update($validated);

        return redirect()->route('inventario.index')->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Producto $inventario)
    {
        $inventario->delete();
        return redirect()->route('inventario.index')->with('success', 'Producto eliminado del inventario.');
    }

    public function pdf(Request $request)
    {
        $tipo = $request->get('tipo', 'todos'); // 'todos' o 'reponer'

        $query = Producto::query();

        if ($tipo === 'reponer') {
            $query->whereColumn('stock', '<=', 'stock_minimo');
        }

        $productos = $query->orderBy('categoria')->orderBy('nombre')->get();

        return view('inventario.pdf', compact('productos', 'tipo'));
    }
}