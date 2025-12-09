<?php
namespace Database\Factories;
use App\Models\Booking;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    protected $model = Booking::class;
    
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('-1 month', '+3 months');
        $endDate = $this->faker->dateTimeBetween($startDate, $startDate->format('Y-m-d') . '+10 days');
        
        
        $customer = User::whereDoesntHave('rental')->inRandomOrder()->first();

        return [
            'rental_id' => Rental::inRandomOrder()->first()->id ?? Rental::factory(),
            'user_id' => $customer->id ?? User::factory()->create()->assignRole('Customer')->id,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => $this->faker->randomElement(['pending', 'confirmed', 'completed', 'cancelled', 'paid']),
            'total_amount' => 0.00, 
        ];
    }
}