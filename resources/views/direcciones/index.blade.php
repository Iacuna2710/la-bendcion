@extends('layouts.app')

@section('titulo', 'Mis Direcciones')

@section('encabezado')
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="h3 fw-bold mb-1"><i class="bi bi-geo-alt me-2"></i>Mis Direcciones</h1>
            <p class="mb-0 opacity-75 small">Gestiona tus direcciones de entrega</p>
        </div>
        <a href="{{ route('direcciones.create') }}" class="btn btn-outline-light btn-sm">
            <i class="bi bi-plus-circle me-1"></i>Nueva dirección
        </a>
    </div>
@endsection

@section('contenido')
<div class="container py-4">

    @include('partials.alertas')

    @if($direcciones->isEmpty())
        <div class="text-center py-5">
            <div style="font-size:5rem;">📍</div>
            <h4 class="fw-bold mt-3">No tienes direcciones registradas</h4>
            <p class="text-muted mb-4">Agrega tu primera dirección de entrega.</p>
            <a href="{{ route('direcciones.create') }}" class="btn btn-lb-primary btn-lg">
                <i class="bi bi-plus-circle me-2"></i>Agregar dirección
            </a>
        </div>
    @else
        <div class="row g-3">
            @foreach($direcciones as $direccion)
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-3 h-100
                            {{ $direccion->es_principal ? 'lb-dir-principal' : '' }}">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div class="d-flex align-items-center gap-2">
                                <span class="lb-dir-icon">📍</span>
                                @if($direccion->es_principal)
                                    <span class="badge bg-success-subtle text-success border border-success-subtle">
                                        <i class="bi bi-star-fill me-1"></i>Principal
                                    </span>
                                @endif
                            </div>
                        </div>

                        <p class="fw-semibold mb-1">{{ $direccion->detalle }}</p>
                        <p class="text-muted small mb-0">
                            <i class="bi bi-map me-1"></i>
                            {{ $direccion->distrito->nombre ?? '—' }},
                            {{ $direccion->distrito->canton->nombre ?? '' }},
                            {{ $direccion->distrito->canton->provincia->nombre ?? '' }}
                        </p>
                    </div>

                    <div class="card-footer bg-transparent border-top d-flex gap-2 flex-wrap">
                        <a href="{{ route('direcciones.edit', $direccion->id_direccion) }}"
                           class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-pencil me-1"></i>Editar
                        </a>

                        @if(!$direccion->es_principal)
                            <form method="POST"
                                  action="{{ route('direcciones.destroy', $direccion->id_direccion) }}"
                                  onsubmit="return confirm('¿Eliminar esta dirección?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach

            {{-- Card para agregar nueva --}}
            <div class="col-md-6">
                <a href="{{ route('direcciones.create') }}"
                   class="card border-dashed rounded-3 h-100 text-decoration-none lb-add-card">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center py-5">
                        <div class="lb-add-icon mb-3">
                            <i class="bi bi-plus-lg fs-4"></i>
                        </div>
                        <p class="fw-semibold mb-0" style="color:#2d6a4f;">Agregar nueva dirección</p>
                    </div>
                </a>
            </div>
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .lb-dir-principal { border: 2px solid #2d6a4f !important; }
    .lb-dir-icon { font-size: 1.2rem; }
    .lb-add-card {
        border: 2px dashed #b7e4c7 !important;
        transition: all 0.2s; min-height: 160px;
        color: #2d6a4f;
    }
    .lb-add-card:hover { border-color: #2d6a4f !important; background-color: #f0faf4; }
    .lb-add-icon {
        width: 48px; height: 48px; border-radius: 50%;
        background-color: #d8f3dc; color: #2d6a4f;
        display: flex; align-items: center; justify-content: center;
    }
    .btn-lb-primary { background-color: #2d6a4f; border-color: #2d6a4f; color: white; }
    .btn-lb-primary:hover { background-color: #1b4332; border-color: #1b4332; color: white; }
</style>
@endpush
