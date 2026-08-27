<?php

namespace Database\Seeders;

use App\Models\Batch;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class TransactionSeeder extends Seeder
{
    /**
     * Membuat data demo penjualan dari 1 Februari sampai kemarin.
     * Awalan DEMO- membuat seeder aman dijalankan ulang tanpa
     * menghapus transaksi yang dibuat pengguna.
     */
    public function run(): void
    {
        if (! app()->environment(['local', 'testing'])) {
            $this->command?->warn('Transaksi demo hanya boleh dibuat di lingkungan local/testing.');

            return;
        }

        $endDate = today()->subDay();
        $startDate = Carbon::create($endDate->year, 2, 1)->startOfDay();

        if ($endDate->lt($startDate)) {
            $this->command?->warn('Belum ada rentang tanggal dari Februari sampai kemarin.');

            return;
        }

        $apotekers = User::query()->where('role', 'apoteker')->get();
        $batches = Batch::query()
            ->where('tanggal_kadaluarsa', '>=', $endDate->toDateString())
            ->get();

        if ($apotekers->isEmpty() || $batches->isEmpty()) {
            throw new RuntimeException(
                'Jalankan UserSeeder dan BatchSeeder sebelum TransactionSeeder.'
            );
        }

        fake()->seed(20260201);

        DB::transaction(function () use ($startDate, $endDate, $apotekers, $batches) {
            Transaction::query()
                ->where('no_transaction', 'like', 'DEMO-%')
                ->delete();

            foreach (CarbonPeriod::create($startDate, $endDate) as $date) {
                $transactionCount = 1;

                if ($date->isWeekday() && fake()->boolean(65)) {
                    $transactionCount++;
                }

                if ($date->month >= 6 && fake()->boolean(25)) {
                    $transactionCount++;
                }

                for ($sequence = 1; $sequence <= $transactionCount; $sequence++) {
                    $transactionTime = $date->copy()->setTime(
                        fake()->numberBetween(8, 20),
                        fake()->numberBetween(0, 59),
                        fake()->numberBetween(0, 59),
                    );

                    $transaction = Transaction::forceCreate([
                        'user_id' => $apotekers->random()->id,
                        'no_transaction' => sprintf(
                            'DEMO-%s-%02d',
                            $date->format('Ymd'),
                            $sequence,
                        ),
                        'total' => 0,
                        'created_at' => $transactionTime,
                        'updated_at' => $transactionTime,
                    ]);

                    $total = 0;
                    $selectedBatches = $batches
                        ->shuffle()
                        ->take(fake()->numberBetween(1, min(3, $batches->count())));

                    foreach ($selectedBatches as $batch) {
                        $quantity = fake()->numberBetween(1, 4);
                        $subtotal = $quantity * (float) $batch->harga_jual;

                        TransactionDetail::forceCreate([
                            'transaction_id' => $transaction->id,
                            'batch_id' => $batch->id,
                            'jumlah' => $quantity,
                            'subtotal' => $subtotal,
                            'created_at' => $transactionTime,
                            'updated_at' => $transactionTime,
                        ]);

                        $total += $subtotal;
                    }

                    $transaction->forceFill(['total' => $total])->saveQuietly();
                }
            }
        });

        $demoCount = Transaction::query()
            ->where('no_transaction', 'like', 'DEMO-%')
            ->count();

        $this->command?->info(
            "Berhasil membuat {$demoCount} transaksi demo dari "
            . $startDate->format('d-m-Y')
            . ' sampai '
            . $endDate->format('d-m-Y')
            . '.'
        );
    }
}
