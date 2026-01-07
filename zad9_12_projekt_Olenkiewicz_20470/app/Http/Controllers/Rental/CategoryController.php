<?php
namespace App\Http\Controllers\Rental;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Wyświetla listę kategorii (automatycznie scope'owanych)
    public function index()
    {
        $categories = Category::orderBy('name')->paginate(10);
        return view('rental.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('rental.categories.create');
    }

    // Tworzy nową kategorię. rental_id jest ustawiane przez model
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Category::create($validated);
        return redirect()->route('rental.categories.index')->with('success', 'Kategoria dodana pomyślnie.');
    }

    public function edit(Category $category)
    {
        // Gate automatycznie sprawdzi, czy kategoria należy do bieżącego Rentala
        return view('rental.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category->update($validated);
        return redirect()->route('rental.categories.index')->with('success', 'Kategoria zaktualizowana.');
    }

    public function destroy(Category $category)
    {
        // Sprawdź, czy są jakieś produkty w tej kategorii
        if ($category->products()->exists()) {
            return back()->with('error', 'Nie można usunąć kategorii, która ma przypisane produkty.');
        }

        $category->delete();
        return redirect()->route('rental.categories.index')->with('success', 'Kategoria usunięta.');
    }
}