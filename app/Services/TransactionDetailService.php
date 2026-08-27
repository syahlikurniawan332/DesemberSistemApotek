<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\Batch;
use App\Models\Medicine;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DomainException;

class TransactionDetailService
{
    /**
     * Ambil daftar transaksi untuk halaman index
     * Hanya data yang diperlukan saja
     */
    public function getTransactionsForIndex(int $perPage = 10)
    {
        return Transaction::query()
            ->select([
                'id',
                'user_id',
                'no_transaction',
                'total',
                'created_at',
            ])

            // Ambil data user, tapi hanya id dan nama
            ->with([
                'user:id,name',

                // Pastikan transaksi punya detail
                'transactionDetails:id,transaction_id'
            ])

            // Filter user login (scope sudah Anda punya)
            ->byCurrentUser()

            // Urutkan dari terbaru
            ->latest()

            // Pagination
            ->paginate($perPage);
    }

    /**
     * Ambil satu transaksi lengkap untuk halaman detail
     * Semua relasi yang dibutuhkan view di-load di sini
     */
    public function getTransactionDetail(int $transactionId): Transaction
    {
        return Transaction::query()
            ->select([
                'id',
                'user_id',
                'no_transaction',
                'total',
                'created_at',
            ])

            // Ambil user (kasir)
            ->with([
                'user:id,name',

                // Ambil detail transaksi
                'transactionDetails' => function ($query) {
                    $query->select(
                        'id',
                        'transaction_id',
                        'batch_id',
                        'jumlah',
                        'subtotal'
                    );
                },

                // Ambil batch dari tiap detail
                'transactionDetails.batch' => function ($query) {
                    $query->select(
                        'id',
                        'medicine_id',
                        'no_batch',
                        'harga_jual'
                    );
                },

                // Ambil medicine dari batch
                'transactionDetails.batch.medicine' => function ($query) {
                    $query->select(
                        'id',
                        'kode',
                        'nama',
                        'satuan'
                    );
                },
            ])

            // Cari transaksi, gagal = 404
            ->byCurrentUser()
            ->findOrFail($transactionId);
    }

    // generarate kode transaksi
    public function generateTransactionCode(): string
    {
        return 'TRX-' . now()->format('YmdHis') . '-' . random_int(1000, 9999);
    }

    public function store(array $data): Transaction
    {
        return DB::transaction(function () use ($data) {

            $totalTransaction = 0;

            // 1. Buat transaksi utama
            $transaction = Transaction::create([
                'user_id'        => Auth::id(),
                'no_transaction' => $this->generateTransactionCode(),
                'total'          => 0, // sementara
            ]);

            // 2. Loop setiap obat
            foreach ($data['medicines'] as $item) {

                $medicineId = $item['medicine_id'];
                $quantityNeeded = (int) $item['quantity'];

                if ($quantityNeeded <= 0) {
                    throw new DomainException('Jumlah obat tidak valid');
                }

                // 3. Ambil batch FIFO (expired terdekat)
                $batches = Batch::where('medicine_id', $medicineId)
                    ->sellable()
                    ->orderBy('tanggal_kadaluarsa')
                    ->lockForUpdate()
                    ->get();

                if ($batches->isEmpty()) {
                    throw new DomainException('Stok obat tidak tersedia');
                }

                // 4. Kurangi stok per batch
                foreach ($batches as $batch) {
                    if ($quantityNeeded <= 0) {
                        break;
                    }

                    $takeQty = min($batch->stok, $quantityNeeded);
                    $subtotal = $takeQty * $batch->harga_jual;

                    // Simpan detail transaksi
                    TransactionDetail::create([
                        'transaction_id' => $transaction->id,
                        'batch_id'       => $batch->id,
                        'jumlah'         => $takeQty,
                        'subtotal'       => $subtotal,
                    ]);

                    // Kurangi stok batch
                    $batch->decrement('stok', $takeQty);

                    // Hitung total
                    $totalTransaction += $subtotal;
                    $quantityNeeded -= $takeQty;
                }

                // Jika stok tidak cukup
                if ($quantityNeeded > 0) {
                    throw new DomainException('Stok obat tidak mencukupi');
                }
            }

            // 5. Update total transaksi
            $transaction->update([
                'total' => $totalTransaction
            ]);

            return $transaction;
        });
    }

    public function getAvailableMedicines()
    {
        return Medicine::whereHas('batches', function ($query) {
            $query->sellable();
        })
            ->with(['batches' => function ($query) {
                $query->sellable()
                    ->orderBy('tanggal_kadaluarsa')
                    ->select('medicine_id', 'harga_jual', 'stok', 'no_batch');
            }])
            ->select('id', 'kode', 'nama', 'satuan')
            ->get();
    }

    // dapatkan data transaksi untuk edit
    public function getTransactionForEdit(Transaction $transaction)
    {
        return $transaction->load([
            'transactionDetails.batch.medicine',
            'user'
        ]);
    }

    // update data transaksi
    public function update(Transaction $transaction, array $data)
    {
        return DB::transaction(function () use ($transaction, $data) {
            $transaction = Transaction::query()
                ->whereKey($transaction->id)
                ->where('user_id', Auth::id())
                ->lockForUpdate()
                ->firstOrFail();

            $oldDetails = $transaction->transactionDetails()
                ->with('batch')
                ->lockForUpdate()
                ->get();

            $oldBatchIds = $oldDetails->pluck('batch_id')->unique()->values();
            Batch::whereKey($oldBatchIds->all())->lockForUpdate()->get();

            // 1️⃣ Kembalikan stok lama
            foreach ($oldDetails as $detail) {
                $detail->batch->increment('stok', $detail->jumlah);
            }

            // 2️⃣ Hapus detail lama
            $transaction->transactionDetails()->delete();

            $total = 0;

            // 3️⃣ Simpan detail baru
            foreach ($data['medicines'] as $item) {

                $batch = Batch::lockForUpdate()->findOrFail($item['batch_id']);

                if ($batch->tanggal_kadaluarsa->isBefore(today())) {
                    throw new DomainException("Batch {$batch->no_batch} sudah kedaluwarsa");
                }

                if ($batch->stok < $item['quantity']) {
                    throw new DomainException("Stok {$batch->medicine->nama} tidak mencukupi");
                }

                $subtotal = $batch->harga_jual * $item['quantity'];

                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'batch_id'       => $batch->id,
                    'jumlah'         => $item['quantity'],
                    'subtotal'       => $subtotal,
                ]);

                $batch->decrement('stok', $item['quantity']);

                $total += $subtotal;
            }

            // 4️⃣ Update total transaksi
            $transaction->update([
                'total' => $total
            ]);

            return $transaction;
        });
    }
}
