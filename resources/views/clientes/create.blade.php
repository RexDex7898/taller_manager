<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Cliente - Taller Manager</title>

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
    </style>
</head>

<body>

<div class="container">

    <div class="header">
        <h1>➕ Nuevo cliente</h1>
        <p>Registra los datos del cliente del taller.</p>
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

        <form action="{{ route('clientes.store') }}" method="POST">

            @csrf

            <div class="form-group">
                <label for="nombre">Nombre *</label>

                <input
                    type="text"
                    id="nombre"
                    name="nombre"
                    value="{{ old('nombre') }}"
                    required
                >
            </div>

            <div class="form-group">
                <label for="apellidos">Apellidos</label>

                <input
                    type="text"
                    id="apellidos"
                    name="apellidos"
                    value="{{ old('apellidos') }}"
                >
            </div>

            <div class="form-group">
                <label for="telefono">Teléfono *</label>

                <input
                    type="text"
                    id="telefono"
                    name="telefono"
                    value="{{ old('telefono') }}"
                    required
                >
            </div>

            <div class="form-group">
                <label for="whatsapp">WhatsApp</label>

                <input
                    type="text"
                    id="whatsapp"
                    name="whatsapp"
                    value="{{ old('whatsapp') }}"
                >
            </div>

            <div class="form-group">
                <label for="email">Correo electrónico</label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                >
            </div>

            <div class="form-group">
                <label for="direccion">Dirección</label>

                <textarea
                    id="direccion"
                    name="direccion"
                >{{ old('direccion') }}</textarea>
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
                    Guardar cliente
                </button>

                <a href="{{ route('clientes.index') }}" class="btn btn-secondary">
                    Cancelar
                </a>

            </div>

        </form>

    </div>

</div>

</body>
</html>
