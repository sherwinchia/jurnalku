<?php

namespace Database\Factories;

use App\Models\Trade;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class TradeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Trade::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $entry_price = $this->faker->randomFloat(1, 300, 500);
        $exit_price = (rand(0, 1) == 1) ? $entry_price + $this->faker->randomFloat(1, 20, 100) : $entry_price - $this->faker->randomFloat(1, 20, 100);
        $quantity = $this->faker->numberBetween(5, 30);
        $entry_fee = $entry_price * 0.05;
        $exit_fee = $entry_price * 0.03;

        $sum = $entry_price * $quantity + $entry_fee + $exit_fee;
        $return_percentage = ($exit_price * $quantity - $sum) / $sum * 100;

        return [
            'portfolio_id' => 3,
            'entry_date' => Carbon::now()->subDays($this->faker->numberBetween(0, 20)),
            'exit_date' => Carbon::now()->addDays($this->faker->numberBetween(1, 50)),
            'instrument' => $this->faker->randomElement(['AAPL', 'CSCO', 'GOGL', 'FB', 'AMD', 'NVDA', 'WU']),
            'mistake' => $this->faker->randomElement(['FOMO', 'Emotional Trading', 'Guessing', 'Quick CL', 'Avoid Plan']),
            'setup' => $this->faker->randomElement(['Breakout', 'Pullback', 'MA Bounce', 'Fibonacci']),
            'status' => ($exit_price - $entry_price) > 0 ? 'win' : 'lose',
            'quantity' => $quantity,
            'entry_price' => $entry_price,
            'exit_price' => $exit_price,
            'take_profit' => $entry_price + ($entry_price * 15 / 100),
            'stop_loss' => $entry_price - ($entry_price * 8 / 100),
            'entry_fee' => $entry_fee,
            'exit_fee' => $exit_fee,
            'return' => $exit_price * $quantity - $entry_price * $quantity - $entry_fee - $entry_price,
            'return_percentage' => $return_percentage,
            'favorite' => $this->faker->randomElement([0, 0, 0, 1, 0]),
            'note' => "Demo data"
        ];
    }
}
