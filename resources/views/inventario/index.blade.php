@extends('layouts.app')

@section('content')
<div class="header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
    <div>
        <h1>📦 Inventario del Taller</h1>
        <p>Gestión de fundas, cristales, baterías, pantallas y accesorios</p>
    </div>
    <div style="display: flex; gap: 8px;">
        <a href="{{ route('inventario.pdf', ['tipo' => 'reponer']) }}" target="_blank" class="btn btn-warning" style="color: white;">📄 Lista para Reponer (PDF)</a>
        <a href="{{ route('inventario.create') }}" class="btn">+ Nuevo producto</a>
    </div>
</div>

<!-- Buscador y Filtros -->
<div class="card" style="margin-bottom: 20px; padding: 15px;">
    <form method="GET" action="{{ route('inventario.index') }}" style="display: flex; gap: 10px; flex-wrap: wrap; align-items: center;">
        <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="🔍 Buscar por nombre o código..." style="flex: 1; min-width: 200px; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 13px;">
        
        <select name="categoria" style="padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 13px; background: white;">
            <option value="">Todas las categorías</option>
            <option value="Fundas" {{ request('categoria') == 'Fundas' ? 'selected' : '' }}>Fundas / Cases</option>
            <option value="Cristales Templados" {{ request('categoria') == 'Cristales Templados' ? 'selected' : '' }}>Cristales Templados</option>
            <option value="Pantallas" {{ request('categoria') == 'Pantallas' ? 'selected' : '' }}>Pantallas / Displays</option>
            <option value="Baterías" {{ request('categoria') == 'Baterías' ? 'selected' : '' }}>Baterías</option>
            <option value="Cargadores" {{ request('categoria') == 'Cargadores' ? 'selected' : '' }}>Cargadores y Cables</option>
            <option value="Audífonos" {{ request('categoria') == 'Audífonos' ? 'selected' : '' }}>Audífonos</option>
            <option value="Refacciones" {{ request('categoria') == 'Refacciones' ? 'selected' : '' }}>Refacciones internas</option>
            <option value="Otros" {{ request('categoria') == 'Otros' ? 'selected' : '' }}>Otros</option>
        </select>

        <button type="submit" class="btn" style="padding: 8px 14px;">Filtrar</button>
        @if(request()->hasAny(['buscar', 'categoria', 'stock_bajo']))
            <a href="{{ route('inventario.index') }}" class="btn" style="background: #6b7280;">Limpiar</a>
        @endif
    </form>
</div>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Producto</th>
                <th>Categoría</th>
                <th>Precio Venta</th>
                <th>Stock</th>
                <th>Estado</th>
                <th style="text-align: right;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($productos as $producto)
                <tr>
                    <td><code>{{ $producto->codigo ?? '—' }}</code></td>
                    <td><strong>{{ $producto->nombre }}</strong></td>
                    <td><span style="background: #f1f5f9; padding: 3px 8px; border-radius: 4px; font-size: 11px;">{{ $producto->categoria }}</span></td>
                    <td><strong>${{ number_format($producto->precio_venta, 2) }}</strong></td>
                    <td><strong>{{ $producto->stock }}</strong> unid.</td>
                    <td>
                        @if($producto->stock <= $producto->stock_minimo)
                            <span style="background: #fef2f2; color: #dc2626; padding: 3px 8px; border-radius: 4px; font-size: 11px; font-weight: 700; border: 1px solid #fecaca;">⚠️ Stock Bajo</span>
                        @else
                            <span style="background: #f0fdf4; color: #16a34a; padding: 3px 8px; border-radius: 4px; font-size: 11px; font-weight: 600;">✅ Disponible</span>
                        @endif
                    </td>
                    <td style="text-align: right;">
                        <div style="display: flex; justify-content: flex-end; gap: 6px;">
                            <a href="{{ route('inventario.edit', $producto) }}" class="btn btn-warning" style="padding: 5px 10px; font-size: 12px; color: white;">✏️ Editar</a>
                            <form action="{{ route('inventario.destroy', $producto) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este producto?');" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="padding: 5px 10px; font-size: 12px;">🗑️ Eliminar</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; color: #6b7280; padding: 25px;">
                        No se encontraron productos en el inventario.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div style="margin-top: 15px;">
        {{ $productos->links() }}
    </div>
</div>
@endsection