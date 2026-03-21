@extends('layouts.app')

@section('titulo', 'Inicio')

@section('contenido')

{{-- ══════════════════════════════════════════════════════════════════════════
     HERO SECTION
══════════════════════════════════════════════════════════════════════════ --}}
<section class="lb-hero position-relative overflow-hidden">
    <div class="lb-hero-bg"></div>
    <div class="container position-relative py-5 py-md-6">
        <div class="row align-items-center g-4">
            <div class="col-lg-6">
                <span class="badge lb-badge-natural mb-3 px-3 py-2">
                    🌿 100% Natural &amp; Macrobiótico
                </span>
                <h1 class="display-4 fw-bold text-white mb-3 lh-sm">
                    Alimenta tu cuerpo,<br>
                    <span style="color: #74c69d;">nutre tu alma</span>
                </h1>
                <p class="text-white-75 fs-5 mb-4">
                    Descubre nuestra selección de productos macrobióticos naturales.
                    Calidad, bienestar y sabor en cada producto.
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="{{ route('catalogo.index') }}" class="btn btn-lg lb-hero-btn-primary fw-semibold">
                        <i class="bi bi-grid me-2"></i>Ver catálogo
                    </a>
                    @guest
                        <a href="{{ route('register') }}" class="btn btn-lg lb-hero-btn-outline fw-semibold">
                            <i class="bi bi-person-plus me-2"></i>Crear cuenta gratis
                        </a>
                    @endguest
                </div>
            </div>
            <div class="col-lg-6 text-center d-none d-lg-block">
                <div class="lb-hero-illustration">
                    <div class="lb-hero-circle">
                        <span style="font-size: 7rem; line-height: 1;">🌾</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Ola decorativa --}}
    <div class="lb-hero-wave">
        <svg viewBox="0 0 1440 60" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0,30 C360,60 1080,0 1440,30 L1440,60 L0,60 Z" fill="#ffffff"/>
        </svg>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════════════════════
     CATEGORÍAS
══════════════════════════════════════════════════════════════════════════ --}}
@if($categorias->isNotEmpty())
<section class="py-5 bg-white">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="fw-bold text-lb-verde">Explora por categoría</h2>
            <p class="text-muted">Encuentra lo que buscas de manera fácil</p>
        </div>

        {{-- Carrusel de categorías --}}
        <div class="lb-cat-carousel-wrapper position-relative">

            {{-- Flecha izquierda --}}
            <button class="lb-cat-arrow lb-cat-arrow-left" id="catPrev" aria-label="Anterior">
                <i class="bi bi-chevron-left"></i>
            </button>

            {{-- Track deslizable --}}
            <div class="lb-cat-track" id="catTrack">
                @foreach($categorias as $categoria)
                    @php
                        $emojis = [
                            'capsulas'     => '💊',
                            'gotas'        => '💧',
                            'jarabes'      => '🍶',
                            'infusiones'   => '🍵',
                            'aceites'      => '🫒',
                            'aromaterapia' => '🌸',
                            'jabones'      => '🧼',
                            'shampoos'     => '🧴',
                            'unguentos'    => '🏺',
                            'granos'       => '🌾',
                            'cereales'     => '🌾',
                            'semillas'     => '🌱',
                            'frutos'       => '🥜',
                            'suplementos'  => '💪',
                            'deportivos'   => '💪',
                        ];
                        $slugLower = strtolower($categoria->slug);
                        $emoji = '🌿';
                        foreach ($emojis as $clave => $icono) {
                            if (str_contains($slugLower, $clave)) {
                                $emoji = $icono;
                                break;
                            }
                        }
                    @endphp
                    <div class="lb-cat-item">
                        <a href="{{ route('catalogo.index', ['categoria' => $categoria->slug]) }}"
                           class="lb-categoria-card text-center text-decoration-none d-block p-3 rounded-3 h-100">
                            <div class="lb-cat-icon mb-2">{{ $emoji }}</div>
                            <div class="fw-semibold small text-dark">{{ $categoria->nombre }}</div>
                            <div class="text-muted" style="font-size: 0.72rem;">
                                {{ $categoria->productos_count }} producto{{ $categoria->productos_count !== 1 ? 's' : '' }}
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            {{-- Flecha derecha --}}
            <button class="lb-cat-arrow lb-cat-arrow-right" id="catNext" aria-label="Siguiente">
                <i class="bi bi-chevron-right"></i>
            </button>
        </div>
    </div>
