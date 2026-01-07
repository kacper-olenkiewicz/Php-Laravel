<x-app-layout>
    <x-slot name="header">
        <h4 class="mb-0"><i class="bi bi-credit-card me-2"></i>Płatności</h4>
    </x-slot>

    <div class="container">
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Rezerwacja</th>
                                <th>Klient</th>
                                <th>Kwota</th>
                                <th>Metoda</th>
                                <th>Status</th>
                                <th>Data</th>
                                <th class="text-end">Akcje</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($payments as $payment)
                                <tr>
                                    <td>#{{ $payment->id }}</td>
                                    <td>
                                        <a href="{{ route('rental.bookings.show', $payment->booking) }}" class="text-decoration-none">
                                            Rezerwacja #{{ $payment->booking_id }}
                                        </a>
                                    </td>
                                    <td>{{ $payment->booking->user->name ?? 'Nieznany' }}</td>
                                    <td class="fw-bold">{{ number_format($payment->amount, 2) }} zł</td>
                                    <td>
                                        @if($payment->method == 'cash')
                                            <i class="bi bi-cash me-1"></i>Gotówka
                                        @elseif($payment->method == 'card')
                                            <i class="bi bi-credit-card me-1"></i>Karta
                                        @else
                                            <i class="bi bi-bank me-1"></i>Przelew
                                        @endif
                                    </td>
                                    <td>
                                        @if($payment->status === 'completed')
                                            <span class="badge bg-success">Opłacona</span>
                                        @elseif($payment->status === 'pending')
                                            <span class="badge bg-warning text-dark">Oczekuje</span>
                                        @else
                                            <span class="badge bg-danger">Nieudana</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $payment->created_at ? $payment->created_at->format('d.m.Y H:i') : 'N/A' }}
                                    </td>
                                    <td class="text-end">
                                        @if($payment->status === 'pending')
                                            <form action="{{ route('rental.payments.confirm', $payment) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success">
                                                    <i class="bi bi-check-lg me-1"></i>Potwierdź
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        <i class="bi bi-wallet2" style="font-size: 2rem;"></i>
                                        <p class="mt-2 mb-0">Brak płatności</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $payments->links('pagination::bootstrap-5') }}
        </div>
    </div>
</x-app-layout>
