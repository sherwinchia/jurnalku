<?php

namespace Database\Seeders;

use App\Models\AppSetting;
use Illuminate\Database\Seeder;

class AppSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AppSetting::create([
            'name' => 'promotion_banner',
            'data' => json_encode([
                'active' => 0,
                'text-color' => '',
                'background-color' => '',
                'html' => '',
            ])
        ]);
        AppSetting::create([
            'name' => 'trial',
            'data' => json_encode([
                'active' => 1,
                'duration' => 14
            ])
        ]);
        AppSetting::create([
            'name' => 'policy',
            'data' => json_encode('')
        ]);
        AppSetting::create([
            'name' => 'terms',
            'data' => json_encode('')
        ]);
    }
}
