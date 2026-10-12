<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Nueva Cotización - Taller Manager</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            margin: 0;
            padding: 30px;
        }

        .container {
            max-width: 800px;
            margin: auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 8px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 6px;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            box-sizing: border-box;
        }

        textarea {
            min-height: 100px;
            resize: vertical;
        }

        .btn {
            display: inline-block;
            padding: 10px 15px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .btn-secondary {
            background: #6b7280;
        }

        .error {
            color: #dc2626;
            font-size: 14px;
            margin-top: 5px;
        }

        .actions {
            display: flex;
            gap: 10px;
            margin-top: 25px;
        }

        .info {
            background: #eff6ff;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            color: #1e40af;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="header">
        <h1>💰 Nueva Cotización</h1>

        <a href="{{ route('cotizaciones.index') }}" class="btn btn-secondary">
            ← Volver
        </a>
    </div>

    <div class="card">

        <div class="info">
            Selecciona la reparación para la cual deseas generar la cotización.
        </div>

        <form action="{{ route('cotizaciones.store') }}" method="POST">

            @csrf

            <div class="form-group">

                <label for="reparacion_id">
                    Reparación
                </label>

                <select name="reparacion_id" id="reparacion_id" required>

                    <option value="">
                        -- Selecciona una reparación --
                    </option>

                    @foreach($reparaciones as $reparacion)

                        <option
                            value="{{ $reparacion->id }}"
                            {{ old('reparacion_id') == $reparacion->id ? 'selected' : '' }}
                        >

                            {{ $reparacion->folio }}
                            —
                            {{ $reparacion->equipo->cliente->nombre }}
                            {{ $reparacion->equipo->cliente->apellidos }}
                            —
                            {{ $reparacion->equipo->marca }}
                            {{ $reparacion->equipo->modelo }}

                        </option>

                    @endforeach

                </select>

                @error('reparacion_id')
                    <div class="error">{{ $message }}</div>
                @enderror

            </div>

            <div class="form-group">

                <label for="subtotal">
                    Subtotal
                </label>

                <input
                    type="number"
                    name="subtotal"
                    id="subtotal"
                    step="0.01"
                    min="0"
                    value="{{ old('subtotal', 0) }}"
                    required
                >

                @error('subtotal')
                    <div class="error">{{ $message }}</div>
                @enderror

            </div>

            <div class="form-group">

                <label for="descuento">
                    Descuento
                </label>

                <input
                    type="number"
                    name="descuento"
                    id="descuento"
                    step="0.01"
                    min="0"
                    value="{{ old('descuento', 0) }}"
                    required
                >

                @error('descuento')
                    <div class="error">{{ $message }}</div>
                @enderror

            </div>

            <div class="form-group">

                <label for="total">
                    Total
                </label>

                <input
                    type="number"
                    name="total"
                    id="total"
                    step="0.01"
                    min="0"
                    value="{{ old('total', 0) }}"
                    required
                >

                @error('total')
                    <div class="error">{{ $message }}</div>
                @enderror

            </div>

            <div class="form-group">

                <label for="estado">
                    Estado
                </label>

                <select name="estado" id="estado" required>

                    @foreach([
                        'Pendiente',
                        'Enviada',
                        'Aceptada',
                        'Rechazada',
                        'Vencida'
                    ] as $estado)

                        <option
                            value="{{ $estado }}"
                            {{ old('estado', 'Pendiente') === $estado ? 'selected' : '' }}
                        >
                            {{ $estado }}
                        </option>

                    @endforeach

                </select>

                @error('estado')
                    <div class="error">{{ $message }}</div>
                @enderror

            </div>

            <div class="form-group">

                <label for="fecha_emision">
                    Fecha de emisión
                </label>

                <input
                    type="datetime-local"
                    name="fecha_emision"
                    id="fecha_emision"
                    value="{{ old('fecha_emision', now()->format('Y-m-d\TH:i')) }}"
                >

                @error('fecha_emision')
                    <div class="error">{{ $message }}</div>
                @enderror

            </div>

            <div class="form-group">

                <label for="notas">
                    Notas
                </label>

                <textarea
                    name="notas"
                    id="notas"
                    placeholder="Notas adicionales de la cotización..."
                >{{ old('notas') }}</textarea>

                @error('notas')
                    <div class="error">{{ $message }}</div>
                @enderror

            </div>

            <div class="actions">

                <button type="submit" class="btn">
                    💾 Guardar cotización
                </button>

                <a
                    href="{{ route('cotizaciones.index') }}"
                    class="btn btn-secondary"
                >
                    Cancelar
                </a>

            </div>

        </form>

    </div>

</div>

</body>
</html>