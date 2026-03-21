@extends('layouts.app')

@section('titulo', 'Catálogo de Productos')

@section('encabezado')
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="h3 fw-bold mb-1">
                <i class="bi bi-grid me-2"></i>Catálogo de Productos
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 small">
                    <li class="breadcrumb-item">
                        <a href="{{ route('inicio') }}" class="text-white-50 text-decoration-none">Inicio</a>
                    </li>
                    <li class="breadcrumb-item active text-white" aria-current="page">Catálogo</li>
                </ol>
            </nav>
        </div>
        <div class="text-white-50 small d-none d-md-block">
            {{ $productos->total() }} producto{{ $productos->total() !== 1 ? 's' : '' }} encontrado{{ $productos->total() !== 1 ? 's' : '' }}
        </div>
    </div>
@endsection

@section('contenido')
<div class="container py-4">
    <div class="row g-4">

        {{-- ── SIDEBAR DE FILTROS ───────────────────────────────────────── --}}
        <div class="col-lg-3">

            {{-- Búsqueda --}}
            <div class="card border-0 shadow-sm rounded-3 mb-3">
                <div class="card-body p-3">
                    <h6 class="fw-bold mb-3" style="color: #1b4332;">
                        <i class="bi bi-search me-2"></i>Buscar
                    </h6>
                    <form method="GET" action="{{ route('catalogo.index') }}">
                        @if($categoriaActual)
                            <input type="hidden" name="categoria" value="{{ $categoriaActual->slug }}">
                        @endif
                        <div class="input-group">
                            <input type="text" name="buscar" class="form-control form-control-sm"
                                   placeholder="Nombre del producto..."
                                   value="{{ $busqueda }}">
                            <button class="btn btn-sm" type="submit"
                                    style="background-color: #2d6a4f; color: white;">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Categorías --}}
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-3">
                    <h6 class="fw-bold mb-3" style="color: #1b4332;">
                        <i class="bi bi-tags me-2"></i>Categorías
                    </h6>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-1">
                            <a href="{{ route('catalogo.index', ['buscar' => $busqueda]) }}"
                               class="d-flex justify-content-between align-items-center py-1 px-2 rounded text-decoration-none lb-cat-filter {{ !$categoriaActual ? 'lb-cat-active' : '' }}">
                                <span>Todos</span>
                                <span class="badge bg-light text-muted">{{ $productos->total() }}</span>
                            </a>
                        </li>
                        @foreach($categorias as $cat)
                            <li class="mb-1">
                                <a href="{{ route('catalogo.index', ['categoria' => $cat->slug, 'buscar' => $busqueda]) }}"
                                   class="d-flex justify-content-between align-items-center py-1 px-2 rounded text-decoration-none lb-cat-filter {{ $categoriaActual?->id_categoria === $cat->id_categoria ? 'lb-cat-active' : '' }}">
                                    <span>{{ $cat->nombre }}</span>
                                    <span class="badge bg-light text-muted">{{ $cat->productos_count }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    {{-- Limpiar filtros --}}
                    @if($busqueda || $categoriaActual)
                        <div class="mt-3 pt-2 border-top">
                            <a href="{{ route('catalogo.index') }}"
                               class="btn btn-sm btn-outline-secondary w-100">
                                <i class="bi bi-x-circle me-1"></i>Limpiar filtros
                            </a>
                        </div>
                    @endif
                </div>
            </div>

        </div>

        {{-- ── GRID DE PRODUCTOS ────────────────────────────────────────── --}}
        <div class="col-lg-9">

            {{-- Alertas --}}
            @include('partials.alertas')

            {{-- Encabezado del resultado --}}
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                <div>
                    @if($categoriaActual)
                        <h5 class="fw-bold mb-0" style="color: #1b4332;">
                            {{ $categoriaActual->nombre }}
                        </h5>
                    @endif
                    @if($busqueda)
                        <p class="text-muted small mb-0">
                            Resultados para: <strong>«{{ $busqueda }}»</strong>
                        </p>
                    @endif
                </div>
                <span class="text-muted small d-lg-none">
                    {{ $productos->total() }} resultado{{ $productos->total() !== 1 ? 's' : '' }}
                </span>
            </div>

            {{-- Sin resultados --}}
            @if($productos->isEmpty())
                <div class="text-center py-5">
                    <div style="font-size: 4rem;">🔍</div>
                    <h5 class="fw-semibold mt-3">No encontramos productos</h5>
                    <p class="text-muted">Intenta con otros términos o explora nuestras categorías.</p>
                    <a href="{{ route('catalogo.index') }}" class="btn btn-lb-primary mt-2">
                        Ver todos los productos
                    </a>
                </div>
            @else
                {{-- Grid de productos --}}
                <div class="row g-3">
                    @foreach($productos as $producto)
                        @include('catalogo._card-producto', ['producto' => $producto])
                    @endforeach
                </div>

                {{-- Paginación --}}
                @if($productos->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $productos->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            @endif

        </div>

    </div>
</div>
@endsection

@push('styles')
<style>
    .lb-cat-filter {
        color: #444;
        font-size: 0.88rem;
        transition: all 0.2s;
    }
    .lb-cat-filter:hover {
        background-color: #f0faf4;
        color: #1b4332;
    }
    .lb-cat-active {
        background-color: #d8f3dc !important;
        color: #1b4332 !important;
        font-weight: 600;
    }
    /* Tarjetas de producto (copiadas del index para consistencia) */
    .lb-prod-card {
        border: none; border-radius: 0.75rem;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        transition: transform 0.2s, box-shadow 0.2s;
        overflow: hidden; position: relative;
    }
    .lb-prod-card:hover { transform: translateY(-4px); box-shadow: 0 10px 28px rgba(0,0,0,0.13); }
    .lb-prod-img { height: 180px; object-fit: cover; width: 100%; }
    .lb-prod-img-placeholder {
        height: 180px; background: linear-gradient(135deg, #d8f3dc, #b7e4c7);
        display: flex; align-items: center; justify-content: center; font-size: 3rem;
    }
    .lb-precio { color: #2d6a4f; font-weight: 700; font-size: 1.1rem; }
    .lb-badge-categoria { background-color: #d8f3dc; color: #1b4332; font-size: 0.68rem; font-weight: 600; }
    .lb-badge-destacado { background-color: #fff3cd; color: #856404; font-size: 0.7rem; font-weight: 600; }
    .lb-prod-nombre { font-size: 0.9rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .lb-btn-agregar { background-color: #2d6a4f; border-color: #2d6a4f; color: white; border-radius: 0 0 0.75rem 0.75rem; }
    .lb-btn-agregar:hover { background-color: #1b4332; border-color: #1b4332; color: white; }
    .btn-lb-primary { background-color: #2d6a4f; border-color: #2d6a4f; color: white; }
    .btn-lb-primary:hover { background-color: #1b4332; border-color: #1b4332; color: white; }
</style>
@endpush
