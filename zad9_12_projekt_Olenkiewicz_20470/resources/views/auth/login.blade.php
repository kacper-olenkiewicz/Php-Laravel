<x-guest-layout>
    <h4 class="text-center mb-4">
        <i class="bi bi-box-arrow-in-right me-2"></i>Logowanie
    </h4>

    <!-- Session Status -->
    @if(session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
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

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label">Hasło</label>
            <input type="password" 
                   class="form-control @error('password') is-invalid @enderror" 
                   id="password" 
                   name="password" 
                   required>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="remember" name="remember">
            <label class="form-check-label" for="remember">Zapamiętaj mnie</label>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="bi bi-box-arrow-in-right me-2"></i>Zaloguj się
            </button>
        </div>

        <hr class="my-4">

        <div class="text-center">
            <a href="{{ route('password.request') }}" class="text-decoration-none">
                Zapomniałeś hasła?
            </a>
        </div>

        <div class="text-center mt-3">
            <span class="text-muted">Nie masz konta?</span>
            <a href="{{ route('register') }}" class="text-decoration-none ms-1">
                Zarejestruj się
            </a>
        </div>
    </form>
</x-guest-layout>
