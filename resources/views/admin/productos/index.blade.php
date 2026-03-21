@extends('layouts.admin')

@section('titulo', 'Gestión de Productos')

@section('contenido')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 fw-bold mb-0">Productos</h2>
    <a href="{{ route('admin.productos.create') }}" class="btn btn-lb-primary">
        <i class="bi bi-plus-circle me-2"></i>Nuevo producto
    </a>
</div>

@include('partials.alertas')

{{-- Búsqueda --}}
<form method="GET" action="{{ route('admin.productos.index') }}" class="mb-3 d-flex gap-2">
    <input type="text" name="buscar" class="form-control form-control-sm"
           placeholder="Buscar por nombre o SKU..." value="{{ request('buscar') }}" style="max-width:300px;">
    <button type="submit" class="btn btn-sm btn-lb-primary">Buscar</button>
    @if(request('buscar'))
        <a href="{{ route('admin.productos.index') }}" class="btn btn-sm btn-outline-secondary">Limpiar</a>
    @endif
</form>

<div class="card lb-admin-card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table lb-admin-table mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width:60px;">Foto</th>
                        <th>Nombre</th>
                        <th>SKU</th>
                        <th class="text-center">Stock</th>
                        <th class="text-end">Precio</th>
                        <th class="text-center">Destacado</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($productos as $producto)
                    <tr>
                        <td>
                            @if($producto->imagenPrincipal)
                                <img src="{{ asset('storage/' . $producto->imagenPrincipal->url) }}"
                                     alt="{{ $producto->nombre }}"
                                     class="rounded-2" style="width:48px;height:48px;object-fit:cover;">
                            @else
                                <div class="rounded-2 d-flex align-items-center justify-content-center"
                                     style="width:48px;height:48px;background:#d8f3dc;font-size:1.4rem;">🌿</div>
                            @endif
                        </td>
                        <td class="fw-semibold">{{ $producto->nombre }}</td>
                        <td class="text-muted small font-monospace">{{ $producto->sku ?? '—' }}</td>
                        <td class="text-center">
                            @if($producto->stock <= $producto->stock_minimo)
                                <span class="badge bg-danger">{{ $producto->stock }}</span>
                            @elseif($producto->stock <= ($producto->stock_minimo * 2))
                                <span class="badge bg-warning text-dark">{{ $producto->stock }}</span>
                            @else
                                <span class="badge bg-success">{{ $producto->stock }}</span>
                            @endif
                        </td>
                        <td class="text-end fw-semibold" style="color:#2d6a4f;">
                            ₡{{ number_format($producto->precio, 2) }}
                        </td>
                        <td class="text-center">
                            @if($producto->es_destacado)
                                <i class="bi bi-star-fill text-warning"></i>
                            @else
                                <i class="bi bi-star text-muted"></i>
                            @endif
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.productos.edit', $producto->id_producto) }}"
                               class="btn btn-sm btn-outline-secondary" title="Editar">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST"
                                  action="{{ route('admin.productos.destroy', $producto->id_producto) }}"
                                  class="d-inline"
                                  onsubmit="return confirm('¿Eliminar este producto?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">Sin productos registrados</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($productos->hasPages())
        <div class="card-footer bg-white border-top">
            {{ $productos->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>

@endsection
