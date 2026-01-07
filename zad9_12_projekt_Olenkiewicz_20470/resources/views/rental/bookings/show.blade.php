<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="bi bi-calendar-check me-2"></i>Rezerwacja #{{ $booking->id }}</h4>
            <a href="{{ route('rental.bookings.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i>Powrót
            </a>
        </div>
    </x-slot>

    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <!-- Szczegóły rezerwacji -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Szczegóły rezerwacji</h5>
                        @php
                            $statusClasses = [
                                'pending' => 'bg-warning text-dark',
                                'confirmed' => 'bg-success',
                                'paid' => 'bg-primary',
                                'completed' => 'bg-secondary',
                                'cancelled' => 'bg-danger',
                            ];
                        @endphp
                        <span class="badge {{ $statusClasses[$booking->status] ?? 'bg-secondary' }} fs-6">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h6 class="text-muted mb-2">Klient</h6>
                                <p class="mb-0 fw-bold">{{ $booking->user->name ?? 'Nieznany' }}</p>
                                <p class="text-muted mb-0">{{ $booking->user->email ?? 'Brak email' }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-muted mb-2">Termin wypożyczenia</h6>
                                <p class="mb-0">
                                    <i class="bi bi-calendar me-1"></i>
                                    {{ $booking->start_date ? $booking->start_date->format('d.m.Y') : 'N/A' }} - 
                                    {{ $booking->end_date ? $booking->end_date->format('d.m.Y') : 'N/A' }}
                                    @if($booking->start_date && $booking->end_date)
                                        <span class="text-muted">({{ $booking->start_date->diffInDays($booking->end_date) }} dni)</span>
                                    @endif
                                </p>
                            </div>
                        </div>

                        <h6 class="text-muted mb-3">Zarezerwowane produkty</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Produkt</th>
                                        <th>Ilość</th>
                                        <th>Cena/dzień</th>
                                        <th class="text-end">Suma</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($booking->items as $item)
                                        <tr>
                                            <td>{{ $item->product->name ?? 'Usunięty produkt' }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>{{ number_format($item->price_per_day ?? 0, 2) }} zł</td>
                                            <td class="text-end">
                                                {{ number_format(($item->price_per_day ?? 0) * ($item->quantity ?? 1) * ($item->days ?? 1), 2) }} zł
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <td colspan="3" class="text-end fw-bold">Razem:</td>
                                        <td class="text-end fw-bold text-primary fs-5">
                                            {{ number_format($booking->total_amount, 2) }} zł
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        @if($booking->notes)
                            <div class="alert alert-info mt-3">
                                <h6 class="alert-heading"><i class="bi bi-sticky me-1"></i>Uwagi</h6>
                                <p class="mb-0">{{ $booking->notes }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Akcje -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="bi bi-gear me-2"></i>Akcje</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('rental.bookings.edit', $booking) }}" class="btn btn-primary">
                                <i class="bi bi-pencil me-1"></i>Edytuj rezerwację
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Płatność -->
                @if($booking->payment)
                    <div class="card shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0"><i class="bi bi-credit-card me-2"></i>Płatność</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Kwota:</strong> {{ number_format($booking->payment->amount, 2) }} zł</p>
                            <p><strong>Metoda:</strong> {{ ucfirst($booking->payment->method) }}</p>
                            <p><strong>Status:</strong> 
                                @if($booking->payment->status === 'completed')
                                    <span class="badge bg-success">Opłacona</span>
                                @else
                                    <span class="badge bg-warning text-dark">Oczekuje</span>
                                @endif
                            </p>
                            @if($booking->payment->paid_at)
                                <p><strong>Data płatności:</strong> {{ $booking->payment->paid_at->format('d.m.Y H:i') }}</p>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
