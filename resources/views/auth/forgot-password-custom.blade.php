@extends('layouts.app')

@section('titulo', 'Recuperar contraseña')

@section('contenido')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-7 col-lg-5 col-xl-4">

            <div class="card border-0 shadow-lg rounded-4">

                {{-- Encabezado --}}
                <div class="card-header rounded-top-4 text-center py-4 text-white"
                     style="background: linear-gradient(135deg, #1b4332 0%, #2d6a4f 100%);">
                    <div class="mb-2" style="font-size: 2.5rem;">🔐</div>
                    <h1 class="h4 fw-bold mb-1">Recuperar contraseña</h1>
                    <p class="small mb-0 opacity-75">Te enviaremos una contraseña temporal</p>
                </div>

                <div class="card-body p-4">

                    {{-- Cómo funciona --}}
                    <div class="alert alert-light border-start border-4 mb-4 py-2"
                         style="border-color: #74c69d !important;">
                        <p class="small mb-0 text-muted">
                            <i class="bi bi-info-circle text-success me-1"></i>
                            Ingresa tu correo registrado y recibirás una contraseña temporal.
                            Con ella podrás ingresar y luego establece una nueva contraseña.
                        </p>
                    </div>

                    {{-- Alertas flash --}}
                    @include('partials.alertas')

                    {{-- Formulario --}}
                    <form method="POST" action="{{ route('password.temporal.enviar') }}" novalidate>
                        @csrf

                        {{-- Correo electrónico --}}
                        <div class="mb-4">
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
                                    autofocus>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Botón enviar --}}
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-lb-primary btn-lg fw-semibold">
                                <i class="bi bi-send me-2"></i>Enviar contraseña temporal
                            </button>
                        </div>

                        {{-- Volver al login --}}
                        <div class="text-center">
                            <a href="{{ route('login') }}"
                               class="text-decoration-none small"
                               style="color: #2d6a4f;">
                                <i class="bi bi-arrow-left me-1"></i>Volver al inicio de sesión
                            </a>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
