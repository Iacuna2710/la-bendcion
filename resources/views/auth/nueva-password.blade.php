@extends('layouts.app')

@section('titulo', 'Establecer nueva contraseña')

@section('contenido')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-7 col-lg-5 col-xl-4">

            <div class="card border-0 shadow-lg rounded-4">

                {{-- Encabezado --}}
                <div class="card-header rounded-top-4 text-center py-4 text-white"
                     style="background: linear-gradient(135deg, #1b4332 0%, #2d6a4f 100%);">
                    <div class="mb-2" style="font-size: 2.5rem;">🔑</div>
                    <h1 class="h4 fw-bold mb-1">Nueva contraseña</h1>
                    <p class="small mb-0 opacity-75">Establece una contraseña segura para tu cuenta</p>
                </div>

                <div class="card-body p-4">

                    {{-- Aviso de contraseña temporal activa --}}
                    @if(auth()->user()->password_es_temporal)
                        <div class="alert alert-warning border-0 d-flex align-items-start gap-2 mb-4">
                            <i class="bi bi-exclamation-triangle-fill flex-shrink-0 mt-1"></i>
                            <div class="small">
                                Estás usando una <strong>contraseña temporal</strong>.
                                Debes establecer una nueva contraseña para continuar.
                            </div>
                        </div>
                    @endif

                    {{-- Alertas flash --}}
                    @include('partials.alertas')

                    {{-- Formulario --}}
                    <form method="POST" action="{{ route('password.nueva.actualizar') }}" novalidate>
                        @csrf

                        {{-- Nueva contraseña --}}
                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold small text-muted text-uppercase" style="letter-spacing: 0.5px;">
                                Nueva contraseña <span class="text-danger">*</span>
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
                                    autofocus
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

                        {{-- Confirmar nueva contraseña --}}
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
                                    placeholder="Repite tu nueva contraseña"
                                    required
                                    autocomplete="new-password">
                                @error('password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            {{-- Indicador de coincidencia en tiempo real --}}
                            <div id="matchIndicator" class="mt-1 small d-none"></div>
                        </div>

                        {{-- Requisitos de contraseña --}}
                        <div class="mb-4 bg-light rounded-3 p-3">
                            <p class="small fw-semibold mb-2 text-muted">La contraseña debe tener:</p>
                            <ul class="list-unstyled mb-0 small text-muted">
                                <li id="req-len"><i class="bi bi-circle me-2"></i>Mínimo 8 caracteres</li>
                                <li id="req-upper"><i class="bi bi-circle me-2"></i>Al menos una mayúscula</li>
                                <li id="req-num"><i class="bi bi-circle me-2"></i>Al menos un número</li>
                                <li id="req-special"><i class="bi bi-circle me-2"></i>Al menos un símbolo</li>
                            </ul>
                        </div>

                        {{-- Botón guardar --}}
                        <div class="d-grid">
                            <button type="submit" class="btn btn-lb-primary btn-lg fw-semibold">
                                <i class="bi bi-check-circle me-2"></i>Guardar nueva contraseña
                            </button>
                        </div>

                    </form>
                </div>
            </div>

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

    // ── Indicador de fortaleza + requisitos ────────────────────────────────
    const pwInput = document.getElementById('password');
    pwInput.addEventListener('input', function () {
        const val = this.value;
        const bar = document.getElementById('strengthBar');
        const lbl = document.getElementById('strengthLabel');

        // Requisitos
        const checks = {
            'req-len':     val.length >= 8,
            'req-upper':   /[A-Z]/.test(val),
            'req-num':     /[0-9]/.test(val),
            'req-special': /[^A-Za-z0-9]/.test(val),
        };
        let score = Object.values(checks).filter(Boolean).length;

        Object.entries(checks).forEach(([id, ok]) => {
            const el = document.getElementById(id);
            el.innerHTML = (ok ? '<i class="bi bi-check-circle-fill text-success me-2"></i>' : '<i class="bi bi-circle me-2"></i>') + el.textContent.trim();
        });

        const levels = [
            { pct: '0%', cls: '', txt: '' },
            { pct: '25%', cls: 'bg-danger', txt: 'Muy débil' },
            { pct: '50%', cls: 'bg-warning', txt: 'Débil' },
            { pct: '75%', cls: 'bg-info', txt: 'Aceptable' },
            { pct: '100%', cls: 'bg-success', txt: 'Segura ✓' },
        ];
        const lvl = val.length === 0 ? levels[0] : levels[score];
        bar.style.width = lvl.pct;
        bar.className = 'progress-bar ' + lvl.cls;
        lbl.textContent = lvl.txt;
        checkMatch();
    });

    // ── Indicador de coincidencia ──────────────────────────────────────────
    function checkMatch() {
        const pw    = document.getElementById('password').value;
        const conf  = document.getElementById('password_confirmation').value;
        const ind   = document.getElementById('matchIndicator');
        if (conf.length === 0) { ind.classList.add('d-none'); return; }
        ind.classList.remove('d-none');
        if (pw === conf) {
            ind.innerHTML = '<i class="bi bi-check-circle-fill text-success me-1"></i><span class="text-success">Las contraseñas coinciden</span>';
        } else {
            ind.innerHTML = '<i class="bi bi-x-circle-fill text-danger me-1"></i><span class="text-danger">Las contraseñas no coinciden</span>';
        }
    }
    document.getElementById('password_confirmation').addEventListener('input', checkMatch);
</script>
@endpush
