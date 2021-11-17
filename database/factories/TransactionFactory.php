<?php

namespace Database\Factories;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $gross_total = $this->faker->numberBetween(5000, 99000);
        $discount = $this->faker->numberBetween(1000, 4000);
        return [
            'user_id' => $this->faker->numberBetween(2, 100),
            'status' => $this->faker->randomElement(['pending', 'success', 'fail', 'cancelled']),
            'promocode_id' => $this->faker->numberBetween(1, 2),
            'gross_total' => $gross_total,
            'discount' => $discount,
            'net_total' => $gross_total - $discount,
            'reference' => 'INV' . $this->faker->numberBetween(1000000, 9999999),
            'merchant_ref' => get_unique_merchant_ref()
        ];
    }
}