</section>
@endif

{{-- ══════════════════════════════════════════════════════════════════════════
     PRODUCTOS DESTACADOS
══════════════════════════════════════════════════════════════════════════ --}}
@if($productosDestacados->isNotEmpty())
<section class="py-5" style="background-color: #f0faf4;">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <h2 class="fw-bold mb-1 text-lb-verde">
                    <i class="bi bi-star-fill text-warning me-2"></i>Productos destacados
                </h2>
                <p class="text-muted mb-0">Selección especial de nuestros mejores productos</p>
            </div>
            <a href="{{ route('catalogo.index') }}" class="btn btn-outline-success btn-sm">
                Ver todos <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="row g-4">
            @foreach($productosDestacados as $producto)
                @include('catalogo._card-producto', ['producto' => $producto])
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ══════════════════════════════════════════════════════════════════════════
     NOVEDADES
══════════════════════════════════════════════════════════════════════════ --}}
@if($productosNuevos->isNotEmpty())
<section class="py-5 bg-white">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <h2 class="fw-bold mb-1 text-lb-verde">
                    <i class="bi bi-lightning-fill text-warning me-2"></i>Novedades
                </h2>
                <p class="text-muted mb-0">Los últimos productos que llegaron a nuestra tienda</p>
            </div>
        </div>
        <div class="row g-4">
            @foreach($productosNuevos as $producto)
                @include('catalogo._card-producto', ['producto' => $producto])
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ══════════════════════════════════════════════════════════════════════════
     BANNER CTA
