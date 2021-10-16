<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Package::create([
            'name' => 'One Week',
            'description' => 'One week subscription.',
            'price' => 39900,
            'duration' => 7,
        ]);
        Package::create([
            'name' => 'One Month',
            'description' => 'One Month subscription.',
            'price' => 99900,
            'duration' => 30,
        ]);
    }
}
