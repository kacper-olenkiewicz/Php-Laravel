<?php
namespace Database\Factories;
use App\Models\BookingItem;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingItemFactory extends Factory
{
    protected $model = BookingItem::class;
    
    public function definition(): array
    {
        
        $product = Product::inRandomOrder()->first();
        
        return [
            
            'product_id' => $product->id ?? Product::factory(),
            'quantity' => $this->faker->numberBetween(1, 5),
            'price_per_day' => $product->daily_price ?? $this->faker->randomFloat(2, 15, 150),
            'days' => $this->faker->numberBetween(1, 10),
        ];
    }
}