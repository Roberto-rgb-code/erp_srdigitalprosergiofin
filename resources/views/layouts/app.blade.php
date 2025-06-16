<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>ERP SRDigitalPro</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons (opcional para iconos bonitos en el sidebar) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { background: #f7f9fb; }
        .sidebar {
            width: 220px;
            min-height: 100vh;
            background: #fff;
            border-right: 1px solid #eee;
            padding: 18px 0;
        }
        .sidebar h4 { padding-left: 25px; font-weight: 800; }
        .sidebar .nav-link.active, .sidebar .nav-link:hover {
            background: #eceefd;
            color: #555 !important;
        }
        .sidebar .nav-link { color: #888; }
        .sidebar .nav-item { margin-bottom: 6px; }
        .navbar { box-shadow: 0 2px 4px rgba(0,0,0,0.03);}
    </style>
</head>
<body>
<div class="d-flex">
    <!-- Sidebar -->
    <nav class="sidebar">
        <h4>SRDigitalPro</h4>
        <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"><i class="bi bi-bar-chart"></i> Dashboard</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('clientes.*') ? 'active' : '' }}" href="{{ route('clientes.index') }}"><i class="bi bi-person"></i> Clientes</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('ventas.*') ? 'active' : '' }}" href="{{ route('ventas.index') }}"><i class="bi bi-cart"></i> Ventas</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('taller.*') ? 'active' : '' }}" href="{{ route('taller.index') }}"><i class="bi bi-tools"></i> Taller</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('cableado.*') ? 'active' : '' }}" href="{{ route('cableado.index') }}"><i class="bi bi-diagram-3"></i> Cableado</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('vehiculos.*') ? 'active' : '' }}" href="{{ route('vehiculos.index') }}"><i class="bi bi-truck"></i> Vehículos</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('desarrollo_software.*') ? 'active' : '' }}" href="{{ route('desarrollo_software.index') }}"><i class="bi bi-code-slash"></i> Desarrollo Software</a></li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('recursos_humanos.*') ? 'active' : '' }}" href="{{ route('recursos_humanos.index') }}">
                    <i class="bi bi-people"></i> Recursos Humanos
                </a>
            </li>            
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('servicios_empresariales.*') ? 'active' : '' }}" href="{{ route('servicios_empresariales.index') }}"><i class="bi bi-building"></i> Servicios Empresariales</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('finanzas.*') ? 'active' : '' }}" href="{{ route('finanzas.index') }}"><i class="bi bi-cash-coin"></i> Finanzas</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('cuentas_por_cobrar.*') ? 'active' : '' }}" href="{{ route('cuentas_por_cobrar.index') }}"><i class="bi bi-arrow-down-right"></i> Cuentas x Cobrar</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('cuentas_por_pagar.*') ? 'active' : '' }}" href="{{ route('cuentas_por_pagar.index') }}"><i class="bi bi-arrow-up-right"></i> Cuentas x Pagar</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('contabilidad.*') ? 'active' : '' }}" href="{{ route('contabilidad.index') }}"><i class="bi bi-journal-bookmark"></i> Contabilidad</a></li>
        </ul>
    </nav>
    <!-- Main content -->
    <div class="flex-fill">
        <!-- Topbar -->
        <nav class="navbar navbar-light bg-white border-bottom px-3">
            <span class="navbar-brand">Bienvenido</span>
            <!-- Aquí puedes poner usuario logueado -->
        </nav>
        <div class="container mt-4">
            @yield('content')
        </div>
    </div>
</div>
<!-- Bootstrap JS (para dropdowns/modals) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
