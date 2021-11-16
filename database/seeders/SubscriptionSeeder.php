<?php

namespace Database\Seeders;

use Faker\Generator as Faker;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SubscriptionSeeder extends Seeder
{

    public function __construct(Faker $faker)
    {
        $this->faker = $faker;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Subscription::create([
            'user_id' => 1,
            'type' => 'free',
            'expired_at' => Carbon::now()->addDays(5),
            'package_id' => 1
        ]);
        Subscription::create([
            'user_id' => 2,
            'type' => 'paid',
            'expired_at' => Carbon::now()->addDays(30),
            'package_id' => 1,
            'max_portfolio' => 2
        ]);
    }
}
