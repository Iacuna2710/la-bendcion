<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="La Bendición — Tienda de productos macrobióticos naturales en Costa Rica">
    <title>@yield('titulo', 'La Bendición') — Macrobiótica Natural</title>

    {{-- Bootstrap 5 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    {{-- Google Fonts: Inter --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* ── Variables de color La Bendición ────────────────────────────── */
        :root {
            --lb-verde-oscuro:   #1b4332;
            --lb-verde:          #2d6a4f;
            --lb-verde-medio:    #40916c;
            --lb-verde-claro:    #74c69d;
            --lb-verde-suave:    #d8f3dc;
            --lb-verde-fondo:    #f0faf4;
            --lb-crema:          #fefae0;
            --lb-texto:          #212529;
        }

        /* ── Tipografía global ──────────────────────────────────────────── */
        body {
            font-family: 'Inter', sans-serif;
            color: var(--lb-texto);
            background-color: #ffffff;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* ── Navbar ─────────────────────────────────────────────────────── */
        .lb-navbar {
            background-color: var(--lb-verde-oscuro);
        }
        .lb-navbar .navbar-brand,
        .lb-navbar .nav-link {
            color: rgba(255,255,255,0.90) !important;
            transition: color 0.2s;
        }
        .lb-navbar .navbar-brand:hover,
        .lb-navbar .nav-link:hover,
        .lb-navbar .nav-link.active {
            color: var(--lb-verde-claro) !important;
        }
        .lb-navbar .navbar-toggler-icon {
            filter: invert(1);
        }
        .lb-navbar-logo {
            font-size: 1.4rem;
        }
        /* Avatar circular con inicial del usuario */
        .lb-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background-color: var(--lb-verde-medio);
            color: white;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.85rem;
            flex-shrink: 0;
        }
        /* Badge de rol en el dropdown */
        .lb-role-badge {
            background-color: var(--lb-verde-medio);
            color: white;
            font-size: 0.7rem;
        }
        /* Dropdown limpio */
        .lb-dropdown {
            border: none;
            border-radius: 0.5rem;
            min-width: 220px;
        }
        /* Botón de registro en la navbar */
        .lb-btn-nav {
            background-color: var(--lb-verde-medio);
            color: white !important;
            border: none;
            border-radius: 20px;
            padding: 0.35rem 1.1rem;
            font-size: 0.9rem;
            transition: background-color 0.2s;
        }
        .lb-btn-nav:hover {
            background-color: var(--lb-verde-claro);
            color: white !important;
        }
        /* Link del carrito */
        .lb-cart-link {
            padding: 0.4rem 0.6rem !important;
        }

        /* ── Botones principales ─────────────────────────────────────────── */
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
        .btn-lb-outline {
            border-color: var(--lb-verde);
            color: var(--lb-verde);
        }
        .btn-lb-outline:hover {
            background-color: var(--lb-verde);
            color: white;
        }

        /* ── Footer ─────────────────────────────────────────────────────── */
        .lb-footer {
            background-color: var(--lb-verde-oscuro);
        }
        .lb-footer-heading {
            color: var(--lb-verde-claro);
            font-size: 0.75rem;
            letter-spacing: 1px;
        }
        .lb-footer-logo {
            font-size: 1.6rem;
        }
        .lb-footer-link:hover {
            color: white !important;
            transition: color 0.2s;
        }
        .lb-social-icon:hover {
            color: var(--lb-verde-claro) !important;
            transition: color 0.2s;
        }

        /* ── Cards generales ─────────────────────────────────────────────── */
        .lb-card {
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .lb-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.12);
        }

        /* ── Sección hero/encabezado de página ───────────────────────────── */
        .lb-page-header {
            background: linear-gradient(135deg, var(--lb-verde-oscuro) 0%, var(--lb-verde) 100%);
            padding: 2.5rem 0;
            color: white;
            margin-bottom: 2rem;
        }

        /* ── Badges de categoría en tarjetas de producto ─────────────────── */
        .lb-badge-categoria {
            background-color: var(--lb-verde-suave);
            color: var(--lb-verde-oscuro);
            font-size: 0.7rem;
            font-weight: 600;
        }

        /* ── Precio del producto ─────────────────────────────────────────── */
        .lb-precio {
            color: var(--lb-verde);
            font-weight: 700;
            font-size: 1.2rem;
        }

        /* ── Alertas con icono ───────────────────────────────────────────── */
        .alert {
            border-radius: 0.5rem;
        }

        /* ── Links con color verde ───────────────────────────────────────── */
        a.lb-link {
            color: var(--lb-verde);
            text-decoration: none;
        }
        a.lb-link:hover {
            color: var(--lb-verde-oscuro);
            text-decoration: underline;
        }

        /* ── Contenido principal ocupa espacio disponible ────────────────── */
        .lb-main-content {
            flex: 1;
        }

        /* ── Scrollbar personalizado ─────────────────────────────────────── */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: var(--lb-verde-claro); border-radius: 3px; }
    </style>

    {{-- CSS adicional por vista --}}
    @stack('styles')
</head>
<body>

    {{-- Barra de navegación --}}
    @include('partials.navbar')

    {{-- Contenido principal --}}
    <main class="lb-main-content">

        {{-- Encabezado de página (opcional por vista) --}}
        @hasSection('encabezado')
            <div class="lb-page-header">
                <div class="container">
                    @yield('encabezado')
                </div>
            </div>
        @endif

        {{-- Mensajes flash y errores de validación --}}
        <div class="container mt-3">
            @include('partials.alertas')
        </div>

        {{-- Contenido específico de cada vista --}}
        @yield('contenido')
    </main>

    {{-- Pie de página --}}
    @include('partials.footer')

    {{-- Bootstrap 5 JS (con Popper) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Auto-cerrar alertas después de 6 segundos --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            setTimeout(function () {
                document.querySelectorAll('.alert.show').forEach(function (alertEl) {
                    var bsAlert = bootstrap.Alert.getOrCreateInstance(alertEl);
                    bsAlert.close();
                });
            }, 6000);
        });
    </script>

    {{-- Scripts adicionales por vista --}}
    @stack('scripts')

</body>
</html>
