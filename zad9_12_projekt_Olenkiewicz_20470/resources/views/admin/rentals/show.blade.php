@extends('layouts.app')

@section('title', 'Szczegóły wypożyczalni')

@section('content')
<div class="container py-4">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('admin.rentals.index') }}" class="btn btn-outline-secondary me-3">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div class="flex-grow-1">
            <h1 class="h3 mb-0">{{ $rental->name }}</h1>
            <p class="text-muted mb-0">Szczegóły wypożyczalni</p>
        </div>
        <a href="{{ route('admin.rentals.edit', $rental) }}" class="btn btn-warning">
            <i class="bi bi-pencil me-1"></i>Edytuj
        </a>
    </div>

    <div class="row">
        <!-- Informacje podstawowe -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header">
                    <i class="bi bi-info-circle me-2"></i>Informacje podstawowe
                </div>
                <div class="card-body">
                    <dl class="mb-0">
                        <dt>Status</dt>
                        <dd>
                            @if($rental->is_active)
                                <span class="badge bg-success">Aktywna</span>
                            @else
                                <span class="badge bg-secondary">Nieaktywna</span>
                            @endif
                        </dd>

                        <dt>Właściciel</dt>
                        <dd>
                            @if($rental->owner)
                                <span class="d-flex align-items-center">
                                    <i class="bi bi-person-circle me-1"></i>
                                    {{ $rental->owner->name }}
                                </span>
                                <small class="text-muted">{{ $rental->owner->email }}</small>
                            @else
                                <span class="text-muted">Nie przypisano</span>
                            @endif
                        </dd>

                        @if($rental->phone)
                            <dt>Telefon</dt>
                            <dd>
                                <a href="tel:{{ $rental->phone }}">{{ $rental->phone }}</a>
                            </dd>
                        @endif

                        @if($rental->email)
                            <dt>Email</dt>
                            <dd>
                                <a href="mailto:{{ $rental->email }}">{{ $rental->email }}</a>
                            </dd>
                        @endif

                        @if($rental->address)
                            <dt>Adres</dt>
                            <dd>{{ $rental->address }}</dd>
                        @endif

                        <dt>Data utworzenia</dt>
                        <dd>{{ $rental->created_at->format('d.m.Y H:i') }}</dd>

                        <dt>Ostatnia aktualizacja</dt>
                        <dd>{{ $rental->updated_at->format('d.m.Y H:i') }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Statystyki -->
        <div class="col-lg-8 mb-4">
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="card bg-primary text-white shadow-sm">
                        <div class="card-body text-center">
                            <i class="bi bi-box display-5"></i>
                            <h2 class="mb-0 mt-2">{{ $rental->products->count() }}</h2>
                            <p class="mb-0">Produkty</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-success text-white shadow-sm">
                        <div class="card-body text-center">
                            <i class="bi bi-calendar-check display-5"></i>
                            <h2 class="mb-0 mt-2">{{ $rental->bookings->count() }}</h2>
                            <p class="mb-0">Rezerwacje</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-info text-white shadow-sm">
                        <div class="card-body text-center">
                            <i class="bi bi-cash display-5"></i>
                            <h2 class="mb-0 mt-2">{{ $rental->payments->count() ?? 0 }}</h2>
                            <p class="mb-0">Płatności</p>
                        </div>
                    </div>
                </div>
            </div>

            @if($rental->description)
                <div class="card shadow-sm mb-4">
                    <div class="card-header">
                        <i class="bi bi-text-paragraph me-2"></i>Opis
                    </div>
                    <div class="card-body">
                        <p class="mb-0">{{ $rental->description }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Ostatnie rezerwacje -->
    <div class="card shadow-sm mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="bi bi-calendar3 me-2"></i>Ostatnie rezerwacje</span>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Klient</th>
                        <th>Data od</th>
                        <th>Data do</th>
                        <th>Kwota</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rental->bookings->take(5) as $booking)
                        <tr>
                            <td>{{ $booking->id }}</td>
                            <td>
                                @if($booking->user)
                                    {{ $booking->user->name }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $booking->start_date ? $booking->start_date->format('d.m.Y') : '-' }}</td>
                            <td>{{ $booking->end_date ? $booking->end_date->format('d.m.Y') : '-' }}</td>
                            <td>{{ number_format($booking->total_price ?? 0, 2) }} zł</td>
                            <td>
                                @switch($booking->status)
                                    @case('pending')
                                        <span class="badge bg-warning">Oczekująca</span>
                                        @break
                                    @case('confirmed')
                                        <span class="badge bg-success">Potwierdzona</span>
                                        @break
                                    @case('cancelled')
                                        <span class="badge bg-danger">Anulowana</span>
                                        @break
                                    @case('completed')
                                        <span class="badge bg-secondary">Zakończona</span>
                                        @break
                                    @default
                                        <span class="badge bg-light text-dark">{{ $booking->status }}</span>
                                @endswitch
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                Brak rezerwacji
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Produkty -->
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="bi bi-box me-2"></i>Produkty w wypożyczalni</span>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nazwa</th>
                        <th>Kategoria</th>
                        <th>Cena/dzień</th>
                        <th>Ilość</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rental->products->take(10) as $product)
                        <tr>
                            <td>
                                <strong>{{ $product->name }}</strong>
                            </td>
                            <td>
                                @if($product->category)
                                    <span class="badge bg-secondary">{{ $product->category->name }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ number_format($product->price_per_day ?? 0, 2) }} zł</td>
                            <td>{{ $product->quantity ?? 0 }}</td>
                            <td>
                                @if($product->is_active ?? true)
                                    <span class="badge bg-success">Aktywny</span>
                                @else
                                    <span class="badge bg-secondary">Nieaktywny</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                Brak produktów
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($rental->products->count() > 10)
            <div class="card-footer text-center">
                <small class="text-muted">Wyświetlono 10 z {{ $rental->products->count() }} produktów</small>
            </div>
        @endif
    </div>
</div>
@endsection
