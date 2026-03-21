@extends('layouts.admin')

@section('titulo', 'Gestión de Roles')

@section('contenido')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 fw-bold mb-0">Roles</h2>
    <a href="{{ route('admin.roles.create') }}" class="btn btn-lb-primary">
        <i class="bi bi-plus-circle me-2"></i>Nuevo rol
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
                        <th class="text-center">Usuarios</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roles as $rol)
                    <tr>
                        <td class="fw-semibold">{{ $rol->nombre }}</td>
                        <td class="text-muted small">{{ $rol->descripcion ?? '—' }}</td>
                        <td class="text-center">
                            <span class="badge bg-light text-dark border">{{ $rol->users_count }}</span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.roles.edit', $rol->id_roles) }}"
                               class="btn btn-sm btn-outline-secondary" title="Editar">
                                <i class="bi bi-pencil"></i>
                            </a>
                            @if($rol->users_count === 0)
                            <form method="POST"
                                  action="{{ route('admin.roles.destroy', $rol->id_roles) }}"
                                  class="d-inline"
                                  onsubmit="return confirm('¿Eliminar este rol?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                            @else
                            <button class="btn btn-sm btn-outline-danger disabled" title="Tiene usuarios asignados">
                                <i class="bi bi-trash"></i>
                            </button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">Sin roles registrados</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
