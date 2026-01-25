<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Batch extends Model
{
    use HasFactory;

    protected $fillable = [
        'medicine_id',
        'user_id',
        'no_batch',
        'tanggal_masuk',
        'tanggal_kadaluarsa',
        'stok',
        'harga_beli',
        'harga_jual',
    ];

    protected $casts = [
        'tanggal_kadaluarsa' => 'datetime',
        'tanggal_masuk' => 'datetime',
    ];

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // membuat kode batch otomatis
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($batch) {
            if (empty($batch->no_batch)) {
                $batch->no_batch = self::generateKodeBatch();
            }
        });
    }

    private static function generateKodeBatch(): string
    {
        $lastNumber = self::where('no_batch', 'like', 'BATCH-%')
            ->orderByRaw('CAST(SUBSTRING(no_batch, 7, 4) AS UNSIGNED) DESC')
            ->value('no_batch');

        if ($lastNumber) {
            $number = intval(substr($lastNumber, 6, 4)) + 1;
        } else {
            $number = 1000;
        }

        $letters = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 2);
        return 'BATCH-' . str_pad($number, 4, '0', STR_PAD_LEFT) . $letters;
    }

    // scope cek tanggal kadaluarsa
    public function scopeExpiringSoon(Builder $query, int $days = 30)
    {
        $date = now()->addDays($days);
        return $query->where('tanggal_kadaluarsa', '<=', $date);
    }

    // scope untuk batch masuk bulan ini 
    public function scopeThisMonth(Builder $query)
    {
        return $query->whereMonth('tanggal_masuk', now()->month);
    }

    // scope untuk stok tersedia
    public function scopeHasStock(Builder $query)
    {
        return $query->where('stok', '>', 0);
    }

    // scope relasi ke medicine 
    public function scopeWithMedicine(Builder $query)
    {
        return $query->with('medicine');
    }

    // scope untuk batch yang akan kadaluarsa dalam beberapa hari dan masih ada stok
    public function scopeExpiringWithinDays(Builder $query, int $days = 60)
    {
        return $query->where('tanggal_kadaluarsa', '<=', now()->addDays($days))
            ->where('stok', '>', 0);
    }

    // Semua transaction details yang pakai batch ini
    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class, 'batch_id');
    }

    // Semua transaksi yang pakai batch ini
    public function transactions()
    {
        return $this->hasManyThrough(
            Transaction::class,
            TransactionDetail::class,
            'batch_id',      // FK di transaction_details
            'id',            // PK di transactions
            'id',            // PK di batches
            'transaction_id' // FK di transaction_details
        );
    }
}
