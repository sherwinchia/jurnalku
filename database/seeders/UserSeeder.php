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
            'email' => 'admin@jurnalku.com',
            'phone_number' => '6281283789123',
            'password' => bcrypt('secret'),
            'role_id' => 1,
            'slug' => generate_user_slug(),
            'email_verified_at' => now()
        ]);

        User::create([
            'name' => 'User',
            'email' => 'user@gmail.com',
            'phone_number' => '6281291232131',
            'password' => bcrypt('secret'),
            'role_id' => 2,
            'slug' => generate_user_slug()
        ]);

        User::factory()->count(10)->create();
    }
}
