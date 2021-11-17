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
            'status' => 'pending',
            'promocode_id' => 1,
            'gross_total' => 19900,
            'discount' => 2000,
            'net_total' => 17900,
            'reference' => 'INV118923123',
            'merchant_ref' => get_unique_merchant_ref()
        ]);
        Transaction::create([
            'user_id' => 2,
            'status' => 'pending',
            'promocode_id' => 2,
            'gross_total' => 19900,
            'discount' => 2000,
            'net_total' => 17900,
            'reference' => 'INV111123223',
            'merchant_ref' => get_unique_merchant_ref()
        ]);

        Transaction::factory()->count(100)->create();
    }
}
