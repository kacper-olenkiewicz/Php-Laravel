<x-app-layout>
    <x-slot name="header">
        <h4 class="mb-0"><i class="bi bi-calendar-event me-2"></i>Rezerwacje</h4>
    </x-slot>

    <div class="container">
        <!-- Filtry -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('rental.bookings.index') }}" class="row g-3">
                    <div class="col-md-4">
                        <label for="search" class="form-label">Szukaj klienta</label>
                        <input type="text" class="form-control" id="search" name="search" 
                               value="{{ request('search') }}" placeholder="Imię lub email...">
                    </div>
                    <div class="col-md-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">Wszystkie</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Oczekujące</option>
                            <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Potwierdzone</option>
                            <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Opłacone</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Zakończone</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Anulowane</option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-search me-1"></i>Filtruj
                        </button>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <a href="{{ route('rental.bookings.index') }}" class="btn btn-outline-secondary w-100">
                            Wyczyść
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabela rezerwacji -->
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Klient</th>
                                <th>Termin</th>
                                <th>Produkty</th>
                                <th>Status</th>
                                <th>Kwota</th>
                                <th class="text-end">Akcje</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bookings as $booking)
                                <tr>
                                    <td>
                                        <a href="{{ route('rental.bookings.show', $booking) }}" class="text-decoration-none fw-bold">
                                            #{{ $booking->id }}
                                        </a>
                                    </td>
                                    <td>
                                        {{ $booking->user->name ?? 'Nieznany' }}
                                        <br><small class="text-muted">{{ $booking->user->email ?? '' }}</small>
                                    </td>
                                    <td>
                                        {{ $booking->start_date ? $booking->start_date->format('d.m.Y') : 'N/A' }}
                                        <br>{{ $booking->end_date ? $booking->end_date->format('d.m.Y') : 'N/A' }}
                                    </td>
                                    <td>
                                        @foreach($booking->items->take(2) as $item)
                                            <span class="badge bg-light text-dark">{{ $item->product->name ?? 'N/A' }}</span>
                                        @endforeach
                                        @if($booking->items->count() > 2)
                                            <span class="badge bg-secondary">+{{ $booking->items->count() - 2 }}</span>
                                        @endif
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
                                    <td class="fw-bold">{{ number_format($booking->total_amount, 2) }} zł</td>
                                    <td class="text-end">
                                        <a href="{{ route('rental.bookings.show', $booking) }}" class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('rental.bookings.edit', $booking) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        <i class="bi bi-calendar-x" style="font-size: 2rem;"></i>
                                        <p class="mt-2 mb-0">Brak rezerwacji</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $bookings->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
    </div>
</x-app-layout>
