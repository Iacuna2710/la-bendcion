{{--
    partial: catalogo/_card-producto.blade.php
    Tarjeta reutilizable de producto para el catálogo e inicio.
    Requiere: $producto (Producto con imagenPrincipal y categorias cargados)
--}}
<div class="col-12 col-sm-6 col-md-4 col-lg-3">
    <div class="card lb-prod-card h-100">

        {{-- Enlace a detalle y badge destacado --}}
        <a href="{{ route('catalogo.detalle', $producto->id_producto) }}" class="text-decoration-none">
            {{-- Imagen del producto --}}
            @if($producto->imagenPrincipal)
                <img src="{{ asset('storage/' . $producto->imagenPrincipal->url) }}"
                     alt="{{ $producto->imagenPrincipal->alt_text ?? $producto->nombre }}"
                     class="lb-prod-img">
            @else
                <div class="lb-prod-img-placeholder">🌿</div>
            @endif
        </a>

        {{-- Badge destacado --}}
        @if($producto->es_destacado)
            <span class="position-absolute top-0 end-0 m-2 badge lb-badge-destacado">
                <i class="bi bi-star-fill me-1"></i>Destacado
            </span>
        @endif

        {{-- Cuerpo de la tarjeta --}}
        <div class="card-body d-flex flex-column p-3">
            {{-- Categorías --}}
            @foreach($producto->categorias->take(2) as $cat)
                <span class="badge lb-badge-categoria mb-1">{{ $cat->nombre }}</span>
            @endforeach

            {{-- Nombre --}}
            <a href="{{ route('catalogo.detalle', $producto->id_producto) }}"
               class="text-decoration-none text-dark">
                <h6 class="card-title fw-semibold mt-1 mb-1 lb-prod-nombre">{{ $producto->nombre }}</h6>
            </a>

            {{-- Precio --}}
            <div class="mt-auto pt-2">
                <span class="lb-precio">₡{{ number_format($producto->precio, 2) }}</span>
                @if($producto->stock <= 5)
                    <span class="badge bg-warning text-dark ms-1" style="font-size: 0.65rem;">
                        ¡Pocas unidades!
                    </span>
                @endif
            </div>
        </div>

        {{-- Botón agregar al carrito --}}
        @auth
            <form method="POST" action="{{ route('carrito.agregar') }}">
                @csrf
                <input type="hidden" name="id_producto" value="{{ $producto->id_producto }}">
                <input type="hidden" name="cantidad" value="1">
                <button type="submit" class="btn lb-btn-agregar w-100 py-2">
                    <i class="bi bi-cart-plus me-2"></i>Agregar al carrito
                </button>
            </form>
        @else
            <a href="{{ route('login') }}" class="btn lb-btn-agregar w-100 py-2">
                <i class="bi bi-cart-plus me-2"></i>Agregar al carrito
            </a>
        @endauth

    </div>
</div>
