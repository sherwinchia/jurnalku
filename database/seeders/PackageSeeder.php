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
            'value' => 7,
            'active' => true,
            'type' => 'duration',
            'display' => true
        ]);
        Package::create([
            'name' => 'One Month',
            'description' => 'One Month subscription.',
            'price' => 99900,
            'value' => 30,
            'active' => true,
            'type' => 'duration',
            'display' => true
        ]);
        Package::create([
            'name' => 'Free Trial',
            'description' => 'Free seven days trial.',
            'price' => 0,
            'value' => 7,
            'active' => true,
            'type' => 'duration',
            'display' => true
        ]);
        Package::create([
            'name' => 'One Portfolio',
            'description' => 'Add extra portfolio.',
            'price' => 5000,
            'value' => 1,
            'active' => true,
            'type' => 'portfolio',
            'display' => false
        ]);
        // Package::factory()->count(50)->create();
    }
}
