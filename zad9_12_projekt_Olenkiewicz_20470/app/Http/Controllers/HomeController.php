<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Rental;
use App\Models\User;
use App\Models\Booking;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Statystyki dla strony głównej
        $stats = [
            'products' => Product::count(),
            'rentals' => Rental::count(),
            'customers' => User::role('Customer')->count(),
            'bookings' => Booking::count(),
        ];

        // Kategorie dla filtrów
        $categories = Category::orderBy('name')->get();

        // Zapytanie produktów
        $query = Product::with('categories')
            ->where('stock_quantity', '>', 0);

        // Filtrowanie po nazwie
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        // Filtrowanie po kategorii
        if ($request->filled('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('categories.id', $request->category);
            });
        }

        // Sortowanie
        switch ($request->get('sort', 'name')) {
            case 'price_asc':
                $query->orderBy('daily_price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('daily_price', 'desc');
                break;
            default:
                $query->orderBy('name', 'asc');
        }

        $products = $query->paginate(12);

        return view('welcome', compact('stats', 'categories', 'products'));
    }
}
