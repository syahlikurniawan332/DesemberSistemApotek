<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Medicine;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Reports\SalesReportRepository;
use App\Services\AdminDashboardService;
use App\Services\ApotekDashboardService;


class DashboardController extends Controller
{

    protected ApotekDashboardService $apotekDashboardService;
    protected $salesRepo;

    protected $adminDashboardService;

    public function __construct(
        ApotekDashboardService $apotekDashboardService,
        AdminDashboardService $adminDashboardService,
        SalesReportRepository $salesRepo
    ) {
        $this->apotekDashboardService = $apotekDashboardService;
        $this->adminDashboardService = $adminDashboardService;
        $this->salesRepo = $salesRepo;
    }

    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return $this->adminDashboard();
        }

        return $this->apotekerDashboard();
    }

    protected function adminDashboard()
    {
        $data = $this->adminDashboardService->getDashboardData();

        return view('admin.index', $data);
    }

    protected function apotekerDashboard()
    {
        $lowStockMedicines = Medicine::lowStock()->get();

        return view('apoteker.index', [
            'quickStats' => $this->apotekDashboardService->getQuickStats(
                $lowStockMedicines->count()
            ),
            'lowStockMedicines' => $lowStockMedicines,
            'expiringBatches' => $this->apotekDashboardService->getExpiringBatches(),
            'recentTransactions' => $this->apotekDashboardService->getRecentTransactions(),
            'topSellingToday' => $this->apotekDashboardService->getTopSellingToday(),
        ]);
    }
}
