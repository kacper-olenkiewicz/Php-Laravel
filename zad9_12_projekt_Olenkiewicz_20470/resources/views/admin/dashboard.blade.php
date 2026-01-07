<x-app-layout>
    <x-slot name="header">
        <h4 class="mb-0"><i class="bi bi-speedometer2 me-2"></i>Panel administratora</h4>
    </x-slot>

    <div class="container">
        <!-- Statystyki -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card bg-primary text-white shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white-50 mb-1">Wypożyczalnie</h6>
                                <h2 class="mb-0">{{ $totalRentals ?? 0 }}</h2>
                            </div>
                            <i class="bi bi-buildings" style="font-size: 2.5rem; opacity: 0.5;"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card bg-success text-white shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white-50 mb-1">Klienci</h6>
                                <h2 class="mb-0">{{ $totalCustomers ?? 0 }}</h2>
                            </div>
                            <i class="bi bi-people" style="font-size: 2.5rem; opacity: 0.5;"></i>
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
                <div class="card bg-warning text-dark shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-dark-50 mb-1">Przychód</h6>
                                <h2 class="mb-0">{{ number_format($recentGlobalRevenue ?? 0, 0) }} zł</h2>
                            </div>
                            <i class="bi bi-currency-dollar" style="font-size: 2.5rem; opacity: 0.5;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Top wypożyczalnie -->
            <div class="col-lg-8 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-trophy me-2"></i>Najlepsze wypożyczalnie</h5>
                        <a href="{{ route('admin.rentals.index') }}" class="btn btn-sm btn-outline-primary">
                            Zobacz wszystkie
                        </a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nazwa</th>
                                        <th class="text-end">Przychód (30 dni)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($topRentalsByRevenue ?? [] as $rental)
                                        <tr>
                                            <td>
                                                <a href="{{ route('admin.rentals.show', $rental->id) }}" class="text-decoration-none">
                                                    <i class="bi bi-building me-1"></i>{{ $rental->name }}
                                                </a>
                                            </td>
                                            <td class="text-end fw-bold text-success">
                                                {{ number_format($rental->total_revenue ?? 0, 2) }} zł
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-muted py-4">
                                                Brak danych
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Najnowsi klienci -->
            <div class="col-lg-4 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-people me-2"></i>Najnowsi klienci</h5>
                        <span class="badge bg-light text-primary">{{ $totalCustomers }}</span>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            @forelse($recentClients ?? [] as $client)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $client->name }}</strong>
                                        <div class="text-muted small">{{ $client->email }}</div>
                                    </div>
                                    <span class="badge bg-light text-dark">{{ $client->bookings_count }} rez.</span>
                                </li>
                            @empty
                                <li class="list-group-item text-center text-muted py-4">
                                    Brak klientów
                                </li>
                            @endforelse
                        </ul>
                    </div>
                    <div class="card-footer bg-white text-end">
                        <a href="{{ route('admin.clients.index') }}" class="btn btn-sm btn-outline-primary">
                            Zarządzaj klientami
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
