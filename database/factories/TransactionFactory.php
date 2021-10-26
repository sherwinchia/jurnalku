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
        $statuses = ['Pending', 'Success', 'Fail', 'Cancelled'];
        return [
            'user_id' => $this->faker->numberBetween(2, 100),
            'package_id' => $this->faker->numberBetween(1, 50),
            'status' => $statuses[array_rand($statuses, 1)],
            'promo_code_id' => $this->faker->numberBetween(1, 2),
            'gross_total' => $gross_total,
            'discount' => $discount,
            'net_total' => $gross_total - $discount
        ];
    }
}
