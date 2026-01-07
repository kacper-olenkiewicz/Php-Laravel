<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="bi bi-box-seam me-2"></i>Produkty</h4>
            <a href="{{ route('rental.products.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i>Dodaj produkt
            </a>
        </div>
    </x-slot>

    <div class="container">
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Zdjęcie</th>
                                <th>Nazwa</th>
                                <th>Kategorie</th>
                                <th>Cena/dzień</th>
                                <th>Stan magazynowy</th>
                                <th class="text-end">Akcje</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                                <tr>
                                    <td>
                                        <img src="{{ $product->preview_image_url }}" 
                                             alt="{{ $product->name }}" 
                                             class="rounded"
                                             style="width: 50px; height: 50px; object-fit: cover;">
                                    </td>
                                    <td>
                                        <strong>{{ $product->name }}</strong>
                                        @if($product->description)
                                            <br><small class="text-muted">{{ Str::limit($product->description, 50) }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @foreach($product->categories->take(2) as $category)
                                            <span class="badge bg-light text-dark">{{ $category->name }}</span>
                                        @endforeach
                                        @if($product->categories->count() > 2)
                                            <span class="badge bg-secondary">+{{ $product->categories->count() - 2 }}</span>
                                        @endif
                                    </td>
                                    <td>{{ number_format($product->daily_price, 2) }} zł</td>
                                    <td>
                                        @if($product->stock_quantity > 5)
                                            <span class="badge bg-success">{{ $product->stock_quantity }} szt.</span>
                                        @elseif($product->stock_quantity > 0)
                                            <span class="badge bg-warning text-dark">{{ $product->stock_quantity }} szt.</span>
                                        @else
                                            <span class="badge bg-danger">Brak</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('rental.products.edit', $product) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('rental.products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('Czy na pewno chcesz usunąć ten produkt?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                                        <p class="mt-2 mb-0">Brak produktów</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $products->links('pagination::bootstrap-5') }}
        </div>
    </div>
</x-app-layout>
