<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Nueva reparación - Taller Manager</title>

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
        }

        .card {
            background: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            color: #374151;
            margin-bottom: 7px;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 11px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
            font-size: 14px;
        }

        textarea {
            min-height: 110px;
            resize: vertical;
        }

        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: #2563eb;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .help {
            font-size: 13px;
            color: #6b7280;
            margin-top: 5px;
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

        .actions {
            display: flex;
            gap: 10px;
            margin-top: 25px;
        }

        .btn {
            background: #2563eb;
            color: white;
            padding: 11px 18px;
            text-decoration: none;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-size: 14px;
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
            <h1>🔧 Nueva reparación</h1>
            <p>Registrar una nueva orden de servicio.</p>
        </div>

    </div>


    <div class="card">

        @if($errors->any())

            <div class="error">

                <strong>Hay algunos errores:</strong>

                <ul>

                    @foreach($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif


        <form
            action="{{ route('reparaciones.store') }}"
            method="POST"
        >

            @csrf


            <!-- EQUIPO -->

            <div class="form-group">

                <label for="equipo_id">
                    Equipo
                </label>

                <select
                    name="equipo_id"
                    id="equipo_id"
                    required
                >

                    <option value="">
                        Selecciona un equipo
                    </option>

                    @foreach($equipos as $equipo)

                        <option
                            value="{{ $equipo->id }}"
                            {{ old('equipo_id') == $equipo->id ? 'selected' : '' }}
                        >

                            {{ $equipo->cliente->nombre }}
                            {{ $equipo->cliente->apellidos }}
                            -
                            {{ $equipo->marca }}
                            {{ $equipo->modelo }}

                        </option>

                    @endforeach

                </select>

                <div class="help">
                    Selecciona el equipo que ingresó al taller.
                </div>

            </div>


            <!-- PROBLEMA -->

            <div class="form-group">

                <label for="problema_reportado">
                    Problema reportado
                </label>

                <textarea
                    name="problema_reportado"
                    id="problema_reportado"
                    placeholder="Describe el problema que reporta el cliente..."
                    required
                >{{ old('problema_reportado') }}</textarea>

            </div>


            <!-- DIAGNÓSTICO -->

            <div class="form-group">

                <label for="diagnostico">
                    Diagnóstico inicial
                </label>

                <textarea
                    name="diagnostico"
                    id="diagnostico"
                    placeholder="Puedes dejarlo vacío si todavía no se ha realizado el diagnóstico..."
                >{{ old('diagnostico') }}</textarea>

                <div class="help">
                    Este campo puede completarse después.
                </div>

            </div>


            <!-- ESTADO Y PRIORIDAD -->

            <div class="grid">

                <div class="form-group">

                    <label for="estado">
                        Estado
                    </label>

                    <select
                        name="estado"
                        id="estado"
                        required
                    >

                        <option value="Recibido"
                            {{ old('estado', 'Recibido') == 'Recibido' ? 'selected' : '' }}>
                            Recibido
                        </option>

                        <option value="Diagnóstico"
                            {{ old('estado') == 'Diagnóstico' ? 'selected' : '' }}>
                            Diagnóstico
                        </option>

                        <option value="Cotización pendiente"
                            {{ old('estado') == 'Cotización pendiente' ? 'selected' : '' }}>
                            Cotización pendiente
                        </option>

                        <option value="Esperando autorización"
                            {{ old('estado') == 'Esperando autorización' ? 'selected' : '' }}>
                            Esperando autorización
                        </option>

                        <option value="Esperando refacción"
                            {{ old('estado') == 'Esperando refacción' ? 'selected' : '' }}>
                            Esperando refacción
                        </option>

                        <option value="En reparación"
                            {{ old('estado') == 'En reparación' ? 'selected' : '' }}>
                            En reparación
                        </option>

                        <option value="En pruebas"
                            {{ old('estado') == 'En pruebas' ? 'selected' : '' }}>
                            En pruebas
                        </option>

                        <option value="Listo para entrega"
                            {{ old('estado') == 'Listo para entrega' ? 'selected' : '' }}>
                            Listo para entrega
                        </option>

                        <option value="Entregado"
                            {{ old('estado') == 'Entregado' ? 'selected' : '' }}>
                            Entregado
                        </option>

                        <option value="Cancelado"
                            {{ old('estado') == 'Cancelado' ? 'selected' : '' }}>
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
                            {{ old('prioridad', 'Normal') == 'Baja' ? 'selected' : '' }}>
                            Baja
                        </option>

                        <option value="Normal"
                            {{ old('prioridad', 'Normal') == 'Normal' ? 'selected' : '' }}>
                            Normal
                        </option>

                        <option value="Alta"
                            {{ old('prioridad') == 'Alta' ? 'selected' : '' }}>
                            Alta
                        </option>

                        <option value="Urgente"
                            {{ old('prioridad') == 'Urgente' ? 'selected' : '' }}>
                            Urgente
                        </option>

                    </select>

                </div>

            </div>


            <!-- FECHAS -->

            <div class="grid">

                <div class="form-group">

                    <label for="fecha_ingreso">
                        Fecha de ingreso
                    </label>

                    <input
                        type="datetime-local"
                        name="fecha_ingreso"
                        id="fecha_ingreso"
                        value="{{ old('fecha_ingreso', now()->format('Y-m-d\TH:i')) }}"
                        required
                    >

                </div>


                <div class="form-group">

                    <label for="fecha_estimada">
                        Fecha estimada de entrega
                    </label>

                    <input
                        type="datetime-local"
                        name="fecha_estimada"
                        id="fecha_estimada"
                        value="{{ old('fecha_estimada') }}"
                    >

                </div>

            </div>


            <!-- NOTAS -->

            <div class="form-group">

                <label for="notas">
                    Notas
                </label>

                <textarea
                    name="notas"
                    id="notas"
                    placeholder="Notas internas sobre esta reparación..."
                >{{ old('notas') }}</textarea>

            </div>


            <!-- BOTONES -->

            <div class="actions">

                <button
                    type="submit"
                    class="btn"
                >
                    💾 Registrar reparación
                </button>

                <a
                    href="{{ route('reparaciones.index') }}"
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
