<x-app-layout>
    @section('title', 'Strona główna')

    <!-- Hero Section -->
    <section class="bg-primary text-white py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <h1 class="display-4 fw-bold mb-3">
                        <i class="bi bi-bicycle me-2"></i>Wypożycz sprzęt sportowy
                    </h1>
                    <p class="lead mb-4">
                        Najlepszy sprzęt sportowy dostępny na wyciągnięcie ręki. 
                        Rowery, narty, kajaki i wiele więcej w atrakcyjnych cenach.
                    </p>
                    <div class="d-flex gap-3">
                        <a href="#katalog" class="btn btn-light btn-lg">
                            <i class="bi bi-search me-2"></i>Przeglądaj katalog
                        </a>
                        @guest
                            <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg">
                                <i class="bi bi-person-plus me-2"></i>Zarejestruj się
                            </a>
                        @endguest
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <i class="bi bi-bicycle" style="font-size: 12rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-3 mb-4 mb-md-0">
                    <div class="p-4">
                        <i class="bi bi-box-seam text-primary" style="font-size: 3rem;"></i>
                        <h2 class="fw-bold mt-3">{{ $stats['products'] ?? 0 }}</h2>
                        <p class="text-muted mb-0">Produktów</p>
                    </div>
                </div>
                <div class="col-md-3 mb-4 mb-md-0">
                    <div class="p-4">
                        <i class="bi bi-buildings text-primary" style="font-size: 3rem;"></i>
                        <h2 class="fw-bold mt-3">{{ $stats['rentals'] ?? 0 }}</h2>
                        <p class="text-muted mb-0">Wypożyczalni</p>
                    </div>
                </div>
                <div class="col-md-3 mb-4 mb-md-0">
                    <div class="p-4">
                        <i class="bi bi-people text-primary" style="font-size: 3rem;"></i>
                        <h2 class="fw-bold mt-3">{{ $stats['customers'] ?? 0 }}</h2>
                        <p class="text-muted mb-0">Klientów</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-4">
                        <i class="bi bi-calendar-check text-primary" style="font-size: 3rem;"></i>
                        <h2 class="fw-bold mt-3">{{ $stats['bookings'] ?? 0 }}</h2>
                        <p class="text-muted mb-0">Rezerwacji</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5">
                <i class="bi bi-question-circle me-2"></i>Jak to działa?
            </h2>
            <div class="row">
                <div class="col-md-4 mb-4 mb-md-0">
                    <div class="card h-100 border-0 shadow-sm text-center">
                        <div class="card-body p-4">
                            <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                <span class="fs-4 fw-bold">1</span>
                            </div>
                            <h5 class="card-title">Wybierz sprzęt</h5>
                            <p class="card-text text-muted">
                                Przeglądaj nasz katalog i wybierz sprzęt, który Cię interesuje.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4 mb-md-0">
                    <div class="card h-100 border-0 shadow-sm text-center">
                        <div class="card-body p-4">
                            <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                <span class="fs-4 fw-bold">2</span>
                            </div>
                            <h5 class="card-title">Zarezerwuj termin</h5>
                            <p class="card-text text-muted">
                                Wybierz daty i dokonaj rezerwacji online.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm text-center">
                        <div class="card-body p-4">
                            <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                <span class="fs-4 fw-bold">3</span>
                            </div>
                            <h5 class="card-title">Odbierz i korzystaj</h5>
                            <p class="card-text text-muted">
                                Odbierz sprzęt w umówionym terminie i ciesz się aktywnością!
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Katalog produktów -->
    <section id="katalog" class="py-5">
        <div class="container">
            <h2 class="text-center mb-4">
                <i class="bi bi-grid me-2"></i>Katalog produktów
            </h2>

            <!-- Filtry -->
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <form method="GET" action="{{ route('products.index') }}" class="row g-3">
                        <div class="col-md-4">
                            <label for="search" class="form-label">Szukaj</label>
                            <input type="text" class="form-control" id="search" name="search" 
                                   value="{{ request('search') }}" placeholder="Nazwa produktu...">
                        </div>
                        <div class="col-md-3">
                            <label for="category" class="form-label">Kategoria</label>
                            <select class="form-select" id="category" name="category">
                                <option value="">Wszystkie</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="sort" class="form-label">Sortowanie</label>
                            <select class="form-select" id="sort" name="sort">
                                <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nazwa A-Z</option>
                                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Cena rosnąco</option>
                                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Cena malejąco</option>
                            </select>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-search me-1"></i>Szukaj
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Produkty -->
            @if($products->count() > 0)
                <div class="row">
                    @foreach($products as $product)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card h-100 shadow-sm card-hover">
                                @if($product->image_path)
                                    <img src="{{ asset('storage/' . $product->image_path) }}" 
                                         class="card-img-top" 
                                         alt="{{ $product->name }}"
                                         style="height: 200px; object-fit: cover;">
                                @else
                                    <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 200px;">
                                        <i class="bi bi-image" style="font-size: 4rem; opacity: 0.5;"></i>
                                    </div>
                                @endif
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h5 class="card-title mb-0">{{ $product->name }}</h5>
                                        @if($product->stock_quantity > 0)
                                            <span class="badge bg-success">Dostępny</span>
                                        @else
                                            <span class="badge bg-danger">Niedostępny</span>
                                        @endif
                                    </div>
                                    <p class="card-text text-muted small">
                                        {{ Str::limit($product->description, 80) }}
                                    </p>
                                    <div class="d-flex flex-wrap gap-1 mb-3">
                                        @foreach($product->categories->take(3) as $category)
                                            <span class="badge bg-light text-dark">{{ $category->name }}</span>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="card-footer bg-white border-top-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="h5 text-primary mb-0">
                                            {{ number_format($product->daily_price, 2) }} zł<small class="text-muted">/dzień</small>
                                        </span>
                                        @auth
                                            @if($product->stock_quantity > 0)
                                                <a href="{{ route('booking.create', ['product_id' => $product->id]) }}" 
                                                   class="btn btn-primary btn-sm">
                                                    <i class="bi bi-calendar-plus me-1"></i>Rezerwuj
                                                </a>
                                            @endif
                                        @else
                                            <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm">
                                                <i class="bi bi-box-arrow-in-right me-1"></i>Zaloguj się
                                            </a>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Paginacja -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $products->withQueryString()->links('pagination::bootstrap-5') }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-inbox text-muted" style="font-size: 4rem;"></i>
                    <h4 class="mt-3">Brak produktów</h4>
                    <p class="text-muted">Nie znaleziono produktów spełniających kryteria.</p>
                </div>
            @endif
        </div>
    </section>
</x-app-layout>
