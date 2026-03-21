@extends('layouts.app')

@section('titulo', 'Factura ' . $factura->numero_factura)

@section('encabezado')
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h1 class="h3 fw-bold mb-1"><i class="bi bi-file-earmark-text me-2"></i>Factura</h1>
            <p class="mb-0 opacity-75 small">{{ $factura->numero_factura }}</p>
        </div>
        <button onclick="window.print()" class="btn btn-outline-light btn-sm">
            <i class="bi bi-printer me-2"></i>Imprimir
        </button>
    </div>
@endsection

@section('contenido')
<div class="container py-4">

    @include('partials.alertas')

    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card border-0 shadow-sm rounded-3 lb-factura-card" id="factura-imprimible">

                {{-- Encabezado de la factura --}}
                <div class="card-body p-4 p-md-5">
                    <div class="row align-items-start mb-4">
                        <div class="col-md-7">
                            <div class="d-flex align-items-center gap-3 mb-2">
                                <span style="font-size:2.5rem;">🌿</span>
                                <div>
                                    <h4 class="fw-bold mb-0" style="color:#1b4332;">La Bendición</h4>
                                    <p class="text-muted small mb-0">Macrobiótica Natural</p>
                                </div>
                            </div>
                            <p class="text-muted small mb-0">San José, Costa Rica</p>
                            <p class="text-muted small mb-0">info@labendicion.cr</p>
                        </div>
                        <div class="col-md-5 text-md-end mt-3 mt-md-0">
                            <h5 class="fw-bold mb-1" style="color:#1b4332;">FACTURA</h5>
                            <p class="fw-semibold mb-0">{{ $factura->numero_factura }}</p>
                            <p class="text-muted small mb-1">
                                Emitida: {{ \Carbon\Carbon::parse($factura->fecha_emision)->format('d/m/Y') }}
                            </p>
                            <span class="badge px-3 py-1"
                                  style="background-color:#d8f3dc; color:#1b4332; font-size:0.75rem;">
                                {{ ucfirst($factura->estado_factura) }}
                            </span>
                        </div>
                    </div>

                    <hr>

                    {{-- Datos del cliente --}}
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="fw-bold text-muted text-uppercase mb-2" style="font-size:0.72rem; letter-spacing:1px;">
                                Facturado a
                            </h6>
                            <p class="fw-semibold mb-0">{{ $factura->pedido->user->nombre ?? 'Cliente' }}</p>
                            <p class="text-muted small mb-0">{{ $factura->pedido->user->email ?? '' }}</p>
                            @if($factura->pedido->user->telefono ?? null)
                                <p class="text-muted small mb-0">Tel: {{ $factura->pedido->user->telefono }}</p>
                            @endif
                        </div>
                        <div class="col-md-6 mt-3 mt-md-0">
                            <h6 class="fw-bold text-muted text-uppercase mb-2" style="font-size:0.72rem; letter-spacing:1px;">
                                Pedido asociado
                            </h6>
                            <p class="fw-semibold mb-0">{{ $factura->pedido->num_pedido }}</p>
                            <p class="text-muted small mb-0">
                                Fecha: {{ $factura->pedido->created_at->format('d/m/Y') }}
                            </p>
                        </div>
                    </div>

                    {{-- Tabla de ítems --}}
                    <div class="table-responsive mb-4">
                        <table class="table lb-factura-tabla">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th class="text-center">Cant.</th>
                                    <th class="text-end">P. Unit.</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($factura->items as $item)
                                <tr>
                                    <td>{{ $item->producto->nombre ?? 'Producto' }}</td>
                                    <td class="text-center">{{ $item->cantidad }}</td>
                                    <td class="text-end">₡{{ number_format($item->precio_unitario, 2) }}</td>
                                    <td class="text-end fw-semibold">₡{{ number_format($item->subtotal, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Totales --}}
                    <div class="row justify-content-end">
                        <div class="col-md-5">
                            <div class="lb-totales p-3 rounded-3" style="background-color:#f0faf4;">
                                <div class="d-flex justify-content-between text-muted small mb-2">
                                    <span>Subtotal</span>
                                    <span>₡{{ number_format($factura->subtotal, 2) }}</span>
                                </div>
                                @if($factura->impuesto > 0)
                                <div class="d-flex justify-content-between text-muted small mb-2">
                                    <span>Impuesto</span>
                                    <span>₡{{ number_format($factura->impuesto, 2) }}</span>
                                </div>
                                @endif
                                <hr class="my-2">
                                <div class="d-flex justify-content-between fw-bold">
                                    <span style="color:#1b4332;">Total</span>
                                    <span style="color:#2d6a4f; font-size:1.1rem;">
                                        ₡{{ number_format($factura->total, 2) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Observaciones --}}
                    @if($factura->observaciones)
                        <div class="mt-4 p-3 bg-light rounded-3">
                            <p class="small text-muted mb-0">
                                <i class="bi bi-info-circle me-1"></i>
                                {{ $factura->observaciones }}
                            </p>
                        </div>
                    @endif

                    {{-- Pie --}}
                    <div class="text-center mt-4 pt-4 border-top text-muted small">
                        <p class="mb-0">
                            🌿 Gracias por comprar en <strong>La Bendición</strong>.
                            Tu bienestar es nuestra misión.
                        </p>
                        <p class="mb-0">Este documento es válido como comprobante de compra.</p>
                    </div>

                </div>
            </div>

            {{-- Botones de acción --}}
            <div class="d-flex justify-content-center gap-3 mt-3 no-print">
                <a href="{{ route('pedidos.detalle', $factura->pedido->id_pedido) }}"
                   class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Volver al pedido
                </a>
                <button onclick="window.print()" class="btn btn-lb-primary">
                    <i class="bi bi-printer me-2"></i>Imprimir factura
                </button>
            </div>

        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .lb-factura-tabla th {
        font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.5px;
        color: #6c757d; font-weight: 600; border-top: none;
    }
    .lb-factura-tabla td { vertical-align: middle; font-size: 0.9rem; }
    .btn-lb-primary { background-color: #2d6a4f; border-color: #2d6a4f; color: white; }
    .btn-lb-primary:hover { background-color: #1b4332; border-color: #1b4332; color: white; }

    @media print {
        .no-print, .lb-navbar, .lb-footer, nav { display: none !important; }
        .lb-factura-card { box-shadow: none !important; border: 1px solid #dee2e6 !important; }
        body { background: white !important; }
        .lb-main-content { flex: none; }
    }
</style>
@endpush
