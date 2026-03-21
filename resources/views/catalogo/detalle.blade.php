@extends('layouts.app')

@section('titulo', $producto->nombre)

@section('encabezado')
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2 small">
                <li class="breadcrumb-item">
                    <a href="{{ route('inicio') }}" class="text-white-50 text-decoration-none">Inicio</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('catalogo.index') }}" class="text-white-50 text-decoration-none">Catálogo</a>
                </li>
                <li class="breadcrumb-item active text-white" aria-current="page">
                    {{ Str::limit($producto->nombre, 40) }}
                </li>
            </ol>
        </nav>
        <h1 class="h3 fw-bold mb-0">{{ $producto->nombre }}</h1>
    </div>
@endsection

@section('contenido')
<div class="container py-4">

    {{-- Alertas --}}
    @include('partials.alertas')

    <div class="row g-4">

        {{-- ── GALERÍA DE IMÁGENES ─────────────────────────────────────── --}}
        <div class="col-lg-6">
            @if($producto->imagenes->isNotEmpty())
                {{-- Imagen principal (carousel) --}}
                <div id="carouselProducto" class="carousel slide rounded-4 overflow-hidden shadow-sm"
                     data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach($producto->imagenes as $index => $imagen)
                            <div class="carousel-item {{ $imagen->es_principal || $index === 0 ? 'active' : '' }}">
                                <img src="{{ asset('storage/' . $imagen->url) }}"
                                     alt="{{ $imagen->alt_text ?? $producto->nombre }}"
                                     class="d-block w-100 lb-detalle-img">
                            </div>
                        @endforeach
                    </div>
                    @if($producto->imagenes->count() > 1)
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselProducto" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselProducto" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    @endif
                </div>

                {{-- Miniaturas --}}
                @if($producto->imagenes->count() > 1)
                    <div class="d-flex gap-2 mt-3 flex-wrap">
                        @foreach($producto->imagenes as $index => $imagen)
                            <img src="{{ asset('storage/' . $imagen->url) }}"
                                 alt="{{ $imagen->alt_text }}"
                                 class="lb-thumb rounded-2 {{ $imagen->es_principal || $index === 0 ? 'lb-thumb-active' : '' }}"
                                 data-bs-target="#carouselProducto"
                                 data-bs-slide-to="{{ $index }}"
                                 role="button">
                        @endforeach
                    </div>
                @endif
            @else
                {{-- Placeholder si no hay imágenes --}}
                <div class="lb-detalle-placeholder rounded-4 shadow-sm">
                    <span>🌿</span>
                </div>
            @endif
        </div>

        {{-- ── INFORMACIÓN DEL PRODUCTO ────────────────────────────────── --}}
        <div class="col-lg-6">

            {{-- Categorías --}}
            <div class="mb-2">
                @foreach($producto->categorias as $cat)
                    <a href="{{ route('catalogo.index', ['categoria' => $cat->slug]) }}"
                       class="badge lb-badge-cat text-decoration-none me-1">
                        {{ $cat->nombre }}
                    </a>
                @endforeach
                @if($producto->es_destacado)
                    <span class="badge bg-warning text-dark">
                        <i class="bi bi-star-fill me-1"></i>Destacado
                    </span>
                @endif
            </div>

            {{-- Nombre y precio --}}
            <h1 class="h3 fw-bold mb-1">{{ $producto->nombre }}</h1>
            @if($producto->sku)
                <p class="text-muted small mb-2">SKU: {{ $producto->sku }}</p>
            @endif
            <div class="lb-precio-detalle mb-3">
                ₡{{ number_format($producto->precio, 2) }}
            </div>

            {{-- Disponibilidad --}}
            <div class="mb-4">
                @if($producto->stock > 10)
                    <span class="badge bg-success-subtle text-success border border-success-subtle">
                        <i class="bi bi-check-circle me-1"></i>En stock ({{ $producto->stock }} disponibles)
                    </span>
                @elseif($producto->stock > 0)
                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle">
                        <i class="bi bi-exclamation-circle me-1"></i>Últimas {{ $producto->stock }} unidades
                    </span>
                @else
                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle">
                        <i class="bi bi-x-circle me-1"></i>Sin stock
                    </span>
                @endif
            </div>

            {{-- Formulario de agregar al carrito --}}
            @if($producto->stock > 0)
                @auth
                    <form method="POST" action="{{ route('carrito.agregar') }}" class="mb-4">
                        @csrf
                        <input type="hidden" name="id_producto" value="{{ $producto->id_producto }}">
                        <div class="d-flex gap-3 align-items-center mb-3">
                            <div class="lb-qty-control d-flex align-items-center border rounded-3 overflow-hidden">
                                <button type="button" class="btn btn-light px-3 py-2 border-0" id="btnMenos">
                                    <i class="bi bi-dash"></i>
                                </button>
                                <input type="number" name="cantidad" id="cantidad" value="1" min="1"
                                       max="{{ $producto->stock }}"
                                       class="form-control border-0 text-center fw-bold"
                                       style="width: 60px;">
                                <button type="button" class="btn btn-light px-3 py-2 border-0" id="btnMas">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="d-flex gap-2 flex-wrap">
                            <button type="submit" class="btn btn-lb-agregar btn-lg flex-grow-1">
                                <i class="bi bi-cart-plus me-2"></i>Agregar al carrito
                            </button>
                            <a href="{{ route('carrito.index') }}"
                               class="btn btn-outline-success btn-lg">
                                <i class="bi bi-cart3"></i>
                            </a>
                        </div>
                    </form>
                @else
                    <div class="d-grid mb-4">
                        <a href="{{ route('login') }}" class="btn btn-lb-agregar btn-lg">
                            <i class="bi bi-person me-2"></i>Inicia sesión para comprar
                        </a>
                    </div>
                @endauth
            @endif

            {{-- Descripción --}}
            @if($producto->descripcion)
                <div class="mb-4">
                    <h6 class="fw-bold text-muted text-uppercase" style="letter-spacing: 0.5px; font-size: 0.75rem;">Descripción</h6>
                    <p class="text-muted lh-lg">{{ $producto->descripcion }}</p>
                </div>
            @endif

        </div>
    </div>

    {{-- ── TABS: INGREDIENTES / BENEFICIOS ──────────────────────────── --}}
    @if($producto->ingredientes || $producto->beneficios)
        <div class="row mt-4">
            <div class="col-12">
                <ul class="nav nav-tabs lb-tabs" id="tabs-detalle" role="tablist">
                    @if($producto->ingredientes)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="tab-ingredientes"
                                    data-bs-toggle="tab" data-bs-target="#pane-ingredientes"
                                    type="button" role="tab">
                                <i class="bi bi-list-ul me-2"></i>Ingredientes
                            </button>
                        </li>
                    @endif
                    @if($producto->beneficios)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ !$producto->ingredientes ? 'active' : '' }}"
                                    id="tab-beneficios"
                                    data-bs-toggle="tab" data-bs-target="#pane-beneficios"
                                    type="button" role="tab">
                                <i class="bi bi-heart me-2"></i>Beneficios
                            </button>
                        </li>
                    @endif
                </ul>
                <div class="tab-content lb-tab-content p-4 bg-white border border-top-0 rounded-bottom-3">
                    @if($producto->ingredientes)
                        <div class="tab-pane fade show active" id="pane-ingredientes" role="tabpanel">
                            <p class="mb-0 lh-lg text-muted">{{ $producto->ingredientes }}</p>
                        </div>
                    @endif
                    @if($producto->beneficios)
                        <div class="tab-pane fade {{ !$producto->ingredientes ? 'show active' : '' }}"
                             id="pane-beneficios" role="tabpanel">
                            <p class="mb-0 lh-lg text-muted">{{ $producto->beneficios }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif

    {{-- ── PRODUCTOS RELACIONADOS ────────────────────────────────────── --}}
    @if($relacionados->isNotEmpty())
        <section class="mt-5">
            <h4 class="fw-bold mb-4" style="color: #1b4332;">
                <i class="bi bi-grid me-2"></i>Productos relacionados
            </h4>
            <div class="row g-3">
                @foreach($relacionados as $prod)
                    @include('catalogo._card-producto', ['producto' => $prod])
                @endforeach
            </div>
        </section>
    @endif

</div>
@endsection

@push('styles')
<style>
    .lb-detalle-img { height: 420px; object-fit: cover; }
    .lb-detalle-placeholder {
        height: 420px; background: linear-gradient(135deg, #d8f3dc, #b7e4c7);
        display: flex; align-items: center; justify-content: center; font-size: 8rem;
    }
    .lb-thumb {
        width: 70px; height: 70px; object-fit: cover; cursor: pointer;
        border: 2.5px solid transparent; transition: border-color 0.2s, opacity 0.2s;
        opacity: 0.7;
    }
    .lb-thumb:hover, .lb-thumb-active { border-color: #2d6a4f; opacity: 1; }
    .lb-precio-detalle { font-size: 2rem; font-weight: 700; color: #2d6a4f; }
    .lb-badge-cat {
        background-color: #d8f3dc; color: #1b4332;
        font-size: 0.75rem; font-weight: 600; padding: 0.3rem 0.6rem; border-radius: 20px;
        transition: background-color 0.2s;
    }
    .lb-badge-cat:hover { background-color: #b7e4c7; color: #1b4332; }
    .lb-qty-control input::-webkit-outer-spin-button,
    .lb-qty-control input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
    .lb-qty-control input[type=number] { -moz-appearance: textfield; }
    .btn-lb-agregar {
        background-color: #2d6a4f; border-color: #2d6a4f; color: white;
        border-radius: 0.5rem; transition: background-color 0.2s;
    }
    .btn-lb-agregar:hover { background-color: #1b4332; border-color: #1b4332; color: white; }
    /* Tabs */
    .lb-tabs .nav-link { color: #6c757d; border-color: transparent; }
    .lb-tabs .nav-link.active { color: #1b4332; border-color: #dee2e6 #dee2e6 white; font-weight: 600; }
    .lb-tabs .nav-link:hover { color: #2d6a4f; }
    /* Tarjetas de relacionados */
    .lb-prod-card { border: none; border-radius: 0.75rem; box-shadow: 0 2px 12px rgba(0,0,0,0.08); transition: transform 0.2s, box-shadow 0.2s; overflow: hidden; position: relative; }
    .lb-prod-card:hover { transform: translateY(-4px); box-shadow: 0 10px 28px rgba(0,0,0,0.13); }
    .lb-prod-img { height: 180px; object-fit: cover; width: 100%; }
    .lb-prod-img-placeholder { height: 180px; background: linear-gradient(135deg, #d8f3dc, #b7e4c7); display: flex; align-items: center; justify-content: center; font-size: 3rem; }
    .lb-precio { color: #2d6a4f; font-weight: 700; font-size: 1.1rem; }
    .lb-badge-categoria { background-color: #d8f3dc; color: #1b4332; font-size: 0.68rem; font-weight: 600; }
    .lb-badge-destacado { background-color: #fff3cd; color: #856404; font-size: 0.7rem; font-weight: 600; }
    .lb-btn-agregar { background-color: #2d6a4f; border-color: #2d6a4f; color: white; border-radius: 0 0 0.75rem 0.75rem; }
    .lb-btn-agregar:hover { background-color: #1b4332; border-color: #1b4332; color: white; }
    .lb-prod-nombre { font-size: 0.9rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
</style>
@endpush

@push('scripts')
<script>
    // ── Control de cantidad +/- ────────────────────────────────────────────
    const inputCantidad = document.getElementById('cantidad');
    const maxStock      = {{ $producto->stock }};

    document.getElementById('btnMenos')?.addEventListener('click', function () {
        if (parseInt(inputCantidad.value) > 1) {
            inputCantidad.value = parseInt(inputCantidad.value) - 1;
        }
    });
    document.getElementById('btnMas')?.addEventListener('click', function () {
        if (parseInt(inputCantidad.value) < maxStock) {
            inputCantidad.value = parseInt(inputCantidad.value) + 1;
        }
    });

    // ── Miniaturas del carousel ───────────────────────────────────────────
    document.querySelectorAll('.lb-thumb').forEach(function (thumb) {
        thumb.addEventListener('click', function () {
            document.querySelectorAll('.lb-thumb').forEach(t => t.classList.remove('lb-thumb-active'));
            this.classList.add('lb-thumb-active');
        });
    });
</script>
@endpush
