<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Taller Manager</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; background: #f4f6f8; color: #1f2937; }

        .layout { display: flex; height: 100vh; overflow: hidden; position: relative; }

        /* Encabezado Móvil (Sólo visible en pantallas pequeñas) */
        .mobile-header {
            display: none;
            background: #111827;
            color: white;
            padding: 14px 18px;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            z-index: 50;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .mobile-header h2 { margin: 0; font-size: 18px; font-weight: 700; }
        .hamburger-btn { background: #1f2937; border: 1px solid #374151; color: white; padding: 6px 12px; border-radius: 6px; font-size: 18px; cursor: pointer; }

        /* Menú Lateral (Sidebar) */
        .sidebar { 
            width: 240px; 
            flex-shrink: 0; 
            background: #111827; 
            color: white; 
            padding: 25px 15px; 
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease-in-out;
            z-index: 40;
        }

        .logo { font-size: 20px; font-weight: bold; margin-bottom: 30px; padding-left: 10px; }
        .menu a { display: block; color: #d1d5db; text-decoration: none; padding: 12px 15px; border-radius: 8px; margin-bottom: 5px; font-size: 14px; transition: all 0.2s; }
        .menu a:hover, .menu .active { background: #2563eb; color: white; }

        /* Fondo para cerrar el menú en móvil */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 30;
        }

        /* Área de Contenido */
        .content { 
            flex: 1; 
            min-width: 0; 
            padding: 25px; 
            overflow-y: auto; 
            display: flex;
            flex-direction: column;
        }

        .header { margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 24px; font-weight: 700; }
        .header p { color: #6b7280; margin: 4px 0 0 0; font-size: 13px; }

        .cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 15px; margin-bottom: 25px; }
        .card { background: white; padding: 18px; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,.06); border: 1px solid #e5e7eb; }
        .card h3 { margin: 0 0 8px; font-size: 12px; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px; }
        .number { font-size: 28px; font-weight: 800; color: #111827; }

        .table-container { 
            background: white; 
            padding: 16px; 
            border-radius: 12px; 
            box-shadow: 0 1px 3px rgba(0,0,0,.06); 
            border: 1px solid #e5e7eb; 
            overflow-x: auto; 
            -webkit-overflow-scrolling: touch;
        }
        table { width: 100%; border-collapse: collapse; min-width: 550px; }
        th, td { text-align: left; padding: 12px; border-bottom: 1px solid #e5e7eb; font-size: 13px; }
        th { color: #6b7280; font-weight: 600; font-size: 11px; text-transform: uppercase; }

        .btn {
            background: #2563eb; color: white; padding: 8px 12px; text-decoration: none; border-radius: 6px; border: none; cursor: pointer; font-size: 13px; display: inline-flex; align-items: center; gap: 4px; font-weight: 500;
        }
        .btn:hover { background: #1d4ed8; }
        .btn-danger { background: #dc2626; }
        .btn-success { background: #16a34a; }
        .btn-warning { background: #eab308; color: white; }

        .success-alert {
            background: #dcfce7; color: #166534; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; border: 1px solid #bbf7d0;
        }

        /* Tablero Kanban */
        .kanban-container { 
            display: flex; gap: 15px; overflow-x: auto; padding-bottom: 15px; flex: 1; align-items: flex-start; -webkit-overflow-scrolling: touch;
        }
        .kanban-column { 
            background: #f1f5f9; border-radius: 10px; padding: 14px; width: 280px; min-width: 280px; border: 1px solid #e2e8f0; max-height: 100%; overflow-y: auto;
        }
        .kanban-column h3 { margin: 0 0 12px 0; font-size: 13px; font-weight: 700; color: #334155; display: flex; justify-content: space-between; align-items: center; }
        .kanban-card { background: white; padding: 12px; border-radius: 8px; box-shadow: 0 1px 2px rgba(0,0,0,0.05); margin-bottom: 10px; border-left: 4px solid #2563eb; }
        .kanban-card h4 { margin: 0 0 4px 0; font-size: 13px; font-weight: 700; }
        .kanban-card p { margin: 3px 0; font-size: 12px; color: #64748b; }
        .kanban-select { font-size: 12px; padding: 6px; border: 1px solid #cbd5e1; border-radius: 6px; background: #f8fafc; width: 100%; margin-top: 8px; }

        /* REGLAS RESPONSIVAS PARA MÓVILES Y TABLETS (Menos de 768px) */
        @media (max-width: 768px) {
            .layout { flex-direction: column; }
            .mobile-header { display: flex; }
            
            .sidebar {
                position: fixed;
                top: 0; left: 0; bottom: 0;
                transform: translateX(-100%);
                width: 250px;
                padding-top: 20px;
                box-shadow: 2px 0 10px rgba(0,0,0,0.3);
            }
            .sidebar.active { transform: translateX(0); }
            .sidebar-overlay.active { display: block; }
            
            .content { padding: 15px; }
            .cards { grid-template-columns: 1fr; }
            .header h1 { font-size: 20px; }
        }
    </style>
</head>
<body>

<div class="layout">
    <!-- Barra superior táctil exclusiva para celulares -->
    <header class="mobile-header">
        <h2>🔧 Taller Manager</h2>
        <button class="hamburger-btn" onclick="toggleMenu()" aria-label="Abrir Menú">☰</button>
    </header>

    <!-- Capa oscura para cerrar menú al tocar la pantalla -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleMenu()"></div>

    <!-- Menú Lateral -->
    <aside class="sidebar" id="sidebar">
        <div class="logo">🔧 Taller Manager</div>
        <nav class="menu">
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}" onclick="closeMenu()">📊 Dashboard</a>
            <a href="{{ route('reparaciones.index') }}" class="{{ request()->routeIs('reparaciones.*') ? 'active' : '' }}" onclick="closeMenu()">🔧 Reparaciones</a>
            <a href="{{ route('clientes.index') }}" class="{{ request()->routeIs('clientes.*') ? 'active' : '' }}" onclick="closeMenu()">👥 Clientes</a>
            <a href="{{ route('equipos.index') }}" class="{{ request()->routeIs('equipos.*') ? 'active' : '' }}" onclick="closeMenu()">📱 Equipos</a>
            <a href="{{ route('inventario.index') }}" class="{{ request()->routeIs('inventario.*') ? 'active' : '' }}" onclick="closeMenu()">📦 Inventario</a>
            <a href="{{ route('reportes.index') }}" class="{{ request()->routeIs('reportes.*') ? 'active' : '' }}" onclick="closeMenu()">📈 Reportes</a>
        </nav>
    </aside>

    <!-- Contenido Principal -->
    <main class="content">
        @if(session('success'))
            <div class="success-alert">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>
</div>

<script>
    function toggleMenu() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        sidebar.classList.toggle('active');
        overlay.classList.toggle('active');
    }

    function closeMenu() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        sidebar.classList.remove('active');
        overlay.classList.remove('active');
    }
</script>
</body>
</html>