══════════════════════════════════════════════════════════════════════════ --}}
<section class="py-5" style="background: linear-gradient(135deg, #1b4332 0%, #2d6a4f 100%);">
    <div class="container text-center">
        <div class="py-3">
            <h2 class="fw-bold text-white mb-3">¿Listo para empezar tu camino natural?</h2>
            <p class="text-white-50 mb-4 fs-5">
                Únete a nuestra comunidad y recibe recomendaciones personalizadas
            </p>
            @guest
                <div class="d-flex justify-content-center gap-3 flex-wrap">
                    <a href="{{ route('register') }}" class="btn btn-light btn-lg fw-semibold text-success">
                        <i class="bi bi-person-plus me-2"></i>Crear cuenta gratuita
                    </a>
                    <a href="{{ route('catalogo.index') }}" class="btn btn-outline-light btn-lg fw-semibold">
                        <i class="bi bi-grid me-2"></i>Ver catálogo
                    </a>
                </div>
            @else
                <a href="{{ route('catalogo.index') }}" class="btn btn-light btn-lg fw-semibold text-success">
                    <i class="bi bi-grid me-2"></i>Explorar catálogo completo
                </a>
            @endguest
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
    /* ── Hero ─────────────────────────────────────────────────────────────── */
    .lb-hero {
        background: linear-gradient(135deg, #1b4332 0%, #2d6a4f 60%, #40916c 100%);
        padding-bottom: 60px;
    }
    .lb-hero-bg {
        position: absolute; inset: 0;
        background-image: radial-gradient(circle at 80% 20%, rgba(116,198,157,0.15) 0%, transparent 60%);
    }
    .lb-hero-wave {
        position: absolute; bottom: 0; left: 0; right: 0;
    }
    .lb-hero-wave svg { display: block; height: 60px; width: 100%; }
    .text-white-75 { color: rgba(255,255,255,0.80) !important; }
    .lb-hero-btn-primary {
        background-color: white; color: #1b4332;
        border: none; border-radius: 30px;
    }
    .lb-hero-btn-primary:hover { background-color: #d8f3dc; color: #1b4332; }
    .lb-hero-btn-outline {
        border: 2px solid rgba(255,255,255,0.6); color: white;
        border-radius: 30px; background: transparent;
    }
    .lb-hero-btn-outline:hover { background-color: rgba(255,255,255,0.15); color: white; }
    .lb-badge-natural {
        background-color: rgba(255,255,255,0.15);
        color: #d8f3dc; border-radius: 20px; font-size: 0.85rem;
    }
    .lb-hero-circle {
        width: 280px; height: 280px; border-radius: 50%;
        background: rgba(255,255,255,0.08);
        display: inline-flex; align-items: center; justify-content: center;
        box-shadow: 0 0 60px rgba(116,198,157,0.2);
        animation: float 4s ease-in-out infinite;
    }
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50%       { transform: translateY(-12px); }
    }

    /* ── Categorías — carrusel ───────────────────────────────────────────── */
    .lb-cat-carousel-wrapper {
        padding: 0 2.5rem;          /* espacio para las flechas */
    }
    .lb-cat-track {
        display: flex;
        gap: 0.75rem;
        overflow-x: auto;
        scroll-behavior: smooth;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;       /* Firefox */
        padding-bottom: 4px;         /* evita cortar sombras */
    }
    .lb-cat-track::-webkit-scrollbar { display: none; } /* Chrome/Safari */
    .lb-cat-item {
        /* 6 visibles en Desktop, 3 en Tablet, 2 en Móvil */
        flex: 0 0 calc((100% - 5 * 0.75rem) / 6);
        min-width: 110px;
    }
    @media (max-width: 991.98px) {
        .lb-cat-item { flex: 0 0 calc((100% - 2 * 0.75rem) / 3); }
    }
    @media (max-width: 575.98px) {
        .lb-cat-item { flex: 0 0 calc((100% - 0.75rem) / 2); }
    }
    .lb-categoria-card {
        border: 1.5px solid #e9ecef; transition: all 0.25s;
        background-color: #fafffe;
    }
    .lb-categoria-card:hover {
        border-color: #74c69d;
        background-color: #f0faf4;
        transform: translateY(-3px);
        box-shadow: 0 6px 18px rgba(45,106,79,0.1);
    }
    .lb-cat-icon { font-size: 1.8rem; }
    /* Flechas de navegación */
    .lb-cat-arrow {
        position: absolute; top: 50%; transform: translateY(-50%);
        z-index: 2;
        width: 2rem; height: 2rem;
        display: flex; align-items: center; justify-content: center;
        background: white;
        border: 1.5px solid #dee2e6;
        border-radius: 50%;
        color: #2d6a4f;
        cursor: pointer;
        transition: all 0.2s;
        padding: 0;
        line-height: 1;
    }
    .lb-cat-arrow:hover { background: #f0faf4; border-color: #74c69d; }
    .lb-cat-arrow.disabled { opacity: 0.3; cursor: default; pointer-events: none; }
    .lb-cat-arrow-left  { left: 0; }
    .lb-cat-arrow-right { right: 0; }
    .text-lb-verde { color: #1b4332; }

    /* ── Tarjetas de producto ─────────────────────────────────────────────── */
    .lb-prod-card {
        border: none; border-radius: 0.75rem;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        transition: transform 0.2s, box-shadow 0.2s;
        overflow: hidden;
    }
    .lb-prod-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 28px rgba(0,0,0,0.13);
    }
    .lb-prod-img {
        height: 200px; object-fit: cover; width: 100%;
    }
    .lb-prod-img-placeholder {
        height: 200px; background: linear-gradient(135deg, #d8f3dc, #b7e4c7);
        display: flex; align-items: center; justify-content: center;
        font-size: 3.5rem;
    }
    .lb-precio { color: #2d6a4f; font-weight: 700; font-size: 1.2rem; }
    .lb-badge-destacado {
        background-color: #fff3cd; color: #856404;
        font-size: 0.7rem; font-weight: 600;
    }
    .lb-btn-agregar {
        background-color: #2d6a4f; border-color: #2d6a4f; color: white;
        border-radius: 0 0 0.75rem 0.75rem;
        transition: background-color 0.2s;
    }
    .lb-btn-agregar:hover { background-color: #1b4332; border-color: #1b4332; color: white; }
</style>
@endpush

@push('scripts')
<script>
(function () {
    const track  = document.getElementById('catTrack');
    const btnPrev = document.getElementById('catPrev');
    const btnNext = document.getElementById('catNext');

    if (!track || !btnPrev || !btnNext) return;

    // Desplazamiento equivalente al ancho visible del track
    function scrollAmount() {
        return track.clientWidth * 0.8;
    }

    function updateArrows() {
        btnPrev.classList.toggle('disabled', track.scrollLeft <= 2);
        btnNext.classList.toggle('disabled',
            track.scrollLeft + track.clientWidth >= track.scrollWidth - 2);
    }

    btnPrev.addEventListener('click', function () {
        track.scrollBy({ left: -scrollAmount(), behavior: 'smooth' });
    });

    btnNext.addEventListener('click', function () {
        track.scrollBy({ left: scrollAmount(), behavior: 'smooth' });
    });

    track.addEventListener('scroll', updateArrows, { passive: true });

    // Estado inicial
    updateArrows();
})();
</script>
@endpush
