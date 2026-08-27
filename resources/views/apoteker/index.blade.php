{{-- File: resources/views/dashboard/index.blade.php --}}
<x-layouts.app title="Dashboard">

    <div class="bg-white rounded-lg shadow p-6">
        <x-slot name="header">
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Dashboard Apoteker
                </h2>
                <span class="text-sm text-gray-500">
                    {{ now()->translatedFormat('l, d F Y') }}
                </span>
            </div>
        </x-slot>

        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <!-- Quick Stats -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Penjualan Hari Ini -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500">Penjualan Hari Ini</p>
                                <p class="text-2xl font-bold text-gray-900">
                                    Rp {{ number_format($quickStats['today_sales'], 0, ',', '.') }}
                                </p>
                            </div>
                            <div class="p-3 bg-green-100 rounded-lg">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="mt-2">
                            <p class="text-xs text-gray-500">
                                {{ $quickStats['today_transactions'] }} transaksi
                            </p>
                        </div>
                    </div>

                    <!-- Stok Rendah -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500">Obat Stok Rendah</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $quickStats['low_stock_medicines'] }}</p>
                            </div>
                            <div class="p-3 bg-red-100 rounded-lg">
                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.618 5.984A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016zM12 9v2m0 4h.01" />
                                </svg>
                            </div>
                        </div>
                        <div class="mt-2">
                            <p class="text-xs text-gray-500">
                                Segera tambah stok obat
                            </p>
                        </div>
                    </div>

                    <!-- Batch Kadaluarsa -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500">Batch Kadaluarsa</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $quickStats['expiring_batches'] }}</p>
                            </div>
                            <div class="p-3 bg-yellow-100 rounded-lg">
                                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="mt-2">
                            <p class="text-xs text-gray-500">
                                dalam 30 hari
                            </p>
                        </div>
                    </div>

                    <!-- Transaksi Baru -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500">Transaksi</p>
                                <p class="text-2xl font-bold text-gray-900">+ Baru</p>
                            </div>
                            <div class="p-3 bg-blue-100 rounded-lg">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="mt-2">
                            <a href="#" class="text-xs font-medium text-blue-600 hover:text-blue-800">
                                Buat transaksi baru →
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Two Columns Layout -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    <!-- Obat Stok Rendah -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Obat Stok Rendah</h3>
                        <div class="space-y-4">
                            @forelse($lowStockMedicines as $medicine)
                            <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $medicine->nama }}</p>
                                    <p class="text-sm text-gray-500">{{ $medicine->kategori }} • {{ $medicine->satuan }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-red-600">{{ $medicine->total_stok }} stok</p>
                                    <p class="text-xs text-gray-500">min: {{ $medicine->min_stok }}</p>
                                </div>
                            </div>
                            @empty
                            <p class="text-gray-500 text-center py-4">Tidak ada obat dengan stok rendah</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Batch Kadaluarsa -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Batch Kadaluarsa Terdekat</h3>
                        <div class="space-y-4">
                            @forelse($expiringBatches as $batch)
                            <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-lg">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $batch->medicine->nama }}</p>
                                    <p class="text-sm text-gray-500">No. Batch: {{ $batch->no_batch }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-yellow-600">{{ $batch->tanggal_kadaluarsa }}</p>
                                    <p class="text-xs text-gray-500">{{ $batch->stok }} stok tersisa</p>
                                </div>
                            </div>
                            @empty
                            <p class="text-gray-500 text-center py-4">Tidak ada batch yang akan kedaluwarsa dalam 60 hari</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Two Columns Layout (Part 2) -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Transaksi Terbaru -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Transaksi Terbaru</h3>
                        <div class="space-y-4">
                            @forelse($recentTransactions as $transaction)
                            <div class="flex items-center justify-between p-3 border border-gray-100 rounded-lg hover:bg-gray-50">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $transaction->no_transaction }}</p>
                                    <p class="text-sm text-gray-500">{{ $transaction->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-green-600">Rp {{ number_format($transaction->total, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            @empty
                            <p class="text-gray-500 text-center py-4">Belum ada transaksi</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Obat Terlaris Hari Ini -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Obat Terlaris Hari Ini</h3>
                        <div class="space-y-4">
                            @forelse($topSellingToday as $medicine)
                            <div class="flex items-center justify-between p-3 border border-gray-100 rounded-lg">
                                <div class="flex items-center">
                                    <span class="flex items-center justify-center w-8 h-8 bg-blue-100 text-blue-600 rounded-full font-bold mr-3">
                                        {{ $loop->iteration }}
                                    </span>
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $medicine->nama }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-gray-900">{{ $medicine->total_terjual }} terjual</p>
                                </div>
                            </div>
                            @empty
                            <p class="text-gray-500 text-center py-4">Belum ada penjualan hari ini</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

</x-layouts.app>
