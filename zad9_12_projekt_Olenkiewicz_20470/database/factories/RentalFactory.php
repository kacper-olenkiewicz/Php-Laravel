<?php
namespace Database\Factories;
use App\Models\Rental;
use Illuminate\Database\Eloquent\Factories\Factory;

class RentalFactory extends Factory
{
    protected $model = Rental::class;
    
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->company . ' Rental Pro',
            'address' => $this->faker->address,
            'is_active' => $this->faker->boolean(90),
        ];
    }
}