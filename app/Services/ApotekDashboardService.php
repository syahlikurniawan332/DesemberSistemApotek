<?php

namespace App\Services;

use App\Models\Batch;
use App\Models\Medicine;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class ApotekDashboardService
{
    public function getQuickStats(int $lowStockCount): array
    {
        return [
            'today_sales' => Transaction::byCurrentUser()
                ->whereDate('created_at', today())
                ->sum('total'),

            'today_transactions' => Transaction::byCurrentUser()
                ->whereDate('created_at', today())
                ->count(),

            'low_stock_medicines' => $lowStockCount,

            'expiring_batches' => Batch::expiringWithinDays(30)->count(),
        ];
    }

    public function getLowStockMedicinesTable()
    {
        return Medicine::withSum([
            'batches as total_stok' => fn ($batchQuery) => $batchQuery->sellable(),
        ], 'stok')
            ->havingRaw('COALESCE(total_stok, 0) <= min_stok')
            ->orderBy('total_stok')
            ->limit(5)
            ->get();
    }

    public function getExpiringBatches()
    {
        return Batch::withMedicine()
            ->expiringWithinDays(60)
            ->orderBy('tanggal_kadaluarsa')
            ->limit(5)
            ->get();
    }

    public function getRecentTransactions()
    {
        return Transaction::withUser()
            ->byCurrentUser()
            ->latest()
            ->limit(5)
            ->get();
    }

    public function getTopSellingToday()
    {
        return DB::table('transaction_details as td')
            ->join('batches as b', 'td.batch_id', '=', 'b.id')
            ->join('medicines as m', 'b.medicine_id', '=', 'm.id')
            ->join('transactions as t', 'td.transaction_id', '=', 't.id')
            ->whereDate('t.created_at', today())
            ->select(
                'm.nama',
                DB::raw('SUM(td.jumlah) as total_terjual')
            )
            ->groupBy('m.id', 'm.nama')
            ->orderByDesc('total_terjual')
            ->limit(5)
            ->get();
    }
}
