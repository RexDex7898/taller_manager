
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $reparacion->folio }} - Taller Manager</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            margin: 0;
            padding: 30px;
        }

        .container {
            max-width: 1100px;
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

        .folio {
            color: #2563eb;
        }

        .card {
            background: white;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .card h2 {
            margin-top: 0;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 12px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .campo {
            margin-bottom: 15px;
        }

        .campo strong {
            display: block;
            color: #374151;
            margin-bottom: 5px;
        }

        .campo span {
            color: #111827;
        }

        .badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            background: #e5e7eb;
            color: #374151;
            font-weight: bold;
        }

        .problema,
        .notas {
            background: #f9fafb;
            padding: 15px;
            border-radius: 6px;
            white-space: pre-line;
        }

        .acciones {
            display: flex;
            gap: 10px;
        }

        .btn {
            background: #2563eb;
            color: white;
            padding: 10px 16px;
            text-decoration: none;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            display: inline-block;
        }

        .btn:hover {
            background: #1d4ed8;
        }

        .btn-secondary {
            background: #6b7280;
        }

        .btn-secondary:hover {
            background: #4b5563;
        }

        .btn-success {
            background: #16a34a;
        }

        .btn-success:hover {
            background: #15803d;
        }

        label {
            display: block;
            font-weight: bold;
            color: #374151;
            margin-bottom: 7px;
        }

        textarea,
        select {
            width: 100%;
            padding: 11px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
            font-size: 14px;
        }

        textarea {
            min-height: 140px;
            resize: vertical;
        }

        textarea:focus,
        select:focus {
            outline: none;
            border-color: #2563eb;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .success {
            background: #dcfce7;
            color: #166534;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .error ul {
            margin: 5px 0 0 20px;
        }

        @media (max-width: 700px) {

            .grid {
                grid-template-columns: 1fr;
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

            <h1>
                Reparación
                <span class="folio">
                    {{ $reparacion->folio }}
                </span>
            </h1>

            <p>
                Detalle de la orden de servicio.
            </p>

        </div>


        <div class="acciones">

            <a
                href="{{ route('reparaciones.index') }}"
                class="btn btn-secondary"
            >
                ← Volver
            </a>

        </div>

    </div>


    @if(session('success'))

        <div class="success">
            {{ session('success') }}
        </div>

    @endif


    @if($errors->any())

        <div class="error">

            <strong>Hay algunos errores:</strong>

            <ul>

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    <!-- INFORMACIÓN DE LA REPARACIÓN -->

    <div class="card">

        <h2>
            🔧 Información de la reparación
        </h2>

        <div class="grid">

            <div class="campo">

                <strong>Folio</strong>

                <span>
                    {{ $reparacion->folio }}
                </span>

            </div>


            <div class="campo">

                <strong>Estado</strong>

                <span class="badge">
                    {{ $reparacion->estado }}
                </span>

            </div>


            <div class="campo">

                <strong>Prioridad</strong>

                <span class="badge">
                    {{ $reparacion->prioridad }}
                </span>

            </div>


            <div class="campo">

                <strong>Fecha de ingreso</strong>

                <span>
                    {{ $reparacion->fecha_ingreso->format('d/m/Y H:i') }}
                </span>

            </div>


            <div class="campo">

                <strong>Fecha estimada</strong>

                <span>

                    @if($reparacion->fecha_estimada)

                        {{ $reparacion->fecha_estimada->format('d/m/Y H:i') }}

                    @else

                        No definida

                    @endif

                </span>

            </div>


            <div class="campo">

                <strong>Fecha de entrega</strong>

                <span>

                    @if($reparacion->fecha_entrega)

                        {{ $reparacion->fecha_entrega->format('d/m/Y H:i') }}

                    @else

                        No entregado

                    @endif

                </span>

            </div>

        </div>

    </div>


    <!-- CLIENTE -->

    <div class="card">

        <h2>
            👤 Cliente
        </h2>

        <div class="grid">

            <div class="campo">

                <strong>Nombre</strong>

                <span>
                    {{ $reparacion->equipo->cliente->nombre }}
                    {{ $reparacion->equipo->cliente->apellidos }}
                </span>

            </div>


            <div class="campo">

                <strong>Teléfono</strong>

                <span>
                    {{ $reparacion->equipo->cliente->telefono }}
                </span>

            </div>


            <div class="campo">

                <strong>WhatsApp</strong>

                <span>
                    {{ $reparacion->equipo->cliente->whatsapp ?? 'No registrado' }}
                </span>

            </div>


            <div class="campo">

                <strong>Email</strong>

                <span>
                    {{ $reparacion->equipo->cliente->email ?? 'No registrado' }}
                </span>

            </div>

        </div>

    </div>


    <!-- EQUIPO -->

    <div class="card">

        <h2>
            📱 Equipo
        </h2>

        <div class="grid">

            <div class="campo">

                <strong>Tipo</strong>

                <span>
                    {{ $reparacion->equipo->tipo }}
                </span>

            </div>


            <div class="campo">

                <strong>Marca</strong>

                <span>
                    {{ $reparacion->equipo->marca }}
                </span>

            </div>


            <div class="campo">

                <strong>Modelo</strong>

                <span>
                    {{ $reparacion->equipo->modelo }}
                </span>

            </div>


            <div class="campo">

                <strong>IMEI</strong>

                <span>
                    {{ $reparacion->equipo->imei ?? 'No registrado' }}
                </span>

            </div>


            <div class="campo">

                <strong>Número de serie</strong>

                <span>
                    {{ $reparacion->equipo->numero_serie ?? 'No registrado' }}
                </span>

            </div>


            <div class="campo">

                <strong>Color</strong>

                <span>
                    {{ $reparacion->equipo->color ?? 'No registrado' }}
                </span>

            </div>

        </div>

    </div>


    <!-- PROBLEMA REPORTADO -->

    <div class="card">

        <h2>
            📝 Problema reportado
        </h2>

        <div class="problema">
            {{ $reparacion->problema_reportado }}
        </div>

    </div>


    <!-- DIAGNÓSTICO Y ESTADO -->

    <div class="card">

        <h2>
            🔍 Diagnóstico y estado
        </h2>


        <form
            action="{{ route('reparaciones.update', $reparacion) }}"
            method="POST"
        >

            @csrf
            @method('PUT')


            <!-- Campos necesarios para la actualización -->

            <input
                type="hidden"
                name="equipo_id"
                value="{{ $reparacion->equipo_id }}"
            >

            <input
                type="hidden"
                name="problema_reportado"
                value="{{ $reparacion->problema_reportado }}"
            >

            <input
                type="hidden"
                name="fecha_ingreso"
                value="{{ $reparacion->fecha_ingreso->format('Y-m-d H:i:s') }}"
            >

            <input
                type="hidden"
                name="fecha_estimada"
                value="{{ $reparacion->fecha_estimada?->format('Y-m-d H:i:s') }}"
            >

            <input
                type="hidden"
                name="fecha_entrega"
                value="{{ $reparacion->fecha_entrega?->format('Y-m-d H:i:s') }}"
            >

            <input
                type="hidden"
                name="notas"
                value="{{ $reparacion->notas }}"
            >


            <div class="form-group">

                <label for="diagnostico">
                    Diagnóstico técnico
                </label>

                <textarea
                    name="diagnostico"
                    id="diagnostico"
                    placeholder="Describe qué encontraste en el equipo..."
                >{{ old('diagnostico', $reparacion->diagnostico) }}</textarea>

            </div>


            <div class="grid">

                <div class="form-group">

                    <label for="estado">
                        Estado de la reparación
                    </label>

                    <select
                        name="estado"
                        id="estado"
                        required
                    >

                        <option value="Recibido"
                            {{ old('estado', $reparacion->estado) == 'Recibido' ? 'selected' : '' }}>
                            Recibido
                        </option>

                        <option value="Diagnóstico"
                            {{ old('estado', $reparacion->estado) == 'Diagnóstico' ? 'selected' : '' }}>
                            Diagnóstico
                        </option>

                        <option value="Cotización pendiente"
                            {{ old('estado', $reparacion->estado) == 'Cotización pendiente' ? 'selected' : '' }}>
                            Cotización pendiente
                        </option>

                        <option value="Esperando autorización"
                            {{ old('estado', $reparacion->estado) == 'Esperando autorización' ? 'selected' : '' }}>
                            Esperando autorización
                        </option>

                        <option value="Esperando refacción"
                            {{ old('estado', $reparacion->estado) == 'Esperando refacción' ? 'selected' : '' }}>
                            Esperando refacción
                        </option>

                        <option value="En reparación"
                            {{ old('estado', $reparacion->estado) == 'En reparación' ? 'selected' : '' }}>
                            En reparación
                        </option>

                        <option value="En pruebas"
                            {{ old('estado', $reparacion->estado) == 'En pruebas' ? 'selected' : '' }}>
                            En pruebas
                        </option>

                        <option value="Listo para entrega"
                            {{ old('estado', $reparacion->estado) == 'Listo para entrega' ? 'selected' : '' }}>
                            Listo para entrega
                        </option>

                        <option value="Entregado"
                            {{ old('estado', $reparacion->estado) == 'Entregado' ? 'selected' : '' }}>
                            Entregado
                        </option>

                        <option value="Cancelado"
                            {{ old('estado', $reparacion->estado) == 'Cancelado' ? 'selected' : '' }}>
                            Cancelado
                        </option>

                    </select>

                </div>


                <div class="form-group">

                    <label for="prioridad">
                        Prioridad
                    </label>

                    <select
                        name="prioridad"
                        id="prioridad"
                        required
                    >

                        <option value="Baja"
                            {{ old('prioridad', $reparacion->prioridad) == 'Baja' ? 'selected' : '' }}>
                            Baja
                        </option>

                        <option value="Normal"
                            {{ old('prioridad', $reparacion->prioridad) == 'Normal' ? 'selected' : '' }}>
                            Normal
                        </option>

                        <option value="Alta"
                            {{ old('prioridad', $reparacion->prioridad) == 'Alta' ? 'selected' : '' }}>
                            Alta
                        </option>

                        <option value="Urgente"
                            {{ old('prioridad', $reparacion->prioridad) == 'Urgente' ? 'selected' : '' }}>
                            Urgente
                        </option>

                    </select>

                </div>

            </div>


            <button
                type="submit"
                class="btn btn-success"
            >
                💾 Guardar cambios
            </button>

        </form>

    </div>


    <!-- NOTAS -->

    <div class="card">

        <h2>
            📌 Notas
        </h2>

        <div class="notas">

            @if($reparacion->notas)

                {{ $reparacion->notas }}

            @else

                <span style="color: #6b7280;">
                    No hay notas registradas.
                </span>

            @endif

        </div>

    </div>


</div>

</body>

</html>
