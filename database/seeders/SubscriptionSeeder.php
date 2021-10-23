<?php

namespace Database\Seeders;

use App\Models\Subscription;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Subscription::create([
            'user_id' => 1,
            'type' => 'Free',
            'expired_at' => Carbon::now()->addDays(5),
            'package_id' => 1
        ]);
        Subscription::create([
            'user_id' => 2,
            'type' => 'Paid',
            'expired_at' => Carbon::now()->addDays(30),
            'package_id' => 1
        ]);
    }
}
