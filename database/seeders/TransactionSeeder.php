<?php

namespace Database\Seeders;

use App\Models\Transaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $trxs = [
            [
                'description' => Transaction::PEMBELIAN,
                'date' => now(),
                'qty' => 40,
                'cost' => 100,
                'price' => 100,
                'total_cost' => 4000,
                'qty_balance' => 40,
                'value_balance' => 4000,
                'hpp' => 100,
            ],
            [
                'description' => Transaction::PENJUALAN,
                'date' => now()->addSeconds(1),
                'qty' => -20,
                'cost' => 100,
                'price' => 100,
                'total_cost' => -2000,
                'qty_balance' => 20,
                'value_balance' => 2000,
                'hpp' => 100,
            ],
            [
                'description' => Transaction::PENJUALAN,
                'date' => now()->addSeconds(2),
                'qty' => -10,
                'cost' => 100,
                'price' => 100,
                'total_cost' => -1000,
                'qty_balance' => 10,
                'value_balance' => 1000,
                'hpp' => 100,
            ],
            [
                'description' => Transaction::PEMBELIAN,
                'date' => now()->addSeconds(3),
                'qty' => 20,
                'cost' => 120,
                'price' => 120,
                'total_cost' => 2400,
                'qty_balance' => 30,
                'value_balance' => 3400,
                'hpp' => 113.33,
            ],
        ];

        foreach ($trxs as $trx) {
            Transaction::create($trx);
        }
    }
}
