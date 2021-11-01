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
        $entry_price = $this->faker->randomFloat(1, 80, 100);
        $exit_price = (rand(0,1) == 1) ? $entry_price + $this->faker->randomFloat(1, 5, 20) : $entry_price - $this->faker->randomFloat(1, 5, 20);

        return [
            'portfolio_id' => $this->faker->numberBetween(1, 4),
            'entry_date' => Carbon::now(),
            'exit_date' => Carbon::now()->addDays($this->faker->numberBetween(1, 14)),
            'instrument' => $this->faker->randomElement(['AAPL','GOTO','GOGL','FB','BBCA','TLKM','JAGO']),
            'mistake' => $this->faker->randomElement(['FOMO','Emotional Trading','Guessing','Quick CL','Avoid Plan']),
            'setup' => $this->faker->randomElement(['Breakout','Pullback','MA Bounce','Fibonacci']),
            'quantity' => $this->faker->numberBetween(1, 20),
            'entry_price' => $entry_price,
            'exit_price' => $exit_price,
            'take_profit' => $entry_price + ($entry_price * 00.5),
            'stop_loss' => $entry_price - ($entry_price * 00.5),
            'fees' => ($entry_price * 000.5),
            'gain_loss' => $exit_price - $entry_price,
            'favorite' => 0,
            'note' => $this->faker->paragraph()
        ];
    }
}