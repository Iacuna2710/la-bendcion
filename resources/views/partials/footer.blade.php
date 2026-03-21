{{--
    partial: footer.blade.php
    Pie de página del área pública de La Bendición.
--}}
<footer class="lb-footer text-white mt-auto py-5">
    <div class="container">
        <div class="row g-4">

            {{-- Columna 1: Marca --}}
            <div class="col-lg-4 col-md-6">
                <div class="d-flex align-items-center mb-3">
                    <span class="lb-footer-logo me-2">🌿</span>
                    <span class="fw-bold fs-5">La Bendición</span>
                </div>
                <p class="text-white-50 small mb-3">
                    Tu tienda de confianza para productos macrobióticos naturales.
                    Salud, bienestar y armonía en cada producto.
                </p>
                <div class="d-flex gap-3">
                    <a href="#" class="text-white-50 lb-social-icon" title="Facebook">
                        <i class="bi bi-facebook fs-5"></i>
                    </a>
                    <a href="#" class="text-white-50 lb-social-icon" title="Instagram">
                        <i class="bi bi-instagram fs-5"></i>
                    </a>
                    <a href="#" class="text-white-50 lb-social-icon" title="WhatsApp">
                        <i class="bi bi-whatsapp fs-5"></i>
                    </a>
                </div>
            </div>

            {{-- Columna 2: Navegación --}}
            <div class="col-lg-2 col-md-6">
                <h6 class="fw-semibold text-uppercase mb-3 lb-footer-heading">Tienda</h6>
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <a href="{{ route('inicio') }}" class="text-white-50 text-decoration-none lb-footer-link">Inicio</a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('catalogo.index') }}" class="text-white-50 text-decoration-none lb-footer-link">Catálogo</a>
                    </li>
                    @auth
                        <li class="mb-2">
                            <a href="{{ route('carrito.index') }}" class="text-white-50 text-decoration-none lb-footer-link">Mi carrito</a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('pedidos.index') }}" class="text-white-50 text-decoration-none lb-footer-link">Mis pedidos</a>
                        </li>
                    @endauth
                </ul>
            </div>

            {{-- Columna 3: Mi cuenta --}}
            <div class="col-lg-2 col-md-6">
                <h6 class="fw-semibold text-uppercase mb-3 lb-footer-heading">Mi cuenta</h6>
                <ul class="list-unstyled mb-0">
                    @guest
                        <li class="mb-2">
                            <a href="{{ route('login') }}" class="text-white-50 text-decoration-none lb-footer-link">Iniciar sesión</a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('register') }}" class="text-white-50 text-decoration-none lb-footer-link">Registro</a>
                        </li>
                    @endguest
                    @auth
                        <li class="mb-2">
                            <a href="{{ route('direcciones.index') }}" class="text-white-50 text-decoration-none lb-footer-link">Mis direcciones</a>
                        </li>
                        <li class="mb-2">
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-link p-0 text-white-50 text-decoration-none lb-footer-link">
                                    Cerrar sesión
                                </button>
                            </form>
                        </li>
                    @endauth
                </ul>
            </div>

            {{-- Columna 4: Contacto --}}
            <div class="col-lg-4 col-md-6">
                <h6 class="fw-semibold text-uppercase mb-3 lb-footer-heading">Contacto</h6>
                <ul class="list-unstyled mb-0">
                    <li class="mb-2 d-flex align-items-start gap-2">
                        <i class="bi bi-geo-alt-fill text-success mt-1"></i>
                        <span class="text-white-50 small">San José, Costa Rica</span>
                    </li>
                    <li class="mb-2 d-flex align-items-center gap-2">
                        <i class="bi bi-telephone-fill text-success"></i>
                        <a href="tel:+50600000000" class="text-white-50 text-decoration-none lb-footer-link small">+506 0000-0000</a>
                    </li>
                    <li class="mb-2 d-flex align-items-center gap-2">
                        <i class="bi bi-envelope-fill text-success"></i>
                        <a href="mailto:info@labendicion.cr" class="text-white-50 text-decoration-none lb-footer-link small">info@labendicion.cr</a>
                    </li>
                </ul>
            </div>

        </div>

        <hr class="border-secondary mt-4 mb-3">

        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
                <p class="text-white-50 small mb-0">
                    &copy; {{ date('Y') }} La Bendición — Macrobiótica Natural. Todos los derechos reservados.
                </p>
            </div>
            <div class="col-md-6 text-center text-md-end mt-2 mt-md-0">
                <span class="text-white-50 small">
                    Hecho con <i class="bi bi-heart-fill text-danger"></i> en Costa Rica
                </span>
            </div>
        </div>
    </div>
</footer>
