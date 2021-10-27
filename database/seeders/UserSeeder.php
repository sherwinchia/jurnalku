<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'phone_number' => '6281295552928',
            'password' => bcrypt('secret'),
            'role_id' => 1
        ]);

        User::create([
            'name' => 'User',
            'email' => 'user@user.com',
            'phone_number' => '6281295552921',
            'password' => bcrypt('secret'),
            'role_id' => 2
        ]);

        User::factory()->count(100)->create();
    }
}
