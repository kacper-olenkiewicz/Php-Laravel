<x-app-layout>
    <x-slot name="header">
        <h4 class="mb-0"><i class="bi bi-pencil me-2"></i>Edytuj produkt</h4>
    </x-slot>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <form method="POST" action="{{ route('rental.products.update', $product) }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="name" class="form-label">Nazwa produktu <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $product->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Opis</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" name="description" rows="3">{{ old('description', $product->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="daily_price" class="form-label">Cena za dzień (zł) <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" min="0.01" 
                                           class="form-control @error('daily_price') is-invalid @enderror" 
                                           id="daily_price" name="daily_price" value="{{ old('daily_price', $product->daily_price) }}" required>
                                    @error('daily_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="stock_quantity" class="form-label">Stan magazynowy <span class="text-danger">*</span></label>
                                    <input type="number" min="0" 
                                           class="form-control @error('stock_quantity') is-invalid @enderror" 
                                           id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" required>
                                    @error('stock_quantity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Kategorie</label>
                                <div class="row">
                                    @php $productCategoryIds = $product->categories->pluck('id')->toArray(); @endphp
                                    @foreach($categories as $category)
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" 
                                                       name="category_ids[]" value="{{ $category->id }}" 
                                                       id="cat{{ $category->id }}"
                                                       {{ in_array($category->id, old('category_ids', $productCategoryIds)) ? 'checked' : '' }}>
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
                                <div class="mb-2">
                                    <img src="{{ $product->preview_image_url }}" 
                                         alt="{{ $product->name }}" class="rounded" style="max-height: 100px;">
                                    <small class="text-muted d-block">Obecne zdjęcie</small>
                                </div>
                                <div class="mb-3">
                                    <label for="image_url" class="form-label">Link do zdjęcia</label>
                                    <input type="url" class="form-control @error('image_url') is-invalid @enderror"
                                           id="image_url" name="image_url"
                                           value="{{ old('image_url', filter_var($product->image_path, FILTER_VALIDATE_URL) ? $product->image_path : '') }}"
                                           placeholder="https://example.com/zdjecie.jpg">
                                    <small class="text-muted">Podaj adres URL nowego zdjęcia (pozostaw puste, aby nic nie zmieniać).</small>
                                    @error('image_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <hr>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('rental.products.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left me-1"></i>Anuluj
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
