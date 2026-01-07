<?php
namespace Database\Factories;
use App\Models\Product;
use App\Models\Rental;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;
    
    public function definition(): array
    {
        return [
            'rental_id' => Rental::inRandomOrder()->first()->id ?? Rental::factory(),
            'name' => $this->faker->randomElement(['Narty Alpine', 'Rower Górski', 'Kajak Jednoosobowy', 'Deska SUP', 'Uprząż']) . ' Rozmiar ' . $this->faker->randomLetter(),
            'description' => $this->faker->sentence(15),
            'daily_price' => $this->faker->randomFloat(2, 15, 150),
            'stock_quantity' => $this->faker->numberBetween(5, 50),
            'image_path' => Product::randomPlaceholderImage(),
            'deleted_at' => $this->faker->boolean(10) ? now() : null,
        ];
    }
}