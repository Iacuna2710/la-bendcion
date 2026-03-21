@extends('layouts.app')

@section('titulo', 'Detalle del Pedido ' . $pedido->num_pedido)

@section('encabezado')
    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-2 small">
                    <li class="breadcrumb-item"><a href="{{ route('inicio') }}" class="text-white-50 text-decoration-none">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('pedidos.index') }}" class="text-white-50 text-decoration-none">Mis Pedidos</a></li>
                    <li class="breadcrumb-item active text-white">{{ $pedido->num_pedido }}</li>
                </ol>
            </nav>
            <h1 class="h3 fw-bold mb-0">{{ $pedido->num_pedido }}</h1>
        </div>
        @php $color = $pedido->estadoPedido->color ?? '#6c757d'; @endphp
        <span class="badge fs-6 px-3 py-2 rounded-pill"
              style="background-color: {{ $color }}30; color: {{ $color }}; border: 1px solid {{ $color }}60;">
            {{ $pedido->estadoPedido->nombre ?? 'Sin estado' }}
        </span>
    </div>
@endsection

@section('contenido')
<div class="container py-4">

    @include('partials.alertas')

    <div class="row g-4">

        {{-- ── DETALLE DE ÍTEMS ─────────────────────────────────────────── --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-header bg-white border-bottom fw-bold" style="color: #1b4332;">
                    <i class="bi bi-bag me-2"></i>Productos del pedido
                </div>
                <div class="card-body p-0">
                    @foreach($pedido->items as $item)
                    <div class="d-flex align-items-center gap-3 p-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                        <div class="rounded-2 d-flex align-items-center justify-content-center flex-shrink-0"
                             style="width:60px; height:60px; background: linear-gradient(135deg,#d8f3dc,#b7e4c7); font-size:1.6rem;">🌿</div>
                        <div class="flex-grow-1">
                            <p class="fw-semibold mb-0">{{ $item->producto->nombre ?? 'Producto' }}</p>
                            <small class="text-muted">{{ $item->cantidad }} × ₡{{ number_format($item->precio_unitario, 2) }}</small>
                        </div>
                        <span class="fw-bold" style="color:#2d6a4f;">₡{{ number_format($item->subtotal, 2) }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Dirección e info de entrega --}}
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white border-bottom fw-bold" style="color: #1b4332;">
                    <i class="bi bi-geo-alt me-2"></i>Información de entrega
                </div>
                <div class="card-body">
                    @if($pedido->direccion)
                        <p class="mb-1 fw-semibold">{{ $pedido->direccion->detalle }}</p>
                        <p class="text-muted small mb-0">
                            {{ $pedido->direccion->distrito->nombre ?? '' }},
                            {{ $pedido->direccion->distrito->canton->nombre ?? '' }},
                            {{ $pedido->direccion->distrito->canton->provincia->nombre ?? '' }}
                        </p>
                    @else
                        <p class="text-muted mb-0">Dirección no disponible</p>
                    @endif

                    @if($pedido->fecha_entrega_esperada)
                        <div class="mt-2 small">
                            <i class="bi bi-calendar-check text-success me-1"></i>
                            <strong>Entrega estimada:</strong>
                            {{ \Carbon\Carbon::parse($pedido->fecha_entrega_esperada)->format('d/m/Y') }}
                        </div>
                    @endif
                    @if($pedido->fecha_entrega_real)
                        <div class="mt-1 small">
                            <i class="bi bi-check-circle-fill text-success me-1"></i>
                            <strong>Entregado el:</strong>
                            {{ \Carbon\Carbon::parse($pedido->fecha_entrega_real)->format('d/m/Y') }}
                        </div>
                    @endif
                    @if($pedido->notas)
                        <div class="mt-2 small">
                            <i class="bi bi-chat-left-text text-muted me-1"></i>
                            <strong>Notas:</strong> {{ $pedido->notas }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- ── RESUMEN ECONÓMICO ────────────────────────────────────────── --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-3 mb-3">
                <div class="card-header bg-white border-bottom fw-bold" style="color: #1b4332;">
                    <i class="bi bi-receipt me-2"></i>Resumen
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between text-muted small mb-2">
                        <span>Subtotal</span>
                        <span>₡{{ number_format($pedido->subtotal, 2) }}</span>
                    </div>
                    @if($pedido->descuento > 0)
                    <div class="d-flex justify-content-between text-success small mb-2">
                        <span>Descuento</span>
                        <span>-₡{{ number_format($pedido->descuento, 2) }}</span>
                    </div>
                    @endif
                    @if($pedido->costo_envio > 0)
                    <div class="d-flex justify-content-between text-muted small mb-2">
                        <span>Envío</span>
                        <span>₡{{ number_format($pedido->costo_envio, 2) }}</span>
                    </div>
                    @endif
                    @if($pedido->impuesto > 0)
                    <div class="d-flex justify-content-between text-muted small mb-2">
                        <span>Impuesto</span>
                        <span>₡{{ number_format($pedido->impuesto, 2) }}</span>
                    </div>
                    @endif
                    <hr>
                    <div class="d-flex justify-content-between fw-bold mb-3">
                        <span style="color:#1b4332;">Total</span>
                        <span style="color:#2d6a4f; font-size:1.2rem;">₡{{ number_format($pedido->total, 2) }}</span>
                    </div>

                    {{-- Info de fecha --}}
                    <div class="text-muted small border-top pt-2">
                        <div><i class="bi bi-calendar me-1"></i>Pedido: {{ $pedido->created_at->format('d/m/Y H:i') }}</div>
                    </div>
                </div>
            </div>

            {{-- Factura disponible --}}
            @if($pedido->factura)
                <a href="{{ route('facturas.show', $pedido->factura->id_factura) }}"
                   class="btn btn-outline-success w-100 mb-3">
                    <i class="bi bi-file-earmark-text me-2"></i>Ver factura
                </a>
            @endif

            {{-- Volver --}}
            <a href="{{ route('pedidos.index') }}" class="btn btn-outline-secondary w-100">
                <i class="bi bi-arrow-left me-2"></i>Mis pedidos
            </a>
        </div>

    </div>
</div>
@endsection

@push('styles')
<style>
    .btn-lb-primary { background-color: #2d6a4f; border-color: #2d6a4f; color: white; }
    .btn-lb-primary:hover { background-color: #1b4332; border-color: #1b4332; color: white; }
</style>
@endpush
