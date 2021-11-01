<?php

namespace Database\Seeders;

use App\Models\Portfolio;
use App\Models\User;
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
        $users = User::all();

        foreach ($users as $user) {
            Portfolio::create([
                'user_id' => $user->id,
                'name' => 'Default',
                'description' => 'Default Portfolio',
            ]);
        }

        Portfolio::create(['user_id' => 2,'name' => 'Second','description' => 'Default Portfolio',]);
        Portfolio::create(['user_id' => 2,'name' => 'Third','description' => 'Default Portfolio',]);
    }
}
