@extends('layouts.app')

@section('content')
<div class="header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
    <div>
        <h1>🛒 Punto de Venta / Ventas</h1>
        <p>Registro de ventas en mostrador y cobros rápidos</p>
    </div>
    <a href="{{ route('ventas.create') }}" class="btn btn-success" style="padding: 10px 18px; font-size: 15px;">➕ Nueva Venta (POS)</a>
</div>

<div class="cards">
    <div class="card">
        <h3>Ventas Realizadas Hoy</h3>
        <div class="number" style="color: #16a34a;">${{ number_format($totalVentasHoy, 2) }}</div>
    </div>
</div>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>Folio</th>
                <th>Fecha / Hora</th>
                <th>Método de Pago</th>
                <th>Artículos</th>
                <th>Total</th>
                <th style="text-align: right;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($ventas as $venta)
                <tr>
                    <td><code>{{ $venta->folio }}</code></td>
                    <td>{{ $venta->created_at->format('d/m/Y h:i A') }}</td>
                    <td><span style="background: #e2e8f0; padding: 3px 8px; border-radius: 4px; font-size: 11px; font-weight: bold;">{{ $venta->metodo_pago }}</span></td>
                    <td>{{ $venta->detalles->sum('cantidad') }} prod.</td>
                    <td><strong>${{ number_format($venta->total, 2) }}</strong></td>
                    <td style="text-align: right;">
                        <a href="{{ route('ventas.show', $venta) }}" class="btn" style="background: #4b5563; padding: 5px 10px; font-size: 12px;">🧾 Ver Ticket</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: #6b7280; padding: 25px;">
                        No se han registrado ventas el día de hoy.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div style="margin-top: 15px;">
        {{ $ventas->links() }}
    </div>
</div>
@endsection