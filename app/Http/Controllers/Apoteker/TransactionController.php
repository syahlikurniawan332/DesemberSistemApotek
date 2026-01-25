<?php

namespace App\Http\Controllers\Apoteker;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use App\Models\Transaction;
use App\Services\TransactionDetailService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    protected $transactionService;

    public function __construct(TransactionDetailService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function index()
    {
        // Ambil data lewat service
        $transactions = $this->transactionService->getTransactionsForIndex(10);

        // Kirim ke view
        return view('apoteker.transactions.index', compact('transactions'));
    }

    public function show(int $id)
    {
        // Ambil data transaksi lengkap
        $transaction = $this->transactionService->getTransactionDetail($id);

        // Kirim ke view
        return view('apoteker.transactions.show', compact('transaction'));
    }


    // create transaksi
    public function create()
    {
        return view('apoteker.transactions.create', [
            'transactionCode' => $this->transactionService->generateTransactionCode(),
            'medicines'       => $this->transactionService->getAvailableMedicines(),
        ]);
    }

    // Simpan transaksi
    public function store(Request $request)
    {
        $request->validate([
            'medicines'                     => 'required|array|min:1',
            'medicines.*.medicine_id'       => 'required|integer',
            'medicines.*.quantity'          => 'required|integer|min:1',
        ]);

        try {
            $transaction = $this->transactionService->store($request->all());

            return redirect()
                ->route('apoteker.transactions.show', $transaction->id)
                ->with('success', 'Transaksi berhasil disimpan');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function edit(Transaction $transaction, TransactionDetailService $service)
    {
        $transaction = $service->getTransactionForEdit($transaction);

        $medicines = Medicine::with('batches')->get();

        return view('apoteker.transactions.edit', compact(
            'transaction',
            'medicines'
        ));
    }

    public function update(Request $request, Transaction $transaction, TransactionDetailService $service)
    {
        $request->validate([
            'medicines' => 'required|array|min:1',
            'medicines.*.batch_id' => 'required|exists:batches,id',
            'medicines.*.quantity' => 'required|integer|min:1',
        ]);

        try {
            $service->update($transaction, $request->all());
            return redirect()
                ->route('apoteker.transactions.show', $transaction)
                ->with('success', 'Transaksi berhasil diperbarui');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
