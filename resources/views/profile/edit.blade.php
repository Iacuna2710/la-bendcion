@extends('layouts.app')

@section('titulo', 'Mi Perfil')

@section('encabezado')
    <h1 class="h3 fw-bold mb-1">
        <i class="bi bi-person-circle me-2"></i>Mi Perfil
    </h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 small">
            <li class="breadcrumb-item">
                <a href="{{ route('inicio') }}" class="text-white-50 text-decoration-none">Inicio</a>
            </li>
            <li class="breadcrumb-item active text-white" aria-current="page">Perfil</li>
        </ol>
    </nav>
@endsection

@section('contenido')
<div class="container py-4">
    <div class="row g-4 justify-content-center">
        
        <div class="col-lg-8">
            
            @include('partials.alertas')

            {{-- 1. Información del Perfil --}}
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="fw-bold mb-0" style="color: #1b4332;">Información del Perfil</h5>
                    <p class="text-muted small mb-0 mt-1">Actualiza la información del perfil y la dirección de correo electrónico de tu cuenta.</p>
                </div>
                <div class="card-body p-4">
                    <form method="post" action="{{ route('profile.update') }}">
                        @csrf
                        @method('patch')

                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">Nombre</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label fw-semibold">Correo electrónico</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex align-items-center gap-3">
                            <button type="submit" class="btn btn-lb-primary">Guardar Cambios</button>
                            @if (session('status') === 'profile-updated')
                                <span class="text-success small fw-semibold"><i class="bi bi-check-circle me-1"></i>Guardado</span>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            {{-- 2. Actualizar Contraseña --}}
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="fw-bold mb-0" style="color: #1b4332;">Actualizar Contraseña</h5>
                    <p class="text-muted small mb-0 mt-1">Asegúrate de que tu cuenta esté utilizando una contraseña larga y aleatoria para mantener la seguridad.</p>
                </div>
                <div class="card-body p-4">
                    <form method="post" action="{{ route('password.update') }}">
                        @csrf
                        @method('put')

                        <div class="mb-3">
                            <label for="current_password" class="form-label fw-semibold">Contraseña actual</label>
                            <input type="password" class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" id="current_password" name="current_password" required>
                            @error('current_password', 'updatePassword')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">Nueva contraseña</label>
                            <input type="password" class="form-control @error('password', 'updatePassword') is-invalid @enderror" id="password" name="password" required>
                            @error('password', 'updatePassword')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label fw-semibold">Confirmar nueva contraseña</label>
                            <input type="password" class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror" id="password_confirmation" name="password_confirmation" required>
                            @error('password_confirmation', 'updatePassword')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex align-items-center gap-3">
                            <button type="submit" class="btn btn-lb-primary">Actualizar Contraseña</button>
                            @if (session('status') === 'password-updated')
                                <span class="text-success small fw-semibold"><i class="bi bi-check-circle me-1"></i>Actualizada</span>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            {{-- 3. Eliminar Cuenta --}}
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="fw-bold text-danger mb-0">Eliminar Cuenta</h5>
                    <p class="text-muted small mb-0 mt-1">Una vez que tu cuenta sea eliminada, todos sus recursos y datos se eliminarán permanentemente.</p>
                </div>
                <div class="card-body p-4">
                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-toggle="modal" data-bs-target="#confirmUserDeletionModal">
                        Eliminar Cuenta
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- Modal Eliminar Cuenta --}}
<div class="modal fade" id="confirmUserDeletionModal" tabindex="-1" aria-labelledby="confirmUserDeletionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')
                
                <div class="modal-header bg-danger text-white border-0">
                    <h5 class="modal-title" id="confirmUserDeletionModalLabel">¿Estás seguro?</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body p-4">
                    <p>Una vez que tu cuenta sea eliminada, todos sus recursos y datos se eliminarán permanentemente. Por favor, introduce tu contraseña para confirmar que deseas eliminar permanentemente tu cuenta.</p>
                    
                    <div class="mb-3">
                        <label for="delete_password" class="form-label fw-semibold">Contraseña</label>
                        <input type="password" class="form-control @error('password', 'userDeletion') is-invalid @enderror" id="delete_password" name="password" required placeholder="Tu contraseña actual">
                        @error('password', 'userDeletion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Eliminar cuenta permanentemente</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    .btn-lb-primary { background-color: #2d6a4f; border-color: #2d6a4f; color: white; }
    .btn-lb-primary:hover { background-color: #1b4332; border-color: #1b4332; color: white; }
</style>
@endpush

@if($errors->userDeletion->isNotEmpty())
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var myModal = new bootstrap.Modal(document.getElementById('confirmUserDeletionModal'));
            myModal.show();
        });
    </script>
    @endpush
@endif
