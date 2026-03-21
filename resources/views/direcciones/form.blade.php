@extends('layouts.app')

@php
    // $direccion viene del controlador: null si es crear, objeto si es editar
    $esEdicion = isset($direccion) && $direccion !== null;
    $titulo    = $esEdicion ? 'Editar Dirección' : 'Nueva Dirección';

    // IDs pre-seleccionados para el modo edición (derivados de la relación cargada)
    $prvSel  = old('id_provincia', $esEdicion ? ($direccion->distrito->canton->id_provincia ?? '') : '');
    $canSel  = old('id_canton',    $esEdicion ? ($direccion->distrito->id_canton ?? '') : '');
    $disSel  = old('id_distrito',  $esEdicion ? ($direccion->id_distrito ?? '') : '');
@endphp

@section('titulo', $titulo)

@section('encabezado')
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2 small">
                <li class="breadcrumb-item"><a href="{{ route('inicio') }}" class="text-white-50 text-decoration-none">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('direcciones.index') }}" class="text-white-50 text-decoration-none">Mis Direcciones</a></li>
                <li class="breadcrumb-item active text-white">{{ $titulo }}</li>
            </ol>
        </nav>
        <h1 class="h3 fw-bold mb-0">
            <i class="bi bi-{{ $esEdicion ? 'pencil' : 'plus-circle' }} me-2"></i>{{ $titulo }}
        </h1>
    </div>
@endsection

