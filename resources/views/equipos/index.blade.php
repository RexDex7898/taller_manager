@extends('layouts.app')

@section('content')
<div class="header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
    <div>
        <h1>📱 Equipos</h1>
        <p>Listado de equipos registrados por cliente</p>
    </div>
    <a href="{{ route('equipos.create') }}" class="btn">+ Nuevo equipo</a>
</div>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>Cliente</th>
                <th>Tipo</th>
                <th>Marca / Modelo</th>
                <th>IMEI / N. Serie</th>
                <th>Registro</th>
                <th style="text-align: right;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($equipos as $equipo)
                <tr>
                    <td><strong>{{ $equipo->cliente->nombre ?? 'Sin cliente' }}</strong></td>
                    <td><span style="background: #e0f2fe; color: #0369a1; padding: 3px 8px; border-radius: 4px; font-size: 11px; font-weight: 600;">{{ $equipo->tipo ?? 'Equipo' }}</span></td>
                    <td>{{ $equipo->marca }} {{ $equipo->modelo }}</td>
                    <td>{{ $equipo->imei ?? $equipo->numero_serie ?? '—' }}</td>
                    <td>{{ $equipo->created_at ? $equipo->created_at->format('d/m/Y') : '—' }}</td>
                    <td style="text-align: right;">
                        <div style="display: flex; justify-content: flex-end; gap: 6px;">
                            <a href="{{ route('equipos.edit', $equipo) }}" class="btn btn-warning" style="padding: 5px 10px; font-size: 12px;">✏️ Editar</a>
                            <form action="{{ route('equipos.destroy', $equipo) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este equipo?');" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="padding: 5px 10px; font-size: 12px;">🗑️ Eliminar</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: #6b7280; padding: 25px;">
                        No hay equipos registrados en el sistema.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection