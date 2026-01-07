<x-guest-layout>
    <h4 class="text-center mb-4">
        <i class="bi bi-key me-2"></i>Resetowanie hasła
    </h4>

    <p class="text-muted text-center mb-4">
        Podaj swój adres email, a wyślemy Ci link do resetowania hasła.
    </p>

    <!-- Session Status -->
    @if(session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email -->
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" 
                   class="form-control @error('email') is-invalid @enderror" 
                   id="email" 
                   name="email" 
                   value="{{ old('email') }}" 
                   required 
                   autofocus>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="bi bi-envelope me-2"></i>Wyślij link
            </button>
        </div>

        <hr class="my-4">

        <div class="text-center">
            <a href="{{ route('login') }}" class="text-decoration-none">
                <i class="bi bi-arrow-left me-1"></i>Powrót do logowania
            </a>
        </div>
    </form>
</x-guest-layout>
