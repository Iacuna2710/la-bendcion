@extends('layouts.app')

@section('titulo', 'Mi Carrito')

@section('encabezado')
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="h3 fw-bold mb-1"><i class="bi bi-cart3 me-2"></i>Mi Carrito</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 small">
                    <li class="breadcrumb-item"><a href="{{ route('inicio') }}" class="text-white-50 text-decoration-none">Inicio</a></li>
                    <li class="breadcrumb-item active text-white">Mi Carrito</li>
                </ol>
            </nav>
        </div>
        @if($carrito && $carrito->items->isNotEmpty())
            <form method="POST" action="{{ route('carrito.vaciar') }}"
                  onsubmit="return confirm('¿Vaciar todo el carrito?')">
                @csrf
                <button type="submit" class="btn btn-outline-light btn-sm">
                    <i class="bi bi-trash me-1"></i>Vaciar carrito
                </button>
            </form>
        @endif
    </div>
@endsection

@section('contenido')
<div class="container py-4">

    @include('partials.alertas')

    @if(!$carrito || $carrito->items->isEmpty())
        {{-- Carrito vacío --}}
        <div class="text-center py-5">
            <div style="font-size: 5rem;" class="mb-3">🛒</div>
            <h4 class="fw-bold">Tu carrito está vacío</h4>
            <p class="text-muted mb-4">¡Explora nuestro catálogo y agrega productos naturales!</p>
            <a href="{{ route('catalogo.index') }}" class="btn btn-lb-primary btn-lg">
                <i class="bi bi-grid me-2"></i>Ir al catálogo
            </a>
        </div>
    @else
        <div class="row g-4">

            {{-- ── ÍTEMS DEL CARRITO ────────────────────────────────────── --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body p-0">
                        @foreach($carrito->items as $item)
                        <div class="lb-cart-item d-flex gap-3 p-3 {{ !$loop->last ? 'border-bottom' : '' }}">

                            {{-- Imagen --}}
                            <div class="flex-shrink-0">
                                @if($item->producto->imagenes->isNotEmpty())
                                    <img src="{{ asset('storage/' . $item->producto->imagenes->first()->url) }}"
                                         alt="{{ $item->producto->nombre }}"
                                         class="lb-cart-img rounded-2">
                                @else
                                    <div class="lb-cart-img-placeholder rounded-2">🌿</div>
                                @endif
                            </div>

                            {{-- Info del producto --}}
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="fw-semibold mb-1">
                                            <a href="{{ route('catalogo.detalle', $item->id_producto) }}"
                                               class="text-decoration-none text-dark">
                                                {{ $item->producto->nombre }}
                                            </a>
                                        </h6>
                                        <p class="text-muted small mb-2">
                                            Precio unitario: <strong>₡{{ number_format($item->precio_unitario, 2) }}</strong>
                                        </p>
                                    </div>
                                    {{-- Eliminar ítem --}}
                                    <form method="POST" action="{{ route('carrito.eliminar', $item->id_c_item) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-link text-danger p-0"
                                                title="Eliminar" onclick="return confirm('¿Eliminar este producto?')">
                                            <i class="bi bi-x-circle"></i>
                                        </button>
                                    </form>
                                </div>

                                {{-- Control de cantidad y subtotal --}}
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                    <form method="POST" action="{{ route('carrito.actualizar', $item->id_c_item) }}"
                                          class="d-flex align-items-center gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <div class="lb-qty-sm d-flex align-items-center border rounded-2">
                                            <button type="button" class="btn btn-light btn-sm border-0 px-2 py-1 lb-qty-btn"
                                                    data-target="qty-{{ $item->id_c_item }}" data-dir="-1">
                                                <i class="bi bi-dash"></i>
                                            </button>
                                            <input type="number" name="cantidad"
                                                   id="qty-{{ $item->id_c_item }}"
                                                   value="{{ $item->cantidad }}"
                                                   min="1" max="{{ $item->producto->stock }}"
                                                   class="form-control form-control-sm border-0 text-center fw-bold p-1"
                                                   style="width:50px;">
                                            <button type="button" class="btn btn-light btn-sm border-0 px-2 py-1 lb-qty-btn"
                                                    data-target="qty-{{ $item->id_c_item }}" data-dir="1">
                                                <i class="bi bi-plus"></i>
                                            </button>
                                        </div>
                                        <button type="submit" class="btn btn-sm btn-outline-secondary">
                                            <i class="bi bi-arrow-clockwise me-1"></i>Actualizar
                                        </button>
                                    </form>
                                    <span class="lb-subtotal-item fw-bold">
                                        ₡{{ number_format($item->subtotal, 2) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- ── RESUMEN DEL PEDIDO ───────────────────────────────────── --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-3 sticky-top" style="top: 80px;">
                    <div class="card-header bg-white border-bottom fw-bold" style="color: #1b4332;">
                        <i class="bi bi-receipt me-2"></i>Resumen del pedido
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2 text-muted small">
                            <span>Subtotal ({{ $carrito->items->sum('cantidad') }} ítem{{ $carrito->items->sum('cantidad') !== 1 ? 's' : '' }})</span>
                            <span>₡{{ number_format($carrito->subtotal ?? $carrito->items->sum('subtotal'), 2) }}</span>
                        </div>
                        @if($carrito->descuento > 0)
                        <div class="d-flex justify-content-between mb-2 text-success small">
                            <span>Descuento</span>
                            <span>-₡{{ number_format($carrito->descuento, 2) }}</span>
                        </div>
                        @endif
                        <hr>
                        <div class="d-flex justify-content-between fw-bold fs-5">
                            <span style="color: #1b4332;">Total</span>
                            <span style="color: #2d6a4f;">₡{{ number_format($carrito->total ?? $carrito->items->sum('subtotal'), 2) }}</span>
                        </div>
                        <div class="d-grid mt-3">
                            <a href="{{ route('pedidos.confirmar') }}" class="btn btn-lb-primary btn-lg fw-semibold">
                                <i class="bi bi-bag-check me-2"></i>Confirmar pedido
                            </a>
                        </div>
                        <div class="text-center mt-2">
                            <a href="{{ route('catalogo.index') }}" class="text-muted small text-decoration-none">
                                <i class="bi bi-arrow-left me-1"></i>Seguir comprando
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .lb-cart-img { width: 80px; height: 80px; object-fit: cover; }
    .lb-cart-img-placeholder {
        width: 80px; height: 80px;
        background: linear-gradient(135deg, #d8f3dc, #b7e4c7);
        display: flex; align-items: center; justify-content: center;
        font-size: 2rem;
    }
    .lb-cart-item { transition: background-color 0.15s; }
    .lb-cart-item:hover { background-color: #fafffe; }
    .lb-subtotal-item { color: #2d6a4f; font-size: 1.05rem; }
    .lb-qty-sm input::-webkit-outer-spin-button,
    .lb-qty-sm input::-webkit-inner-spin-button { -webkit-appearance: none; }
    .lb-qty-sm input[type=number] { -moz-appearance: textfield; }
    .btn-lb-primary { background-color: #2d6a4f; border-color: #2d6a4f; color: white; }
    .btn-lb-primary:hover { background-color: #1b4332; border-color: #1b4332; color: white; }
</style>
@endpush

@push('scripts')
<script>
    // Botones +/- de cantidad
    document.querySelectorAll('.lb-qty-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const input = document.getElementById(this.dataset.target);
            const dir   = parseInt(this.dataset.dir);
            const val   = parseInt(input.value) + dir;
            const min   = parseInt(input.min) || 1;
            const max   = parseInt(input.max) || 99;
            if (val >= min && val <= max) input.value = val;
        });
    });
</script>
@endpush
