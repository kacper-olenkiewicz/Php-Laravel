<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rental;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use App\Models\Booking;
use App\Models\BookingItem;
use App\Models\Payment;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\RolePermissionSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(RolePermissionSeeder::class); 

        // 1. UTWÓRZ SUPER ADMINA
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'rental_id' => null,
        ]);
        $superAdmin->assignRole('SuperAdmin');

        // 2. UTWÓRZ KLIENTÓW (BEZ RENTAL_ID)
        User::factory(50)->create()->each(fn ($user) => $user->assignRole('Customer'));

        // 3. UTWÓRZ 5 RENTALI (TENANTÓW) I ICH DANE
        $rentals = Rental::factory(5)->create(); 

        $rentals->each(function (Rental $rental) {

            // Właściciel dla każdego Rentala
            $owner = User::factory()->create([
                'rental_id' => $rental->id,
                'name' => $rental->name . ' Owner',
                'email' => 'owner' . $rental->id . '@rental.com',
                'password' => Hash::make('password'),
            ]);
            $owner->assignRole('RentalOwner');

            // Pracownicy dla każdego Rentala
            User::factory(3)->create(['rental_id' => $rental->id])->each(fn ($user) => $user->assignRole('Employee'));

            // Kategorie i Produkty dla Rentala
            $categories = Category::factory(5)->create(['rental_id' => $rental->id]);

            Product::factory(30)->create(['rental_id' => $rental->id])
                ->each(function (Product $product) use ($categories) {
                    // Przypisz 1-3 losowe kategorie
                    $productCategories = $categories->random(rand(1, 3))->pluck('id');
                    $product->categories()->attach($productCategories);
                });

            // Rezerwacje dla Rentala
            Booking::factory(10)->create(['rental_id' => $rental->id])
                ->each(function (Booking $booking) use ($rental) {
                    $products = Product::where('rental_id', $rental->id)->get();

                    // Dodaj 1-3 pozycje do rezerwacji
                    $totalAmount = 0;
                    $products->random(rand(1, 3))->each(function (Product $product) use ($booking, &$totalAmount) {
                        $quantity = rand(1, 2);
                        $days = $booking->start_date->diffInDays($booking->end_date) ?: 1;

                        BookingItem::factory()->create([
                            'booking_id' => $booking->id,
                            'product_id' => $product->id,
                            'quantity' => $quantity,
                            'price_per_day' => $product->daily_price,
                            'days' => $days,
                        ]);
                        $totalAmount += ($product->daily_price * $quantity * $days);
                    });

                    // Uaktualnij total_amount
                    $booking->update(['total_amount' => $totalAmount]);

                    // Dodaj płatność
                    if ($booking->status === 'paid' || $booking->status === 'confirmed') {
                        Payment::factory()->create([
                            'booking_id' => $booking->id,
                            'user_id' => $booking->user_id,
                            'amount' => $booking->total_amount,
                            'status' => 'completed',
                        ]);
                    }
                });
        });

        $this->command->info('Database seeded successfully with 5 Tenants, users, roles, and data.');
    }
}