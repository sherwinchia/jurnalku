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
        Promocode::create([
            'code' => get_unique_promocode(),
            'type' => 'Percentage',
            'value' => 20,
            'max_discount' => 10000,
            'max_use_count' => 100,
            'first_time_user' => false,
            'start_at' => Carbon::now(),
            'expired_at' => Carbon::now()->addDays(10),
            'active' => true,
        ]);

        Promocode::create([
            'code' => get_unique_promocode(),
            'type' => 'Fixed',
            'value' => 10000,
            'max_discount' => null,
            'max_use_count' => 20,
            'first_time_user' => false,
            'start_at' => Carbon::now(),
            'expired_at' => Carbon::now()->addDays(10),
            'active' => true,
        ]);
    }
}
