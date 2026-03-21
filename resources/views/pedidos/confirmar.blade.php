@extends('layouts.app')

@section('titulo', 'Confirmar Pedido')

@section('encabezado')
    <h1 class="h3 fw-bold mb-1"><i class="bi bi-bag-check me-2"></i>Confirmar Pedido</h1>
    <p class="mb-0 opacity-75 small">Revisa tu pedido antes de confirmarlo</p>
@endsection

@section('contenido')
<div class="container py-4">

    @include('partials.alertas')

    <form method="POST" action="{{ route('pedidos.procesar') }}">
        @csrf
        <div class="row g-4">

            {{-- ── RESUMEN DE ÍTEMS ─────────────────────────────────────── --}}
            <div class="col-lg-7">

                {{-- Productos --}}
                <div class="card border-0 shadow-sm rounded-3 mb-4">
                    <div class="card-header bg-white border-bottom fw-bold" style="color: #1b4332;">
                        <i class="bi bi-bag me-2"></i>Productos en tu carrito
                    </div>
                    <div class="card-body p-0">
                        @foreach($carrito->items as $item)
                        <div class="d-flex align-items-center gap-3 p-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                            @if($item->producto->imagenes->isNotEmpty())
                                <img src="{{ asset('storage/' . $item->producto->imagenes->first()->url) }}"
                                     alt="{{ $item->producto->nombre }}"
                                     class="rounded-2" style="width:55px; height:55px; object-fit:cover;">
                            @else
                                <div class="rounded-2 d-flex align-items-center justify-content-center"
                                     style="width:55px; height:55px; background: linear-gradient(135deg,#d8f3dc,#b7e4c7); font-size:1.4rem;">🌿</div>
                            @endif
                            <div class="flex-grow-1">
                                <p class="fw-semibold mb-0 small">{{ $item->producto->nombre }}</p>
                                <small class="text-muted">{{ $item->cantidad }} × ₡{{ number_format($item->precio_unitario, 2) }}</small>
                            </div>
                            <span class="fw-bold" style="color:#2d6a4f;">
                                ₡{{ number_format($item->subtotal, 2) }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Dirección de entrega --}}
                <div class="card border-0 shadow-sm rounded-3 mb-4">
                    <div class="card-header bg-white border-bottom fw-bold" style="color: #1b4332;">
                        <i class="bi bi-geo-alt me-2"></i>Dirección de entrega
                        <a href="{{ route('direcciones.index') }}" class="float-end small text-success text-decoration-none fw-normal">
                            + Gestionar direcciones
                        </a>
                    </div>
                    <div class="card-body">
                        @if($direcciones->isEmpty())
                            <div class="alert alert-warning mb-3">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                No tienes direcciones registradas.
                                <a href="{{ route('direcciones.create') }}" class="alert-link">Agrega una aquí</a>.
                            </div>
                        @else
                            @foreach($direcciones as $dir)
                                <div class="form-check lb-dir-option mb-2 p-3 rounded-3 border
                                            {{ $dir->es_principal ? 'lb-dir-active' : '' }}">
                                    <input class="form-check-input" type="radio"
                                           name="id_direccion"
                                           id="dir-{{ $dir->id_direccion }}"
                                           value="{{ $dir->id_direccion }}"
                                           {{ $dir->es_principal ? 'checked' : '' }}
                                           required>
                                    <label class="form-check-label w-100" for="dir-{{ $dir->id_direccion }}">
                                        <span class="fw-semibold small">{{ $dir->detalle }}</span>
                                        <br>
                                        <span class="text-muted small">
                                            {{ $dir->distrito->nombre ?? '' }},
                                            {{ $dir->distrito->canton->nombre ?? '' }},
                                            {{ $dir->distrito->canton->provincia->nombre ?? '' }}
                                        </span>
                                        @if($dir->es_principal)
                                            <span class="badge bg-success-subtle text-success ms-2" style="font-size:0.65rem;">Principal</span>
                                        @endif
                                    </label>
                                </div>
                            @endforeach
                        @endif
                        @error('id_direccion')
                            <div class="text-danger small mt-1"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Método de pago --}}
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-header bg-white border-bottom fw-bold" style="color: #1b4332;">
                        <i class="bi bi-credit-card me-2"></i>Método de pago
                    </div>
                    <div class="card-body">
                        @foreach($metodosPago as $metodo)
                            <div class="form-check lb-dir-option mb-2 p-3 rounded-3 border
                                        {{ $loop->first ? 'lb-dir-active' : '' }}">
                                <input class="form-check-input" type="radio"
                                       name="id_met_pago"
                                       id="pago-{{ $metodo->id_met_pago }}"
                                       value="{{ $metodo->id_met_pago }}"
                                       {{ $loop->first ? 'checked' : '' }}
                                       required>
                                <label class="form-check-label w-100" for="pago-{{ $metodo->id_met_pago }}">
                                    <span class="fw-semibold small">{{ $metodo->nombre }}</span>
                                    @if($metodo->descripcion)
                                        <br><span class="text-muted small">{{ $metodo->descripcion }}</span>
                                    @endif
                                </label>
                            </div>
                        @endforeach
                        @error('id_met_pago')
                            <div class="text-danger small mt-1"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>
                </div>

            </div>

            {{-- ── RESUMEN TOTAL ────────────────────────────────────────── --}}
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm rounded-3 sticky-top" style="top: 80px;">
                    <div class="card-header bg-white border-bottom fw-bold" style="color: #1b4332;">
                        <i class="bi bi-receipt me-2"></i>Resumen del pedido
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between text-muted small mb-2">
                            <span>Subtotal</span>
                            <span>₡{{ number_format($carrito->subtotal ?? $carrito->items->sum('subtotal'), 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between text-muted small mb-2">
                            <span>Envío</span>
                            <span class="text-success">A definir</span>
                        </div>
                        @if($carrito->descuento > 0)
                        <div class="d-flex justify-content-between text-success small mb-2">
                            <span>Descuento</span>
                            <span>-₡{{ number_format($carrito->descuento, 2) }}</span>
                        </div>
                        @endif
                        <hr>
                        <div class="d-flex justify-content-between fw-bold">
                            <span style="color:#1b4332;">Total estimado</span>
                            <span style="color:#2d6a4f; font-size:1.2rem;">
                                ₡{{ number_format($carrito->total ?? $carrito->items->sum('subtotal'), 2) }}
                            </span>
                        </div>

                        {{-- Notas opcionales --}}
                        <div class="mt-3">
                            <label for="notas" class="form-label small text-muted fw-semibold">Notas para el pedido (opcional)</label>
                            <textarea name="notas" id="notas" class="form-control form-control-sm"
                                      rows="2" placeholder="Instrucciones especiales de entrega...">{{ old('notas') }}</textarea>
                        </div>

                        <div class="d-grid mt-3">
                            <button type="submit" class="btn btn-lb-primary btn-lg fw-semibold"
                                    onclick="return confirm('¿Confirmar y procesar el pedido?')">
                                <i class="bi bi-check-circle me-2"></i>Confirmar pedido
                            </button>
                        </div>
                        <div class="text-center mt-2">
                            <a href="{{ route('carrito.index') }}" class="text-muted small text-decoration-none">
                                <i class="bi bi-arrow-left me-1"></i>Volver al carrito
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>
@endsection

@push('styles')
<style>
    .lb-dir-option { cursor: pointer; border-color: #dee2e6 !important; transition: all 0.2s; }
    .lb-dir-option:hover { border-color: #74c69d !important; background-color: #f0faf4; }
    .lb-dir-active { border-color: #2d6a4f !important; background-color: #f0faf4; }
    .btn-lb-primary { background-color: #2d6a4f; border-color: #2d6a4f; color: white; }
    .btn-lb-primary:hover { background-color: #1b4332; border-color: #1b4332; color: white; }
</style>
@endpush

@push('scripts')
<script>
    // Resaltar la opción seleccionada en radio buttons de dirección y pago
    document.querySelectorAll('.lb-dir-option input[type="radio"]').forEach(function (radio) {
        radio.addEventListener('change', function () {
            // Quitar active del grupo hermano (misma card)
            const parent = this.closest('.card-body');
            parent.querySelectorAll('.lb-dir-option').forEach(el => el.classList.remove('lb-dir-active'));
            this.closest('.lb-dir-option').classList.add('lb-dir-active');
        });
    });
</script>
@endpush
