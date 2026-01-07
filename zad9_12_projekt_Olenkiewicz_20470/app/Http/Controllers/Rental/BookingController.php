<?php
namespace App\Http\Controllers\Rental;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    // Lista rezerwacji dla danego Rentala (auto-scope)
    public function index(Request $request)
    {
        $query = Booking::with('user', 'items.product')
                        ->orderByDesc('created_at');

        // Filtrowanie po statusie
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Wyszukiwanie po użytkowniku
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $bookings = $query->paginate(15)->withQueryString();

        return view('rental.bookings.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        // Auto-scope pilnuje, by widzieć tylko swoje rezerwacje
        $booking->load('user', 'items.product', 'payment');
        return view('rental.bookings.show', compact('booking'));
    }

    public function edit(Booking $booking)
    {
        $booking->load('user', 'items.product', 'payment');
        return view('rental.bookings.edit', compact('booking'));
    }

    // Endpoint do zmiany statusu rezerwacji
    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,rejected,paid,cancelled',
            'notes' => 'nullable|string|max:500',
        ]);

        // Aktualizuj status i notatki
        $booking->update([
            'status' => $validated['status'],
            'notes' => $validated['notes'] ?? $booking->notes,
        ]);

        return redirect()->route('rental.bookings.index')->with('success', "Status rezerwacji nr {$booking->id} zmieniony na {$validated['status']}.");
    }
}