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
            'promocode_id' => 1,
            'gross_total' => 19900,
            'discount' => 2000,
            'net_total' => 17900,
            'reference' => 'INV118923123',
            'merchant_ref' => 'TPX1231908230'
        ]);
        Transaction::create([
            'user_id' => 2,
            'package_id' => 2,
            'status' => 'Pending',
            'promocode_id' => 2,
            'gross_total' => 19900,
            'discount' => 2000,
            'net_total' => 17900,
            'reference' => 'INV111123223',
            'merchant_ref' => 'TPX1231111130'
        ]);

        Transaction::factory()->count(1000)->create();
    }
}
