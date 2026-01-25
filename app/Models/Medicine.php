<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'nama',
        'satuan',
        'kategori',
        'min_stok',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($medicine) {
            if (empty($medicine->kode)) {
                $medicine->kode = self::generateKode();
            }
        });
    }

    private static function generateKode(): string
    {
        $lastNumber = self::where('kode', 'like', 'MED-%')
            ->orderByRaw('CAST(SUBSTRING(kode, 5, 4) AS UNSIGNED) DESC')
            ->value('kode');

        if ($lastNumber) {
            $number = intval(substr($lastNumber, 4, 4)) + 1;
        } else {
            $number = 1000;
        }

        // Format: MED-1000AB (angka 4 digit + 2 huruf random)
        $letters = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 2);
        return 'MED-' . str_pad($number, 4, '0', STR_PAD_LEFT) . $letters;
    }

    public function batches()
    {
        return $this->hasMany(Batch::class);
    }

    // scopes cek stok rendah
    public function scopeLowStock(Builder $query)
    {
        return $query
            ->withSum('batches as total_stok', 'stok')
            ->havingRaw('COALESCE(total_stok, 0) <= min_stok');
    }


    // scope cek obat berdasarkan kategori
    public function scopeByCategory(Builder $query, string $category)
    {
        return $query->where('kategori', $category);
    }

    // scope untuk menghitung jumlah obat per kategori
    public function scopeCountByCategory(Builder $query)
    {
        return $query->selectRaw('kategori, COUNT(*) as total')
            ->groupBy('kategori');
    }

    // menghitung total stok obat per medicine
    public function scopeWithTotalStock(Builder $query)
    {
        return $query->with(['batches' => function ($q) {
            $q->select('medicine_id', DB::raw('SUM(stok) as total_stok'))
                ->groupBy('medicine_id');
        }]);
    }

    // scope untuk cek obat dengan stok di bawah threshold tertentu
    public function scopeLowStockThreshold(Builder $query, int $threshold = 20)
    {
        return $query
            ->withSum('batches as total_stok', 'stok')
            ->having('total_stok', '<', DB::raw('min_stok'));
    }

    // scope untuk fitur table di master data 

    public function scopeForMasterTable(Builder $query)
    {
        return $query
            ->select([
                'id',
                'kode',
                'nama',
                'kategori',
                'satuan',
                'min_stok',
            ])
            ->withSum('batches as total_stok', 'stok');
    }

    public function getStockStatusAttribute(): string
    {
        if (($this->total_stok ?? 0) <= $this->min_stok) {
            return 'low';
        }

        return 'safe';
    }
}
