<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RentalController extends Controller
{
    public function index()
    {
        $rentals = Rental::with('owner')
            ->withCount(['products', 'bookings'])
            ->paginate(10);
        return view('admin.rentals.index', compact('rentals'));
    }

    public function create()
    {
        return view('admin.rentals.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:rentals,name',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'owner_name' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            // 1. Stwórz nowy Rental
            $rental = Rental::create(['name' => $validated['name']]);

            // 2. Stwórz właściciela Rentala
            $owner = User::create([
                'name' => $validated['owner_name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'rental_id' => $rental->id, // Przypisz do nowo utworzonego Rentala
            ]);

            // 3. Przypisz mu rolę RentalOwner
            $owner->assignRole('RentalOwner');

            // 4. Ustaw ID właściciela w tabeli Rentala
            $rental->update(['owner_id' => $owner->id]);

            DB::commit();

            return redirect()->route('admin.rentals.index')->with('success', 'Nowa wypożyczalnia i jej właściciel dodani pomyślnie.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Błąd podczas tworzenia wypożyczalni: ' . $e->getMessage());
        }
    }

    public function show(Rental $rental)
    {
        $rental->load(['owner', 'products', 'categories', 'bookings']);
        
        $stats = [
            'totalProducts' => $rental->products()->count(),
            'totalCategories' => $rental->categories()->count(),
            'totalBookings' => $rental->bookings()->count(),
            'totalRevenue' => $rental->bookings()->where('status', 'paid')->sum('total_amount'),
        ];
        
        return view('admin.rentals.show', compact('rental', 'stats'));
    }

    public function edit(Rental $rental)
    {
        $rental->load('owner');
        return view('admin.rentals.edit', compact('rental'));
    }

    public function update(Request $request, Rental $rental)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:rentals,name,' . $rental->id,
            'owner_name' => 'nullable|string|max:255',
            'owner_email' => 'nullable|email|unique:users,email,' . ($rental->owner->id ?? 'null'),
        ]);

        DB::beginTransaction();
        try {
            $rental->update(['name' => $validated['name']]);
            
            // Zaktualizuj dane właściciela jeśli podano
            if ($rental->owner && ($validated['owner_name'] || $validated['owner_email'])) {
                $ownerData = [];
                if ($validated['owner_name']) {
                    $ownerData['name'] = $validated['owner_name'];
                }
                if ($validated['owner_email']) {
                    $ownerData['email'] = $validated['owner_email'];
                }
                if (!empty($ownerData)) {
                    $rental->owner->update($ownerData);
                }
            }

            DB::commit();

            return redirect()->route('admin.rentals.index')->with('success', 'Wypożyczalnia zaktualizowana pomyślnie.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Błąd podczas aktualizacji wypożyczalni: ' . $e->getMessage());
        }
    }

    public function destroy(Rental $rental)
    {
        // Sprawdź czy są aktywne rezerwacje
        if ($rental->bookings()->whereIn('status', ['pending', 'confirmed'])->exists()) {
            return back()->with('error', 'Nie można usunąć wypożyczalni z aktywnymi rezerwacjami.');
        }

        DB::beginTransaction();
        try {
            // Usuń powiązanych użytkowników (pracowników) i produkty
            $rental->products()->delete();
            $rental->categories()->delete();
            
            // Usuń właściciela
            if ($rental->owner) {
                $rental->owner->delete();
            }
            
            // Usuń użytkowników przypisanych do tej wypożyczalni (pracownicy)
            User::where('rental_id', $rental->id)->delete();
            
            $rental->delete();
            
            DB::commit();

            return redirect()->route('admin.rentals.index')->with('success', 'Wypożyczalnia usunięta pomyślnie.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Błąd podczas usuwania wypożyczalni: ' . $e->getMessage());
        }
    }
}