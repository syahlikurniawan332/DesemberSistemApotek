<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use function Symfony\Component\Clock\now;

class SalesReportService
{
    public function getTotalTransaksiFilter(String $filter = 'today'): int
    {
        if ($filter === 'year') {
            $startDate = Carbon::now()->startOfYear();
            $endDate = Carbon::now()->endOfYear();
        } elseif ($filter === 'month') {
            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now()->endOfMonth();
        } elseif ($filter === 'week') {
            $startDate = Carbon::now()->startOfWeek();
            $endDate = Carbon::now()->endOfWeek();
        } else {
            $startDate = Carbon::now()->startOfDay();
            $endDate = Carbon::now()->endOfDay();
        }

        return Transaction::whereBetween('created_at', [
            $startDate,
            $endDate
        ])->count('total');
    }

    public function getOmzetByFilter(String $filter = 'today'): int
    {
        $now = Carbon::now();

        if ($filter === 'year') {
            $startDate = $now->copy()->startOfYear();
            $endDate = $now->copy()->endOfYear();
        } elseif ($filter === 'month') {
            $startDate = $now->copy()->startOfMonth();
            $endDate   = $now->copy()->endOfMonth();
        } elseif ($filter === 'week') {
            $startDate = $now->copy()->startOfWeek();
            $endDate   = $now->copy()->endOfWeek();
        } else {
            $startDate = $now->copy()->startOfDay();
            $endDate   = $now->copy()->endOfDay();
        }

        return Transaction::whereBetween('created_at', [
            $startDate,
            $endDate
        ])->sum('total');
    }

    public function getJumlahObatTerjualByFilter(string $filter = 'today'): int
    {
        $now = Carbon::now();

        if ($filter === 'year') {
            $startDate = $now->copy()->startOfYear();
            $endDate   = $now->copy()->endOfYear();
        } elseif ($filter === 'month') {
            $startDate = $now->copy()->startOfMonth();
            $endDate   = $now->copy()->endOfMonth();
        } elseif ($filter === 'week') {
            $startDate = $now->copy()->startOfWeek();
            $endDate   = $now->copy()->endOfWeek();
        } else {
            $startDate = $now->copy()->startOfDay();
            $endDate   = $now->copy()->endOfDay();
        }

        return DB::table('transaction_details')
            ->join('transactions', 'transaction_details.transaction_id', '=', 'transactions.id')
            ->whereBetween('transactions.created_at', [
                $startDate,
                $endDate
            ])
            ->sum('transaction_details.jumlah');
    }

    public function getProfitByFilter(string $filter = 'today'): int
    {
        $now = Carbon::now();

        if ($filter === 'year') {
            $startDate = $now->copy()->startOfYear();
            $endDate   = $now->copy()->endOfYear();
        } elseif ($filter === 'month') {
            $startDate = $now->copy()->startOfMonth();
            $endDate   = $now->copy()->endOfMonth();
        } elseif ($filter === 'week') {
            $startDate = $now->copy()->startOfWeek();
            $endDate   = $now->copy()->endOfWeek();
        } else {
            $startDate = $now->copy()->startOfDay();
            $endDate   = $now->copy()->endOfDay();
        }

        return DB::table('transaction_details as td')
            ->join('transactions as t', 'td.transaction_id', '=', 't.id')
            ->join('batches as b', 'td.batch_id', '=', 'b.id')
            ->whereBetween('t.created_at', [
                $startDate,
                $endDate
            ])
            ->selectRaw('SUM((b.harga_jual - b.harga_beli) * td.jumlah) as profit')
            ->value('profit') ?? 0;
    }

    public function getAverageTransactionByFilter(string $filter = 'today'): float
    {
        $totalTransaksi = $this->getTotalTransaksiFilter($filter);

        if ($totalTransaksi === 0) {
            return 0;
        }

        $omzet = $this->getOmzetByFilter($filter);

        return $omzet / $totalTransaksi;
    }

    public function getOmzetPerWaktu(string $filter = 'week'): array
    {
        $now = Carbon::now();

        if ($filter === 'year') {
            $start = $now->copy()->startOfYear();
            $end   = $now->copy()->endOfYear();
            $groupFormat = '%Y-%m';
        } elseif ($filter === 'month') {
            $start = $now->copy()->startOfMonth();
            $end   = $now->copy()->endOfMonth();
            $groupFormat = '%Y-%m-%d';
        } elseif ($filter === 'week') {
            $start = $now->copy()->startOfWeek();
            $end   = $now->copy()->endOfWeek();
            $groupFormat = '%Y-%m-%d';
        } else {
            $start = $now->copy()->startOfDay();
            $end   = $now->copy()->endOfDay();
            $groupFormat = '%H.%i';
        }

        return Transaction::selectRaw("
            DATE_FORMAT(created_at, '{$groupFormat}') as label,
            SUM(total) as total
        ")
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('label')
            ->orderBy('label')
            ->get()
            ->map(fn($row) => [
                'label' => $row->label,
                'total' => (int) $row->total,
            ])
            ->toArray();
    }

    public function getTopObatTerlarisChart(string $filter = 'today', int $limit = 5)
    {
        $now = Carbon::now();

        if ($filter === 'year') {
            $startDate = $now->copy()->startOfYear();
            $endDate   = $now->copy()->endOfYear();
        } elseif ($filter === 'month') {
            $startDate = $now->copy()->startOfMonth();
            $endDate   = $now->copy()->endOfMonth();
        } elseif ($filter === 'week') {
            $startDate = $now->copy()->startOfWeek();
            $endDate   = $now->copy()->endOfWeek();
        } else {
            $startDate = $now->copy()->startOfDay();
            $endDate   = $now->copy()->endOfDay();
        }

        return TransactionDetail::query()
            ->selectRaw('
            medicines.nama as nama,
            SUM(transaction_details.jumlah) as total_terjual
        ')
            ->join('transactions', 'transactions.id', '=', 'transaction_details.transaction_id')
            ->join('batches', 'batches.id', '=', 'transaction_details.batch_id')
            ->join('medicines', 'medicines.id', '=', 'batches.medicine_id')
            ->whereBetween('transactions.created_at', [$startDate, $endDate])
            ->groupBy('medicines.id', 'medicines.nama')
            ->orderByDesc('total_terjual')
            ->limit($limit)
            ->get();
    }
}
