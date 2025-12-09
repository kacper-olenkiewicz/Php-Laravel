<?php
namespace Database\Factories;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;
    
    public function definition(): array
    {
        
        $customer = User::whereDoesntHave('rental')->inRandomOrder()->first();

        return [
            
            'user_id' => $customer->id ?? User::factory()->create()->assignRole('Customer')->id,
            'amount' => $this->faker->randomFloat(2, 50, 500),
            'method' => $this->faker->randomElement(['Credit Card', 'Cash', 'Transfer']),
            'transaction_id' => $this->faker->uuid(),
            'status' => $this->faker->randomElement(['completed', 'pending', 'failed']),
        ];
    }
}