<?php

namespace App\Services;

use App\Models\Batch;
use App\Models\Medicine;
use App\Models\User;
use App\Repositories\Reports\SalesReportRepository;

class AdminDashboardService
{
    public function __construct(
        protected SalesReportRepository $salesRepo
    ) {}

    public function getDashboardData(): array
    {
        return [
            'medicines' => $this->getMedicineStats(),
            'batches' => $this->getBatchStats(),
            'userStash' => $this->getUserStats(),
            'transactionStats' => $this->salesRepo->getTransactionStats(),
            'last7DaysSales' => $this->salesRepo->getLast7DaysSales(),
            'topMedicines' => $this->salesRepo->getTopSellingMedicinesByCategory(),
        ];
    }

    protected function getMedicineStats(): array
    {
        return [
            'total_obat' => Medicine::count(),
            'stok_rendah' => Medicine::lowStock()->count(),
            'by_kategori' => Medicine::countByCategory()->pluck('total', 'kategori'),
        ];
    }

    protected function getBatchStats(): array
    {
        return [
            'batch_tersedia' => Batch::sellable()->count(),
            'expired' => Batch::expired()->count(),
            'expiring_soon' => Batch::expiringWithinDays(30)->count(),
            'batch_bulan_ini' => Batch::thisMonth()->count(),
            'total_stok' => Batch::sellable()->sum('stok'),
            'total_value' => Batch::sellable()
                ->selectRaw('COALESCE(SUM(stok * harga_beli), 0) as total_value')
                ->value('total_value'),
        ];
    }

    protected function getUserStats(): array
    {
        return [
            'total_user' => User::count(),
            'admins' => User::where('role', 'admin')->count(),
            'apotekers' => User::where('role', 'apoteker')->count(),
        ];
    }
}
