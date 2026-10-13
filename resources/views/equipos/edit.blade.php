@extends('layouts.app')

@section('content')
<div class="header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <div>
        <h1>✏️ Editar equipo</h1>
        <p>Actualizar datos del {{ $equipo->marca }} {{ $equipo->modelo }}</p>
    </div>
    <a href="{{ route('equipos.index') }}" class="btn" style="background: #4b5563;">← Volver</a>
</div>

<div class="card" style="max-width: 650px; padding: 24px;">
    <form action="{{ route('equipos.update', $equipo) }}" method="POST">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 15px;">
            <label for="cliente_id" style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Cliente *</label>
            <select name="cliente_id" id="cliente_id" required style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; background: white;">
                @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id }}" {{ old('cliente_id', $equipo->cliente_id) == $cliente->id ? 'selected' : '' }}>
                        {{ $cliente->nombre }} ({{ $cliente->telefono ?? 'Sin tel' }})
                    </option>
                @endforeach
            </select>
            @error('cliente_id') <span style="color: #dc2626; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span> @enderror
        </div>

        <div style="margin-bottom: 15px;">
            <label for="tipo" style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Tipo de equipo *</label>
            <select name="tipo" id="tipo" required style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; background: white;">
                <option value="Smartphone" {{ old('tipo', $equipo->tipo) == 'Smartphone' ? 'selected' : '' }}>Celular / Smartphone</option>
                <option value="Laptop" {{ old('tipo', $equipo->tipo) == 'Laptop' ? 'selected' : '' }}>Laptop</option>
                <option value="PC Escritorio" {{ old('tipo', $equipo->tipo) == 'PC Escritorio' ? 'selected' : '' }}>PC de Escritorio</option>
                <option value="Tablet" {{ old('tipo', $equipo->tipo) == 'Tablet' ? 'selected' : '' }}>Tablet</option>
                <option value="Consola" {{ old('tipo', $equipo->tipo) == 'Consola' ? 'selected' : '' }}>Consola de Videojuegos</option>
                <option value="Otro" {{ old('tipo', $equipo->tipo) == 'Otro' ? 'selected' : '' }}>Otro</option>
            </select>
            @error('tipo') <span style="color: #dc2626; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span> @enderror
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
            <div>
                <label for="marca" style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Marca *</label>
                <input type="text" name="marca" id="marca" value="{{ old('marca', $equipo->marca) }}" required style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;">
                @error('marca') <span style="color: #dc2626; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span> @enderror
            </div>
            <div>
                <label for="modelo" style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Modelo *</label>
                <input type="text" name="modelo" id="modelo" value="{{ old('modelo', $equipo->modelo) }}" required style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;">
                @error('modelo') <span style="color: #dc2626; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span> @enderror
            </div>
        </div>

        <div style="margin-bottom: 15px;">
            <label for="imei" style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">IMEI</label>
            <input type="text" name="imei" id="imei" value="{{ old('imei', $equipo->imei) }}" style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;">
            @error('imei') <span style="color: #dc2626; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span> @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label for="numero_serie" style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Número de serie</label>
            <input type="text" name="numero_serie" id="numero_serie" value="{{ old('numero_serie', $equipo->numero_serie) }}" style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;">
            @error('numero_serie') <span style="color: #dc2626; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span> @enderror
        </div>

        <div style="display: flex; gap: 10px; align-items: center;">
            <button type="submit" class="btn btn-warning" style="padding: 10px 18px; font-size: 14px; color: white;">💾 Actualizar equipo</button>
            <a href="{{ route('equipos.index') }}" class="btn" style="background: #9ca3af; padding: 10px 18px; font-size: 14px;">Cancelar</a>
        </div>
    </form>
</div>
@endsection