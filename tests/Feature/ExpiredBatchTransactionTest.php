<?php

namespace Tests\Feature;

use App\Models\Batch;
use App\Models\Medicine;
use App\Models\Transaction;
use App\Models\User;
use App\Services\TransactionDetailService;
use DomainException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExpiredBatchTransactionTest extends TestCase
{
    use RefreshDatabase;

    public function test_expired_batch_cannot_be_sold(): void
    {
        $apoteker = User::factory()->apoteker()->create();
        $this->actingAs($apoteker);

        $medicine = Medicine::create([
            'kode' => 'MED-TEST',
            'nama' => 'Obat Uji',
            'satuan' => 'tablet',
            'kategori' => 'Uji',
            'min_stok' => 10,
        ]);

        Batch::create([
            'medicine_id' => $medicine->id,
            'user_id' => $apoteker->id,
            'no_batch' => 'BATCH-EXPIRED',
            'tanggal_masuk' => today()->subMonth(),
            'tanggal_kadaluarsa' => today()->subDay(),
            'stok' => 10,
            'harga_beli' => 1000,
            'harga_jual' => 1500,
        ]);

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Stok obat tidak tersedia');

        try {
            app(TransactionDetailService::class)->store([
                'medicines' => [[
                    'medicine_id' => $medicine->id,
                    'quantity' => 1,
                ]],
            ]);
        } finally {
            $this->assertDatabaseCount((new Transaction())->getTable(), 0);
        }
    }
}
