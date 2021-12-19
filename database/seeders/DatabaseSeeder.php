<?php

namespace Database\Seeders;

use App\Models\Portfolio;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AppSettingSeeder::class,
            RoleSeeder::class,
            PackageSeeder::class,
            UserSeeder::class,
            // PortfolioSeeder::class,
            PromocodeSeeder::class,
            TransactionSeeder::class,
            // TradeSeeder::class,
            TransactionPackageSeeder::class,
            BlogSeeder::class,
        ]);
    }
}
