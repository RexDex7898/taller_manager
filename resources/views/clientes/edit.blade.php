@extends('layouts.app')

@section('content')
<div class="header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <div>
        <h1>✏️ Editar Cliente</h1>
        <p>Actualizar información de {{ $cliente->nombre }}</p>
    </div>
    <a href="{{ route('clientes.index') }}" class="btn" style="background: #4b5563;">← Volver</a>
</div>

<div class="card" style="max-width: 600px; padding: 24px;">
    <form action="{{ route('clientes.update', $cliente) }}" method="POST">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 15px;">
            <label for="nombre" style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Nombre Completo *</label>
            <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $cliente->nombre) }}" required style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;">
            @error('nombre') <span style="color: #dc2626; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span> @enderror
        </div>

        <div style="margin-bottom: 15px;">
            <label for="telefono" style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Teléfono</label>
            <input type="text" name="telefono" id="telefono" value="{{ old('telefono', $cliente->telefono) }}" style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;">
            @error('telefono') <span style="color: #dc2626; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span> @enderror
        </div>

        <div style="margin-bottom: 15px;">
            <label for="whatsapp" style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">WhatsApp</label>
            <input type="text" name="whatsapp" id="whatsapp" value="{{ old('whatsapp', $cliente->whatsapp) }}" style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;">
            @error('whatsapp') <span style="color: #dc2626; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span> @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label for="email" style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Correo Electrónico</label>
            <input type="email" name="email" id="email" value="{{ old('email', $cliente->email) }}" style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;">
            @error('email') <span style="color: #dc2626; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span> @enderror
        </div>

        <div style="display: flex; gap: 10px; align-items: center;">
            <button type="submit" class="btn btn-warning" style="padding: 10px 18px; font-size: 14px; color: white;">💾 Actualizar Cliente</button>
            <a href="{{ route('clientes.index') }}" class="btn" style="background: #9ca3af; padding: 10px 18px; font-size: 14px;">Cancelar</a>
        </div>
    </form>
</div>
@endsection