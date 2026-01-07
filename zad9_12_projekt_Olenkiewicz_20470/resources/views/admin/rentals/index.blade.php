<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="bi bi-buildings me-2"></i>Wypożyczalnie</h4>
        </div>
    </x-slot>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Nazwa</th>
                                <th>Właściciel</th>
                                <th>Email</th>
                                <th class="text-center">Produkty</th>
                                <th class="text-center">Rezerwacje</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rentals as $rental)
                                <tr>
                                    <td>
                                        <strong>{{ $rental->name }}</strong>
                                        <br>
                                        <small class="text-muted">ID #{{ $rental->id }}</small>
                                    </td>
                                    <td>{{ $rental->owner->name ?? 'Brak' }}</td>
                                    <td>{{ $rental->owner->email ?? '—' }}</td>
                                    <td class="text-center">{{ $rental->products_count ?? $rental->products()->count() }}</td>
                                    <td class="text-center">{{ $rental->bookings_count ?? $rental->bookings()->count() }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                                        <p class="mt-2 mb-0">Brak wypożyczalni</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $rentals->links('pagination::bootstrap-5') }}
        </div>
    </div>
</x-app-layout>
