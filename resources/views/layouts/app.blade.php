<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taller Manager</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: system-ui, -apple-system, sans-serif; background: #f4f6f8; color: #1f2937; }

        .layout { display: flex; height: 100vh; overflow: hidden; }

        .sidebar { 
            width: 240px; 
            flex-shrink: 0; 
            background: #111827; 
            color: white; 
            padding: 25px 15px; 
            display: flex;
            flex-direction: column;
        }

        .logo { font-size: 20px; font-weight: bold; margin-bottom: 30px; padding-left: 10px; }
        .menu a { display: block; color: #d1d5db; text-decoration: none; padding: 12px 15px; border-radius: 8px; margin-bottom: 5px; font-size: 14px; transition: all 0.2s; }
        .menu a:hover, .menu .active { background: #2563eb; color: white; }

        .content { 
            flex: 1; 
            min-width: 0; 
            padding: 30px; 
            overflow-y: auto; 
            display: flex;
            flex-direction: column;
        }

        .header { margin-bottom: 25px; }
        .header h1 { margin: 0; font-size: 26px; font-weight: 700; }
        .header p { color: #6b7280; margin: 5px 0 0 0; font-size: 14px; }

        .cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 25px; }
        .card { background: white; padding: 20px; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,.08); border: 1px solid #e5e7eb; }
        .card h3 { margin: 0 0 8px; font-size: 13px; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px; }
        .number { font-size: 32px; font-weight: 800; color: #111827; }

        .table-container { background: white; padding: 20px; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,.08); border: 1px solid #e5e7eb; }
        table { width: 100%; border-collapse: collapse; }
        th, td { text-align: left; padding: 12px 14px; border-bottom: 1px solid #e5e7eb; font-size: 14px; }
        th { color: #6b7280; font-weight: 600; font-size: 12px; text-transform: uppercase; }

        .status { padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; display: inline-block; }

        .btn {
            background: #2563eb;
            color: white;
            padding: 8px 14px;
            text-decoration: none;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-size: 13px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        .btn:hover { background: #1d4ed8; }
        .btn-danger { background: #dc2626; }
        .btn-danger:hover { background: #b91c1c; }
        .btn-success { background: #16a34a; }
        .btn-success:hover { background: #15803d; }
        .btn-warning { background: #eab308; color: white; }
        .btn-warning:hover { background: #ca8a04; }

        .success-alert {
            background: #dcfce7;
            color: #166534;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            border: 1px solid #bbf7d0;
        }

        .kanban-container { 
            display: flex; 
            gap: 15px; 
            overflow-x: auto; 
            padding-bottom: 15px; 
            flex: 1;
            align-items: flex-start;
        }

        .kanban-column { 
            background: #f1f5f9; 
            border-radius: 10px; 
            padding: 15px; 
            width: 290px; 
            min-width: 290px; 
            border: 1px solid #e2e8f0;
            max-height: 100%;
            overflow-y: auto;
        }

        .kanban-column h3 { 
            margin: 0 0 12px 0; 
            font-size: 14px; 
            font-weight: 700; 
            color: #334155; 
            display: flex; 
            justify-content: space-between; 
            align-items: center;
        }

        .kanban-card { 
            background: white; 
            padding: 14px; 
            border-radius: 8px; 
            box-shadow: 0 1px 2px rgba(0,0,0,0.06); 
            margin-bottom: 12px; 
            border-left: 4px solid #2563eb; 
            border-top: 1px solid #f1f5f9;
            border-right: 1px solid #f1f5f9;
            border-bottom: 1px solid #f1f5f9;
        }

        .kanban-card h4 { margin: 0 0 6px 0; font-size: 14px; font-weight: 700; color: #0f172a; }
        .kanban-card p { margin: 4px 0; font-size: 12px; color: #64748b; }
        .kanban-action { margin-top: 10px; padding-top: 8px; border-top: 1px solid #f1f5f9; }
        .kanban-select { font-size: 12px; padding: 6px; border: 1px solid #cbd5e1; border-radius: 6px; background: #f8fafc; width: 100%; cursor: pointer; }

        @media (max-width: 600px) { .sidebar { display: none; } .content { padding: 20px; } }
    </style>
</head>
<body>

<div class="layout">
    <aside class="sidebar">
        <div class="logo">🔧 Taller Manager</div>
        <nav class="menu">
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">📊 Dashboard</a>
            <a href="{{ route('reparaciones.index') }}" class="{{ request()->routeIs('reparaciones.*') ? 'active' : '' }}">🔧 Reparaciones</a>
            <a href="{{ route('clientes.index') }}" class="{{ request()->routeIs('clientes.*') ? 'active' : '' }}">👥 Clientes</a>
            <a href="{{ route('equipos.index') }}" class="{{ request()->routeIs('equipos.*') ? 'active' : '' }}">📱 Equipos</a>
            <a href="#">📦 Inventario</a>
            <a href="#">📈 Reportes</a>
        </nav>
    </aside>

    <main class="content">
        @if(session('success'))
            <div class="success-alert">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>
</div>

</body>
</html>