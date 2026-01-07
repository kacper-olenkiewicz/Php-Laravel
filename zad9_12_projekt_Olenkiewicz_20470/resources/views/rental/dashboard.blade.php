<x-app-layout>
    <x-slot name="header">
        <h4 class="mb-0"><i class="bi bi-speedometer2 me-2"></i>Panel wypożyczalni</h4>
    </x-slot>

    <div class="container">
        <!-- Statystyki -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card bg-primary text-white shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white-50 mb-1">Rezerwacje</h6>
                                <h2 class="mb-0">{{ $totalBookings ?? 0 }}</h2>
                            </div>
                            <i class="bi bi-calendar-check" style="font-size: 2.5rem; opacity: 0.5;"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card bg-warning text-dark shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-dark-50 mb-1">Oczekujące</h6>
                                <h2 class="mb-0">{{ $pendingBookings ?? 0 }}</h2>
                            </div>
                            <i class="bi bi-hourglass-split" style="font-size: 2.5rem; opacity: 0.5;"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card bg-info text-white shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white-50 mb-1">Produkty</h6>
                                <h2 class="mb-0">{{ $totalProducts ?? 0 }}</h2>
                            </div>
                            <i class="bi bi-box-seam" style="font-size: 2.5rem; opacity: 0.5;"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card bg-success text-white shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white-50 mb-1">Przychód</h6>
                                <h2 class="mb-0">{{ number_format($recentRevenue ?? 0, 0) }} zł</h2>
                            </div>
                            <i class="bi bi-currency-dollar" style="font-size: 2.5rem; opacity: 0.5;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Ostatnie rezerwacje -->
            <div class="col-lg-8 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>Ostatnie rezerwacje</h5>
                        <a href="{{ route('rental.bookings.index') }}" class="btn btn-sm btn-outline-primary">
                            Zobacz wszystkie
                        </a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Klient</th>
                                        <th>Termin</th>
                                        <th>Status</th>
                                        <th class="text-end">Kwota</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentBookings ?? [] as $booking)
                                        <tr>
                                            <td>
                                                <a href="{{ route('rental.bookings.show', $booking) }}" class="text-decoration-none">
                                                    #{{ $booking->id }}
                                                </a>
                                            </td>
                                            <td>{{ $booking->user->name ?? 'Nieznany' }}</td>
                                            <td>
                                                {{ $booking->start_date ? $booking->start_date->format('d.m') : 'N/A' }} - 
                                                {{ $booking->end_date ? $booking->end_date->format('d.m') : 'N/A' }}
                                            </td>
                                            <td>
                                                @php
                                                    $statusClasses = [
                                                        'pending' => 'bg-warning text-dark',
                                                        'confirmed' => 'bg-success',
                                                        'paid' => 'bg-primary',
                                                        'completed' => 'bg-secondary',
                                                        'cancelled' => 'bg-danger',
                                                    ];
                                                @endphp
                                                <span class="badge {{ $statusClasses[$booking->status] ?? 'bg-secondary' }}">
                                                    {{ ucfirst($booking->status) }}
                                                </span>
                                            </td>
                                            <td class="text-end fw-bold">
                                                {{ number_format($booking->total_amount, 2) }} zł
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4">
                                                Brak rezerwacji
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Szybkie akcje -->
            <div class="col-lg-4 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="bi bi-lightning me-2"></i>Szybkie akcje</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            @can('manage products')
                                <a href="{{ route('rental.products.create') }}" class="btn btn-primary">
                                    <i class="bi bi-plus-lg me-2"></i>Dodaj produkt
                                </a>
                                <a href="{{ route('rental.products.index') }}" class="btn btn-outline-primary">
                                    <i class="bi bi-box-seam me-2"></i>Zarządzaj produktami
                                </a>
                                <a href="{{ route('rental.categories.index') }}" class="btn btn-outline-primary">
                                    <i class="bi bi-tags me-2"></i>Zarządzaj kategoriami
                                </a>
                            @endcan
                            @can('manage bookings')
                                <a href="{{ route('rental.bookings.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-calendar-event me-2"></i>Rezerwacje
                                </a>
                            @endcan
                            @can('process payments')
                                <a href="{{ route('rental.payments.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-credit-card me-2"></i>Płatności
                                </a>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
