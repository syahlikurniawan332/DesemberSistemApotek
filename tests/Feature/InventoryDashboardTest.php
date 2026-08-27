<?php

namespace Tests\Feature;

use App\Models\Batch;
use App\Models\Medicine;
use App\Models\User;
use App\Services\AdminDashboardService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InventoryDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_separates_sellable_expiring_and_expired_batches(): void
    {
        $user = User::factory()->admin()->create();
        $medicine = Medicine::create([
            'kode' => 'MED-DASH',
            'nama' => 'Obat Dashboard',
            'satuan' => 'tablet',
            'kategori' => 'Uji',
            'min_stok' => 10,
        ]);

        $this->createBatch($medicine, $user, 'BATCH-SAFE', today()->addMonths(2), 2, 100);
        $this->createBatch($medicine, $user, 'BATCH-SOON', today()->addDays(10), 3, 50);
        $this->createBatch($medicine, $user, 'BATCH-EXPIRED', today()->subDay(), 7, 1000);

        $batchStats = new \ReflectionMethod(AdminDashboardService::class, 'getBatchStats');
        $batches = $batchStats->invoke(app(AdminDashboardService::class));

        $this->assertSame(2, $batches['batch_tersedia']);
        $this->assertSame(1, $batches['expiring_soon']);
        $this->assertSame(1, $batches['expired']);
        $this->assertSame(5, $batches['total_stok']);
        $this->assertEquals(350, $batches['total_value']);
    }

    private function createBatch(
        Medicine $medicine,
        User $user,
        string $number,
        $expiresAt,
        int $stock,
        int $purchasePrice,
    ): void {
        Batch::create([
            'medicine_id' => $medicine->id,
            'user_id' => $user->id,
            'no_batch' => $number,
            'tanggal_masuk' => today()->subMonth(),
            'tanggal_kadaluarsa' => $expiresAt,
            'stok' => $stock,
            'harga_beli' => $purchasePrice,
            'harga_jual' => $purchasePrice + 50,
        ]);
    }
}
