@extends('layouts.admin')

@php
    $esEdicion = isset($producto) && $producto !== null;
    $titulo    = $esEdicion ? 'Editar Producto' : 'Nuevo Producto';
@endphp

@section('titulo', $titulo)

@section('contenido')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 fw-bold mb-0">{{ $titulo }}</h2>
    <a href="{{ route('admin.productos.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Volver
    </a>
</div>

@include('partials.alertas')

<form method="POST"
      action="{{ $esEdicion
          ? route('admin.productos.update', $producto->id_producto)
          : route('admin.productos.store') }}"
      enctype="multipart/form-data"
      novalidate>
    @csrf
    @if($esEdicion) @method('PUT') @endif

    <div class="row g-4">

        {{-- ── DATOS PRINCIPALES ────────────────────────────────────────── --}}
        <div class="col-lg-8">
            <div class="card lb-admin-card mb-4">
                <div class="card-header fw-bold">Información del producto</div>
                <div class="card-body">

                    <div class="mb-3">
                        <label for="nombre" class="form-label fw-semibold">Nombre <span class="text-danger">*</span></label>
                        <input type="text" id="nombre" name="nombre"
                               class="form-control @error('nombre') is-invalid @enderror"
                               value="{{ old('nombre', $producto->nombre ?? '') }}" required>
                        @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label for="sku" class="form-label fw-semibold">SKU</label>
                            <input type="text" id="sku" name="sku"
                                   class="form-control font-monospace @error('sku') is-invalid @enderror"
                                   value="{{ old('sku', $producto->sku ?? '') }}"
                                   placeholder="Único, opcional">
                            @error('sku') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="precio" class="form-label fw-semibold">Precio (₡) <span class="text-danger">*</span></label>
                            <input type="number" id="precio" name="precio" step="0.01" min="0"
                                   class="form-control @error('precio') is-invalid @enderror"
                                   value="{{ old('precio', $producto->precio ?? '') }}" required>
                            @error('precio') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="stock" class="form-label fw-semibold">Stock <span class="text-danger">*</span></label>
                            <input type="number" id="stock" name="stock" min="0"
                                   class="form-control @error('stock') is-invalid @enderror"
                                   value="{{ old('stock', $producto->stock ?? '') }}" required>
                            @error('stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="stock_minimo" class="form-label fw-semibold">Stock mínimo</label>
                        <input type="number" id="stock_minimo" name="stock_minimo" min="0"
                               class="form-control @error('stock_minimo') is-invalid @enderror"
                               value="{{ old('stock_minimo', $producto->stock_minimo ?? 5) }}">
                        <div class="form-text text-muted">Cantidad mínima antes de alertar bajo stock.</div>
                        @error('stock_minimo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="descripcion" class="form-label fw-semibold">Descripción</label>
                        <textarea id="descripcion" name="descripcion" rows="3"
                                  class="form-control @error('descripcion') is-invalid @enderror"
                                  placeholder="Descripción general del producto...">{{ old('descripcion', $producto->descripcion ?? '') }}</textarea>
                        @error('descripcion') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="ingredientes" class="form-label fw-semibold">Ingredientes</label>
                        <textarea id="ingredientes" name="ingredientes" rows="3"
                                  class="form-control @error('ingredientes') is-invalid @enderror"
                                  placeholder="Lista de ingredientes...">{{ old('ingredientes', $producto->ingredientes ?? '') }}</textarea>
                        @error('ingredientes') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-0">
                        <label for="beneficios" class="form-label fw-semibold">Beneficios</label>
                        <textarea id="beneficios" name="beneficios" rows="3"
                                  class="form-control @error('beneficios') is-invalid @enderror"
                                  placeholder="Beneficios y propiedades...">{{ old('beneficios', $producto->beneficios ?? '') }}</textarea>
                        @error('beneficios') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                </div>
            </div>

            {{-- Imágenes --}}
            <div class="card lb-admin-card">
                <div class="card-header fw-bold">Imágenes</div>
                <div class="card-body">

                    {{-- Imágenes actuales (edición) --}}
                    @if($esEdicion && $producto->imagenes->isNotEmpty())
                        <div class="mb-3">
                            <p class="fw-semibold small mb-2">Imágenes actuales:</p>
                            <div class="d-flex gap-2 flex-wrap">
                                @foreach($producto->imagenes as $img)
                                <div class="position-relative">
                                    <img src="{{ asset('storage/' . $img->url) }}"
                                         alt="{{ $img->alt_text }}"
                                         class="rounded-2 border {{ $img->es_principal ? 'border-success border-2' : '' }}"
                                         style="width:80px;height:80px;object-fit:cover;">
                                    @if($img->es_principal)
                                        <span class="position-absolute bottom-0 start-0 badge bg-success"
                                              style="font-size:0.6rem;">Principal</span>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="mb-2">
                        <label for="imagenes" class="form-label fw-semibold">
                            {{ $esEdicion ? 'Agregar nuevas imágenes' : 'Imágenes del producto' }}
                        </label>
                        <input type="file" id="imagenes" name="imagenes[]"
                               class="form-control @error('imagenes.*') is-invalid @enderror"
                               multiple accept="image/*">
                        <div class="form-text text-muted">
                            Formatos: JPG, PNG, WEBP. Máximo 2MB por imagen.
                            La primera imagen marcada como "principal" será la imagen destacada.
                        </div>
                        @error('imagenes.*') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    {{-- Previsualización --}}
                    <div id="preview-imagenes" class="d-flex gap-2 flex-wrap mt-2"></div>

                </div>
            </div>
        </div>

        {{-- ── SIDEBAR ──────────────────────────────────────────────────── --}}
        <div class="col-lg-4">

            {{-- Categorías --}}
            <div class="card lb-admin-card mb-4">
                <div class="card-header fw-bold">Categorías <span class="text-danger">*</span></div>
                <div class="card-body" style="max-height:250px; overflow-y:auto;">
                    @foreach($categorias as $categoria)
                    <div class="form-check mb-1">
                        <input class="form-check-input" type="checkbox" name="categorias[]"
                               id="cat-{{ $categoria->id_categoria }}"
                               value="{{ $categoria->id_categoria }}"
                               {{ in_array($categoria->id_categoria,
                                   old('categorias', $esEdicion
                                       ? $producto->categorias->pluck('id_categoria')->toArray()
                                       : [])
                                  ) ? 'checked' : '' }}>
                        <label class="form-check-label" for="cat-{{ $categoria->id_categoria }}">
                            {{ $categoria->nombre }}
                        </label>
                    </div>
                    @endforeach
                    @error('categorias') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>
            </div>

            {{-- Opciones extra --}}
            <div class="card lb-admin-card mb-4">
                <div class="card-header fw-bold">Opciones</div>
                <div class="card-body">
                    <div class="form-check form-switch mb-3">
                        <input type="hidden" name="es_destacado" value="0">
                        <input class="form-check-input" type="checkbox" id="es_destacado"
                               name="es_destacado" value="1"
                               {{ old('es_destacado', $producto->es_destacado ?? false) ? 'checked' : '' }}>
                        <label class="form-check-label" for="es_destacado">
                            <i class="bi bi-star me-1 text-warning"></i>Producto destacado
                        </label>
                    </div>
                </div>
            </div>

            {{-- Guardar --}}
            <div class="card lb-admin-card">
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-lb-primary btn-lg fw-semibold">
                            <i class="bi bi-{{ $esEdicion ? 'floppy' : 'plus-circle' }} me-2"></i>
                            {{ $esEdicion ? 'Guardar cambios' : 'Crear producto' }}
                        </button>
                        <a href="{{ route('admin.productos.index') }}" class="btn btn-outline-secondary">
                            Cancelar
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</form>

@endsection

@push('scripts')
<script>
    // Previsualización de imágenes seleccionadas antes de subir
    document.getElementById('imagenes').addEventListener('change', function () {
        const preview = document.getElementById('preview-imagenes');
        preview.innerHTML = '';
        Array.from(this.files).forEach(function (file) {
            if (!file.type.startsWith('image/')) return;
            const reader = new FileReader();
            reader.onload = function (e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'rounded-2 border';
                img.style.cssText = 'width:80px;height:80px;object-fit:cover;';
                preview.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    });
</script>
@endpush
