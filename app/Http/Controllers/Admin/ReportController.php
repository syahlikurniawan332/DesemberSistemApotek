<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SalesReportService;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    protected SalesReportService $salesReportService;

    public function __construct(SalesReportService $salesReportService)
    {
        $this->salesReportService = $salesReportService;
    }

    public function index(Request $request)
    {
        $filter = $request->get('filter', 'today');

        $total_transaksi = $this->salesReportService->getTotalTransaksiFilter($filter);
        $omzet = $this->salesReportService->getOmzetByFilter($filter);
        $total_obat = $this->salesReportService->getJumlahObatTerjualByFilter($filter);
        $profit = $this->salesReportService->getProfitByFilter($filter);
        $averageTransaction = $this->salesReportService->getAverageTransactionByFilter($filter);
        $omzetChart = $this->salesReportService->getOmzetPerWaktu($filter);
        $topObatTerjual = $this->salesReportService->getTopObatTerlarisChart($filter, 5);
        // dd($topObatTerjual);

        return view('admin.reports.index', [
            'filter' => $filter,
            'total_transaksi' => $total_transaksi,
            'omzet' => $omzet,
            'total_obat' => $total_obat,
            'profit' => $profit,
            'rata_rata_transaksi' => $averageTransaction,
            'omzetChart' => $omzetChart,
            'topObat' => $topObatTerjual,
        ]);
    }
}
