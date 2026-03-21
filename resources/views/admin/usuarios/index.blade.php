@extends('layouts.admin')

@section('titulo', 'Gestión de Usuarios')

@section('contenido')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 fw-bold mb-0">Usuarios</h2>
    <a href="{{ route('admin.usuarios.create') }}" class="btn btn-lb-primary">
        <i class="bi bi-person-plus me-2"></i>Nuevo usuario
    </a>
</div>

@include('partials.alertas')

<div class="card lb-admin-card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table lb-admin-table mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th class="text-center">Estado</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($usuarios as $usuario)
                    <tr>
                        <td class="fw-semibold">{{ $usuario->nombre }}</td>
                        <td class="text-muted small">{{ $usuario->email }}</td>
                        <td>
                            @foreach($usuario->roles as $rol)
                                <span class="badge bg-light text-dark border">{{ $rol->nombre }}</span>
                            @endforeach
                        </td>
                        <td class="text-center">
                            <form method="POST"
                                  action="{{ route('admin.usuarios.estado', $usuario->id_user) }}"
                                  class="d-inline">
                                @csrf @method('PATCH')
                                <button type="submit"
                                        class="btn btn-sm {{ $usuario->is_active ? 'btn-success' : 'btn-outline-secondary' }}"
                                        title="{{ $usuario->is_active ? 'Desactivar' : 'Activar' }}">
                                    <i class="bi bi-{{ $usuario->is_active ? 'toggle-on' : 'toggle-off' }}"></i>
                                </button>
                            </form>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.usuarios.edit', $usuario->id_user) }}"
                               class="btn btn-sm btn-outline-secondary" title="Editar">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST"
                                  action="{{ route('admin.usuarios.destroy', $usuario->id_user) }}"
                                  class="d-inline"
                                  onsubmit="return confirm('¿Eliminar este usuario?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">Sin usuarios registrados</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($usuarios->hasPages())
        <div class="card-footer bg-white border-top">
            {{ $usuarios->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>

@endsection
