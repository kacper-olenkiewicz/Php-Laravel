<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;
use App\Http\Resources\BookingResource; // Będziesz musiał stworzyć

class BookingApiController extends Controller
{
    // Logika Store jest analogiczna do BookingController@store (w Kroku 6.2)
    // Musisz przekopiować całą logikę walidacji dostępności z Client/BookingController!
    public function store(Request $request)
    {
        // Przekopiuj logikę walidacji i tworzenia z Client/BookingController@store
        // Zamiast redirect, zwróć:
        // return new BookingResource($booking);

        // ... Po udanej rezerwacji ...
        $booking = Booking::find(1); // Zastąp logiką tworzenia
        return response()->json(['message' => 'Rezerwacja złożona pomyślnie.'], 201);
    }

    public function myBookings()
    {
        $bookings = Auth::user()->bookings()->orderByDesc('created_at')->paginate(10);
        return BookingResource::collection($bookings);
    }

    // Zmiana statusu rezerwacji (dla RentalOwner/Employee)
    public function updateStatus(Request $request, Booking $booking)
    {
        // Automatyczny Tenant Scoping nie działa na API, więc sprawdzamy manualnie!
        if ($booking->rental_id !== Auth::user()->rental_id) {
            return response()->json(['error' => 'Brak dostępu do rezerwacji innego Rentala.'], 403);
        }

        $validated = $request->validate(['status' => 'required|in:confirmed,rejected,cancelled,paid']);
        $booking->update(['status' => $validated['status']]);

        return new BookingResource($booking);
    }
}