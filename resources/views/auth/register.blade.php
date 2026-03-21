@extends('layouts.app')

@section('titulo', 'Crear cuenta')

@section('contenido')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">

            {{-- Tarjeta de registro --}}
            <div class="card border-0 shadow-lg rounded-4">

                {{-- Encabezado --}}
                <div class="card-header rounded-top-4 text-center py-4 text-white"
                     style="background: linear-gradient(135deg, #1b4332 0%, #40916c 100%);">
                    <div class="mb-2" style="font-size: 2.5rem;">🌱</div>
                    <h1 class="h4 fw-bold mb-1">Crear tu cuenta</h1>
                    <p class="small mb-0 opacity-75">Únete a la familia La Bendición</p>
                </div>

                <div class="card-body p-4">

                    {{-- Alertas --}}
                    @include('partials.alertas')

                    {{-- Formulario --}}
                    <form method="POST" action="{{ route('register') }}" novalidate>
                        @csrf

                        {{-- Nombre completo --}}
                        <div class="mb-3">
                            <label for="nombre" class="form-label fw-semibold small text-muted text-uppercase" style="letter-spacing: 0.5px;">
                                Nombre completo <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-person text-muted"></i>
                                </span>
                                <input
                                    type="text"
                                    id="nombre"
                                    name="nombre"
                                    class="form-control border-start-0 ps-0 @error('nombre') is-invalid @enderror"
                                    value="{{ old('nombre') }}"
                                    placeholder="Ej. María Rodríguez"
                                    required
                                    autocomplete="name"
                                    autofocus>
                                @error('nombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Correo electrónico --}}
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold small text-muted text-uppercase" style="letter-spacing: 0.5px;">
                                Correo electrónico <span class="text-danger">*</span>
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
                                    autocomplete="username">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Teléfono --}}
                        <div class="mb-3">
                            <label for="telefono" class="form-label fw-semibold small text-muted text-uppercase" style="letter-spacing: 0.5px;">
                                Teléfono
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-telephone text-muted"></i>
                                </span>
                                <input
                                    type="tel"
                                    id="telefono"
                                    name="telefono"
                                    class="form-control border-start-0 ps-0 @error('telefono') is-invalid @enderror"
                                    value="{{ old('telefono') }}"
                                    placeholder="8888-8888">
                                @error('telefono')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Contraseña --}}
                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold small text-muted text-uppercase" style="letter-spacing: 0.5px;">
                                Contraseña <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-lock text-muted"></i>
                                </span>
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    class="form-control border-start-0 ps-0 border-end-0 @error('password') is-invalid @enderror"
                                    placeholder="Mínimo 8 caracteres"
                                    required
                                    autocomplete="new-password">
                                <button type="button" class="input-group-text bg-light border-start-0"
                                        id="togglePassword" title="Mostrar contraseña">
                                    <i class="bi bi-eye text-muted" id="eyeIcon"></i>
                                </button>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            {{-- Indicador de fortaleza --}}
                            <div class="progress mt-2" style="height: 4px;">
                                <div class="progress-bar" id="strengthBar" role="progressbar" style="width: 0%;"></div>
                            </div>
                            <small class="text-muted" id="strengthLabel"></small>
                        </div>

                        {{-- Confirmación de contraseña --}}
                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label fw-semibold small text-muted text-uppercase" style="letter-spacing: 0.5px;">
                                Confirmar contraseña <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-lock-fill text-muted"></i>
                                </span>
                                <input
                                    type="password"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    class="form-control border-start-0 ps-0 @error('password_confirmation') is-invalid @enderror"
                                    placeholder="Repite tu contraseña"
                                    required
                                    autocomplete="new-password">
                                @error('password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Botón registrar --}}
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-lb-primary btn-lg fw-semibold">
                                <i class="bi bi-person-plus me-2"></i>Crear cuenta
                            </button>
                        </div>

                        {{-- Enlace a login --}}
                        <div class="text-center">
                            <span class="text-muted small">¿Ya tienes cuenta?</span>
                            <a href="{{ route('login') }}"
                               class="fw-semibold text-decoration-none ms-1"
                               style="color: #2d6a4f;">
                                Inicia sesión aquí
                            </a>
                        </div>

                    </form>
                </div>
            </div>

            <p class="text-center text-muted small mt-3">
                <i class="bi bi-shield-lock me-1"></i>
                Al crear tu cuenta aceptas nuestros términos de uso y política de privacidad
            </p>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // ── Mostrar/ocultar contraseña ──────────────────────────────────────────
    document.getElementById('togglePassword').addEventListener('click', function () {
        const input   = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');
        if (input.type === 'password') {
            input.type = 'text';
            eyeIcon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            input.type = 'password';
            eyeIcon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    });

    // ── Indicador de fortaleza de contraseña ───────────────────────────────
    document.getElementById('password').addEventListener('input', function () {
        const val    = this.value;
        const bar    = document.getElementById('strengthBar');
        const label  = document.getElementById('strengthLabel');
        let score    = 0;

        if (val.length >= 8)              score++;
        if (/[A-Z]/.test(val))           score++;
        if (/[0-9]/.test(val))           score++;
        if (/[^A-Za-z0-9]/.test(val))   score++;

        const levels = [
            { pct: '0%',   cls: '',          txt: '' },
            { pct: '25%',  cls: 'bg-danger', txt: 'Muy débil' },
            { pct: '50%',  cls: 'bg-warning',txt: 'Débil' },
            { pct: '75%',  cls: 'bg-info',   txt: 'Aceptable' },
            { pct: '100%', cls: 'bg-success',txt: 'Segura ✓' },
        ];

        const lvl = val.length === 0 ? levels[0] : levels[score];
        bar.style.width = lvl.pct;
        bar.className   = 'progress-bar ' + lvl.cls;
        label.textContent = lvl.txt;
        label.className   = 'small ' + (score === 4 ? 'text-success' : 'text-muted');
    });
</script>
@endpush
