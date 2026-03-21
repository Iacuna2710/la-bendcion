{{--
    partial: navbar.blade.php
    Barra de navegación principal del área pública.
    Muestra menús diferentes según el rol del usuario autenticado.
--}}

<nav class="navbar navbar-expand-lg lb-navbar shadow-sm sticky-top">
    <div class="container">

        {{-- Logo / Marca --}}
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('inicio') }}">
            <span class="lb-navbar-logo">🌿</span>
            <span class="fw-bold fs-5">La Bendición</span>
        </a>

        {{-- Botón hamburguesa (móvil) --}}
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarPrincipal" aria-controls="navbarPrincipal"
                aria-expanded="false" aria-label="Menú">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarPrincipal">

            {{-- Menú central --}}
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('inicio') ? 'active' : '' }}"
                       href="{{ route('inicio') }}">
                        <i class="bi bi-house-door me-1"></i>Inicio
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('catalogo.*') ? 'active' : '' }}"
                       href="{{ route('catalogo.index') }}">
                        <i class="bi bi-grid me-1"></i>Catálogo
                    </a>
                </li>

                {{-- Menú exclusivo de admin/trabajador --}}
                @auth
                    @if(auth()->user()->hasAnyRole(['admin', 'trabajador']))
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('admin*') ? 'active' : '' }}"
                               href="{{ route('admin.dashboard') }}">
                                <i class="bi bi-speedometer2 me-1"></i>Panel Admin
                            </a>
                        </li>
                    @endif
                @endauth
            </ul>

            {{-- Sección derecha: Carrito + Cuenta --}}
            <ul class="navbar-nav align-items-center gap-1">

                {{-- Ícono de carrito (solo para usuarios autenticados con rol cliente/trabajador/admin) --}}
                @auth
                    <li class="nav-item">
                        <a class="nav-link position-relative lb-cart-link {{ request()->routeIs('carrito.*') ? 'active' : '' }}"
                           href="{{ route('carrito.index') }}" title="Mi carrito">
                            <i class="bi bi-cart3 fs-5"></i>
                            {{-- Badge con cantidad de ítems del carrito --}}
                            @php
                                $cantidadCarrito = auth()->user()->carrito?->items->sum('cantidad') ?? 0;
                            @endphp
                            @if($cantidadCarrito > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                      style="font-size: 0.65rem;">
                                    {{ $cantidadCarrito > 99 ? '99+' : $cantidadCarrito }}
                                </span>
                            @endif
                        </a>
                    </li>
                @endauth

                {{-- Menú de usuario autenticado --}}
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#"
                           id="dropdownUsuario" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="lb-avatar">{{ strtoupper(substr(auth()->user()->nombre, 0, 1)) }}</span>
                            <span class="d-none d-md-inline">{{ auth()->user()->nombre }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow lb-dropdown" aria-labelledby="dropdownUsuario">
                            <li>
                                <span class="dropdown-item-text small text-muted">
                                    {{ auth()->user()->email }}
                                </span>
                            </li>
                            <li>
                                <span class="dropdown-item-text small">
                                    @foreach(auth()->user()->roles as $rol)
                                        <span class="badge lb-role-badge">{{ ucfirst($rol->nombre) }}</span>
                                    @endforeach
                                </span>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            @if(auth()->user()->hasAnyRole(['admin', 'trabajador']))
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        <i class="bi bi-speedometer2 me-2"></i>Panel Admin
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                            @endif
                            <li>
                                <a class="dropdown-item" href="{{ route('pedidos.index') }}">
                                    <i class="bi bi-bag-check me-2"></i>Mis pedidos
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('direcciones.index') }}">
                                    <i class="bi bi-geo-alt me-2"></i>Mis direcciones
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i>Cerrar sesión
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    {{-- Botones para visitantes --}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}"
                           href="{{ route('login') }}">
                            <i class="bi bi-person me-1"></i>Iniciar sesión
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn lb-btn-nav ms-2" href="{{ route('register') }}">
                            Registrarse
                        </a>
                    </li>
                @endguest
            </ul>

        </div>
    </div>
</nav>
