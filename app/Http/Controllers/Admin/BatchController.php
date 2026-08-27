<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Medicine;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class BatchController extends Controller
{
    public function create(Medicine $medicine)
    {
        return view('admin.batches.create', compact('medicine'));
    }

    public function store(Request $request, Medicine $medicine)
    {
        $validated = $request->validate([
            'tanggal_masuk' => ['required', 'date', 'before_or_equal:today'],
            'tanggal_kadaluarsa' => ['required', 'date', 'after:tanggal_masuk', 'after_or_equal:today'],
            'stok' => ['required', 'integer', 'min:1'],
            'harga_beli' => ['required', 'numeric', 'min:0'],
            'harga_jual' => ['required', 'numeric', 'gte:harga_beli'],
        ]);

        $medicine->batches()->create([
            ...$validated,
            'user_id' => Auth::id(),
        ]);

        return redirect()
            ->route('admin.medicines.index', $medicine)
            ->with('success', 'Batch berhasil ditambahkan.');
    }

    public function edit(Medicine $medicine, Batch $batch)
    {
        // Validasi: batch harus milik medicine
        if ($batch->medicine_id !== $medicine->id) {
            abort(404);
        }

        // Optional (disarankan): larang edit jika sudah ada transaksi
        if ($batch->transactions()->exists()) {
            return redirect()
                ->back()
                ->with('error', 'Batch yang sudah memiliki transaksi tidak dapat diedit.');
        }

        return view('admin.batches.edit', compact('medicine', 'batch'));
    }

    public function update(Request $request, Medicine $medicine, Batch $batch)
    {
        if ($batch->medicine_id !== $medicine->id) {
            abort(404);
        }

        if ($batch->transactions()->exists()) {
            return redirect()
                ->back()
                ->with('error', 'Batch yang sudah memiliki transaksi tidak dapat diubah.');
        }

        $validated = $request->validate([
            'tanggal_masuk' => ['required', 'date', 'before_or_equal:today'],
            'tanggal_kadaluarsa' => ['required', 'date', 'after:tanggal_masuk', 'after_or_equal:today'],
            'stok' => ['required', 'integer', 'min:0'],
            'harga_beli' => ['required', 'numeric', 'min:0'],
            'harga_jual' => ['required', 'numeric', 'gte:harga_beli'],
        ]);

        $batch->update($validated);

        return redirect()
            ->route('admin.medicines.show', $medicine)
            ->with('success', 'Batch berhasil diperbarui.');
    }
}
