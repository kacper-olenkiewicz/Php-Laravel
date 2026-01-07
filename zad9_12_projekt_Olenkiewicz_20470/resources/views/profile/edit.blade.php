<x-app-layout>
    <x-slot name="header">
        <h4 class="mb-0"><i class="bi bi-person-circle me-2"></i>Mój profil</h4>
    </x-slot>

    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <!-- Aktualizacja danych profilu -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="bi bi-person me-2"></i>Informacje o profilu</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-4">Zaktualizuj swoje dane osobowe i adres email.</p>
                        
                        <form method="POST" action="{{ route('profile.update') }}">
                            @csrf
                            @method('PATCH')

                            <div class="mb-3">
                                <label for="name" class="form-label">Imię i nazwisko</label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $user->name) }}" 
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', $user->email) }}" 
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg me-1"></i>Zapisz zmiany
                            </button>

                            @if (session('status') === 'profile-updated')
                                <span class="text-success ms-3">
                                    <i class="bi bi-check-circle me-1"></i>Zapisano
                                </span>
                            @endif
                        </form>
                    </div>
                </div>

                <!-- Zmiana hasła -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="bi bi-key me-2"></i>Zmiana hasła</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-4">Upewnij się, że używasz silnego, bezpiecznego hasła.</p>
                        
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="current_password" class="form-label">Obecne hasło</label>
                                <input type="password" 
                                       class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" 
                                       id="current_password" 
                                       name="current_password" 
                                       required>
                                @error('current_password', 'updatePassword')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Nowe hasło</label>
                                <input type="password" 
                                       class="form-control @error('password', 'updatePassword') is-invalid @enderror" 
                                       id="password" 
                                       name="password" 
                                       required>
                                @error('password', 'updatePassword')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Potwierdź nowe hasło</label>
                                <input type="password" 
                                       class="form-control" 
                                       id="password_confirmation" 
                                       name="password_confirmation" 
                                       required>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-key me-1"></i>Zmień hasło
                            </button>

                            @if (session('status') === 'password-updated')
                                <span class="text-success ms-3">
                                    <i class="bi bi-check-circle me-1"></i>Hasło zmienione
                                </span>
                            @endif
                        </form>
                    </div>
                </div>

                <!-- Usunięcie konta -->
                <div class="card shadow-sm border-danger">
                    <div class="card-header bg-white">
                        <h5 class="mb-0 text-danger"><i class="bi bi-exclamation-triangle me-2"></i>Usuń konto</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-4">Po usunięciu konta wszystkie dane zostaną trwale usunięte. Ta akcja jest nieodwracalna.</p>
                        
                        <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Czy na pewno chcesz usunąć swoje konto? Ta akcja jest nieodwracalna.')">
                            @csrf
                            @method('DELETE')

                            <div class="mb-3">
                                <label for="delete_password" class="form-label">Potwierdź hasło</label>
                                <input type="password" 
                                       class="form-control @error('password', 'userDeletion') is-invalid @enderror" 
                                       id="delete_password" 
                                       name="password" 
                                       required>
                                @error('password', 'userDeletion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-trash me-1"></i>Usuń konto
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
