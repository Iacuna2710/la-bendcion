@extends('layouts.admin')

@section('titulo', 'Gestión de Pedidos')

@section('contenido')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 fw-bold mb-0">Pedidos</h2>
    {{-- Filtros --}}
    <form method="GET" action="{{ route('admin.pedidos.index') }}" class="d-flex gap-2">
        <input type="text" name="buscar" class="form-control form-control-sm"
               placeholder="Número o cliente..." value="{{ request('buscar') }}" style="width:200px;">
        <select name="estado" class="form-select form-select-sm" style="width:160px;">
            <option value="">Todos los estados</option>
            @foreach($estados as $estado)
                <option value="{{ $estado->id_estado_pedido }}"
                    {{ request('estado') == $estado->id_estado_pedido ? 'selected' : '' }}>
                    {{ $estado->nombre }}
                </option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-sm btn-lb-primary">Filtrar</button>
        @if(request('buscar') || request('estado'))
            <a href="{{ route('admin.pedidos.index') }}" class="btn btn-sm btn-outline-secondary">Limpiar</a>
        @endif
    </form>
</div>

@include('partials.alertas')

<div class="card lb-admin-card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table lb-admin-table mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Número</th>
                        <th>Cliente</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th class="text-end">Total</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pedidos as $pedido)
                    <tr>
                        <td class="fw-semibold font-monospace">{{ $pedido->num_pedido }}</td>
                        <td>{{ $pedido->user->nombre ?? '—' }}</td>
                        <td class="text-muted small">{{ $pedido->created_at->format('d/m/Y H:i') }}</td>
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
                               class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Sin pedidos encontrados</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($pedidos->hasPages())
        <div class="card-footer bg-white border-top">
            {{ $pedidos->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>

@endsection
