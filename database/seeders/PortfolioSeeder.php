<?php

namespace Database\Seeders;

use App\Models\Portfolio;
use Illuminate\Database\Seeder;

class PortfolioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Portfolio::create([
            'user_id' => 2,
            'name' => 'Test',
            'currency' => 'Rp',
            'balance' => 500000,
            'description' => 'Test portfolio'
        ]);
        Portfolio::create([
            'user_id' => 2,
            'name' => 'Test2',
            'currency' => 'Rp',
            'balance' => 500000,
            'description' => 'Test portfolio2'
        ]);
    }
}
