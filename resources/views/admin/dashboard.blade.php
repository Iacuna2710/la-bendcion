@extends('layouts.admin')

@section('titulo', 'Dashboard')

@section('contenido')

{{-- ══ KPI CARDS ═══════════════════════════════════════════════════════════ --}}
<div class="row g-3 mb-4">

    {{-- Total Usuarios --}}
    <div class="col-6 col-lg-3">
        <div class="lb-kpi-card" style="background: linear-gradient(135deg,#2d6a4f,#40916c);">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="kpi-value">{{ $totalUsuarios }}</div>
                    <div class="kpi-label">Usuarios registrados</div>
                </div>
                <span class="kpi-icon"><i class="bi bi-people"></i></span>
            </div>
        </div>
    </div>

    {{-- Total Productos --}}
    <div class="col-6 col-lg-3">
        <div class="lb-kpi-card" style="background: linear-gradient(135deg,#1b4332,#2d6a4f);">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="kpi-value">{{ $totalProductos }}</div>
                    <div class="kpi-label">Productos activos</div>
                </div>
                <span class="kpi-icon"><i class="bi bi-box-seam"></i></span>
            </div>
        </div>
    </div>

    {{-- Pedidos hoy --}}
    <div class="col-6 col-lg-3">
        <div class="lb-kpi-card" style="background: linear-gradient(135deg,#40916c,#74c69d);">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="kpi-value">{{ $pedidosHoy }}</div>
                    <div class="kpi-label">Pedidos hoy</div>
                </div>
                <span class="kpi-icon"><i class="bi bi-bag-check"></i></span>
            </div>
        </div>
    </div>

    {{-- Ingresos del mes --}}
    <div class="col-6 col-lg-3">
        <div class="lb-kpi-card" style="background: linear-gradient(135deg,#0d6efd,#3d8ef0);">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="kpi-value" style="font-size:1.4rem;">₡{{ number_format($ingresosMes, 0) }}</div>
                    <div class="kpi-label">Ingresos este mes</div>
                </div>
                <span class="kpi-icon"><i class="bi bi-graph-up"></i></span>
            </div>
        </div>
    </div>
</div>

{{-- ══ ALERTAS DE STOCK BAJO ════════════════════════════════════════════════ --}}
@if($productosStockBajo->isNotEmpty())
<div class="card lb-admin-card mb-4 border-start border-4 border-danger">
    <div class="card-header d-flex align-items-center gap-2">
        <i class="bi bi-exclamation-triangle-fill text-danger"></i>
        <span class="text-danger fw-bold">Stock bajo — {{ $productosStockBajo->count() }} producto{{ $productosStockBajo->count() !== 1 ? 's' : '' }}</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table lb-admin-table mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Producto</th>
                        <th class="text-center">Stock actual</th>
                        <th class="text-center">Stock mínimo</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($productosStockBajo as $prod)
                    <tr>
                        <td class="fw-semibold">{{ $prod->nombre }}</td>
                        <td class="text-center">
                            <span class="badge bg-danger">{{ $prod->stock }}</span>
                        </td>
                        <td class="text-center text-muted">{{ $prod->stock_minimo }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.productos.edit', $prod->id_producto) }}"
                               class="btn btn-sm btn-outline-success">
                                <i class="bi bi-pencil me-1"></i>Editar
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif

{{-- ══ ÚLTIMOS PEDIDOS ═════════════════════════════════════════════════════ --}}
<div class="card lb-admin-card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-bag-check me-2"></i>Últimos pedidos</span>
        <a href="{{ route('admin.pedidos.index') }}" class="btn btn-sm btn-lb-primary">
            Ver todos
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table lb-admin-table mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Número</th>
                        <th>Cliente</th>
                        <th>Estado</th>
                        <th class="text-end">Total</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ultimosPedidos as $pedido)
                    <tr>
                        <td class="fw-semibold">{{ $pedido->num_pedido }}</td>
                        <td>{{ $pedido->user->nombre ?? '—' }}</td>
                        <td>
                            @php $color = $pedido->estadoPedido->color ?? '#6c757d'; @endphp
                            <span class="badge px-2 py-1"
                                  style="background-color:{{ $color }}25; color:{{ $color }}; border:1px solid {{ $color }}50;">
                                {{ $pedido->estadoPedido->nombre ?? '—' }}
                            </span>
                        </td>
                        <td class="text-end fw-semibold" style="color:#2d6a4f;">
                            ₡{{ number_format($pedido->total, 2) }}
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.pedidos.show', $pedido->id_pedido) }}"
                               class="btn btn-sm btn-outline-secondary">Ver</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-3">Sin pedidos recientes</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
