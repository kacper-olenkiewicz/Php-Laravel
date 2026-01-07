<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use App\Models\User;
use App\Models\Booking;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // --- Statystyki Globalne ---
        $totalRentals = Rental::count();
        $totalCustomers = User::role('Customer')->count();
        $totalOwners = User::role('RentalOwner')->count();

        // --- Statystyki Finansowe i Rezerwacje ---
        $last30Days = Carbon::now()->subDays(30);

        // Całkowita suma opłaconych rezerwacji z ostatnich 30 dni (globalnie)
        $recentGlobalRevenue = Booking::where('status', 'paid')
                                        ->where('updated_at', '>=', $last30Days)
                                        ->sum('total_amount');

        $pendingGlobalBookings = Booking::where('status', 'pending')->count();

        // Lista top 5 Rentali z największym przychodem w ostatnim miesiącu
        $topRentalsByRevenue = Rental::select('rentals.id', 'rentals.name')
            ->join('bookings', 'rentals.id', '=', 'bookings.rental_id')
            ->where('bookings.status', 'paid')
            ->where('bookings.updated_at', '>=', $last30Days)
            ->groupBy('rentals.id', 'rentals.name')
            ->selectRaw('rentals.id, rentals.name, sum(bookings.total_amount) as total_revenue')
            ->orderByDesc('total_revenue')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalRentals',
            'totalCustomers',
            'totalOwners',
            'recentGlobalRevenue',
            'pendingGlobalBookings',
            'topRentalsByRevenue'
        ));
    }
}