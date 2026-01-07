<x-app-layout>
    <x-slot name="header">
        <h4 class="mb-0"><i class="bi bi-pencil me-2"></i>Edytuj rezerwację #{{ $booking->id }}</h4>
    </x-slot>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <form method="POST" action="{{ route('rental.bookings.update', $booking) }}">
                            @csrf
                            @method('PUT')

                            <!-- Status -->
                            <div class="mb-3">
                                <label for="status" class="form-label">Status rezerwacji <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                    <option value="pending" {{ old('status', $booking->status) == 'pending' ? 'selected' : '' }}>Oczekująca</option>
                                    <option value="confirmed" {{ old('status', $booking->status) == 'confirmed' ? 'selected' : '' }}>Potwierdzona</option>
                                    <option value="paid" {{ old('status', $booking->status) == 'paid' ? 'selected' : '' }}>Opłacona</option>
                                    <option value="completed" {{ old('status', $booking->status) == 'completed' ? 'selected' : '' }}>Zakończona</option>
                                    <option value="cancelled" {{ old('status', $booking->status) == 'cancelled' ? 'selected' : '' }}>Anulowana</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Uwagi -->
                            <div class="mb-4">
                                <label for="notes" class="form-label">Uwagi</label>
                                <textarea class="form-control @error('notes') is-invalid @enderror" 
                                          id="notes" name="notes" rows="3">{{ old('notes', $booking->notes) }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Produkty (tylko podgląd) -->
                            <div class="mb-4">
                                <label class="form-label">Zarezerwowane produkty</label>
                                <div class="bg-light p-3 rounded">
                                    @foreach($booking->items as $item)
                                        <div class="d-flex justify-content-between py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                                            <span>{{ $item->product->name ?? 'Usunięty' }} x{{ $item->quantity }}</span>
                                            <span class="text-muted">{{ number_format(($item->price_per_day ?? 0) * ($item->quantity ?? 1), 2) }} zł/dzień</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <hr>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('rental.bookings.show', $booking) }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left me-1"></i>Powrót
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-lg me-1"></i>Zapisz zmiany
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
