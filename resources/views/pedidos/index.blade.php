@extends('layouts.app')

@section('titulo', 'Mis Pedidos')

@section('encabezado')
    <h1 class="h3 fw-bold mb-1"><i class="bi bi-bag-check me-2"></i>Mis Pedidos</h1>
    <p class="mb-0 opacity-75 small">Historial completo de tus compras</p>
@endsection

@section('contenido')
<div class="container py-4">

    @include('partials.alertas')

    @if($pedidos->isEmpty())
        <div class="text-center py-5">
            <div style="font-size: 5rem;">📦</div>
            <h4 class="fw-bold mt-3">Aún no tienes pedidos</h4>
            <p class="text-muted mb-4">Explora nuestro catálogo y realiza tu primer pedido.</p>
            <a href="{{ route('catalogo.index') }}" class="btn btn-lb-primary btn-lg">
                <i class="bi bi-grid me-2"></i>Ir al catálogo
            </a>
        </div>
    @else
        <div class="row g-3">
            @foreach($pedidos as $pedido)
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-3 lb-pedido-card">
                    <div class="card-body p-3 p-md-4">
                        <div class="row align-items-center g-3">

                            {{-- Info principal --}}
                            <div class="col-md-5">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="lb-pedido-icon">
                                        <i class="bi bi-bag fs-4"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-0" style="color: #1b4332;">
                                            {{ $pedido->num_pedido }}
                                        </h6>
                                        <small class="text-muted">
                                            {{ $pedido->created_at->format('d/m/Y, H:i') }}
                                        </small>
                                    </div>
                                </div>
                            </div>

                            {{-- Estado --}}
                            <div class="col-md-3 col-6">
                                @php
                                    $color = $pedido->estadoPedido->color ?? '#6c757d';
                                @endphp
                                <span class="badge px-3 py-2 rounded-pill"
                                      style="background-color: {{ $color }}20; color: {{ $color }}; border: 1px solid {{ $color }}40;">
                                    {{ $pedido->estadoPedido->nombre ?? 'Sin estado' }}
                                </span>
                            </div>

                            {{-- Total --}}
                            <div class="col-md-2 col-6 text-end text-md-start">
                                <span class="fw-bold" style="color: #2d6a4f; font-size: 1.05rem;">
                                    ₡{{ number_format($pedido->total, 2) }}
                                </span>
                            </div>

                            {{-- Acción --}}
                            <div class="col-md-2 text-md-end">
                                <a href="{{ route('pedidos.detalle', $pedido->id_pedido) }}"
                                   class="btn btn-sm btn-outline-success">
                                    Ver detalle <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Paginación --}}
        @if($pedidos->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $pedidos->links('pagination::bootstrap-5') }}
            </div>
        @endif
    @endif
</div>
@endsection

@push('styles')
<style>
    .lb-pedido-card { transition: transform 0.15s, box-shadow 0.15s; }
    .lb-pedido-card:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,0.1) !important; }
    .lb-pedido-icon {
        width: 48px; height: 48px; border-radius: 12px;
        background-color: #d8f3dc; color: #2d6a4f;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .btn-lb-primary { background-color: #2d6a4f; border-color: #2d6a4f; color: white; }
    .btn-lb-primary:hover { background-color: #1b4332; border-color: #1b4332; color: white; }
</style>
@endpush
