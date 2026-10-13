<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Productos a Reponer - Taller Manager</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; font-size: 12px; color: #111; }
        .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #111; padding-bottom: 10px; margin-bottom: 20px; }
        h1 { margin: 0; font-size: 18px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background: #f2f2f2; font-weight: bold; }
        .btn-print { background: #2563eb; color: white; border: none; padding: 10px 18px; border-radius: 6px; cursor: pointer; font-size: 14px; font-weight: bold; margin-bottom: 15px; }
        @media print {
            .btn-print { display: none; }
        }
    </style>
</head>
<body>

<button class="btn-print" onclick="window.print()">🖨️ Imprimir / Guardar como PDF</button>

<div class="header">
    <div>
        <h1>🔧 Taller Manager — Reporte de Inventario</h1>
        <p>Lista de productos a pedir/reponer</p>
    </div>
    <div>
        <strong>Fecha:</strong> {{ date('d/m/Y H:i') }}
    </div>
</div>

<table>
    <thead>
        <tr>
            <th>Categoría</th>
            <th>Producto</th>
            <th>Código</th>
            <th>Stock Actual</th>
            <th>Stock Mínimo</th>
            <th>Sugerencia a Pedir</th>
        </tr>
    </thead>
    <tbody>
        @forelse($productos as $producto)
            <tr>
                <td>{{ $producto->categoria }}</td>
                <td><strong>{{ $producto->nombre }}</strong></td>
                <td>{{ $producto->codigo ?? '—' }}</td>
                <td style="color: red; font-weight: bold;">{{ $producto->stock }}</td>
                <td>{{ $producto->stock_minimo }}</td>
                <td><strong>{{ max(($producto->stock_minimo * 2) - $producto->stock, 1) }} unid.</strong></td>
            </tr>
        @empty
            <tr>
                <td colspan="6" style="text-align: center; padding: 20px;">No hay productos pendientes por reponer. ¡Todo el inventario está completo!</td>
            </tr>
        @endforelse
    </tbody>
</table>

</body>
</html>