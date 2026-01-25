<?php

namespace Database\Seeders;

use App\Models\Batch;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $apotekers = User::where('role', 'apoteker')->get();
        $batches = Batch::all();

        Transaction::factory()->count(100)->create([
            'user_id' => fn() => $apotekers->random()->id,
        ])->each(function ($transaction) use ($batches) {
            // Untuk setiap transaksi, buat 1-5 detail transaksi
            $detailCount = fake()->numberBetween(1, 5);

            for ($i = 0; $i < $detailCount; $i++) {
                $batch = $batches->random();
                $jumlah = fake()->numberBetween(1, min(5, $batch->stok)); // Jumlah tidak melebihi stok

                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'batch_id' => $batch->id,
                    'jumlah' => $jumlah,
                    'subtotal' => $jumlah * $batch->harga_jual,
                ]);

                // Kurangi stok batch
                $batch->decrement('stok', $jumlah);
            }

            // Update total transaksi dari jumlah subtotal detail
            $total = $transaction->transactionDetails()->sum('subtotal');
            $transaction->update(['total' => $total]);
        });
    }
}
