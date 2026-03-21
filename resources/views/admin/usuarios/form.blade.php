@extends('layouts.admin')

@php
    $esEdicion = isset($usuario) && $usuario !== null;
    $titulo    = $esEdicion ? 'Editar Usuario' : 'Nuevo Usuario';
@endphp

@section('titulo', $titulo)

@section('contenido')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 fw-bold mb-0">{{ $titulo }}</h2>
    <a href="{{ route('admin.usuarios.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Volver
    </a>
</div>

@include('partials.alertas')

<div class="card lb-admin-card" style="max-width:640px;">
    <div class="card-body p-4">
        <form method="POST"
              action="{{ $esEdicion
                  ? route('admin.usuarios.update', $usuario->id_user)
                  : route('admin.usuarios.store') }}"
              novalidate>
            @csrf
            @if($esEdicion) @method('PUT') @endif

            <div class="mb-3">
                <label for="nombre" class="form-label fw-semibold">Nombre <span class="text-danger">*</span></label>
                <input type="text" id="nombre" name="nombre"
                       class="form-control @error('nombre') is-invalid @enderror"
                       value="{{ old('nombre', $usuario->nombre ?? '') }}" required>
                @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label fw-semibold">Correo electrónico <span class="text-danger">*</span></label>
                <input type="email" id="email" name="email"
                       class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email', $usuario->email ?? '') }}" required>
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="telefono" class="form-label fw-semibold">Teléfono</label>
                <input type="text" id="telefono" name="telefono"
                       class="form-control @error('telefono') is-invalid @enderror"
                       value="{{ old('telefono', $usuario->telefono ?? '') }}">
                @error('telefono') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Contraseña --}}
            <div class="mb-3">
                <label for="password" class="form-label fw-semibold">
                    Contraseña {{ !$esEdicion ? '*' : '' }}
                    @if($esEdicion) <small class="text-muted fw-normal">(dejar vacío para no cambiar)</small> @endif
                </label>
                <div class="input-group">
                    <input type="password" id="password" name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           {{ !$esEdicion ? 'required' : '' }}>
                    <button type="button" class="btn btn-outline-secondary" id="togglePassword" tabindex="-1"
                            title="Mostrar/ocultar contraseña">
                        <i class="bi bi-eye" id="iconPassword"></i>
                    </button>
                </div>
                @error('password') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>

            {{-- Confirmación de contraseña --}}
            <div class="mb-3">
                <label for="password_confirmation" class="form-label fw-semibold">
                    Confirmar contraseña {{ !$esEdicion ? '*' : '' }}
                </label>
                <div class="input-group">
                    <input type="password" id="password_confirmation" name="password_confirmation"
                           class="form-control"
                           {{ !$esEdicion ? 'required' : '' }}>
                    <button type="button" class="btn btn-outline-secondary" id="toggleConfirm" tabindex="-1"
                            title="Mostrar/ocultar contraseña">
                        <i class="bi bi-eye" id="iconConfirm"></i>
                    </button>
                </div>
            </div>

            {{-- Rol --}}
            <div class="mb-3">
                <label for="id_roles" class="form-label fw-semibold">Rol <span class="text-danger">*</span></label>
                <select id="id_roles" name="id_roles"
                        class="form-select @error('id_roles') is-invalid @enderror" required>
                    <option value="">— Selecciona un rol —</option>
                    @foreach($roles as $rol)
                        <option value="{{ $rol->id_roles }}"
                            {{ old('id_roles', ($esEdicion ? $usuario->roles->first()?->id_roles : '')) == $rol->id_roles ? 'selected' : '' }}>
                            {{ $rol->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('id_roles') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Estado activo (disponible en creación y edición) --}}
            <div class="mb-4">
                <div class="form-check form-switch">
                    <input type="hidden" name="is_active" value="0">
                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                           value="1"
                           {{ old('is_active', $esEdicion ? ($usuario->is_active ?? true) : true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">Usuario activo</label>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-lb-primary">
                    <i class="bi bi-{{ $esEdicion ? 'floppy' : 'person-plus' }} me-2"></i>
                    {{ $esEdicion ? 'Guardar cambios' : 'Crear usuario' }}
                </button>
                <a href="{{ route('admin.usuarios.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Toggle visibilidad: Contraseña
    document.getElementById('togglePassword')?.addEventListener('click', function () {
        const input = document.getElementById('password');
        const icon  = document.getElementById('iconPassword');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    });

    // Toggle visibilidad: Confirmar contraseña
    document.getElementById('toggleConfirm')?.addEventListener('click', function () {
        const input = document.getElementById('password_confirmation');
        const icon  = document.getElementById('iconConfirm');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    });
</script>
@endpush
