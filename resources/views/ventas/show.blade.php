<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ticket de Venta {{ $venta->folio }}</title>
    <style>
        body { font-family: monospace, sans-serif; width: 300px; margin: 0 auto; padding: 15px; font-size: 12px; color: #000; }
        .text-center { text-align: center; }
        .line { border-bottom: 1px dashed #000; margin: 10px 0; }
        table { width: 100%; border-collapse: collapse; }
        td, th { padding: 4px 0; text-align: left; }
        .btn-print { background: #2563eb; color: white; border: none; padding: 10px; width: 100%; border-radius: 6px; cursor: pointer; font-weight: bold; margin-bottom: 15px; font-family: sans-serif; }
        @media print { .btn-print, .btn-back { display: none !important; } }
    </style>
</head>
<body>

<button class="btn-print" onclick="window.print()">🖨️ Imprimir Ticket</button>
<a href="{{ route('ventas.create') }}" class="btn-back" style="display: block; text-align: center; margin-bottom: 15px; color: #4b5563; text-decoration: none; font-family: sans-serif; font-size: 13px;">← Nueva Venta</a>

<div class="text-center">
    <h2 style="margin: 0;">🔧 TALLER MANAGER</h2>
    <p style="margin: 3px 0;">Comprobante de Venta</p>
    <p style="margin: 3px 0; font-size: 10px;">Folio: {{ $venta->folio }}</p>
    <p style="margin: 3px 0; font-size: 10px;">Fecha: {{ $venta->created_at->format('d/m/Y h:i A') }}</p>
</div>

<div class="line"></div>

<table>
    <thead>
        <tr>
            <th>Cant. Prod.</th>
            <th style="text-align: right;">Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($venta->detalles as $item)
            <tr>
                <td colspan="2"><strong>{{ $item->producto->nombre }}</strong></td>
            </tr>
            <tr>
                <td>{{ $item->cantidad }} x ${{ number_format($item->precio_unitario, 2) }}</td>
                <td style="text-align: right;">${{ number_format($item->subtotal, 2) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="line"></div>

<table>
    <tr>
        <td><strong>TOTAL:</strong></td>
        <td style="text-align: right; font-size: 14px;"><strong>${{ number_format($venta->total, 2) }}</strong></td>
    </tr>
    <tr>
        <td>Método de Pago:</td>
        <td style="text-align: right;">{{ $venta->metodo_pago }}</td>
    </tr>
    @if($venta->pago_con)
        <tr>
            <td>Pagó con:</td>
            <td style="text-align: right;">${{ number_format($venta->pago_con, 2) }}</td>
        </tr>
        <tr>
            <td>Cambio:</td>
            <td style="text-align: right;">${{ number_format($venta->cambio, 2) }}</td>
        </tr>
    @endif
</table>

<div class="line"></div>

<div class="text-center" style="font-size: 10px; margin-top: 15px;">
    <p>¡Gracias por su compra!</p>
    <p>Conserve este ticket para cualquier aclaración.</p>
</div>

</body>
</html>