@extends('layouts.app')

@section('content')
    <div class="header">
        <h1>Dashboard</h1>
        <p>Resumen general del taller</p>
    </div>

    <section class="cards">
        <div class="card">
            <h3>Reparaciones activas</h3>
            <div class="number">{{ $reparacionesActivas }}</div>
        </div>
        <div class="card">
            <h3>Pendientes de diagnóstico</h3>
            <div class="number">{{ $pendientesDiagnostico }}</div>
        </div>
        <div class="card">
            <h3>Listas para entregar</h3>
            <div class="number">{{ $listasEntregar }}</div>
        </div>
        <div class="card">
            <h3>Clientes</h3>
            <div class="number">{{ $totalClientes }}</div>
        </div>
    </section>

    <section class="table-container">
        <h2>Reparaciones recientes</h2>
        <table>
            <thead>
                <tr>
                    <th>Folio</th>
                    <th>Cliente</th>
                    <th>Equipo</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reparacionesRecientes as $rep)
                    <tr>
                        <td>#{{ str_pad($rep->id, 4, '0', STR_PAD_LEFT) }}</td>
                        <td>{{ $rep->equipo->cliente->nombre ?? 'Sin asignar' }}</td>
                        <td>{{ $rep->equipo->marca }} {{ $rep->equipo->modelo }}</td>
                        <td>
                            <span class="status">
                                {{ ucfirst(str_replace('_', ' ', $rep->estado)) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center; color: #6b7280; padding: 20px;">No hay reparaciones recientes.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </section>
@endsection