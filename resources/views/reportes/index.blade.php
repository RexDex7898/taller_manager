@extends('layouts.app')

@section('content')
<div class="header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
    <div>
        <h1>📈 Reportes y Estadísticas</h1>
        <p>Resumen del rendimiento del taller y valor comercial</p>
    </div>
    <button onclick="window.print()" class="btn btn-warning" style="color: white;">🖨️ Imprimir / Guardar Reporte PDF</button>
</div>

<!-- Tarjetas KPI -->
<div class="cards">
    <div class="card">
        <h3>Reparaciones (Este Mes)</h3>
        <div class="number">{{ $reparacionesMes }}</div>
    </div>
    <div class="card">
        <h3>Valor del Inventario</h3>
        <div class="number" style="color: #16a34a;">${{ number_format($valorInventario, 2) }}</div>
    </div>
    <div class="card">
        <h3>Stock en Alerta</h3>
        <div class="number" style="color: {{ $productosStockBajo > 0 ? '#dc2626' : '#111827' }};">
            {{ $productosStockBajo }} <span style="font-size: 13px; font-weight: normal; color: #6b7280;">prod.</span>
        </div>
    </div>
    <div class="card">
        <h3>Clientes Registrados</h3>
        <div class="number">{{ $totalClientes }}</div>
    </div>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 20px; margin-bottom: 25px;">
    <!-- Estado de Reparaciones -->
    <div class="card">
        <h3 style="font-size: 14px; font-weight: 700; color: #111827; margin-bottom: 15px;">📊 Estado de Reparaciones en el Taller</h3>
        <table style="width: 100%; min-width: 100%;">
            <thead>
                <tr>
                    <th>Estado</th>
                    <th style="text-align: right;">Cantidad</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reparacionesPorEstado as $estado)
                    <tr>
                        <td><strong>{{ $estado->estado }}</strong></td>
                        <td style="text-align: right;"><span style="background: #e2e8f0; padding: 4px 10px; border-radius: 12px; font-weight: bold; font-size: 12px;">{{ $estado->total }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="2" style="text-align: center; color: #6b7280;">Sin datos registrados.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Tipos de Equipos Frecuentes -->
    <div class="card">
        <h3 style="font-size: 14px; font-weight: 700; color: #111827; margin-bottom: 15px;">📱 Equipos / Dispositivos Frecuentes</h3>
        <table style="width: 100%; min-width: 100%;">
            <thead>
                <tr>
                    <th>Tipo de Dispositivo</th>
                    <th style="text-align: right;">Total Ingresados</th>
                </tr>
            </thead>
            <tbody>
                @forelse($equiposPorTipo as $tipo)
                    <tr>
                        <td>{{ $tipo->tipo ?? 'No especificado' }}</td>
                        <td style="text-align: right;"><strong>{{ $tipo->total }}</strong></td>
                    </tr>
                @empty
                    <tr><td colspan="2" style="text-align: center; color: #6b7280;">Sin equipos registrados.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Últimas Reparaciones Completadas -->
<div class="table-container">
    <h3 style="margin-top: 0; font-size: 15px; font-weight: 700;">✅ Historial Reciente de Reparaciones Finalizadas</h3>
    <table>
        <thead>
            <tr>
                <th>Cliente</th>
                <th>Equipo</th>
                <th>Estado</th>
                <th>Última Actualización</th>
            </tr>
        </thead>
        <tbody>
            @forelse($ultimasEntregas as $reparacion)
                <tr>
                    <td><strong>{{ $reparacion->equipo->cliente->nombre ?? 'N/A' }}</strong></td>
                    <td>{{ $reparacion->equipo->marca ?? '' }} {{ $reparacion->equipo->modelo ?? '' }}</td>
                    <td><span style="background: #dcfce7; color: #15803d; padding: 3px 8px; border-radius: 4px; font-weight: bold; font-size: 11px;">{{ $reparacion->estado }}</span></td>
                    <td>{{ $reparacion->updated_at ? $reparacion->updated_at->format('d/m/Y H:i') : '—' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center; color: #6b7280; padding: 20px;">No hay reparaciones finalizadas recientemente.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<style>
    @media print {
        .sidebar, .mobile-header, .btn { display: none !important; }
        .content { padding: 0 !important; }
        .layout { display: block !important; }
    }
</style>
@endsection