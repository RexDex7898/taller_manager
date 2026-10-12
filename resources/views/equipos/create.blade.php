<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Equipo - Taller Manager</title>

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
            margin-bottom: 25px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 11px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 15px;
        }

        textarea {
            min-height: 90px;
            resize: vertical;
        }

        .buttons {
            display: flex;
            gap: 10px;
            margin-top: 25px;
        }

        .btn {
            padding: 11px 18px;
            border-radius: 6px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 15px;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
        }

        .btn-secondary {
            background: #e5e7eb;
            color: #111827;
        }

        .error {
            color: #dc2626;
            font-size: 14px;
            margin-top: 5px;
        }

        .hint {
            color: #6b7280;
            font-size: 13px;
            margin-top: 5px;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="header">
        <h1>📱 Nuevo equipo</h1>
        <p>Registra un equipo y asígnalo a un cliente.</p>
    </div>

    <div class="card">

        @if($errors->any())
            <div>
                <strong>Hay algunos errores:</strong>

                <ul>
                    @foreach($errors->all() as $error)
                        <li class="error">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if($clientes->count() === 0)

            <p>
                No hay clientes registrados.
                Primero debes registrar un cliente.
            </p>

            <a href="{{ route('clientes.create') }}" class="btn btn-primary">
                + Registrar cliente
            </a>

        @else

            <form action="{{ route('equipos.store') }}" method="POST">

                @csrf

                <div class="form-group">
                    <label for="cliente_id">Cliente *</label>

                    <select id="cliente_id" name="cliente_id" required>

                        <option value="">
                            Selecciona un cliente
                        </option>

                        @foreach($clientes as $cliente)

                            <option
                                value="{{ $cliente->id }}"
                                {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}
                            >
                                {{ $cliente->nombre }}
                                {{ $cliente->apellidos }}
                                — {{ $cliente->telefono }}
                            </option>

                        @endforeach

                    </select>
                </div>

                <div class="form-group">
                    <label for="tipo">Tipo de equipo *</label>

                    <select id="tipo" name="tipo" required>

                        <option value="">Selecciona un tipo</option>

                        <option value="Celular" {{ old('tipo') == 'Celular' ? 'selected' : '' }}>
                            Celular
                        </option>

                        <option value="Tablet" {{ old('tipo') == 'Tablet' ? 'selected' : '' }}>
                            Tablet
                        </option>

                        <option value="Laptop" {{ old('tipo') == 'Laptop' ? 'selected' : '' }}>
                            Laptop
                        </option>

                        <option value="Computadora" {{ old('tipo') == 'Computadora' ? 'selected' : '' }}>
                            Computadora
                        </option>

                        <option value="Consola" {{ old('tipo') == 'Consola' ? 'selected' : '' }}>
                            Consola
                        </option>

                        <option value="Otro" {{ old('tipo') == 'Otro' ? 'selected' : '' }}>
                            Otro
                        </option>

                    </select>
                </div>

                <div class="form-group">
                    <label for="marca">Marca *</label>

                    <input
                        type="text"
                        id="marca"
                        name="marca"
                        value="{{ old('marca') }}"
                        placeholder="Ej. Samsung"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="modelo">Modelo *</label>

                    <input
                        type="text"
                        id="modelo"
                        name="modelo"
                        value="{{ old('modelo') }}"
                        placeholder="Ej. Galaxy S23"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="imei">IMEI</label>

                    <input
                        type="text"
                        id="imei"
                        name="imei"
                        value="{{ old('imei') }}"
                        placeholder="Número IMEI"
                    >

                    <div class="hint">
                        Para celulares que tengan IMEI.
                    </div>
                </div>

                <div class="form-group">
                    <label for="numero_serie">Número de serie</label>

                    <input
                        type="text"
                        id="numero_serie"
                        name="numero_serie"
                        value="{{ old('numero_serie') }}"
                    >
                </div>

                <div class="form-group">
                    <label for="color">Color</label>

                    <input
                        type="text"
                        id="color"
                        name="color"
                        value="{{ old('color') }}"
                    >
                </div>

                <div class="form-group">
                    <label for="contrasena">Contraseña / PIN</label>

                    <input
                        type="text"
                        id="contrasena"
                        name="contrasena"
                        value="{{ old('contrasena') }}"
                    >

                    <div class="hint">
                        Información necesaria para realizar pruebas al equipo.
                    </div>
                </div>

                <div class="form-group">
                    <label for="descripcion">Descripción del equipo</label>

                    <textarea
                        id="descripcion"
                        name="descripcion"
                        placeholder="Ej. Tiene funda negra, pantalla con mica..."
                    >{{ old('descripcion') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="notas">Notas</label>

                    <textarea
                        id="notas"
                        name="notas"
                    >{{ old('notas') }}</textarea>
                </div>

                <div class="buttons">

                    <button type="submit" class="btn btn-primary">
                        Guardar equipo
                    </button>

                    <a href="{{ route('equipos.index') }}" class="btn btn-secondary">
                        Cancelar
                    </a>

                </div>

            </form>

        @endif

    </div>

</div>

</body>
</html>	
