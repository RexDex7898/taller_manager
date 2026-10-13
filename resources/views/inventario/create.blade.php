@extends('layouts.app')

@section('content')
<div class="header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <div>
        <h1>➕ Agregar Producto al Inventario</h1>
        <p>Registra accesorios, refacciones o mercancía</p>
    </div>
    <a href="{{ route('inventario.index') }}" class="btn" style="background: #4b5563;">← Volver</a>
</div>

<div class="card" style="max-width: 650px; padding: 24px;">
    <form action="{{ route('inventario.store') }}" method="POST">
        @csrf

        <div style="margin-bottom: 15px;">
            <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Nombre del Producto *</label>
            <input type="text" name="nombre" value="{{ old('nombre') }}" placeholder="Ej. Cristal Templado iPhone 13 / Funda Uso Rudo A54" required style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;">
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
            <div>
                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Categoría *</label>
                <select name="categoria" required style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; background: white;">
                    <option value="">Selecciona una opción</option>
                    <option value="Fundas" {{ old('categoria') == 'Fundas' ? 'selected' : '' }}>Fundas / Cases</option>
                    <option value="Cristales Templados" {{ old('categoria') == 'Cristales Templados' ? 'selected' : '' }}>Cristales Templados</option>
                    <option value="Pantallas" {{ old('categoria') == 'Pantallas' ? 'selected' : '' }}>Pantallas / Displays</option>
                    <option value="Baterías" {{ old('categoria') == 'Baterías' ? 'selected' : '' }}>Baterías</option>
                    <option value="Cargadores" {{ old('categoria') == 'Cargadores' ? 'selected' : '' }}>Cargadores y Cables</option>
                    <option value="Audífonos" {{ old('categoria') == 'Audífonos' ? 'selected' : '' }}>Audífonos</option>
                    <option value="Refacciones" {{ old('categoria') == 'Refacciones' ? 'selected' : '' }}>Refacciones internas</option>
                    <option value="Otros" {{ old('categoria') == 'Otros' ? 'selected' : '' }}>Otros</option>
                </select>
            </div>
            <div>
                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Código / SKU (Opcional)</label>
                <input type="text" name="codigo" value="{{ old('codigo') }}" placeholder="Código de barras" style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;">
            </div>
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Precio de Venta ($) *</label>
            <input type="number" step="0.01" name="precio_venta" value="{{ old('precio_venta') }}" placeholder="0.00" required style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;">
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
            <div>
                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Stock Inicial *</label>
                <input type="number" name="stock" value="{{ old('stock', 1) }}" required style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;">
            </div>
            <div>
                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Stock Mínimo (Alerta) *</label>
                <input type="number" name="stock_minimo" value="{{ old('stock_minimo', 3) }}" required style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;">
            </div>
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn btn-success" style="padding: 10px 18px;">💾 Guardar Producto</button>
            <a href="{{ route('inventario.index') }}" class="btn" style="background: #9ca3af;">Cancelar</a>
        </div>
    </form>
</div>
@endsection