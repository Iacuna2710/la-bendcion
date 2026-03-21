@extends('layouts.admin')

@section('titulo', 'Detalle Pedido ' . $pedido->num_pedido)

@section('contenido')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 fw-bold mb-0">
        Pedido <span class="font-monospace">{{ $pedido->num_pedido }}</span>
    </h2>
    <a href="{{ route('admin.pedidos.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Volver
    </a>
</div>

@include('partials.alertas')

<div class="row g-4">

    {{-- Ítems del pedido --}}
    <div class="col-lg-8">
        <div class="card lb-admin-card mb-4">
            <div class="card-header fw-bold"><i class="bi bi-bag me-2"></i>Productos</div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table lb-admin-table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Producto</th>
                                <th class="text-center">Cantidad</th>
                                <th class="text-end">P. Unit.</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pedido->items as $item)
                            <tr>
                                <td>{{ $item->producto->nombre ?? '—' }}</td>
                                <td class="text-center">{{ $item->cantidad }}</td>
                                <td class="text-end">₡{{ number_format($item->precio_unitario, 2) }}</td>
                                <td class="text-end fw-semibold">₡{{ number_format($item->subtotal, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Cambiar estado --}}
        <div class="card lb-admin-card">
            <div class="card-header fw-bold"><i class="bi bi-arrow-repeat me-2"></i>Cambiar estado</div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.pedidos.estado', $pedido->id_pedido) }}">
                    @csrf @method('PATCH')
                    <div class="d-flex gap-3 align-items-end">
                        <div class="flex-grow-1">
                            <label for="id_estado_pedido" class="form-label fw-semibold small">Nuevo estado</label>
                            <select name="id_estado_ped" id="id_estado_ped" class="form-select" required>
                                @foreach($estados as $estado)
                                    <option value="{{ $estado->id_estado_ped }}"
                                        {{ $pedido->id_estado_ped == $estado->id_estado_ped ? 'selected' : '' }}>
                                        {{ $estado->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-lb-primary"
                                onclick="return confirm('¿Confirmar el cambio de estado?')">
                            <i class="bi bi-check-circle me-1"></i>Actualizar
                        </button>
                    </div>
                    <div class="form-text text-muted mt-1">
                        El cliente recibirá un correo de notificación con el nuevo estado.
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Info lateral --}}
    <div class="col-lg-4">

        {{-- Resumen --}}
        <div class="card lb-admin-card mb-3">
            <div class="card-header fw-bold"><i class="bi bi-receipt me-2"></i>Resumen</div>
            <div class="card-body">
                <div class="d-flex justify-content-between text-muted small mb-2">
                    <span>Subtotal</span><span>₡{{ number_format($pedido->subtotal, 2) }}</span>
                </div>
                @if($pedido->descuento > 0)
                <div class="d-flex justify-content-between text-success small mb-2">
                    <span>Descuento</span><span>-₡{{ number_format($pedido->descuento, 2) }}</span>
                </div>
                @endif
                @if($pedido->costo_envio > 0)
                <div class="d-flex justify-content-between text-muted small mb-2">
                    <span>Envío</span><span>₡{{ number_format($pedido->costo_envio, 2) }}</span>
                </div>
                @endif
                @if($pedido->impuesto > 0)
                <div class="d-flex justify-content-between text-muted small mb-2">
                    <span>Impuesto</span><span>₡{{ number_format($pedido->impuesto, 2) }}</span>
                </div>
                @endif
                <hr>
                <div class="d-flex justify-content-between fw-bold">
                    <span style="color:#1b4332;">Total</span>
                    <span style="color:#2d6a4f;">₡{{ number_format($pedido->total, 2) }}</span>
                </div>
            </div>
        </div>

        {{-- Cliente --}}
        <div class="card lb-admin-card mb-3">
            <div class="card-header fw-bold"><i class="bi bi-person me-2"></i>Cliente</div>
            <div class="card-body small">
                <p class="fw-semibold mb-0">{{ $pedido->user->nombre ?? '—' }}</p>
                <p class="text-muted mb-1">{{ $pedido->user->email ?? '' }}</p>
                @if($pedido->user->telefono ?? null)
                    <p class="text-muted mb-0"><i class="bi bi-telephone me-1"></i>{{ $pedido->user->telefono }}</p>
                @endif
            </div>
        </div>

        {{-- Dirección --}}
        @if($pedido->direccion)
        <div class="card lb-admin-card">
            <div class="card-header fw-bold"><i class="bi bi-geo-alt me-2"></i>Dirección</div>
            <div class="card-body small">
                <p class="fw-semibold mb-1">{{ $pedido->direccion->detalle }}</p>
                <p class="text-muted mb-0">
                    {{ $pedido->direccion->distrito->nombre ?? '' }},
                    {{ $pedido->direccion->distrito->canton->nombre ?? '' }},
                    {{ $pedido->direccion->distrito->canton->provincia->nombre ?? '' }}
                </p>
            </div>
        </div>
        @endif

    </div>
</div>

@endsection
