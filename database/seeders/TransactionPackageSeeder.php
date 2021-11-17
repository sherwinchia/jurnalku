<?php

namespace Database\Seeders;

use App\Models\Transaction;
use App\Models\TransactionPackage;
use Illuminate\Database\Seeder;

class TransactionPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $transactions = Transaction::all();

        foreach ($transactions as $transaction) {
            TransactionPackage::create([
                'transaction_id' => $transaction->id,
                'package_id' => 1
            ]);
        }
    }
}
