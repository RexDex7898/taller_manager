@extends('layouts.app')

@section('content')
<div class="header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <div>
        <h1>✏️ Editar Producto</h1>
        <p>Actualizar datos de {{ $producto->nombre }}</p>
    </div>
    <a href="{{ route('inventario.index') }}" class="btn" style="background: #4b5563;">← Volver</a>
</div>

<div class="card" style="max-width: 650px; padding: 24px;">
    <form action="{{ route('inventario.update', $producto) }}" method="POST">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 15px;">
            <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Nombre del Producto *</label>
            <input type="text" name="nombre" value="{{ old('nombre', $producto->nombre) }}" required style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;">
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
            <div>
                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Categoría *</label>
                <select name="categoria" required style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; background: white;">
                    @foreach(['Fundas', 'Cristales Templados', 'Pantallas', 'Baterías', 'Cargadores', 'Audífonos', 'Refacciones', 'Otros'] as $cat)
                        <option value="{{ $cat }}" {{ old('categoria', $producto->categoria) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Código / SKU</label>
                <input type="text" name="codigo" value="{{ old('codigo', $producto->codigo) }}" style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
            <div>
                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Precio de Compra ($)</label>
                <input type="number" step="0.01" name="precio_compra" value="{{ old('precio_compra', $producto->precio_compra) }}" style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;">
            </div>
            <div>
                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Precio de Venta ($) *</label>
                <input type="number" step="0.01" name="precio_venta" value="{{ old('precio_venta', $producto->precio_venta) }}" required style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
            <div>
                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Stock Actual *</label>
                <input type="number" name="stock" value="{{ old('stock', $producto->stock) }}" required style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;">
            </div>
            <div>
                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Stock Mínimo (Alerta) *</label>
                <input type="number" name="stock_minimo" value="{{ old('stock_minimo', $producto->stock_minimo) }}" required style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;">
            </div>
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn btn-warning" style="padding: 10px 18px; color: white;">💾 Actualizar Producto</button>
            <a href="{{ route('inventario.index') }}" class="btn" style="background: #9ca3af;">Cancelar</a>
        </div>
    </form>
</div>
@endsection