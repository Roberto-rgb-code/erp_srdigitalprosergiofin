<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ERP SRDigitalPro</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    @yield('styles')
    <style>
        body { background: #f6f8fb; }
        .sidebar { min-height: 100vh; background: #fff; box-shadow: 2px 0 8px rgba(0,0,0,0.03);}
        .sidebar .nav-link.active { background: #f0f4ff; color: #2d5ff7; font-weight: bold;}
        .sidebar .nav-link { color: #6b7280; font-size: 1rem; margin-bottom: 6px; border-radius: 12px; transition: 0.2s;}
        .sidebar .nav-link:hover { background: #e5e9fa; color: #2d5ff7;}
        .sidebar .logo { font-size: 1.3rem; font-weight: bold; color: #2d5ff7; padding: 1.2rem 1rem 1.2rem 1.5rem; letter-spacing: 2px;}
        .header-erp { height: 56px; background: #2d5ff7; color: #fff; display: flex; align-items: center; padding: 0 2rem 0 0.5rem; box-shadow: 0 1px 6px rgba(45,95,247,0.10); z-index: 100; }
        .header-erp .erp-title { font-weight: bold; font-size: 1.3rem; letter-spacing: 2px;}
        .header-erp .user-box { margin-left: auto; display: flex; align-items: center; gap: 1rem;}
        .header-erp .avatar { border-radius: 50%; width: 38px; height: 38px; }
        .header-erp .user-name { font-weight: 600; margin-bottom: 0; color: #fff; }
        .header-erp .user-email { font-size: 0.97rem; color: #e0e7ff; }
        .logout-btn { background: transparent; border: none; color: #fff; text-decoration: underline; cursor: pointer; padding: 0; }
        @media (max-width: 900px) {
            .sidebar { width: 100vw !important; min-height: auto; position: static !important; }
            .header-erp { padding: 0 0.5rem; }
        }
    </style>
</head>
<body>
    <div class="header-erp">
        <span class="erp-title"><i class="bi bi-box"></i> SRDigitalPro ERP</span>
        <div class="user-box">
            @auth
                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&size=60" class="avatar" alt="avatar">
                <div class="d-flex flex-column">
                    <span class="user-name">{{ auth()->user()->name }}</span>
                    <span class="user-email">{{ auth()->user()->email }}</span>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="mb-0 ms-2">
                    @csrf
                    <button class="logout-btn">Cerrar sesión</button>
                </form>
            @endauth
        </div>
    </div>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar d-flex flex-column p-0 position-relative" style="width: 240px;">
            <div class="logo mt-2">
                <i class="bi bi-menu-button"></i> Menú
            </div>
            <nav class="nav flex-column px-3">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <i class="bi bi-grid-1x2-fill me-2"></i> Dashboard
                </a>
                <a class="nav-link {{ request()->routeIs('clientes.*') ? 'active' : '' }}" href="{{ route('clientes.index') }}">
                    <i class="bi bi-person-lines-fill me-2"></i> Clientes
                </a>
                <a class="nav-link {{ request()->routeIs('ventas.*') ? 'active' : '' }}" href="{{ route('ventas.index') }}">
                    <i class="bi bi-cart-fill me-2"></i> Ventas
                </a>
                {{-- ---- INVENTARIO NUEVO MODULO ---- --}}
                <a class="nav-link {{ request()->routeIs('inventario.*') ? 'active' : '' }}" href="{{ route('inventario.index') }}">
                    <i class="bi bi-box-seam me-2"></i> Inventario
                </a>
                {{-- ------------------------------------ --}}
                <a class="nav-link {{ request()->routeIs('cableado.*') ? 'active' : '' }}" href="{{ route('cableado.index') }}">
                    <i class="bi bi-diagram-3-fill me-2"></i> Cableado Estructurado
                </a>
                <a class="nav-link {{ request()->routeIs('desarrollo_software.*') ? 'active' : '' }}" href="{{ route('desarrollo_software.index') }}">
                    <i class="bi bi-code-slash me-2"></i> Desarrollo de Software
                </a>
                <a class="nav-link {{ request()->routeIs('finanzas.*') ? 'active' : '' }}" href="{{ route('finanzas.index') }}">
                    <i class="bi bi-cash-stack me-2"></i> Finanzas
                </a>
                <a class="nav-link {{ request()->routeIs('recursos_humanos.*') ? 'active' : '' }}" href="{{ route('recursos_humanos.index') }}">
                    <i class="bi bi-people-fill me-2"></i> Recursos Humanos
                </a>
                <a class="nav-link {{ request()->routeIs('contabilidad.*') ? 'active' : '' }}" href="{{ route('contabilidad.index') }}">
                    <i class="bi bi-journal-bookmark-fill me-2"></i> Contabilidad
                </a>
                <a class="nav-link {{ request()->routeIs('cuentas_por_cobrar.*') ? 'active' : '' }}" href="{{ route('cuentas_por_cobrar.index') }}">
                    <i class="bi bi-cash-coin me-2"></i> Cuentas x Cobrar
                </a>
                <a class="nav-link {{ request()->routeIs('cuentas_por_pagar.*') ? 'active' : '' }}" href="{{ route('cuentas_por_pagar.index') }}">
                    <i class="bi bi-credit-card-2-back me-2"></i> Cuentas x Pagar
                </a>
                <a class="nav-link {{ request()->routeIs('taller.*') ? 'active' : '' }}" href="{{ route('taller.index') }}">
                    <i class="bi bi-tools me-2"></i> Taller
                </a>
                <a class="nav-link {{ request()->routeIs('vehiculos.*') ? 'active' : '' }}" href="{{ route('vehiculos.index') }}">
                    <i class="bi bi-truck-front-fill me-2"></i> Control de Vehículos
                </a>
                <a class="nav-link {{ request()->routeIs('servicios_empresariales.*') ? 'active' : '' }}" href="{{ route('servicios_empresariales.index') }}">
                    <i class="bi bi-person-badge me-2"></i> Servicios Empresariales
                </a>
                <a class="nav-link {{ request()->routeIs('creditos.*') ? 'active' : '' }}" href="{{ route('creditos.index') }}">
                    <i class="bi bi-wallet2 me-2"></i> Créditos
                </a>
                <a class="nav-link {{ request()->routeIs('compras.*') ? 'active' : '' }}" href="{{ route('compras.index') }}">
                    <i class="bi bi-basket3-fill me-2"></i> Proveedores
                </a>
                <a class="nav-link {{ request()->routeIs('punto_venta.*') ? 'active' : '' }}" href="{{ route('punto_venta.index') }}">
                    <i class="bi bi-receipt-cutoff me-2"></i> Punto de Venta
                </a>
                <a class="nav-link {{ request()->routeIs('personal.*') ? 'active' : '' }}" href="{{ route('personal.index') }}">
                    <i class="bi bi-person-badge-fill me-2"></i> Personal
                </a>
            </nav>
        </div>
        <!-- Main Content -->
        <div class="flex-grow-1 p-4">
            @yield('content')
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @stack('scripts')
</body>
</html>
