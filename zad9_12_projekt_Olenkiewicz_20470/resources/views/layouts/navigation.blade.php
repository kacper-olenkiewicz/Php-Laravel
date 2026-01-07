<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ route('products.index') }}">
            <i class="bi bi-bicycle me-2"></i>SportRental Pro
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('products.index') ? 'active' : '' }}" href="{{ route('products.index') }}">
                        <i class="bi bi-shop me-1"></i>Katalog
                    </a>
                </li>

                @auth
                    {{-- Menu dla klientów --}}
                    @if(Auth::user()->hasRole('Customer'))
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('booking.history') ? 'active' : '' }}" href="{{ route('booking.history') }}">
                                <i class="bi bi-calendar-check me-1"></i>Moje rezerwacje
                            </a>
                        </li>
                    @endif

                    {{-- Menu dla RentalOwner/Employee --}}
                    @if(Auth::user()->hasAnyRole(['RentalOwner', 'Employee']))
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ request()->is('rental/*') ? 'active' : '' }}" href="#" data-bs-toggle="dropdown">
                                <i class="bi bi-building me-1"></i>Wypożyczalnia
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="{{ route('rental.dashboard') }}">
                                        <i class="bi bi-speedometer2 me-2"></i>Panel
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                @can('manage products')
                                    <li>
                                        <a class="dropdown-item" href="{{ route('rental.products.index') }}">
                                            <i class="bi bi-box-seam me-2"></i>Produkty
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('rental.categories.index') }}">
                                            <i class="bi bi-tags me-2"></i>Kategorie
                                        </a>
                                    </li>
                                @endcan
                                @can('manage bookings')
                                    <li>
                                        <a class="dropdown-item" href="{{ route('rental.bookings.index') }}">
                                            <i class="bi bi-calendar-event me-2"></i>Rezerwacje
                                        </a>
                                    </li>
                                @endcan
                                @can('process payments')
                                    <li>
                                        <a class="dropdown-item" href="{{ route('rental.payments.index') }}">
                                            <i class="bi bi-credit-card me-2"></i>Płatności
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endif

                    {{-- Menu dla SuperAdmin --}}
                    @if(Auth::user()->hasRole('SuperAdmin'))
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ request()->is('admin/*') ? 'active' : '' }}" href="#" data-bs-toggle="dropdown">
                                <i class="bi bi-shield-lock me-1"></i>Admin
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        <i class="bi bi-speedometer2 me-2"></i>Panel admina
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.rentals.index') }}">
                                        <i class="bi bi-buildings me-2"></i>Wypożyczalnie
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.clients.index') }}">
                                        <i class="bi bi-people me-2"></i>Klienci
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="/admin">
                                        <i class="bi bi-gear me-2"></i>Filament Panel
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                @endauth
            </ul>

            {{-- User menu --}}
            <ul class="navbar-nav">
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="bi bi-box-arrow-in-right me-1"></i>Logowanie
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">
                            <i class="bi bi-person-plus me-1"></i>Rejestracja
                        </a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-1"></i>{{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <span class="dropdown-item-text text-muted small">
                                    {{ Auth::user()->email }}
                                </span>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="bi bi-person me-2"></i>Mój profil
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i>Wyloguj
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
