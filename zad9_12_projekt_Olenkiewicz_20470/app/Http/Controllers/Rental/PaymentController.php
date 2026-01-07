<?php

namespace App\Http\Controllers\Rental;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Booking;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Wyświetl listę płatności
     */
    public function index()
    {
        $payments = Payment::with(['booking.user'])
            ->whereHas('booking') // Automatycznie scope'owane przez relację
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('rental.payments.index', compact('payments'));
    }

    /**
     * Potwierdź płatność
     */
    public function confirm(Payment $payment)
    {
        // Sprawdź, czy płatność nie jest już potwierdzona
        if ($payment->status === 'completed') {
            return back()->with('error', 'Ta płatność jest już potwierdzona.');
        }

        $payment->update([
            'status' => 'completed',
            'paid_at' => now(),
        ]);

        // Zaktualizuj status rezerwacji na "paid"
        $payment->booking->update(['status' => 'paid']);

        return redirect()->route('rental.payments.index')
            ->with('success', 'Płatność #' . $payment->id . ' została potwierdzona.');
    }

    /**
     * Utwórz nową płatność dla rezerwacji
     */
    public function store(Request $request, Booking $booking)
    {
        // Sprawdź, czy rezerwacja nie ma już płatności
        if ($booking->payment) {
            return back()->with('error', 'Ta rezerwacja ma już przypisaną płatność.');
        }

        $validated = $request->validate([
            'method' => 'required|in:cash,card,transfer',
        ]);

        Payment::create([
            'booking_id' => $booking->id,
            'amount' => $booking->total_amount,
            'method' => $validated['method'],
            'status' => 'pending',
        ]);

        return redirect()->route('rental.bookings.show', $booking)
            ->with('success', 'Płatność została dodana.');
    }
}

