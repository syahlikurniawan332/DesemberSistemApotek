<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'no_transaction',
        'total',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactionDetails()  // GANTI KE PLURAL
    {
        return $this->hasMany(TransactionDetail::class);
    }

    // Lalu update method yang menggunakan relationship
    public function scopeWithUser(Builder $query)
    {
        return $query->with('user');
    }

    // Tambahkan scope untuk include details
    public function scopeWithDetails(Builder $query)
    {
        return $query->with('transactionDetails');
    }

    // scope transaksi hari ini 
    public function scopeThisDay(Builder $query)
    {
        return $query->whereBetween('created_at', [
            today()->startOfDay(),
            today()->endOfDay(),
        ]);
    }

    // scope transaksi bulan ini
    public function scopeThisMonth(Builder $query)
    {
        return $query->whereBetween('created_at', [
            now()->startOfMonth(),
            now()->endOfMonth(),
        ]);
    }

    // scope transaksi total minimal 
    public function scopeMinTotal(Builder $query, float $amount)
    {
        return $query->where('total', '>=', $amount);
    }

    // scope transaksi oleh user saat ini
    public function scopeByCurrentUser(Builder $query)
    {
        return $query->where('user_id', Auth::id());
    }

}
