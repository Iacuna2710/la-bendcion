@extends('layouts.app')

@section('titulo', 'Iniciar sesión')

@section('contenido')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-7 col-lg-5 col-xl-4">

            {{-- Tarjeta de login --}}
            <div class="card border-0 shadow-lg rounded-4">

                {{-- Encabezado de la tarjeta --}}
                <div class="card-header rounded-top-4 text-center py-4 text-white"
                     style="background: linear-gradient(135deg, #1b4332 0%, #2d6a4f 100%);">
                    <div class="mb-2" style="font-size: 2.5rem;">🌿</div>
                    <h1 class="h4 fw-bold mb-1">Bienvenido de vuelta</h1>
                    <p class="small mb-0 opacity-75">Inicia sesión en tu cuenta</p>
                </div>

                <div class="card-body p-4">

                    {{-- Alertas y errores de validación --}}
                    @include('partials.alertas')

                    {{-- Formulario de login --}}
                    <form method="POST" action="{{ route('login') }}" novalidate>
                        @csrf

                        {{-- Correo electrónico --}}
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold small text-muted text-uppercase" style="letter-spacing: 0.5px;">
                                Correo electrónico
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-envelope text-muted"></i>
                                </span>
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}"
                                    placeholder="tucorreo@ejemplo.com"
                                    required
                                    autocomplete="username"
                                    autofocus>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Contraseña --}}
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label for="password" class="form-label fw-semibold small text-muted text-uppercase mb-0" style="letter-spacing: 0.5px;">
                                    Contraseña
                                </label>
                                <a href="{{ route('password.temporal.form') }}"
                                   class="text-decoration-none small"
                                   style="color: #2d6a4f;">
                                    ¿Olvidaste tu contraseña?
                                </a>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-lock text-muted"></i>
                                </span>
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    class="form-control border-start-0 ps-0 border-end-0 @error('password') is-invalid @enderror"
                                    placeholder="Tu contraseña"
                                    required
                                    autocomplete="current-password">
                                <button type="button" class="input-group-text bg-light border-start-0"
                                        id="togglePassword" title="Mostrar/ocultar contraseña">
                                    <i class="bi bi-eye text-muted" id="eyeIcon"></i>
                                </button>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Recordarme --}}
                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox"
                                       id="remember_me" name="remember">
                                <label class="form-check-label small text-muted" for="remember_me">
                                    Mantener sesión iniciada
                                </label>
                            </div>
                        </div>

                        {{-- Botón de submit --}}
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-lb-primary btn-lg fw-semibold">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Ingresar
                            </button>
                        </div>

                        {{-- Separador --}}
                        <div class="text-center">
                            <span class="text-muted small">¿No tienes cuenta?</span>
                            <a href="{{ route('register') }}"
                               class="fw-semibold text-decoration-none ms-1"
                               style="color: #2d6a4f;">
                                Regístrate gratis
                            </a>
                        </div>

                    </form>
                </div>
            </div>

            {{-- Texto de seguridad al pie --}}
            <p class="text-center text-muted small mt-3">
                <i class="bi bi-shield-lock me-1"></i>
                Tu información está protegida con cifrado SSL
            </p>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Mostrar/ocultar contraseña
    document.getElementById('togglePassword').addEventListener('click', function () {
        const input  = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');
        if (input.type === 'password') {
            input.type = 'text';
            eyeIcon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            input.type = 'password';
            eyeIcon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    });
</script>
@endpush
