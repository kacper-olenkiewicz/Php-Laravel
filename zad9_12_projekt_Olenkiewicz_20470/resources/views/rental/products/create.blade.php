<x-app-layout>
    <x-slot name="header">
        <h4 class="mb-0"><i class="bi bi-plus-lg me-2"></i>Dodaj produkt</h4>
    </x-slot>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <form method="POST" action="{{ route('rental.products.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label">Nazwa produktu <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Opis</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" name="description" rows="3">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="daily_price" class="form-label">Cena za dzień (zł) <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" min="0.01" 
                                           class="form-control @error('daily_price') is-invalid @enderror" 
                                           id="daily_price" name="daily_price" value="{{ old('daily_price') }}" required>
                                    @error('daily_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="stock_quantity" class="form-label">Stan magazynowy <span class="text-danger">*</span></label>
                                    <input type="number" min="0" 
                                           class="form-control @error('stock_quantity') is-invalid @enderror" 
                                           id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity', 1) }}" required>
                                    @error('stock_quantity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Kategorie</label>
                                <div class="row">
                                    @foreach($categories as $category)
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" 
                                                       name="category_ids[]" value="{{ $category->id }}" 
                                                       id="cat{{ $category->id }}"
                                                       {{ in_array($category->id, old('category_ids', [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="cat{{ $category->id }}">
                                                    {{ $category->name }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="image" class="form-label">Zdjęcie produktu</label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                       id="image" name="image" accept="image/*">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <hr>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('rental.products.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left me-1"></i>Anuluj
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-lg me-1"></i>Zapisz produkt
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
