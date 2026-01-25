<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $medicines = Medicine::forMasterTable()->latest()->paginate(10);
        return view('admin.medicines.index', compact('medicines'));
    }

    public function create()
    {
        $categories = ['Analgesik', 'Antibiotik', 'Vitamin', 'Antiseptik', 'Antihipertensi'];
        $units = ['tablet', 'kapsul', 'botol', 'tube', 'sachet'];

        return view('admin.medicines.create', compact('categories', 'units'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'satuan' => 'required|string|max:50',
            'kategori' => 'required|string|max:100',
            'min_stok' => 'required|integer|min:10',
        ]);

        // Kode akan auto generate dari model
        Medicine::create($validated);

        return redirect()->route('admin.medicines.index')
            ->with('success', 'Obat berhasil ditambahkan.');
    }


    public function show(Medicine $medicine)
    {
        $medicine->load([
            'batches' => function ($query) {
                $query
                    ->orderBy('tanggal_kadaluarsa')
                    ->orderBy('tanggal_masuk');
            }
        ])->loadSum('batches as total_stok', 'stok');
        return view('admin.medicines.show', compact('medicine'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Medicine $medicine)
    {
        $categories = ['Analgesik', 'Antibiotik', 'Vitamin', 'Antiseptik', 'Antihipertensi'];
        $units = ['tablet', 'strip', 'botol', 'box'];

        return view('admin.medicines.edit', compact('medicine', 'categories', 'units'));
    }


    public function update(Request $request, Medicine $medicine)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'satuan' => 'required|string|max:50',
            'kategori' => 'required|string|max:100',
            'min_stok' => 'required|integer|min:10',
        ]);

        $medicine->update($validated);

        return redirect()->route('admin.medicines.index')
            ->with('success', 'Obat berhasil diperbarui.');
    }

    public function destroy(Medicine $medicine)
    {
        if ($medicine->batches()->exists()) {
            return redirect()->back()
                ->with('error', 'Tidak dapat menghapus obat yang memiliki batch.');
        }

        $medicine->delete();

        return redirect()->route('admin.medicines.index')
            ->with('success', 'Obat berhasil dihapus.');
    }

    public function addBatch()
    {
        return view('admin.medicines.addbatch');
    }
}
