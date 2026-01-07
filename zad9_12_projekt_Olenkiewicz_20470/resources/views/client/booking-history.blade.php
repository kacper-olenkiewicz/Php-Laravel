<x-app-layout>
    <x-slot name="header">
        <h4 class="mb-0"><i class="bi bi-calendar-check me-2"></i>Moje rezerwacje</h4>
    </x-slot>

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <p class="text-muted mb-0">Lista Twoich rezerwacji</p>
            <a href="{{ route('booking.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i>Nowa rezerwacja
            </a>
        </div>

        @if($bookings->count() > 0)
            @foreach($bookings as $booking)
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h5 class="mb-1">Rezerwacja #{{ $booking->id }}</h5>
                                <p class="text-muted mb-1">
                                    <i class="bi bi-building me-1"></i>{{ $booking->rental->name ?? 'Nieznana wypożyczalnia' }}
                                </p>
                                <p class="mb-0">
                                    <i class="bi bi-calendar me-1"></i>
                                    {{ $booking->start_date ? $booking->start_date->format('d.m.Y') : 'N/A' }} - 
                                    {{ $booking->end_date ? $booking->end_date->format('d.m.Y') : 'N/A' }}
                                </p>
                            </div>
                            <div class="col-md-3 text-md-center my-3 my-md-0">
                                @php
                                    $statusClasses = [
                                        'pending' => 'bg-warning text-dark',
                                        'confirmed' => 'bg-success',
                                        'paid' => 'bg-primary',
                                        'completed' => 'bg-secondary',
                                        'cancelled' => 'bg-danger',
                                    ];
                                    $statusLabels = [
                                        'pending' => 'Oczekująca',
                                        'confirmed' => 'Potwierdzona',
                                        'paid' => 'Opłacona',
                                        'completed' => 'Zakończona',
                                        'cancelled' => 'Anulowana',
                                    ];
                                @endphp
                                <span class="badge {{ $statusClasses[$booking->status] ?? 'bg-secondary' }} fs-6">
                                    {{ $statusLabels[$booking->status] ?? ucfirst($booking->status) }}
                                </span>
                            </div>
                            <div class="col-md-3 text-md-end">
                                <h4 class="text-primary mb-0">{{ number_format($booking->total_amount, 2) }} zł</h4>
                            </div>
                        </div>

                        @if($booking->items && $booking->items->count() > 0)
                            <hr>
                            <div class="row">
                                @foreach($booking->items as $item)
                                    <div class="col-md-6 col-lg-4 mb-2">
                                        <div class="d-flex justify-content-between align-items-center bg-light p-2 rounded">
                                            <span>
                                                <i class="bi bi-box-seam text-primary me-1"></i>
                                                {{ $item->product->name ?? 'Produkt usunięty' }} 
                                                <span class="text-muted">x{{ $item->quantity }}</span>
                                            </span>
                                            <span class="text-muted">
                                                {{ number_format(($item->price_per_day ?? 0) * ($item->quantity ?? 1) * ($item->days ?? 1), 2) }} zł
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach

            <div class="d-flex justify-content-center mt-4">
                {{ $bookings->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div class="card shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="bi bi-calendar-x text-muted" style="font-size: 4rem;"></i>
                    <h4 class="mt-3">Brak rezerwacji</h4>
                    <p class="text-muted">Nie masz jeszcze żadnych rezerwacji.</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary">
                        <i class="bi bi-search me-1"></i>Przeglądaj katalog
                    </a>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
