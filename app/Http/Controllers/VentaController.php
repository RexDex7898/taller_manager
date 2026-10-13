<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    public function index()
    {
        $ventas = Venta::with('detalles.producto')->orderBy('created_at', 'desc')->paginate(20);
        $totalVentasHoy = Venta::whereDate('created_at', now()->today())->sum('total');

        return view('ventas.index', compact('ventas', 'totalVentasHoy'));
    }

    public function create()
    {
        $productos = Producto::where('stock', '>', 0)->orderBy('nombre', 'asc')->get();
        return view('ventas.create', compact('productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'productos' => 'required|array|min:1',
            'productos.*.id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1',
            'metodo_pago' => 'required|string',
        ]);

        return DB::transaction(function () use ($request) {
            $total = 0;
            $itemsParaGuardar = [];

            // Validar stock y calcular total
            foreach ($request->productos as $item) {
                $producto = Producto::lockForUpdate()->find($item['id']);

                if ($producto->stock < $item['cantidad']) {
                    return back()->withErrors(["stock" => "El producto '{$producto->nombre}' no tiene suficiente stock disponible (Quedan: {$producto->stock})."]);
                }

                $subtotal = $producto->precio_venta * $item['cantidad'];
                $total += $subtotal;

                $itemsParaGuardar[] = [
                    'producto' => $producto,
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $producto->precio_venta,
                    'subtotal' => $subtotal,
                ];
            }

            // Crear la venta
            $pagoCon = $request->pago_con ?? $total;
            $cambio = max($pagoCon - $total, 0);

            $venta = Venta::create([
                'folio' => 'VEN-' . strtoupper(uniqid()),
                'total' => $total,
                'metodo_pago' => $request->metodo_pago,
                'pago_con' => $pagoCon,
                'cambio' => $cambio,
                'notas' => $request->notas,
            ]);

            // Guardar detalles y descontar stock automáticamente
            foreach ($itemsParaGuardar as $item) {
                DetalleVenta::create([
                    'venta_id' => $venta->id,
                    'producto_id' => $item['producto']->id,
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $item['precio_unitario'],
                    'subtotal' => $item['subtotal'],
                ]);

                // Disminuir stock
                $item['producto']->decrement('stock', $item['cantidad']);
            }

            return redirect()->route('ventas.show', $venta)->with('success', '¡Venta realizada con éxito!');
        });
    }

    public function show(Venta $venta)
    {
        $venta->load('detalles.producto');
        return view('ventas.show', compact('venta'));
    }
}