<?php

namespace Database\Seeders;

use Faker\Generator as Faker;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SubscriptionSeeder extends Seeder
{

    public function __construct(Faker $faker)
    {
        $this->faker = $faker;
    }

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

        // $users = User::where('id', '!=', 1)->where('id', '!=', 2)->get();
        $users = User::all()->except([1, 2]);

        foreach ($users as $user) {
            $types = ['Free', 'Paid'];
            Subscription::create([
                'user_id' => $user->id,
                'type' => $types[array_rand($types, 1)],
                'expired_at' => Carbon::now()->addDays(10),
                'package_id' => $this->faker->numberBetween(1, 50)
            ]);
        }
    }
}
