<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            "instruments" => [
                "AAPL","GOTO","GOGL","FB","BBCA","TLKM","JAGO"
            ],
            "setups" => [
                "Breakout","Pullback","MA Bounce","Fibonacci","Ichimoku"
            ],
            "mistakes" => [
                "FOMO","Emotional Trading","Guessing","Quick CL","Avoid Plan"
            ],
            "generals" => [
                "currency" => "Rp",
                "decimals" => 2,
                "public_profile" => false
            ],
            "balances" => [
                [
                    "type" => "deposit",
                    "amount" => 100000,
                ],
                [
                    "type" => "deposit",
                    "amount" => 100000,
                ],
                [
                    "type" => "withdraw",
                    "amount" => 50000,
                ]
            ],
        ];

        Setting::where('user_id', '2')->update([
            'data' => json_encode($data)
        ]);

        // $users = User::all()->except([1, 2]);

        // foreach ($users as $user) {
        //     Setting::create([
        //         'user_id' => $user->id
        //     ]);
        // }
    }
}
