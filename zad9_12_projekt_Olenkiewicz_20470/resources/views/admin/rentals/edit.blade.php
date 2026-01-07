@extends('layouts.app')

@section('title', 'Edytuj wypożyczalnię')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('admin.rentals.index') }}" class="btn btn-outline-secondary me-3">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <div>
                    <h1 class="h3 mb-0">Edytuj wypożyczalnię</h1>
                    <p class="text-muted mb-0">{{ $rental->name }}</p>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('admin.rentals.update', $rental) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Nazwa wypożyczalni <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $rental->name) }}" 
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="owner_id" class="form-label">Właściciel</label>
                            <select class="form-select @error('owner_id') is-invalid @enderror" 
                                    id="owner_id" 
                                    name="owner_id">
                                <option value="">-- Wybierz właściciela --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('owner_id', $rental->owner_id) == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('owner_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Użytkownik, który będzie zarządzał wypożyczalnią</div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Telefon</label>
                                <input type="tel" 
                                       class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" 
                                       name="phone" 
                                       value="{{ old('phone', $rental->phone) }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', $rental->email) }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Adres</label>
                            <textarea class="form-control @error('address') is-invalid @enderror" 
                                      id="address" 
                                      name="address" 
                                      rows="2">{{ old('address', $rental->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Opis</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="4">{{ old('description', $rental->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="is_active" 
                                       name="is_active" 
                                       value="1" 
                                       {{ old('is_active', $rental->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Wypożyczalnia aktywna
                                </label>
                            </div>
                            <div class="form-text">Nieaktywne wypożyczalnie nie są widoczne dla klientów</div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.rentals.index') }}" class="btn btn-outline-secondary">
                                Anuluj
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg me-1"></i>Zapisz zmiany
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Danger Zone -->
            <div class="card border-danger mt-4">
                <div class="card-header bg-danger text-white">
                    <i class="bi bi-exclamation-triangle me-2"></i>Strefa niebezpieczna
                </div>
                <div class="card-body">
                    <p class="mb-3">Usunięcie wypożyczalni spowoduje usunięcie wszystkich powiązanych produktów, rezerwacji i płatności.</p>
                    <form action="{{ route('admin.rentals.destroy', $rental) }}" 
                          method="POST" 
                          onsubmit="return confirm('Czy na pewno chcesz usunąć tę wypożyczalnię? Ta operacja jest nieodwracalna!')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash me-1"></i>Usuń wypożyczalnię
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
