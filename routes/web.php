<?php

use App\Http\Controllers\Admin\BatchController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\MedicineController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Apoteker\TransactionController;

Route::get('/', function () {
    return view('welcome');
});

require __DIR__ . '/auth.php';

// Semua route butuh login
Route::middleware(['auth'])->group(function () {

    // Redirect berdasarkan role
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware(['auth'])
        ->name('dashboard');

    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        
     Route::get('/dashboard', [DashboardController::class, 'index'])
                ->name('dashboard');
                
    // Master data obat
        Route::prefix('medicines')->name('medicines.')->group(function () {
            Route::get('/', [MedicineController::class, 'index'])->name('index');         // admin.medicines.index
            Route::get('/create', [MedicineController::class, 'create'])->name('create'); // admin.medicines.create
            Route::post('/', [MedicineController::class, 'store'])->name('store');        // admin.medicines.store
            Route::get('/{medicine}', [MedicineController::class, 'show'])->name('show'); // admin.medicines.show
            Route::get('/{medicine}/edit', [MedicineController::class, 'edit'])->name('edit'); // admin.medicines.edit
            Route::put('/{medicine}', [MedicineController::class, 'update'])->name('update'); // admin.medicines.update
            Route::delete('/{medicine}', [MedicineController::class, 'destroy'])->name('destroy'); // admin.medicines.destroy
        });

        Route::prefix('medicines/{medicine}/batches')
            ->name('batches.')
            ->group(function () {
                Route::get('/create', [BatchController::class, 'create'])->name('create');
                Route::post('/', [BatchController::class, 'store'])->name('store');
                Route::get('{batch}/edit', [BatchController::class, 'edit'])->name('edit');
                Route::put('{batch}', [BatchController::class, 'update'])->name('update');
            });

        Route::prefix('usermanagemen')
            ->name('usermanagemen.')
            ->group(function () {
                // Tulis CREATE dan STORE terlebih dahulu
                Route::get('/create', [UserManagementController::class, 'create'])->name('create');
                Route::post('/', [UserManagementController::class, 'store'])->name('store');

                // Baru kemudian rute yang lain
                Route::get('/', [UserManagementController::class, 'index'])->name('index');
                Route::get('/{user}/edit', [UserManagementController::class, 'edit'])->name('edit');
                Route::put('/{user}', [UserManagementController::class, 'update'])->name('update');
                Route::delete('/{user}', [UserManagementController::class, 'destroy'])->name('destroy');
            });

        Route::get('/reports', [ReportController::class, 'index'])
            ->name('reports.index');
    });

    // Route dashboard apoteker
    Route::middleware(['role:apoteker'])
        ->prefix('apoteker')
        ->name('apoteker.')
        ->group(function () {

            Route::get('/dashboard', [DashboardController::class, 'index'])
                ->name('dashboard');

            Route::prefix('transactions')->name('transactions.')->group(function () {
                Route::get('/', [TransactionController::class, 'index'])->name('index');
                Route::get('/create', [TransactionController::class, 'create'])->name('create');
                Route::post('/', [TransactionController::class, 'store'])->name('store');
                Route::get('/{id}', [TransactionController::class, 'show'])->name('show');
                Route::get('/{transaction}/edit', [TransactionController::class, 'edit'])->name('edit');
                Route::put('/{transaction}', [TransactionController::class, 'update'])->name('update');
            });
        });


    // Route profile (dari Breeze)
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
