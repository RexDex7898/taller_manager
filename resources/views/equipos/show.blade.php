<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Detalle del Equipo - Taller Manager</title>

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

        .header h1 {
            margin: 0;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            margin-bottom: 20px;
        }

        .card h2 {
            margin-top: 0;
            margin-bottom: 20px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }

        .info-item {
            padding: 12px;
            background: #f9fafb;
            border-radius: 6px;
        }

        .label {
            display: block;
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 5px;
        }

        .value {
            font-size: 16px;
            font-weight: bold;
            color: #111827;
        }

        .full {
            grid-column: 1 / -1;
        }

        .buttons {
            display: flex;
            gap: 10px;
            margin-top: 20px;
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

        @media (max-width: 650px) {
            .info-grid {
                grid-template-columns: 1fr;
            }

            .full {
                grid-column: auto;
            }

            .header {
                display: block;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <div class="header">
        <div>
            <h1>📱 {{ $equipo->marca }} {{ $equipo->modelo }}</h1>
            <p>Detalle del equipo registrado.</p>
        </div>
    </div>


    <div class="card">

        <h2>Información del equipo</h2>

        <div class="info-grid">

            <div class="info-item">
                <span class="label">Tipo</span>
                <span class="value">{{ $equipo->tipo }}</span>
            </div>

            <div class="info-item">
                <span class="label">Marca</span>
                <span class="value">{{ $equipo->marca }}</span>
            </div>

            <div class="info-item">
                <span class="label">Modelo</span>
                <span class="value">{{ $equipo->modelo }}</span>
            </div>

            <div class="info-item">
                <span class="label">Color</span>
                <span class="value">{{ $equipo->color ?: 'No especificado' }}</span>
            </div>

            <div class="info-item">
                <span class="label">IMEI</span>
                <span class="value">{{ $equipo->imei ?: 'No especificado' }}</span>
            </div>

            <div class="info-item">
                <span class="label">Número de serie</span>
                <span class="value">{{ $equipo->numero_serie ?: 'No especificado' }}</span>
            </div>

            <div class="info-item">
                <span class="label">Contraseña / PIN</span>
                <span class="value">{{ $equipo->contrasena ?: 'No especificado' }}</span>
            </div>

            <div class="info-item">
                <span class="label">Fecha de registro</span>
                <span class="value">
                    {{ $equipo->created_at->format('d/m/Y H:i') }}
                </span>
            </div>

            <div class="info-item full">
                <span class="label">Descripción</span>
                <span class="value">
                    {{ $equipo->descripcion ?: 'Sin descripción' }}
                </span>
            </div>

            <div class="info-item full">
                <span class="label">Notas</span>
                <span class="value">
                    {{ $equipo->notas ?: 'Sin notas' }}
                </span>
            </div>

        </div>

    </div>


    <div class="card">

        <h2>👤 Cliente</h2>

        <div class="info-grid">

            <div class="info-item">
                <span class="label">Nombre</span>
                <span class="value">
                    {{ $equipo->cliente->nombre }}
                    {{ $equipo->cliente->apellidos }}
                </span>
            </div>

            <div class="info-item">
                <span class="label">Teléfono</span>
                <span class="value">
                    {{ $equipo->cliente->telefono }}
                </span>
            </div>

            <div class="info-item">
                <span class="label">WhatsApp</span>
                <span class="value">
                    {{ $equipo->cliente->whatsapp ?: 'No registrado' }}
                </span>
            </div>

            <div class="info-item">
                <span class="label">Correo</span>
                <span class="value">
                    {{ $equipo->cliente->email ?: 'No registrado' }}
                </span>
            </div>

        </div>

    </div>


    <div class="buttons">

        <a href="{{ route('equipos.edit', $equipo) }}" class="btn btn-primary">
            ✏️ Editar equipo
        </a>

        <a href="{{ route('equipos.index') }}" class="btn btn-secondary">
            ← Volver a equipos
        </a>

    </div>

</div>

</body>
</html>