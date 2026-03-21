@extends('layouts.admin')

@php
    $esEdicion = isset($metodoPago) && $metodoPago !== null;
    $titulo    = $esEdicion ? 'Editar Método de Pago' : 'Nuevo Método de Pago';
@endphp

@section('titulo', $titulo)

@section('contenido')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 fw-bold mb-0">{{ $titulo }}</h2>
    <a href="{{ route('admin.metodos-pago.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Volver
    </a>
</div>

@include('partials.alertas')

<div class="card lb-admin-card" style="max-width:500px;">
    <div class="card-body p-4">
        <form method="POST"
              action="{{ $esEdicion
                  ? route('admin.metodos-pago.update', $metodoPago->id_met_pago)
                  : route('admin.metodos-pago.store') }}"
              novalidate>
            @csrf
            @if($esEdicion) @method('PUT') @endif

            <div class="mb-3">
                <label for="nombre" class="form-label fw-semibold">
                    Nombre <span class="text-danger">*</span>
                </label>
                <input type="text" id="nombre" name="nombre"
                       class="form-control @error('nombre') is-invalid @enderror"
                       value="{{ old('nombre', $metodoPago->nombre ?? '') }}"
                       placeholder="Ej. Tarjeta de crédito, SINPE Móvil..." required>
                @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label for="descripcion" class="form-label fw-semibold">Descripción</label>
                <textarea id="descripcion" name="descripcion" rows="2"
                          class="form-control @error('descripcion') is-invalid @enderror"
                          placeholder="Instrucciones o detalles del método de pago...">{{ old('descripcion', $metodoPago->descripcion ?? '') }}</textarea>
                @error('descripcion') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            @if($esEdicion)
            <div class="mb-4">
                <div class="form-check form-switch">
                    <input type="hidden" name="is_active" value="0">
                    <input class="form-check-input" type="checkbox" id="is_active"
                           name="is_active" value="1"
                           {{ old('is_active', $metodoPago->is_active ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">Método activo</label>
                </div>
            </div>
            @endif

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-lb-primary">
                    <i class="bi bi-{{ $esEdicion ? 'floppy' : 'plus-circle' }} me-2"></i>
                    {{ $esEdicion ? 'Guardar cambios' : 'Crear método' }}
                </button>
                <a href="{{ route('admin.metodos-pago.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

@endsection
