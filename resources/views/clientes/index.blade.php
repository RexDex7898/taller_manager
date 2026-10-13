@extends('layouts.app')

@section('content')
<div class="header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
    <div>
        <h1>👥 Clientes</h1>
        <p>Gestión y registro de clientes del taller</p>
    </div>
    <a href="{{ route('clientes.create') }}" class="btn">+ Nuevo cliente</a>
</div>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>WhatsApp</th>
                <th>Email</th>
                <th>Registro</th>
                <th style="text-align: right;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($clientes as $cliente)
                <tr>
                    <td><strong>{{ $cliente->nombre }}</strong></td>
                    <td>{{ $cliente->telefono ?? '—' }}</td>
                    <td>{{ $cliente->whatsapp ?? '—' }}</td>
                    <td>{{ $cliente->email ?? '—' }}</td>
                    <td>{{ $cliente->created_at ? $cliente->created_at->format('d/m/Y') : '—' }}</td>
                    <td style="text-align: right;">
                        <div style="display: flex; justify-content: flex-end; gap: 6px;">
                            <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-warning" style="padding: 5px 10px; font-size: 12px;">✏️ Editar</a>
                            <form action="{{ route('clientes.destroy', $cliente) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este cliente?');" style="display: inline;">
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
                        No hay clientes registrados en el sistema.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection