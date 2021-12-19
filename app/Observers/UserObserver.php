<?php

namespace App\Observers;

use App\Models\AppSetting;
use App\Models\User;
use App\Models\Setting;
use App\Models\Portfolio;
use App\Models\Subscription;
use Faker\Generator as Faker;
use Carbon\Carbon;

class UserObserver
{
    protected $faker;

    public function __construct(Faker $faker)
    {
        $this->faker = $faker;
    }
    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(User $user)
    {
        Setting::create([
            'user_id' => $user->id
        ]);

        $freeDays = 0;
        $appSetting = AppSetting::where('name', 'trial')->first();
        $appSettingData = json_decode($appSetting->data, true);
        if ($appSettingData['active']) {
            $freeDays = $appSettingData['duration'];
        }

        Subscription::create([
            'user_id' => $user->id,
            'type' => 'free',
            'expired_at' => now()->addDays($freeDays),
            'max_portfolio' => isset($appSettingData['max_portfolio']) ? $appSettingData['max_portfolio'] : 1
        ]);

        $portfolio = Portfolio::create([
            'user_id' => $user->id,
            'name' => "Demo Portfolio",
            'currency' => "$",
            'balance' => "10000",
            'description' => "Demo portfolio. Feel free to delete it."
        ]);

        $portfolio->trades()->createMany([
            $this->generateDemoTradeData(),
            $this->generateDemoTradeData(),
            $this->generateDemoTradeData(),
            $this->generateDemoTradeData(),
            $this->generateDemoTradeData(),
            $this->generateDemoTradeData(),
            $this->generateDemoTradeData(),
            $this->generateDemoTradeData(),
            $this->generateDemoTradeData(),
            $this->generateDemoTradeData(),
            $this->generateDemoTradeData(),
            $this->generateDemoTradeData(),
            $this->generateDemoTradeData(),
            $this->generateDemoTradeData(),
            $this->generateDemoTradeData(),
            $this->generateDemoTradeData(),
            $this->generateDemoTradeData(),
            $this->generateDemoTradeData(),
        ]);
    }

    public function generateDemoTradeData()
    {
        $entry_price = $this->faker->randomFloat(1, 300, 500);
        $exit_price = (rand(0, 8) > 1) ? $entry_price + $this->faker->randomFloat(1, 20, 100) : $entry_price - $this->faker->randomFloat(1, 20, 100);
        $quantity = $this->faker->numberBetween(5, 30);
        $entry_fee = $entry_price * 0.05;
        $exit_fee = $entry_price * 0.03;

        $sum = $entry_price * $quantity + $entry_fee + $exit_fee;
        $return_percentage = ($exit_price * $quantity - $sum) / $sum * 100;

        return [
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

    /**
     * Handle the User "updated" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the User "restored" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
