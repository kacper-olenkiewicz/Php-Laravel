<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="bi bi-tags me-2"></i>Kategorie</h4>
            <a href="{{ route('rental.categories.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i>Dodaj kategorię
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
                                <th>Nazwa</th>
                                <th>Opis</th>
                                <th>Produkty</th>
                                <th class="text-end">Akcje</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                                <tr>
                                    <td><strong>{{ $category->name }}</strong></td>
                                    <td class="text-muted">{{ Str::limit($category->description, 60) ?: '-' }}</td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $category->products_count ?? $category->products()->count() }}</span>
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('rental.categories.edit', $category) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('rental.categories.destroy', $category) }}" method="POST" class="d-inline" onsubmit="return confirm('Czy na pewno chcesz usunąć tę kategorię?')">
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
                                    <td colspan="4" class="text-center text-muted py-4">
                                        <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                                        <p class="mt-2 mb-0">Brak kategorii</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $categories->links('pagination::bootstrap-5') }}
        </div>
    </div>
</x-app-layout>
