@extends('layouts.app')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <div class="header" style="margin-bottom: 0;">
            <h1>📱 Equipos</h1>
            <p>Listado de dispositivos registrados en el sistema</p>
        </div>

        <a href="{{ route('equipos.create') }}" class="btn">
            + Nuevo equipo
        </a>
    </div>

    <div class="table-container">
        @if($equipos->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Tipo</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>IMEI</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($equipos as $equipo)
                        <tr>
                            <td>
                                <strong>{{ $equipo->cliente->nombre ?? 'Sin cliente' }} {{ $equipo->cliente->apellidos ?? '' }}</strong>
                            </td>
                            <td>{{ $equipo->tipo }}</td>
                            <td>{{ $equipo->marca }}</td>
                            <td>{{ $equipo->modelo }}</td>
                            <td>{{ $equipo->imei ?? '—' }}</td>
                            <td>
                                <div style="display: flex; gap: 6px; align-items: center;">
                                    <!-- Botón rápido para mandar a Reparaciones -->
                                    <form action="{{ route('equipos.ingresar', $equipo) }}" method="POST" style="margin:0;">
                                        @csrf
                                        <button type="submit" class="btn btn-success" title="Ingresar a flujo de taller">
                                            🔨 Reparar
                                        </button>
                                    </form>

                                    <a href="{{ route('equipos.show', $equipo) }}" class="btn">
                                        👁️ Ver
                                    </a>

                                    <a href="{{ route('equipos.edit', $equipo) }}" class="btn btn-warning">
                                        ✏️ Editar
                                    </a>

                                    <form action="{{ route('equipos.destroy', $equipo) }}" method="POST" onsubmit="return confirm('¿Seguro que quieres eliminar este equipo?');" style="margin:0;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            🗑️
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div style="text-align: center; padding: 40px; color: #6b7280;">
                <h2 style="margin-top:0;">No hay equipos registrados</h2>
                <p>Comienza registrando el primer equipo del taller.</p>
            </div>
        @endif
    </div>
@endsection