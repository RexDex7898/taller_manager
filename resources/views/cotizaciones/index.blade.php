<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cotizaciones - Taller Manager</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            margin: 0;
            padding: 30px;
        }

        .container {
            max-width: 1200px;
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
        }

        .btn {
            display: inline-block;
            padding: 10px 15px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            border: none;
            cursor: pointer;
        }

        .btn-danger {
            background: #dc2626;
        }

        .btn-secondary {
            background: #6b7280;
        }

        .alert {
            padding: 12px 15px;
            background: #dcfce7;
            color: #166534;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 14px;
            border-bottom: 1px solid #e5e7eb;
            text-align: left;
        }

        th {
            background: #f9fafb;
        }

        .actions {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .empty {
            text-align: center;
            padding: 40px;
            background: white;
            border-radius: 8px;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="header">
        <h1>💰 Cotizaciones</h1>

        <a href="{{ route('cotizaciones.create') }}" class="btn">
            + Nueva cotización
        </a>
    </div>

    @if(session('success'))
        <div class="alert">
            {{ session('success') }}
        </div>
    @endif

    @if($cotizaciones->count())

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Equipo</th>
                    <th>Reparación</th>
                    <th>Subtotal</th>
                    <th>Descuento</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>

                @foreach($cotizaciones as $cotizacion)

                    <tr>

                        <td>
                            #{{ $cotizacion->id }}
                        </td>

                        <td>
                            {{ $cotizacion->reparacion->equipo->cliente->nombre }}
                            {{ $cotizacion->reparacion->equipo->cliente->apellidos }}
                        </td>

                        <td>
                            {{ $cotizacion->reparacion->equipo->marca }}
                            {{ $cotizacion->reparacion->equipo->modelo }}
                        </td>

                        <td>
                            {{ $cotizacion->reparacion->folio }}
                        </td>

                        <td>
                            ${{ number_format($cotizacion->subtotal, 2) }}
                        </td>

                        <td>
                            ${{ number_format($cotizacion->descuento, 2) }}
                        </td>

                        <td>
                            <strong>
                                ${{ number_format($cotizacion->total, 2) }}
                            </strong>
                        </td>

                        <td>
                            {{ $cotizacion->estado }}
                        </td>

                        <td>
                            {{ $cotizacion->fecha_emision
                                ? $cotizacion->fecha_emision->format('d/m/Y H:i')
                                : '—'
                            }}
                        </td>

                        <td>

                            <div class="actions">

                                <a
                                    href="{{ route('cotizaciones.show', $cotizacion) }}"
                                    class="btn"
                                >
                                    👁️ Ver
                                </a>

                                <form
                                    action="{{ route('cotizaciones.destroy', $cotizacion) }}"
                                    method="POST"
                                    onsubmit="return confirm('¿Seguro que quieres eliminar esta cotización?');"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-danger"
                                    >
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

        <div class="empty">

            <h2>No hay cotizaciones registradas</h2>

            <p>
                Cuando registres una cotización aparecerá aquí.
            </p>

            <a href="{{ route('cotizaciones.create') }}" class="btn">
                + Nueva cotización
            </a>

        </div>

    @endif

</div>

</body>
</html>