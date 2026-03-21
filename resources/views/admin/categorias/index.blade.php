@extends('layouts.admin')

@section('titulo', 'Gestión de Categorías')

@section('contenido')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 fw-bold mb-0">Categorías</h2>
    <a href="{{ route('admin.categorias.create') }}" class="btn btn-lb-primary">
        <i class="bi bi-plus-circle me-2"></i>Nueva categoría
    </a>
</div>

@include('partials.alertas')

<div class="card lb-admin-card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table lb-admin-table mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Slug</th>
                        <th class="text-center">Productos</th>
                        <th class="text-center">Estado</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categorias as $categoria)
                    <tr>
                        <td class="text-muted small">{{ $loop->iteration }}</td>
                        <td class="fw-semibold">{{ $categoria->nombre }}</td>
                        <td class="text-muted small font-monospace">{{ $categoria->slug }}</td>
                        <td class="text-center">
                            <span class="badge bg-light text-dark border">{{ $categoria->productos_count }}</span>
                        </td>
                        <td class="text-center">
                            @if($categoria->is_active)
                                <span class="badge bg-success-subtle text-success border border-success-subtle">Activa</span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary border">Inactiva</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.categorias.edit', $categoria->id_categoria) }}"
                               class="btn btn-sm btn-outline-secondary" title="Editar">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST"
                                  action="{{ route('admin.categorias.destroy', $categoria->id_categoria) }}"
                                  class="d-inline"
                                  onsubmit="return confirm('¿Desactivar esta categoría?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Desactivar">
                                    <i class="bi bi-toggle-off"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Sin categorías registradas</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
