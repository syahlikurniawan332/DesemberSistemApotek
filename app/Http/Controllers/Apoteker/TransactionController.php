<?php

namespace App\Http\Controllers\Apoteker;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use App\Models\Transaction;
use App\Services\TransactionDetailService;
use DomainException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;

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
            'medicines'       => $this->transactionService->getAvailableMedicines(),
        ]);
    }

    // Simpan transaksi
    public function store(Request $request)
    {
        $validated = $request->validate([
            'medicines'                     => 'required|array|min:1',
            'medicines.*.medicine_id'       => 'required|integer|distinct|exists:medicines,id',
            'medicines.*.quantity'          => 'required|integer|min:1',
        ]);

        try {
            $transaction = $this->transactionService->store($validated);

            return redirect()
                ->route('apoteker.transactions.show', $transaction->id)
                ->with('success', 'Transaksi berhasil disimpan');
        } catch (DomainException $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        } catch (Throwable $e) {
            report($e);

            return back()
                ->withInput()
                ->with('error', 'Transaksi gagal disimpan. Silakan coba lagi.');
        }
    }

    public function edit(Transaction $transaction, TransactionDetailService $service)
    {
        $this->ensureTransactionOwner($transaction);

        $transaction = $service->getTransactionForEdit($transaction);

        $medicines = Medicine::with('batches')->get();

        return view('apoteker.transactions.edit', compact(
            'transaction',
            'medicines'
        ));
    }

    public function update(Request $request, Transaction $transaction, TransactionDetailService $service)
    {
        $this->ensureTransactionOwner($transaction);

        $validated = $request->validate([
            'medicines' => 'required|array|min:1',
            'medicines.*.batch_id' => 'required|integer|distinct|exists:batches,id',
            'medicines.*.quantity' => 'required|integer|min:1',
        ]);

        try {
            $service->update($transaction, $validated);
            return redirect()
                ->route('apoteker.transactions.show', $transaction)
                ->with('success', 'Transaksi berhasil diperbarui');
        } catch (DomainException $e) {
            return back()->with('error', $e->getMessage());
        } catch (Throwable $e) {
            report($e);

            return back()
                ->withInput()
                ->with('error', 'Transaksi gagal diperbarui. Silakan coba lagi.');
        }
    }

    private function ensureTransactionOwner(Transaction $transaction): void
    {
        abort_unless($transaction->user_id === Auth::id(), 404);
    }
}
