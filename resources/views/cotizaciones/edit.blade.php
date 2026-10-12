<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Editar Cotización - Taller Manager</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            margin: 0;
            padding: 30px;
        }

        .container {
            max-width: 900px;
            margin: auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        h1 {
            margin: 0;
            color: #222;
        }

        .subtitle {
            color: #666;
            margin-top: 5px;
        }

        .card {
            background: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            margin-bottom: 20px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .field {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 7px;
            color: #333;
        }

        input,
        select,
        textarea {
            width: 100%;
            box-sizing: border-box;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }

        textarea {
            resize: vertical;
        }

        .button-container {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }

        .btn {
            display: inline-block;
            padding: 10px 16px;
            border-radius: 6px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-secondary {
            background: #e5e7eb;
            color: #333;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
        }

        .btn-secondary:hover {
            background: #d1d5db;
        }

        .btn-primary:hover {
            background: #1d4ed8;
        }

        .alert {
            background: #fee2e2;
            border: 1px solid #fca5a5;
            color: #991b1b;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .alert ul {
            margin: 0;
            padding-left: 20px;
        }

        @media (max-width: 700px) {
            .grid {
                grid-template-columns: 1fr;
            }

            body {
                padding: 15px;
            }

            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <div class="header">
        <div>
            <h1>Editar Cotización #{{ $cotizacion->id }}</h1>

            <div class="subtitle">
                Reparación {{ $cotizacion->reparacion->folio }}
            </div>
        </div>

        <a
            href="{{ route('cotizaciones.show', $cotizacion) }}"
            class="btn btn-secondary"
        >
            ← Volver
        </a>
    </div>

    @if ($errors->any())
        <div class="alert">
            <strong>Hay algunos errores:</strong>

            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">

        <form
            action="{{ route('cotizaciones.update', $cotizacion) }}"
            method="POST"
        >
            @csrf
            @method('PUT')

            <div class="field">
                <label for="reparacion_id">
                    Reparación
                </label>

                <select
                    id="reparacion_id"
                    name="reparacion_id"
                    required
                >
                    @foreach ($reparaciones as $reparacion)

                        <option
                            value="{{ $reparacion->id }}"
                            {{ old('reparacion_id', $cotizacion->reparacion_id) == $reparacion->id ? 'selected' : '' }}
                        >
                            {{ $reparacion->folio }}
                            -
                            {{ $reparacion->equipo->cliente->nombre }}
                            {{ $reparacion->equipo->cliente->apellidos }}
                            -
                            {{ $reparacion->equipo->marca }}
                            {{ $reparacion->equipo->modelo }}
                        </option>

                    @endforeach
                </select>
            </div>

            <div class="grid">

                <div class="field">
                    <label for="subtotal">
                        Subtotal
                    </label>

                    <input
                        type="number"
                        id="subtotal"
                        name="subtotal"
                        step="0.01"
                        min="0"
                        value="{{ old('subtotal', $cotizacion->subtotal) }}"
                        required
                    >
                </div>

                <div class="field">
                    <label for="descuento">
                        Descuento
                    </label>

                    <input
                        type="number"
                        id="descuento"
                        name="descuento"
                        step="0.01"
                        min="0"
                        value="{{ old('descuento', $cotizacion->descuento) }}"
                        required
                    >
                </div>

                <div class="field">
                    <label for="total">
                        Total
                    </label>

                    <input
                        type="number"
                        id="total"
                        name="total"
                        step="0.01"
                        min="0"
                        value="{{ old('total', $cotizacion->total) }}"
                        required
                    >
                </div>

            </div>

            <div class="field">
                <label for="estado">
                    Estado
                </label>

                <select
                    id="estado"
                    name="estado"
                    required
                >
                    @foreach (['Pendiente', 'Enviada', 'Aceptada', 'Rechazada', 'Vencida'] as $estado)

                        <option
                            value="{{ $estado }}"
                            {{ old('estado', $cotizacion->estado) === $estado ? 'selected' : '' }}
                        >
                            {{ $estado }}
                        </option>

                    @endforeach
                </select>
            </div>

            <div class="field">
                <label for="fecha_emision">
                    Fecha de emisión
                </label>

                <input
                    type="datetime-local"
                    id="fecha_emision"
                    name="fecha_emision"
                    value="{{ old('fecha_emision', $cotizacion->fecha_emision?->format('Y-m-d\TH:i')) }}"
                >
            </div>

            <div class="field">
                <label for="fecha_autorizacion">
                    Fecha de autorización
                </label>

                <input
                    type="datetime-local"
                    id="fecha_autorizacion"
                    name="fecha_autorizacion"
                    value="{{ old('fecha_autorizacion', $cotizacion->fecha_autorizacion?->format('Y-m-d\TH:i')) }}"
                >
            </div>

            <div class="field">
                <label for="notas">
                    Notas
                </label>

                <textarea
                    id="notas"
                    name="notas"
                    rows="5"
                >{{ old('notas', $cotizacion->notas) }}</textarea>
            </div>

            <div class="button-container">

                <a
                    href="{{ route('cotizaciones.show', $cotizacion) }}"
                    class="btn btn-secondary"
                >
                    Cancelar
                </a>

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Guardar cambios
                </button>

            </div>

        </form>

    </div>

</div>

</body>
</html>