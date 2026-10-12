```blade
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cotización #{{ $cotizacion->id }} - Taller Manager</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            margin: 0;
            padding: 30px;
        }

        .container {
            max-width: 1000px;
            margin: auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .header h1 {
            margin: 0;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .card h2 {
            margin-top: 0;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 10px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .info-item {
            padding: 12px;
            background: #f9fafb;
            border-radius: 6px;
        }

        .info-item strong {
            display: block;
            margin-bottom: 5px;
            color: #374151;
        }

        .money {
            max-width: 400px;
            margin-left: auto;
        }

        .money-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .money-total {
            display: flex;
            justify-content: space-between;
            padding: 18px 0;
            font-size: 22px;
            font-weight: bold;
        }

        .status {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            background: #fef3c7;
            color: #92400e;
            font-weight: bold;
        }

        .notes {
            white-space: pre-line;
            background: #f9fafb;
            padding: 15px;
            border-radius: 6px;
        }

        .actions {
            display: flex;
            gap: 10px;
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

        .btn-secondary {
            background: #6b7280;
        }

        .btn-danger {
            background: #dc2626;
        }

        .btn-success {
            background: #16a34a;
        }

        .alert {
            padding: 12px 15px;
            background: #dcfce7;
            color: #166534;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        /* Tabla de conceptos */

        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .details-table th {
            padding: 12px;
            text-align: left;
            background: #f4f6f8;
            border-bottom: 1px solid #ddd;
            color: #374151;
        }

        .details-table td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }

        .text-right {
            text-align: right !important;
        }

        .empty-details {
            padding: 20px;
            text-align: center;
            color: #666;
            background: #f9fafb;
            border-radius: 6px;
            margin-top: 15px;
        }

        @media (max-width: 700px) {
            body {
                padding: 15px;
            }

            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .details-table {
                font-size: 13px;
            }

            .details-table th,
            .details-table td {
                padding: 8px;
            }
        }
    </style>
</head>

<body>

<div class="container">

    {{-- ENCABEZADO --}}

    <div class="header">

        <div>
            <h1>💰 Cotización #{{ $cotizacion->id }}</h1>

            <p>
                Reparación:
                <strong>
                    {{ $cotizacion->reparacion->folio }}
                </strong>
            </p>
        </div>

        <div class="actions">

            <a
                href="{{ route('cotizaciones.index') }}"
                class="btn btn-secondary"
            >
                ← Volver
            </a>

            <a
                href="{{ route('cotizaciones.edit', $cotizacion) }}"
                class="btn"
            >
                ✏️ Editar
            </a>

        </div>

    </div>


    {{-- MENSAJE DE ÉXITO --}}

    @if(session('success'))

        <div class="alert">
            {{ session('success') }}
        </div>

    @endif


    {{-- INFORMACIÓN DEL CLIENTE --}}

    <div class="card">

        <h2>👤 Cliente</h2>

        <div class="info-grid">

            <div class="info-item">

                <strong>Nombre</strong>

                {{ $cotizacion->reparacion->equipo->cliente->nombre }}
                {{ $cotizacion->reparacion->equipo->cliente->apellidos }}

            </div>

            <div class="info-item">

                <strong>Teléfono</strong>

                {{ $cotizacion->reparacion->equipo->cliente->telefono }}

            </div>

            <div class="info-item">

                <strong>WhatsApp</strong>

                {{ $cotizacion->reparacion->equipo->cliente->whatsapp ?: '—' }}

            </div>

            <div class="info-item">

                <strong>Email</strong>

                {{ $cotizacion->reparacion->equipo->cliente->email ?: '—' }}

            </div>

        </div>

    </div>


    {{-- INFORMACIÓN DEL EQUIPO --}}

    <div class="card">

        <h2>📱 Equipo</h2>

        <div class="info-grid">

            <div class="info-item">

                <strong>Tipo</strong>

                {{ $cotizacion->reparacion->equipo->tipo }}

            </div>

            <div class="info-item">

                <strong>Marca</strong>

                {{ $cotizacion->reparacion->equipo->marca }}

            </div>

            <div class="info-item">

                <strong>Modelo</strong>

                {{ $cotizacion->reparacion->equipo->modelo }}

            </div>

            <div class="info-item">

                <strong>IMEI / Número de serie</strong>

                {{ $cotizacion->reparacion->equipo->imei
                    ?: $cotizacion->reparacion->equipo->numero_serie
                    ?: '—'
                }}

            </div>

        </div>

    </div>


    {{-- INFORMACIÓN DE LA REPARACIÓN --}}

    <div class="card">

        <h2>🔧 Reparación</h2>

        <div class="info-grid">

            <div class="info-item">

                <strong>Folio</strong>

                {{ $cotizacion->reparacion->folio }}

            </div>

            <div class="info-item">

                <strong>Estado de la reparación</strong>

                {{ $cotizacion->reparacion->estado }}

            </div>

            <div class="info-item">

                <strong>Problema reportado</strong>

                {{ $cotizacion->reparacion->problema_reportado }}

            </div>

            <div class="info-item">

                <strong>Diagnóstico</strong>

                {{ $cotizacion->reparacion->diagnostico ?: 'Pendiente' }}

            </div>

        </div>

    </div>


    {{-- CONCEPTOS DE LA COTIZACIÓN --}}

    <div class="card">

        <h2>🧾 Conceptos de la cotización</h2>

        @if($cotizacion->detalles->count() > 0)

            <table class="details-table">

                <thead>

                    <tr>

                        <th>
                            Concepto
                        </th>

                        <th>
                            Tipo
                        </th>

                        <th class="text-right">
                            Cantidad
                        </th>

                        <th class="text-right">
                            Precio unitario
                        </th>

                        <th class="text-right">
                            Total
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($cotizacion->detalles as $detalle)

                        <tr>

                            <td>
                                {{ $detalle->concepto }}
                            </td>

                            <td>
                                {{ $detalle->tipo }}
                            </td>

                            <td class="text-right">
                                {{ number_format($detalle->cantidad, 2) }}
                            </td>

                            <td class="text-right">
                                ${{ number_format($detalle->precio_unitario, 2) }}
                            </td>

                            <td class="text-right">
                                ${{ number_format($detalle->total, 2) }}
                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        @else

            <div class="empty-details">

                Esta cotización todavía no tiene conceptos registrados.

            </div>

        @endif

    </div>


    {{-- INFORMACIÓN DE LA COTIZACIÓN --}}

    <div class="card">

        <h2>💵 Información de la cotización</h2>

        <div class="info-grid">

            <div class="info-item">

                <strong>Estado</strong>

                <span class="status">
                    {{ $cotizacion->estado }}
                </span>

            </div>

            <div class="info-item">

                <strong>Fecha de emisión</strong>

                {{ $cotizacion->fecha_emision
                    ? $cotizacion->fecha_emision->format('d/m/Y H:i')
                    : '—'
                }}

            </div>

            <div class="info-item">

                <strong>Fecha de autorización</strong>

                {{ $cotizacion->fecha_autorizacion
                    ? $cotizacion->fecha_autorizacion->format('d/m/Y H:i')
                    : '—'
                }}

            </div>

        </div>


        {{-- TOTALES --}}

        <div class="money">

            <div class="money-row">

                <span>Subtotal</span>

                <span>
                    ${{ number_format($cotizacion->subtotal, 2) }}
                </span>

            </div>

            <div class="money-row">

                <span>Descuento</span>

                <span>
                    - ${{ number_format($cotizacion->descuento, 2) }}
                </span>

            </div>

            <div class="money-total">

                <span>Total</span>

                <span>
                    ${{ number_format($cotizacion->total, 2) }}
                </span>

            </div>

        </div>

    </div>


    {{-- NOTAS --}}

    @if($cotizacion->notas)

        <div class="card">

            <h2>📝 Notas</h2>

            <div class="notes">
                {{ $cotizacion->notas }}
            </div>

        </div>

    @endif


    {{-- ACCIONES --}}

    <div class="card">

        <div class="actions">

            <a
                href="{{ route('cotizaciones.edit', $cotizacion) }}"
                class="btn"
            >
                ✏️ Editar cotización
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
                    🗑️ Eliminar
                </button>

            </form>

        </div>

    </div>

</div>

</body>
</html>
```
