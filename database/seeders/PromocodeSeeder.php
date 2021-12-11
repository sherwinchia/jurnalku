<?php

namespace Database\Seeders;

use App\Models\Promocode;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PromocodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Promocode::truncate();

        Promocode::create([
            'code' => strtoupper('test1'),
            'type' => 'percentage',
            'value' => 20,
            'max_discount' => 10000,
            'max_use_count' => 100,
            'first_time_user' => false,
            'start_at' => Carbon::now(),
            'expired_at' => Carbon::now()->addDays(10),
            'active' => true,
        ]);

        Promocode::create([
            'code' => strtoupper('test2'),
            'type' => 'fixed',
            'value' => 10000,
            'max_discount' => null,
            'max_use_count' => 20,
            'first_time_user' => false,
            'start_at' => Carbon::now(),
            'expired_at' => Carbon::now()->addDays(10),
            'active' => true,
        ]);

        Promocode::create([
            'code' => strtoupper('test3'),
            'type' => 'fixed',
            'value' => 1000,
            'max_discount' => null,
            'min_spending' => 50000,
            'max_use_count' => 0,
            'first_time_user' => false,
            'start_at' => Carbon::now()->subDays(20),
            'expired_at' => Carbon::now()->addDays(10),
            'active' => true,
        ]);

        Promocode::create([
            'code' => strtoupper('test4'),
            'type' => 'fixed',
            'value' => 1000,
            'max_discount' => 500,
            'max_use_count' => 0,
            'first_time_user' => true,
            'start_at' => Carbon::now(),
            'expired_at' => Carbon::now()->addDays(10),
            'active' => true,
        ]);

        Promocode::create([
            'code' => strtoupper('free'),
            'type' => 'percentage',
            'value' => 100,
            'max_discount' => null,
            'max_use_count' => 1000,
            'first_time_user' => false,
            'start_at' => Carbon::now(),
            'expired_at' => Carbon::now()->addDays(10),
            'active' => true,
        ]);
    }
}
