<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes - Taller Manager</title>

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

        .btn {
            background: #2563eb;
            color: white;
            padding: 10px 16px;
            text-decoration: none;
            border-radius: 6px;
            border: none;
            cursor: pointer;
        }

        .btn:hover {
            background: #1d4ed8;
        }

.btn-danger {
    background: #dc2626;
    color: white;
}

.btn-danger:hover {
    background: #b91c1c;
}

        .success {
            background: #dcfce7;
            color: #166534;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 14px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }

        th {
            background: #f9fafb;
        }

        .empty {
            text-align: center;
            padding: 40px;
            color: #6b7280;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="header">
        <h1>👥 Clientes</h1>

        <a href="{{ route('clientes.create') }}" class="btn">
            + Nuevo cliente
        </a>
    </div>

    @if(session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">

        @if($clientes->count() > 0)

            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Teléfono</th>
                        <th>WhatsApp</th>
                        <th>Email</th>
                        <th>Registro</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($clientes as $cliente)

                        <tr>
                            <td>
                                {{ $cliente->nombre }}
                                {{ $cliente->apellidos }}
                            </td>

                            <td>
                                {{ $cliente->telefono }}
                            </td>

                            <td>
                                {{ $cliente->whatsapp ?? '—' }}
                            </td>

                            <td>
                                {{ $cliente->email ?? '—' }}
                            </td>

                            <td>
                                {{ $cliente->created_at->format('d/m/Y') }}
                            </td>
    
                        <td>
                            <a
                                href="{{ route('clientes.edit', $cliente) }}"
                                class="btn"
                            >
        ✏️ Editar
     </a>
<form
    action="{{ route('clientes.destroy', $cliente) }}"
    method="POST"
    style="display: inline;"
    onsubmit="return confirm('¿Seguro que quieres eliminar este cliente?');"
>
    @csrf
    @method('DELETE')

    <button type="submit" class="btn btn-danger">
        🗑️ Eliminar
    </button>
</form>

  </td>
</tr>

                    @endforeach

                </tbody>
            </table>

        @else

            <div class="empty">
                <h2>No hay clientes registrados</h2>
                <p>Comienza registrando el primer cliente del taller.</p>
            </div>

        @endif

    </div>

</div>

</body>
</html>
