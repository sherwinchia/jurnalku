<?php

namespace Database\Seeders;

use App\Models\Transaction;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Transaction::create([
            'user_id' => 2,
            'package_id' => 1,
            'status' => 'Pending',
            'promo_code_id' => 1,
            'gross_total' => 19900,
            'discount' => 2000,
            'net_total' => 17900
        ]);
        Transaction::create([
            'user_id' => 2,
            'package_id' => 2,
            'status' => 'Pending',
            'promo_code_id' => 2,
            'gross_total' => 19900,
            'discount' => 2000,
            'net_total' => 17900
        ]);

        Transaction::factory()->count(10000)->create();
    }
}
