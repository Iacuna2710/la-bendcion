<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo', 'Panel Admin') — La Bendición Admin</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Bootstrap 5 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* ── Variables ──────────────────────────────────────────────────── */
        :root {
            --lb-verde-oscuro:  #1b4332;
            --lb-verde:         #2d6a4f;
            --lb-verde-medio:   #40916c;
            --lb-verde-claro:   #74c69d;
            --lb-verde-suave:   #d8f3dc;
            --lb-verde-fondo:   #f0faf4;
            --lb-sidebar-bg:    #1a2e25;
            --lb-sidebar-hover: #243d31;
            --lb-sidebar-w:     265px;
        }

        /* ── Tipografía global ──────────────────────────────────────────── */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f6f4;
            overflow-x: hidden;
        }

        /* ════════════════════════════════════════════════
           SIDEBAR
        ════════════════════════════════════════════════ */
        .lb-sidebar {
            width: var(--lb-sidebar-w);
            min-height: 100vh;
            background-color: var(--lb-sidebar-bg);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1040;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease;
            overflow-y: auto;
        }

        /* Logo del sidebar */
        .lb-sidebar-brand {
            padding: 1.5rem 1.2rem 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }
        .lb-sidebar-brand a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }
        .lb-sidebar-brand .brand-icon {
            font-size: 1.6rem;
        }
        .lb-sidebar-brand .brand-text {
            font-size: 1.1rem;
            font-weight: 700;
            line-height: 1.2;
        }
        .lb-sidebar-brand .brand-sub {
            font-size: 0.65rem;
            color: var(--lb-verde-claro);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Secciones de navegación sidebar */
        .lb-sidebar-section {
            padding: 0.5rem 0;
        }
        .lb-sidebar-section-title {
            color: rgba(255,255,255,0.35);
            font-size: 0.65rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            padding: 0.8rem 1.2rem 0.4rem;
        }
        .lb-sidebar nav a {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            padding: 0.6rem 1.2rem;
            color: rgba(255,255,255,0.75);
            text-decoration: none;
            font-size: 0.88rem;
            border-radius: 0;
            transition: background-color 0.2s, color 0.2s;
            position: relative;
        }
        .lb-sidebar nav a:hover {
            background-color: var(--lb-sidebar-hover);
            color: white;
        }
        .lb-sidebar nav a.active {
            background-color: var(--lb-verde);
            color: white;
            font-weight: 600;
        }
        .lb-sidebar nav a.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 3px;
            background-color: var(--lb-verde-claro);
            border-radius: 0 2px 2px 0;
        }
        .lb-sidebar nav a i {
            width: 1.1rem;
            text-align: center;
            font-size: 1rem;
            flex-shrink: 0;
        }
        /* Badge numérico en sidebar */
        .lb-sidebar-badge {
            margin-left: auto;
            background-color: var(--lb-verde-claro);
            color: var(--lb-verde-oscuro);
            font-size: 0.65rem;
            font-weight: 700;
            padding: 0.15rem 0.45rem;
            border-radius: 10px;
        }

        /* Perfil al pie del sidebar */
        .lb-sidebar-footer {
            margin-top: auto;
            padding: 1rem 1.2rem;
            border-top: 1px solid rgba(255,255,255,0.08);
        }
        .lb-sidebar-footer .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: var(--lb-verde-medio);
            color: white;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.9rem;
            flex-shrink: 0;
        }
        .lb-sidebar-footer .user-name {
            color: white;
            font-size: 0.82rem;
            font-weight: 500;
        }
        .lb-sidebar-footer .user-role {
            color: var(--lb-verde-claro);
            font-size: 0.7rem;
        }

        /* ════════════════════════════════════════════════
           ÁREA DE CONTENIDO PRINCIPAL
        ════════════════════════════════════════════════ */
        .lb-admin-content {
            margin-left: var(--lb-sidebar-w);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── Topbar ─────────────────────────────────────────────────────── */
        .lb-topbar {
            background-color: white;
            border-bottom: 1px solid #e9ecef;
            padding: 0.75rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 1030;
            box-shadow: 0 1px 4px rgba(0,0,0,0.06);
        }
        .lb-topbar-title {
            font-weight: 600;
            color: var(--lb-verde-oscuro);
            font-size: 1rem;
            margin: 0;
        }
        .lb-topbar-right {
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }
        /* Botón que activa la vista al sitio público */
        .lb-topbar .btn-site {
            font-size: 0.8rem;
            padding: 0.35rem 0.8rem;
            border-color: var(--lb-verde-medio);
            color: var(--lb-verde);
        }
        .lb-topbar .btn-site:hover {
            background-color: var(--lb-verde-suave);
        }

        /* ── Wrapper interno del contenido ───────────────────────────────── */
        .lb-admin-main {
            padding: 1.5rem;
            flex: 1;
        }

        /* ── Cards del panel ─────────────────────────────────────────────── */
        .lb-admin-card {
            background-color: white;
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 1px 8px rgba(0,0,0,0.07);
        }
        .lb-admin-card .card-header {
            background-color: transparent;
            border-bottom: 1px solid #e9ecef;
            padding: 1rem 1.25rem;
            font-weight: 600;
            color: var(--lb-verde-oscuro);
        }

        /* ── KPI Cards del dashboard ─────────────────────────────────────── */
        .lb-kpi-card {
            border-radius: 0.75rem;
            padding: 1.2rem 1.4rem;
            border: none;
            color: white;
            box-shadow: 0 3px 12px rgba(0,0,0,0.12);
            transition: transform 0.2s;
        }
        .lb-kpi-card:hover { transform: translateY(-2px); }
        .lb-kpi-card .kpi-icon { font-size: 2rem; opacity: 0.85; }
        .lb-kpi-card .kpi-value { font-size: 1.9rem; font-weight: 700; line-height: 1.1; }
        .lb-kpi-card .kpi-label { font-size: 0.8rem; opacity: 0.85; }

        /* ── Tabla administrativa ────────────────────────────────────────── */
        .lb-admin-table th {
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #6c757d;
            font-weight: 600;
            border-top: none;
        }
        .lb-admin-table td { vertical-align: middle; font-size: 0.88rem; }

        /* ── Botones de acción ───────────────────────────────────────────── */
        .btn-lb-primary {
            background-color: var(--lb-verde);
            border-color: var(--lb-verde);
            color: white;
        }
        .btn-lb-primary:hover, .btn-lb-primary:focus {
            background-color: var(--lb-verde-oscuro);
            border-color: var(--lb-verde-oscuro);
            color: white;
        }

        /* ── Alerta de stock bajo ────────────────────────────────────────── */
        .lb-stock-alert {
            border-left: 4px solid #dc3545;
            background-color: #fff5f5;
        }

        /* ── Mobile: ocultar sidebar en pantallas pequeñas ───────────────── */
        @media (max-width: 991.98px) {
            .lb-sidebar {
                transform: translateX(-100%);
            }
            .lb-sidebar.show {
                transform: translateX(0);
            }
            .lb-admin-content {
                margin-left: 0;
            }
            .lb-topbar-title { font-size: 0.9rem; }
        }
    </style>

    @stack('styles')
</head>
<body>

    {{-- ══ SIDEBAR ═════════════════════════════════════════════════════════ --}}
    <aside class="lb-sidebar" id="sidebarAdmin">

        {{-- Marca --}}
        <div class="lb-sidebar-brand">
            <a href="{{ route('admin.dashboard') }}">
                <span class="brand-icon">🌿</span>
                <div>
                    <div class="brand-text">La Bendición</div>
                    <div class="brand-sub">Panel Admin</div>
                </div>
            </a>
        </div>

        {{-- Navegación --}}
        <div class="lb-sidebar-section flex-grow-1">

            {{-- General --}}
            <div class="lb-sidebar-section-title">General</div>
            <nav>
                <a href="{{ route('admin.dashboard') }}"
                   class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </nav>

            {{-- Catálogo --}}
            <div class="lb-sidebar-section-title mt-1">Catálogo</div>
            <nav>
                <a href="{{ route('admin.productos.index') }}"
                   class="{{ request()->routeIs('admin.productos.*') ? 'active' : '' }}">
                    <i class="bi bi-box-seam"></i> Productos
                </a>
                <a href="{{ route('admin.categorias.index') }}"
                   class="{{ request()->routeIs('admin.categorias.*') ? 'active' : '' }}">
                    <i class="bi bi-tags"></i> Categorías
                </a>
            </nav>

            {{-- Ventas --}}
            <div class="lb-sidebar-section-title mt-1">Ventas</div>
            <nav>
                <a href="{{ route('admin.pedidos.index') }}"
                   class="{{ request()->routeIs('admin.pedidos.*') ? 'active' : '' }}">
                    <i class="bi bi-bag-check"></i> Pedidos
                </a>
            </nav>

            {{-- Solo Administrador --}}
            @auth
                @if(auth()->user()->hasRole('admin'))
                    <div class="lb-sidebar-section-title mt-1">Administración</div>
                    <nav>
                        <a href="{{ route('admin.usuarios.index') }}"
                           class="{{ request()->routeIs('admin.usuarios.*') ? 'active' : '' }}">
                            <i class="bi bi-people"></i> Usuarios
                        </a>
                        <a href="{{ route('admin.roles.index') }}"
                           class="{{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
                            <i class="bi bi-shield-check"></i> Roles
                        </a>
                        <a href="{{ route('admin.metodos-pago.index') }}"
                           class="{{ request()->routeIs('admin.metodos-pago.*') ? 'active' : '' }}">
                            <i class="bi bi-credit-card"></i> Métodos de pago
                        </a>
                    </nav>
                @endif
            @endauth

        </div>

        {{-- Perfil al pie --}}
        @auth
            <div class="lb-sidebar-footer">
                <div class="d-flex align-items-center gap-2">
                    <span class="user-avatar">
                        {{ strtoupper(substr(auth()->user()->nombre, 0, 1)) }}
                    </span>
                    <div class="overflow-hidden">
                        <div class="user-name text-truncate">{{ auth()->user()->nombre }}</div>
                        <div class="user-role">
                            @foreach(auth()->user()->roles as $rol)
                                {{ ucfirst($rol->nombre) }}
                            @endforeach
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="ms-auto">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-link text-white-50 p-0"
                                title="Cerrar sesión">
                            <i class="bi bi-box-arrow-right"></i>
                        </button>
                    </form>
                </div>
            </div>
        @endauth
    </aside>

    {{-- ══ CONTENIDO PRINCIPAL ═════════════════════════════════════════════ --}}
    <div class="lb-admin-content">

        {{-- Topbar --}}
        <header class="lb-topbar">
            <div class="d-flex align-items-center gap-3">
                {{-- Botón hamburguesa para móvil --}}
                <button class="btn btn-sm d-lg-none" id="sidebarToggle" aria-label="Menú">
                    <i class="bi bi-list fs-5"></i>
                </button>
                <h1 class="lb-topbar-title">@yield('titulo', 'Dashboard')</h1>
            </div>
            <div class="lb-topbar-right">
                {{-- Alerta rápida de stock bajo --}}
                @php
                    $alertasStock = \App\Models\Producto::whereColumn('stock', '<=', 'stock_minimo')->count();
                @endphp
                @if($alertasStock > 0)
                    <a href="{{ route('admin.productos.index') }}"
                       class="btn btn-sm btn-warning d-flex align-items-center gap-1">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        {{ $alertasStock }} stock bajo
                    </a>
                @endif
                {{-- Botón ver el sitio público --}}
                <a href="{{ route('inicio') }}" target="_blank"
                   class="btn btn-sm btn-site border">
                    <i class="bi bi-box-arrow-up-right me-1"></i>Ver sitio
                </a>
            </div>
        </header>

        {{-- Contenido de cada vista --}}
        <main class="lb-admin-main">
            {{-- Mensajes flash --}}
            @include('partials.alertas')

            {{-- Contenido específico de cada vista admin --}}
            @yield('contenido')
        </main>

    </div>

    {{-- Bootstrap 5 JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // ── Toggle del sidebar en móvil ────────────────────────────────────
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarAdmin  = document.getElementById('sidebarAdmin');

        if (sidebarToggle && sidebarAdmin) {
            sidebarToggle.addEventListener('click', function () {
                sidebarAdmin.classList.toggle('show');
            });
            // Cerrar al hacer clic fuera del sidebar en móvil
            document.addEventListener('click', function (e) {
                if (window.innerWidth < 992 &&
                    !sidebarAdmin.contains(e.target) &&
                    !sidebarToggle.contains(e.target)) {
                    sidebarAdmin.classList.remove('show');
                }
            });
        }

        // ── Auto-cerrar alertas después de 6 segundos ─────────────────────
        document.addEventListener('DOMContentLoaded', function () {
            setTimeout(function () {
                document.querySelectorAll('.alert.show').forEach(function (alertEl) {
                    var bsAlert = bootstrap.Alert.getOrCreateInstance(alertEl);
                    bsAlert.close();
                });
            }, 6000);
        });
    </script>

    @stack('scripts')

</body>
</html>
