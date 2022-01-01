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
        AppSetting::truncate();

        AppSetting::create([
            'name' => 'promotion_banner',
            'data' => json_encode([
                'active' => 0,
                'text-color' => '',
                'background-color' => '',
                'html' => '<div class="flex items-center justify-center p-4 text-white bg-primary-500">
<p class="text-xl">Web app trading journal by Sherwin, tertarik untuk membeli source code? <a href="https://api.whatsapp.com/send?phone=+6281295552928" target="_blank" class="cursor-pointer">Klik disini!</a></p>
</div>',
            ])
        ]);
        AppSetting::create([
            'name' => 'trial',
            'data' => json_encode([
                'active' => 1,
                'duration' => 14,
                'max_portfolio' => 3
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

        AppSetting::create([
            'name' => 'faq',
            'data' => json_encode([
                [
                    "question" => "Lorem ipsum dolor amet?",
                    "answer" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin sed libero turpis. Pellentesque accumsan diam vitae purus auctor, in vehicula magna varius. Ut quis ligula sit amet turpis placerat venenatis. Sed vehicula bibendum nisl. Phasellus et efficitur mi. Nam rhoncus at sem eget eleifend. Aliquam at turpis est. Fusce mauris neque, tincidunt ac tristique vitae, porta at nisi."
                ],
                [
                    "question" => "Lorem ipsum dolor amet?",
                    "answer" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin sed libero turpis. Pellentesque accumsan diam vitae purus auctor, in vehicula magna varius. Ut quis ligula sit amet turpis placerat venenatis. Sed vehicula bibendum nisl. Phasellus et efficitur mi. Nam rhoncus at sem eget eleifend. Aliquam at turpis est. Fusce mauris neque, tincidunt ac tristique vitae, porta at nisi."
                ],
                [
                    "question" => "Lorem ipsum dolor amet?",
                    "answer" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin sed libero turpis. Pellentesque accumsan diam vitae purus auctor, in vehicula magna varius. Ut quis ligula sit amet turpis placerat venenatis. Sed vehicula bibendum nisl. Phasellus et efficitur mi. Nam rhoncus at sem eget eleifend. Aliquam at turpis est. Fusce mauris neque, tincidunt ac tristique vitae, porta at nisi."
                ]
            ])
        ]);
    }
}
