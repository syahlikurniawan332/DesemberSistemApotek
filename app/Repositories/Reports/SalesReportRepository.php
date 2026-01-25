<?php

namespace App\Repositories\Reports;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class SalesReportRepository
{
    /**
     * Mengambil statistik transaksi:
     * - total hari ini
     * - total bulan ini
     * - total 7 hari terakhir
     * - total transaksi seluruhnya
     * - rata-rata transaksi
     */
    public function getTransactionStats(): array
    {
        $today = Transaction::thisDay()->sum('total');
        $thisMonth = Transaction::thisMonth()->sum('total');
        $last7Days = Transaction::whereDate('created_at', '>=', now()->subDays(7))
            ->sum('total');

        return [
            'today'          => $today,
            'this_month'     => $thisMonth,
            'last_7_days'    => $last7Days,
            'total_count'    => Transaction::count(),
            'avg_transaction' => Transaction::avg('total') ?? 0,
        ];
    }

    public function getLast7DaysSales(): array
    {
        // Ambil tanggal 7 hari ke belakang
        $startDate = now()->subDays(6)->startOfDay();
        // 6 supaya total hari = 7 (0..6)

        $rawData = Transaction::selectRaw("
            DATE(created_at) as date,
            SUM(total) as total
        ")
            ->whereDate('created_at', '>=', $startDate)
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('total', 'date') // hasil: ['2025-12-05' => 500000, ...]
            ->toArray();

        // Buat array lengkap 7 hari (agar chart tidak bolong)
        $result = [];
        for ($i = 0; $i < 7; $i++) {
            $date = now()->subDays(6 - $i)->toDateString();

            $result[] = [
                'date' => $date,
                'total' => $rawData[$date] ?? 0,
            ];
        }

        return $result;
    }

    public function getTopSellingMedicinesByCategory(
        int $limit = 5,
        ?Carbon $startDate = null
    ): array {
        $startDate = $startDate ?? now()->subMonth()->startOfDay();

        return DB::table('transaction_details as td')
            ->join('transactions as t', 'td.transaction_id', '=', 't.id')
            ->join('batches as b', 'td.batch_id', '=', 'b.id')
            ->join('medicines as m', 'b.medicine_id', '=', 'm.id')
            ->where('t.created_at', '>=', $startDate)
            ->select(
                'm.kategori',
                'm.nama',
                DB::raw('SUM(td.jumlah) as total_terjual')
            )
            ->groupBy('m.kategori', 'm.nama')
            ->orderByDesc('total_terjual')
            ->limit($limit)
            ->get()
            ->toArray();
    }
}
