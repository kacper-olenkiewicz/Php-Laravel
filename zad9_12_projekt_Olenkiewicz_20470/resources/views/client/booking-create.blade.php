<x-app-layout>
    <x-slot name="header">
        <h4 class="mb-0"><i class="bi bi-calendar-plus me-2"></i>Nowa rezerwacja</h4>
    </x-slot>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Formularz rezerwacji</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('booking.store') }}">
                            @csrf

                            <!-- Wybór produktu -->
                            <div class="mb-3">
                                <label for="product_id" class="form-label">Produkt <span class="text-danger">*</span></label>
                                @if($selectedProduct)
                                    <input type="hidden" name="product_id" value="{{ $selectedProduct->id }}">
                                    <div class="alert alert-info">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong>{{ $selectedProduct->name }}</strong>
                                                <p class="mb-0 small text-muted">{{ Str::limit($selectedProduct->description, 100) }}</p>
                                            </div>
                                            <div class="text-end">
                                                <span class="h5 text-primary">{{ number_format($selectedProduct->daily_price, 2) }} zł/dzień</span>
                                                <br>
                                                <small class="text-muted">Dostępne: {{ $selectedProduct->stock_quantity }} szt.</small>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="{{ route('booking.create') }}" class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-arrow-left me-1"></i>Zmień produkt
                                    </a>
                                @else
                                    <select class="form-select @error('product_id') is-invalid @enderror" 
                                            id="product_id" 
                                            name="product_id" 
                                            required>
                                        <option value="">-- Wybierz produkt --</option>
                                        @php
                                            $products = \App\Models\Product::where('stock_quantity', '>', 0)->orderBy('name')->get();
                                        @endphp
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                                {{ $product->name }} - {{ number_format($product->daily_price, 2) }} zł/dzień (dost. {{ $product->stock_quantity }} szt.)
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('product_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                @endif
                            </div>

                            <div class="row">
                                <!-- Data rozpoczęcia -->
                                <div class="col-md-6 mb-3">
                                    <label for="start_date" class="form-label">Data rozpoczęcia <span class="text-danger">*</span></label>
                                    <input type="date" 
                                           class="form-control @error('start_date') is-invalid @enderror" 
                                           id="start_date" 
                                           name="start_date" 
                                           value="{{ old('start_date', date('Y-m-d')) }}"
                                           min="{{ date('Y-m-d') }}"
                                           required>
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Data zakończenia -->
                                <div class="col-md-6 mb-3">
                                    <label for="end_date" class="form-label">Data zakończenia <span class="text-danger">*</span></label>
                                    <input type="date" 
                                           class="form-control @error('end_date') is-invalid @enderror" 
                                           id="end_date" 
                                           name="end_date" 
                                           value="{{ old('end_date', date('Y-m-d', strtotime('+1 day'))) }}"
                                           min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                           required>
                                    @error('end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Ilość -->
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Ilość <span class="text-danger">*</span></label>
                                <input type="number" 
                                       class="form-control @error('quantity') is-invalid @enderror" 
                                       id="quantity" 
                                       name="quantity" 
                                       value="{{ old('quantity', 1) }}"
                                       min="1" 
                                       max="{{ $selectedProduct->stock_quantity ?? 10 }}"
                                       required>
                                @error('quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Uwagi -->
                            <div class="mb-4">
                                <label for="notes" class="form-label">Uwagi (opcjonalnie)</label>
                                <textarea class="form-control @error('notes') is-invalid @enderror" 
                                          id="notes" 
                                          name="notes" 
                                          rows="3"
                                          placeholder="Dodatkowe informacje...">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <hr>

                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left me-1"></i>Powrót do katalogu
                                </a>
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-calendar-check me-1"></i>Zarezerwuj
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
