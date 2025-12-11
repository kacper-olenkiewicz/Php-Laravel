<?php
namespace Database\Factories;
use App\Models\Category;
use App\Models\Rental;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;
    
    public function definition(): array
    {
        // Używamy unikalnego ID rentala, aby zapewnić, że name jest unikalne W OBRĘBIE TEGO rentala
        $rentalId = Rental::inRandomOrder()->first()->id ?? Rental::factory();
        
        return [
            'rental_id' => $rentalId,
            'name' => $this->faker->randomElement(['Narty', 'Rowery', 'Kajaki', 'Deski SUP', 'Sprzęt wspinaczkowy']) . ' ' . $this->faker->word(),
            'description' => $this->faker->sentence(10),
        ];
    }
}