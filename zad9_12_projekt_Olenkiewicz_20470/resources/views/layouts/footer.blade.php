<footer class="bg-dark text-light py-5 mt-auto">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4 mb-md-0">
                <h5 class="mb-3">
                    <i class="bi bi-bicycle me-2"></i>SportRental Pro
                </h5>
                <p class="text-secondary">
                    Profesjonalna wypożyczalnia sprzętu sportowego. 
                    Szeroki wybór, konkurencyjne ceny, najwyższa jakość.
                </p>
            </div>
            <div class="col-md-4 mb-4 mb-md-0">
                <h6 class="mb-3">Szybkie linki</h6>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="{{ route('products.index') }}" class="text-secondary text-decoration-none">
                            <i class="bi bi-chevron-right me-1"></i>Katalog produktów
                        </a>
                    </li>
                    @auth
                        <li class="mb-2">
                            <a href="{{ route('booking.history') }}" class="text-secondary text-decoration-none">
                                <i class="bi bi-chevron-right me-1"></i>Moje rezerwacje
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('profile.edit') }}" class="text-secondary text-decoration-none">
                                <i class="bi bi-chevron-right me-1"></i>Mój profil
                            </a>
                        </li>
                    @else
                        <li class="mb-2">
                            <a href="{{ route('register') }}" class="text-secondary text-decoration-none">
                                <i class="bi bi-chevron-right me-1"></i>Rejestracja
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
            <div class="col-md-4">
                <h6 class="mb-3">Kontakt</h6>
                <ul class="list-unstyled text-secondary">
                    <li class="mb-2">
                        <i class="bi bi-envelope me-2"></i>kontakt@sportrental.pl
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-telephone me-2"></i>+48 123 456 789
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-geo-alt me-2"></i>ul. Sportowa 15, Warszawa
                    </li>
                </ul>
            </div>
        </div>
        <hr class="my-4 border-secondary">
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
                <p class="text-secondary mb-0 small">
                    &copy; {{ date('Y') }} SportRental Pro. Wszelkie prawa zastrzeżone.
                </p>
            </div>
            <div class="col-md-6 text-center text-md-end mt-3 mt-md-0">
                <a href="#" class="text-secondary me-3"><i class="bi bi-facebook fs-5"></i></a>
                <a href="#" class="text-secondary me-3"><i class="bi bi-instagram fs-5"></i></a>
                <a href="#" class="text-secondary"><i class="bi bi-twitter-x fs-5"></i></a>
            </div>
        </div>
    </div>
</footer>
