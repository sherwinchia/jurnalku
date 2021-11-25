<?php

namespace Database\Seeders;

use App\Models\Trade;
use Illuminate\Database\Seeder;

class TradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Trade::truncate();

        Trade::factory()->count(20000)->create();
    }
}
