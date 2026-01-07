<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;

class ClientController extends Controller
{
    public function index()
    {
        $clients = User::role('Customer')
            ->withCount('bookings')
            ->latest()
            ->paginate(10);

        return view('admin.clients.index', compact('clients'));
    }

    public function destroy(User $client): RedirectResponse
    {
        if (! $client->hasRole('Customer')) {
            return back()->with('error', 'Można usuwać wyłącznie konta klientów.');
        }

        $client->delete();

        return back()->with('success', 'Klient został usunięty.');
    }
}
