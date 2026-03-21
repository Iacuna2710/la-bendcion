@extends('layouts.admin')

@php
    $esEdicion = isset($rol) && $rol !== null;
    $titulo    = $esEdicion ? 'Editar Rol' : 'Nuevo Rol';
@endphp

@section('titulo', $titulo)

@section('contenido')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 fw-bold mb-0">{{ $titulo }}</h2>
    <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Volver
    </a>
</div>

@include('partials.alertas')

<div class="card lb-admin-card" style="max-width:500px;">
    <div class="card-body p-4">
        <form method="POST"
              action="{{ $esEdicion
                  ? route('admin.roles.update', $rol->id_roles)
                  : route('admin.roles.store') }}"
              novalidate>
            @csrf
            @if($esEdicion) @method('PUT') @endif

            <div class="mb-3">
                <label for="nombre" class="form-label fw-semibold">Nombre del rol <span class="text-danger">*</span></label>
                <input type="text" id="nombre" name="nombre"
                       class="form-control @error('nombre') is-invalid @enderror"
                       value="{{ old('nombre', $rol->nombre ?? '') }}"
                       placeholder="Ej. cliente, admin, trabajador" required>
                @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label for="descripcion" class="form-label fw-semibold">Descripción</label>
                <textarea id="descripcion" name="descripcion" rows="2"
                          class="form-control @error('descripcion') is-invalid @enderror"
                          placeholder="Descripción breve del rol...">{{ old('descripcion', $rol->descripcion ?? '') }}</textarea>
                @error('descripcion') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-lb-primary">
                    <i class="bi bi-{{ $esEdicion ? 'floppy' : 'plus-circle' }} me-2"></i>
                    {{ $esEdicion ? 'Guardar cambios' : 'Crear rol' }}
                </button>
                <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

@endsection
