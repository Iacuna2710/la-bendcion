@extends('layouts.admin')

@php
    $esEdicion = isset($categoria) && $categoria !== null;
    $titulo    = $esEdicion ? 'Editar Categoría' : 'Nueva Categoría';
@endphp

@section('titulo', $titulo)

@section('contenido')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 fw-bold mb-0">{{ $titulo }}</h2>
    <a href="{{ route('admin.categorias.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Volver
    </a>
</div>

@include('partials.alertas')

<div class="card lb-admin-card" style="max-width: 600px;">
    <div class="card-body p-4">
        <form method="POST"
              action="{{ $esEdicion
                  ? route('admin.categorias.update', $categoria->id_categoria)
                  : route('admin.categorias.store') }}"
              novalidate>
            @csrf
            @if($esEdicion) @method('PUT') @endif

            <div class="mb-3">
                <label for="nombre" class="form-label fw-semibold">Nombre <span class="text-danger">*</span></label>
                <input type="text" id="nombre" name="nombre"
                       class="form-control @error('nombre') is-invalid @enderror"
                       value="{{ old('nombre', $categoria->nombre ?? '') }}"
                       placeholder="Ej. Cereales Integrales" required>
                @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="slug" class="form-label fw-semibold">Slug</label>
                <input type="text" id="slug" name="slug"
                       class="form-control font-monospace @error('slug') is-invalid @enderror"
                       value="{{ old('slug', $categoria->slug ?? '') }}"
                       placeholder="Se genera automáticamente">
                <div class="form-text text-muted">Se genera automáticamente si lo dejas vacío.</div>
                @error('slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label for="descripcion" class="form-label fw-semibold">Descripción</label>
                <textarea id="descripcion" name="descripcion" rows="3"
                          class="form-control @error('descripcion') is-invalid @enderror"
                          placeholder="Descripción breve de esta categoría...">{{ old('descripcion', $categoria->descripcion ?? '') }}</textarea>
                @error('descripcion') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            @if($esEdicion)
            <div class="mb-4">
                <div class="form-check form-switch">
                    <input type="hidden" name="is_active" value="0">
                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                           value="1" {{ old('is_active', $categoria->is_active ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">Categoría activa</label>
                </div>
            </div>
            @endif

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-lb-primary">
                    <i class="bi bi-{{ $esEdicion ? 'floppy' : 'plus-circle' }} me-2"></i>
                    {{ $esEdicion ? 'Guardar cambios' : 'Crear categoría' }}
                </button>
                <a href="{{ route('admin.categorias.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Auto-generar el slug desde el nombre
    document.getElementById('nombre').addEventListener('input', function () {
        const slugInput = document.getElementById('slug');
        if (slugInput.dataset.manual === 'true') return;
        slugInput.value = this.value
            .toLowerCase()
            .normalize('NFD').replace(/[\u0300-\u036f]/g, '')      // quitar tildes
            .replace(/[^a-z0-9\s-]/g, '')
            .trim().replace(/\s+/g, '-');
    });
    document.getElementById('slug').addEventListener('input', function () {
        this.dataset.manual = 'true';
    });
</script>
@endpush
