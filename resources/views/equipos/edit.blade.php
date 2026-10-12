<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Editar Equipo - Taller Manager</title>

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
        <h1>✏️ Editar equipo</h1>
        <p>Modifica la información del equipo.</p>
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

        <form action="{{ route('equipos.update', $equipo) }}" method="POST">

            @csrf
            @method('PUT')

            <div class="form-group">

                <label for="cliente_id">Cliente *</label>

                <select id="cliente_id" name="cliente_id" required>

                    <option value="">
                        Selecciona un cliente
                    </option>

                    @foreach($clientes as $cliente)

                        <option
                            value="{{ $cliente->id }}"
                            {{ old('cliente_id', $equipo->cliente_id) == $cliente->id ? 'selected' : '' }}
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

                    <option value="Celular"
                        {{ old('tipo', $equipo->tipo) == 'Celular' ? 'selected' : '' }}>
                        Celular
                    </option>

                    <option value="Tablet"
                        {{ old('tipo', $equipo->tipo) == 'Tablet' ? 'selected' : '' }}>
                        Tablet
                    </option>

                    <option value="Laptop"
                        {{ old('tipo', $equipo->tipo) == 'Laptop' ? 'selected' : '' }}>
                        Laptop
                    </option>

                    <option value="Computadora"
                        {{ old('tipo', $equipo->tipo) == 'Computadora' ? 'selected' : '' }}>
                        Computadora
                    </option>

                    <option value="Consola"
                        {{ old('tipo', $equipo->tipo) == 'Consola' ? 'selected' : '' }}>
                        Consola
                    </option>

                    <option value="Otro"
                        {{ old('tipo', $equipo->tipo) == 'Otro' ? 'selected' : '' }}>
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
                    value="{{ old('marca', $equipo->marca) }}"
                    required
                >

            </div>


            <div class="form-group">

                <label for="modelo">Modelo *</label>

                <input
                    type="text"
                    id="modelo"
                    name="modelo"
                    value="{{ old('modelo', $equipo->modelo) }}"
                    required
                >

            </div>


            <div class="form-group">

                <label for="imei">IMEI</label>

                <input
                    type="text"
                    id="imei"
                    name="imei"
                    value="{{ old('imei', $equipo->imei) }}"
                >

            </div>


            <div class="form-group">

                <label for="numero_serie">Número de serie</label>

                <input
                    type="text"
                    id="numero_serie"
                    name="numero_serie"
                    value="{{ old('numero_serie', $equipo->numero_serie) }}"
                >

            </div>


            <div class="form-group">

                <label for="color">Color</label>

                <input
                    type="text"
                    id="color"
                    name="color"
                    value="{{ old('color', $equipo->color) }}"
                >

            </div>


            <div class="form-group">

                <label for="contrasena">Contraseña / PIN</label>

                <input
                    type="text"
                    id="contrasena"
                    name="contrasena"
                    value="{{ old('contrasena', $equipo->contrasena) }}"
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
                >{{ old('descripcion', $equipo->descripcion) }}</textarea>

            </div>


            <div class="form-group">

                <label for="notas">Notas</label>

                <textarea
                    id="notas"
                    name="notas"
                >{{ old('notas', $equipo->notas) }}</textarea>

            </div>


            <div class="buttons">

                <button type="submit" class="btn btn-primary">
                    Guardar cambios
                </button>

                <a href="{{ route('equipos.index') }}" class="btn btn-secondary">
                    Cancelar
                </a>

            </div>

        </form>

    </div>

</div>

</body>
</html>