@section('contenido')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-7 col-md-9">

            @include('partials.alertas')

            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-4">

                    <form method="POST"
                          action="{{ $esEdicion
                              ? route('direcciones.update', $direccion->id_direccion)
                              : route('direcciones.store') }}"
                          novalidate>
                        @csrf
                        @if($esEdicion) @method('PATCH') @endif

                        {{-- ── SELECTOR EN CASCADA: PROVINCIA ────────────── --}}
                        <div class="mb-3">
                            <label for="id_provincia" class="form-label fw-semibold small text-muted text-uppercase"
                                   style="letter-spacing:0.5px;">
                                Provincia <span class="text-danger">*</span>
                            </label>
                            <select id="id_provincia" name="id_provincia"
                                    class="form-select @error('id_provincia') is-invalid @enderror"
                                    required>
                                <option value="">— Selecciona una provincia —</option>
                                @foreach($provincias as $provincia)
                                    <option value="{{ $provincia->id_provincia }}"
                                        {{ ($prvSel == $provincia->id_provincia) ? 'selected' : '' }}>
                                        {{ $provincia->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_provincia')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- ── SELECTOR EN CASCADA: CANTÓN ──────────────── --}}
                        <div class="mb-3">
                            <label for="id_canton" class="form-label fw-semibold small text-muted text-uppercase"
                                   style="letter-spacing:0.5px;">
                                Cantón <span class="text-danger">*</span>
                            </label>
                            <select id="id_canton" name="id_canton"
                                    class="form-select @error('id_canton') is-invalid @enderror"
                                    required disabled>
                                <option value="">— Selecciona un cantón —</option>
                                {{-- Se llena por JS cuando se elige la provincia --}}
                            </select>
                            @error('id_canton')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- ── SELECTOR EN CASCADA: DISTRITO ────────────── --}}
                        <div class="mb-3">
                            <label for="id_distrito" class="form-label fw-semibold small text-muted text-uppercase"
                                   style="letter-spacing:0.5px;">
                                Distrito <span class="text-danger">*</span>
                            </label>
                            <select id="id_distrito" name="id_distrito"
                                    class="form-select @error('id_distrito') is-invalid @enderror"
                                    required disabled>
                                <option value="">— Selecciona un distrito —</option>
                                {{-- Se llena por JS cuando se elige el cantón --}}
                            </select>
                            @error('id_distrito')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- ── DETALLE / SEÑAS ────────────────────────────── --}}
                        <div class="mb-3">
                            <label for="detalle" class="form-label fw-semibold small text-muted text-uppercase"
                                   style="letter-spacing:0.5px;">
                                Señas de la dirección <span class="text-danger">*</span>
                            </label>
                            <textarea id="detalle" name="detalle" rows="3"
                                      class="form-control @error('detalle') is-invalid @enderror"
                                      placeholder="Ej. De la iglesia 200m norte, casa azul con portón negro."
                                      required>{{ old('detalle', $direccion->detalle ?? '') }}</textarea>
                            @error('detalle')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- ── DIRECCIÓN PRINCIPAL ────────────────────────── --}}
                        <div class="mb-4">
                            <div class="form-check">
                                <input type="checkbox" id="es_principal" name="es_principal"
                                       class="form-check-input"
                                       value="1"
                                       {{ old('es_principal', ($esEdicion && $direccion->es_principal) ? '1' : '') ? 'checked' : '' }}>
                                <label class="form-check-label" for="es_principal">
                                    Establecer como dirección principal
                                </label>
                            </div>
                        </div>

                        {{-- ── BOTONES ────────────────────────────────────── --}}
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-lb-primary btn-lg flex-grow-1 fw-semibold">
                                <i class="bi bi-{{ $esEdicion ? 'floppy' : 'plus-circle' }} me-2"></i>
                                {{ $esEdicion ? 'Guardar cambios' : 'Agregar dirección' }}
                            </button>
                            <a href="{{ route('direcciones.index') }}" class="btn btn-outline-secondary btn-lg">
                                Cancelar
                            </a>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .btn-lb-primary { background-color: #2d6a4f; border-color: #2d6a4f; color: white; }
    .btn-lb-primary:hover { background-color: #1b4332; border-color: #1b4332; color: white; }
    select:disabled { background-color: #f8f9fa; cursor: not-allowed; }
</style>
@endpush

@push('scripts')
<script>
    // ─────────────────────────────────────────────────────────────────────────
    // SELECTOR EN CASCADA: Provincia → Cantón → Distrito
    // API:
    //   GET /api/cantones/{id_provincia}  → [{id_canton, nombre}, ...]
    //   GET /api/distritos/{id_canton}    → [{id_distrito, nombre}, ...]
    // ─────────────────────────────────────────────────────────────────────────

    const selectProvincia = document.getElementById('id_provincia');
    const selectCanton    = document.getElementById('id_canton');
    const selectDistrito  = document.getElementById('id_distrito');

    // Valores pre-seleccionados en modo edición (inyectados por PHP)
    const cantonPresel   = "{{ $canSel }}";
    const distritoPresel = "{{ $disSel }}";

    // Bandera para evitar que el listener de province dispare durante init()
    let ignorarCambio = false;

    /**
     * Llena un <select> con las opciones recibidas del API.
     * @param {HTMLSelectElement} select      - El select a poblar
     * @param {Array}             items       - Array de objetos del API
     * @param {string}            idKey       - Nombre del campo ID en cada objeto
     * @param {string}            placeholder - Texto de la opción vacía
     * @param {string}            selectedId  - ID a pre-seleccionar (opcional)
     */
    function llenarSelect(select, items, idKey, placeholder, selectedId = '') {
        select.innerHTML = `<option value="">${placeholder}</option>`;
        items.forEach(function (item) {
            const opt = document.createElement('option');
            opt.value       = item[idKey];
            opt.textContent = item.nombre;
            if (String(item[idKey]) === String(selectedId)) {
                opt.selected = true;
            }
            select.appendChild(opt);
        });
        select.disabled = items.length === 0;
    }

    // ── Al cambiar PROVINCIA: cargar sus cantones ─────────────────────────
    selectProvincia.addEventListener('change', function () {
        if (ignorarCambio) return;          // no procesar durante init()

        const idProvincia = this.value;

        // Resetear cantón y distrito
        selectCanton.innerHTML   = '<option value="">— Cargando cantones... —</option>';
        selectCanton.disabled    = true;
        selectDistrito.innerHTML = '<option value="">— Selecciona un distrito —</option>';
        selectDistrito.disabled  = true;

        if (!idProvincia) return;

        fetch(`/api/cantones/${idProvincia}`)
            .then(r => r.json())
            .then(data => {
                llenarSelect(selectCanton, data, 'id_canton', '— Selecciona un cantón —');
                selectCanton.disabled = false;
            })
            .catch(() => {
                selectCanton.innerHTML = '<option value="">Error al cargar cantones</option>';
            });
    });

    // ── Al cambiar CANTÓN: cargar sus distritos ───────────────────────────
    selectCanton.addEventListener('change', function () {
        if (ignorarCambio) return;          // no procesar durante init()

        const idCanton = this.value;

        selectDistrito.innerHTML = '<option value="">— Cargando distritos... —</option>';
        selectDistrito.disabled  = true;

        if (!idCanton) return;

        fetch(`/api/distritos/${idCanton}`)
            .then(r => r.json())
            .then(data => {
                llenarSelect(selectDistrito, data, 'id_distrito', '— Selecciona un distrito —');
                selectDistrito.disabled = false;
            })
            .catch(() => {
                selectDistrito.innerHTML = '<option value="">Error al cargar distritos</option>';
            });
    });

    // ── Inicialización en modo EDICIÓN: precargar cantones y distritos ────
    (function init() {
        const provId = selectProvincia.value;   // ya pre-seleccionado por PHP
        if (!provId || !cantonPresel) return;

        ignorarCambio = true;   // evitar que los listeners de arriba disparen

        // 1. Cargar cantones de la provincia guardada
        fetch(`/api/cantones/${provId}`)
            .then(r => r.json())
            .then(data => {
                llenarSelect(selectCanton, data, 'id_canton',
                             '— Selecciona un cantón —', cantonPresel);
                selectCanton.disabled = false;

                if (!cantonPresel || !distritoPresel) {
                    ignorarCambio = false;
                    return;
                }

                // 2. Cargar distritos del cantón guardado
                return fetch(`/api/distritos/${cantonPresel}`)
                    .then(r => r.json())
                    .then(data => {
                        llenarSelect(selectDistrito, data, 'id_distrito',
                                     '— Selecciona un distrito —', distritoPresel);
                        selectDistrito.disabled = false;
                    });
            })
            .finally(() => {
                ignorarCambio = false;  // re-activar listeners
            });
    })();
</script>
@endpush
