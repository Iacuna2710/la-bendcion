@extends('layouts.admin')

@section('titulo', 'Métodos de Pago')

@section('contenido')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 fw-bold mb-0">Métodos de Pago</h2>
    <a href="{{ route('admin.metodos-pago.create') }}" class="btn btn-lb-primary">
        <i class="bi bi-plus-circle me-2"></i>Nuevo método
    </a>
</div>

@include('partials.alertas')

<div class="card lb-admin-card" style="max-width:700px;">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table lb-admin-table mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th class="text-center">Estado</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($metodosPago as $metodo)
                    <tr>
                        <td class="fw-semibold">{{ $metodo->nombre }}</td>
                        <td class="text-muted small">{{ $metodo->descripcion ?? '—' }}</td>
                        <td class="text-center">
                            @if($metodo->is_active)
                                <span class="badge bg-success-subtle text-success border border-success-subtle">Activo</span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary border">Inactivo</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.metodos-pago.edit', $metodo->id_met_pago) }}"
                               class="btn btn-sm btn-outline-secondary" title="Editar">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST"
                                  action="{{ route('admin.metodos-pago.destroy', $metodo->id_met_pago) }}"
                                  class="d-inline"
                                  onsubmit="return confirm('¿Desactivar este método de pago?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Desactivar">
                                    <i class="bi bi-toggle-off"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">Sin métodos de pago registrados</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
