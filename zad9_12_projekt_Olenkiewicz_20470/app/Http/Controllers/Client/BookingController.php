<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Wyświetl formularz tworzenia rezerwacji
     */
    public function create(Request $request)
    {
        $productId = $request->get('product_id');
        $selectedProduct = null;
        
        if ($productId) {
            $selectedProduct = Product::find($productId);
        }
        
        return view('client.booking-create', compact('selectedProduct'));
    }

    /**
     * Zapisz nową rezerwację
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:10',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'notes' => 'nullable|string|max:500',
        ]);

        $product = Product::findOrFail($validated['product_id']);

        // Sprawdź dostępność
        if ($product->stock_quantity < $validated['quantity']) {
            return back()->withErrors(['quantity' => 'Niewystarczająca ilość produktu w magazynie.']);
        }

        // Oblicz liczbę dni i cenę
        $startDate = \Carbon\Carbon::parse($validated['start_date']);
        $endDate = \Carbon\Carbon::parse($validated['end_date']);
        $days = $startDate->diffInDays($endDate);
        $totalAmount = $product->daily_price * $validated['quantity'] * $days;

        // Utwórz rezerwację
        $booking = Booking::create([
            'user_id' => Auth::id(),
            'rental_id' => $product->rental_id,
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'status' => 'pending',
            'total_amount' => $totalAmount,
            'notes' => $validated['notes'] ?? null,
        ]);

        // Utwórz pozycję rezerwacji
        BookingItem::create([
            'booking_id' => $booking->id,
            'product_id' => $product->id,
            'quantity' => $validated['quantity'],
            'price_per_day' => $product->daily_price,
            'days' => $days,
        ]);

        return redirect()->route('booking.history')
            ->with('success', 'Rezerwacja #' . $booking->id . ' została utworzona! Oczekuje na potwierdzenie.');
    }

    /**
     * Wyświetl historię rezerwacji użytkownika
     */
    public function history()
    {
        $bookings = Booking::where('user_id', Auth::id())
            ->with(['items.product', 'rental'])
            ->latest()
            ->paginate(10);

        return view('client.booking-history', compact('bookings'));
    }
}
