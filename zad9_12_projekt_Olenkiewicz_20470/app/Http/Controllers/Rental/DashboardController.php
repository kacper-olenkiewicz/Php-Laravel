<?php
namespace App\Http\Controllers\Rental;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Product;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Wartości są automatycznie scope'owane do bieżącego Rentala

        // Rezerwacje w ostatnich 30 dniach
        $last30Days = Carbon::now()->subDays(30);

        $totalBookings = Booking::count();
        $pendingBookings = Booking::where('status', 'pending')->count();
        $recentRevenue = Booking::where('status', 'paid')
                                ->where('updated_at', '>=', $last30Days)
                                ->sum('total_amount');

        $totalProducts = Product::sum('stock_quantity');

        // Wykres: Rezerwacje wg statusu
        $bookingsByStatus = Booking::select('status', DB::raw('count(*) as count'))
                                   ->groupBy('status')
                                   ->get();

        return view('rental.dashboard', compact(
            'totalBookings',
            'pendingBookings',
            'recentRevenue',
            'totalProducts',
            'bookingsByStatus'
        ));
    }
}