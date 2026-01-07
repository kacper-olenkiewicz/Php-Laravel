@extends('layouts.app')

@section('title', 'Zarządzanie wypożyczalniami')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0"><i class="bi bi-building me-2"></i>Wypożyczalnie</h1>
            <p class="text-muted mb-0">Zarządzaj wypożyczalniami w systemie</p>
        </div>
        <a href="{{ route('admin.rentals.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>Dodaj wypożyczalnię
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nazwa</th>
                            <th>Właściciel</th>
                            <th>Telefon</th>
                            <th>Adres</th>
                            <th>Status</th>
                            <th>Produkty</th>
                            <th>Rezerwacje</th>
                            <th>Utworzono</th>
                            <th class="text-end">Akcje</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rentals as $rental)
                            <tr>
                                <td>{{ $rental->id }}</td>
                                <td>
                                    <strong>{{ $rental->name }}</strong>
                                </td>
                                <td>
                                    @if($rental->owner)
                                        <span class="d-flex align-items-center">
                                            <i class="bi bi-person-circle me-1"></i>
                                            {{ $rental->owner->name }}
                                        </span>
                                        <small class="text-muted">{{ $rental->owner->email }}</small>
                                    @else
                                        <span class="text-muted">Brak</span>
                                    @endif
                                </td>
                                <td>{{ $rental->phone ?? '-' }}</td>
                                <td>
                                    @if($rental->address)
                                        <small>{{ Str::limit($rental->address, 30) }}</small>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($rental->is_active)
                                        <span class="badge bg-success">Aktywna</span>
                                    @else
                                        <span class="badge bg-secondary">Nieaktywna</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $rental->products_count ?? $rental->products->count() }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-primary">{{ $rental->bookings_count ?? $rental->bookings->count() }}</span>
                                </td>
                                <td>
                                    <small>{{ $rental->created_at->format('d.m.Y') }}</small>
                                </td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.rentals.show', $rental) }}" 
                                           class="btn btn-outline-info" title="Szczegóły">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.rentals.edit', $rental) }}" 
                                           class="btn btn-outline-warning" title="Edytuj">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.rentals.destroy', $rental) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Czy na pewno chcesz usunąć tę wypożyczalnię?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Usuń">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center py-5 text-muted">
                                    <i class="bi bi-building display-4 d-block mb-3"></i>
                                    Brak wypożyczalni w systemie
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        @if($rentals->hasPages())
            <div class="card-footer">
                {{ $rentals->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
