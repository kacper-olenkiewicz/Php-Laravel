<?php
namespace App\Http\Controllers\Rental;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        // Auto-scoping
        $products = Product::with('categories')->orderBy('name')->paginate(10); 
        return view('rental.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('rental.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'daily_price' => 'required|numeric|min:0.01',
            'stock_quantity' => 'required|integer|min:0',
            'category_ids' => 'array',
            'image_url' => 'nullable|url|max:2048',
        ]);

        if (! empty($validated['image_url'])) {
            $validated['image_path'] = $validated['image_url'];
        }

        unset($validated['image_url']);

        // rental_id zostanie automatycznie ustawione przez HasRentalScope
        $product = Product::create($validated);
        $product->categories()->sync($validated['category_ids'] ?? []);

        return redirect()->route('rental.products.index')->with('success', 'Produkt dodany pomyślnie.');
    }

    public function edit(Product $product)
    {
        // Auto-scoping zapewnia, że tylko produkty Rentala są dostępne
        $categories = Category::all();
        return view('rental.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'daily_price' => 'required|numeric|min:0.01',
            'stock_quantity' => 'required|integer|min:0',
            'category_ids' => 'array',
            'image_url' => 'nullable|url|max:2048',
        ]);

        if (! empty($validated['image_url'])) {
            if ($product->image_path && ! filter_var($product->image_path, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($product->image_path);
            }
            $validated['image_path'] = $validated['image_url'];
        }

        unset($validated['image_url']);

        $product->update($validated);
        $product->categories()->sync($validated['category_ids'] ?? []);

        return redirect()->route('rental.products.index')->with('success', 'Produkt zaktualizowany.');
    }

    public function destroy(Product $product)
    {
        // Sprawdź, czy produkt ma aktywne lub oczekujące rezerwacje
        if ($product->bookingItems()->whereHas('booking', fn($q) => $q->whereIn('status', ['pending', 'confirmed']))->exists()) {
            return back()->with('error', 'Nie można usunąć produktu, który ma aktywne rezerwacje.');
        }

        // Usuń zdjęcie
        if ($product->image_path && ! filter_var($product->image_path, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete($product->image_path);
        }

        $product->delete();
        return redirect()->route('rental.products.index')->with('success', 'Produkt usunięty.');
    }
}