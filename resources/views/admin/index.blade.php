{{-- File: resources/views/dashboard/index.blade.php --}}
<x-layouts.app title="Dashboard">

    <div class="bg-white rounded-lg shadow p-6">
        <x-slot name="header">
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Dashboard Admin
                </h2>
                <span class="text-sm text-gray-500">
                    {{ now()->translatedFormat('l, d F Y') }}
                </span>
            </div>
        </x-slot>

        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <!-- Statistic Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Total Obat -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500">Total Obat</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $medicines['total_obat'] }}</p>
                            </div>
                            <div class="p-3 bg-blue-100 rounded-lg">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                {{ $medicines['stok_rendah'] }} Stok Rendah
                            </span>
                        </div>
                    </div>

                    <!-- Total Batch -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500">Total Batch</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $batches['batch_tersedia'] }}</p>
                            </div>
                            <div class="p-3 bg-green-100 rounded-lg">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                        </div>
                        <div class="mt-2">
                            <p class="text-xs text-gray-500">
                                {{ $batches['expiring_soon'] }} akan kedaluwarsa dalam 30 hari
                                @if ($batches['expired'] > 0)
                                    · <span class="text-red-600">{{ $batches['expired'] }} sudah kedaluwarsa</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <!-- Total Transaksi -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500">Penjualan Hari Ini</p>
                                <p class="text-2xl font-bold text-gray-900">
                                    Rp {{ number_format($transactionStats['today'], 0, ',', '.') }}
                                </p>
                            </div>
                            <div class="p-3 bg-purple-100 rounded-lg">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="mt-2">
                            <p class="text-xs text-gray-500">
                                {{ $transactionStats['total_count'] }} transaksi total
                            </p>
                        </div>
                    </div>

                    <!-- Total User -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500">Total User</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $userStash['total_user'] }}</p>
                            </div>
                            <div class="p-3 bg-yellow-100 rounded-lg">
                                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9.197h-7.5" />
                                </svg>
                            </div>
                        </div>
                        <div class="mt-2">
                            <p class="text-xs text-gray-500">
                                {{ $userStash['admins'] }} admin, {{ $userStash['apotekers'] }} apoteker
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Charts & Tables -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Sales Chart -->
                    <div class="bg-white p-6 rounded-lg shadow mb-6">
                        <h3 class="text-lg font-semibold mb-3">Penjualan 7 Hari Terakhir</h3>

                        <canvas id="sales7DaysChart" height="120"></canvas>
                    </div>

                    <!-- Medicine by Category -->
                    <div class="bg-white p-6 rounded-lg shadow mb-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">
                            5 Obat Paling Laku ({{ now()->format('F Y') }})

                        </h3>

                        <div class="relative h-72">
                            <canvas id="topMedicinesChart"></canvas>
                        </div>
                    </div>

                </div>

            </div>
        </div>

        <script>
            const salesData = @json($last7DaysSales);
            const topMedicines = @json($topMedicines);

            const labels = salesData.map(item => item.date);
            const totals = salesData.map(item => item.total);
            const ctx = document.getElementById('sales7DaysChart').getContext('2d');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Total Penjualan',
                        data: totals,
                        borderWidth: 2,
                        borderColor: 'rgb(75, 192, 192)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        tension: 0.3,
                        fill: true,
                    }],
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                        }
                    }
                }
            });

            const names = topMedicines.map(item => item.nama + " (" + item.kategori + ")");
            const total_tops = topMedicines.map(item => item.total_terjual);

            const ctxTop = document.getElementById('topMedicinesChart').getContext('2d');

            new Chart(ctxTop, {
                type: 'bar',
                data: {
                    labels: names,
                    datasets: [{
                        label: 'Jumlah Terjual',
                        data: total_tops,
                        borderWidth: 1,
                        backgroundColor: [
                            'rgba(75, 192, 192, 0.4)',
                            'rgba(54, 162, 235, 0.4)',
                            'rgba(255, 159, 64, 0.4)',
                            'rgba(153, 102, 255, 0.4)',
                            'rgba(255, 99, 132, 0.4)',
                        ],
                        borderColor: [
                            'rgb(75, 192, 192)',
                            'rgb(54, 162, 235)',
                            'rgb(255, 159, 64)',
                            'rgb(153, 102, 255)',
                            'rgb(255, 99, 132)',
                        ],
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });
        </script>

</x-layouts.app>
