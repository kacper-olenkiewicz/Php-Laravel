<x-app-layout>
    <x-slot name="header">
        <h4 class="mb-0"><i class="bi bi-people me-2"></i>Klienci</h4>
    </x-slot>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Imię i nazwisko</th>
                                <th>Email</th>
                                <th class="text-center">Rezerwacje</th>
                                <th class="text-center">Dołączył</th>
                                <th class="text-end">Akcje</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($clients as $client)
                                <tr>
                                    <td>#{{ $client->id }}</td>
                                    <td>
                                        <strong>{{ $client->name }}</strong>
                                    </td>
                                    <td>{{ $client->email }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-primary">
                                            {{ $client->bookings_count }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        {{ optional($client->created_at)->format('d.m.Y') ?? '—' }}
                                    </td>
                                    <td class="text-end">
                                        <form action="{{ route('admin.clients.destroy', $client) }}" method="POST" class="d-inline" onsubmit="return confirm('Czy na pewno chcesz usunąć tego klienta? Usuniesz także jego rezerwacje.');">
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
                                        <p class="mt-2 mb-0">Brak klientów</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $clients->links('pagination::bootstrap-5') }}
        </div>
    </div>
</x-app-layout>
