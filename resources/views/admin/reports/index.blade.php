<x-layouts.app>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800">
                Laporan & Monitoring
            </h2>
            <span class="text-sm text-gray-500">
                {{ now()->translatedFormat('l, d F Y') }}
            </span>
        </div>
    </x-slot>

    <!-- Header Section -->
    <div class="mb-8">

        <!-- Filter Cards -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">

            <a href="?filter=today"
                class="group relative overflow-hidden bg-white rounded-xl border {{ $filter === 'today' ? 'border-green-300 shadow-lg shadow-green-100' : 'border-gray-200 hover:border-green-200' }} 
                  p-4 transition-all duration-300 hover:shadow-md hover:-translate-y-0.5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium {{ $filter === 'today' ? 'text-green-700' : 'text-gray-600' }}">Hari Ini</p>
                        <div class="mt-2 h-1 w-8 {{ $filter === 'today' ? 'bg-gradient-to-r from-green-400 to-emerald-500' : 'bg-gray-200' }} rounded-full"></div>
                    </div>
                    <div class="p-2 rounded-lg {{ $filter === 'today' ? 'bg-green-50' : 'bg-gray-50 group-hover:bg-green-50' }} transition-colors">
                        <svg class="w-5 h-5 {{ $filter === 'today' ? 'text-green-600' : 'text-gray-400 group-hover:text-green-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
            </a>

            <a href="?filter=week"
                class="group relative overflow-hidden bg-white rounded-xl border {{ $filter === 'week' ? 'border-blue-300 shadow-lg shadow-blue-100' : 'border-gray-200 hover:border-blue-200' }} 
                  p-4 transition-all duration-300 hover:shadow-md hover:-translate-y-0.5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium {{ $filter === 'week' ? 'text-blue-700' : 'text-gray-600' }}">Minggu Ini</p>
                        <div class="mt-2 h-1 w-8 {{ $filter === 'week' ? 'bg-gradient-to-r from-blue-400 to-cyan-500' : 'bg-gray-200' }} rounded-full"></div>
                    </div>
                    <div class="p-2 rounded-lg {{ $filter === 'week' ? 'bg-blue-50' : 'bg-gray-50 group-hover:bg-blue-50' }} transition-colors">
                        <svg class="w-5 h-5 {{ $filter === 'week' ? 'text-blue-600' : 'text-gray-400 group-hover:text-blue-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
            </a>

            <a href="?filter=month"
                class="group relative overflow-hidden bg-white rounded-xl border {{ $filter === 'month' ? 'border-purple-300 shadow-lg shadow-purple-100' : 'border-gray-200 hover:border-purple-200' }} 
                  p-4 transition-all duration-300 hover:shadow-md hover:-translate-y-0.5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium {{ $filter === 'month' ? 'text-purple-700' : 'text-gray-600' }}">Bulan Ini</p>
                        <div class="mt-2 h-1 w-8 {{ $filter === 'month' ? 'bg-gradient-to-r from-purple-400 to-violet-500' : 'bg-gray-200' }} rounded-full"></div>
                    </div>
                    <div class="p-2 rounded-lg {{ $filter === 'month' ? 'bg-purple-50' : 'bg-gray-50 group-hover:bg-purple-50' }} transition-colors">
                        <svg class="w-5 h-5 {{ $filter === 'month' ? 'text-purple-600' : 'text-gray-400 group-hover:text-purple-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
            </a>

            <a href="?filter=year"
                class="group relative overflow-hidden bg-white rounded-xl border {{ $filter === 'year' ? 'border-amber-300 shadow-lg shadow-amber-100' : 'border-gray-200 hover:border-amber-200' }} 
                  p-4 transition-all duration-300 hover:shadow-md hover:-translate-y-0.5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium {{ $filter === 'year' ? 'text-amber-700' : 'text-gray-600' }}">Tahun Ini</p>
                        <div class="mt-2 h-1 w-8 {{ $filter === 'year' ? 'bg-gradient-to-r from-amber-400 to-orange-500' : 'bg-gray-200' }} rounded-full"></div>
                    </div>
                    <div class="p-2 rounded-lg {{ $filter === 'year' ? 'bg-amber-50' : 'bg-gray-50 group-hover:bg-amber-50' }} transition-colors">
                        <svg class="w-5 h-5 {{ $filter === 'year' ? 'text-amber-600' : 'text-gray-400 group-hover:text-amber-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Stats Grid - Simplified 4 Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

        <!-- Total Transaksi Card -->
        <div class="group bg-white rounded-2xl border border-gray-200 p-6 shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 rounded-xl bg-green-50 group-hover:bg-green-100 transition-colors">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <span class="text-xs font-medium px-2 py-1 rounded-full bg-gray-100 text-gray-600">
                    {{ ucfirst($filter) }}
                </span>
            </div>

            <p class="text-sm text-gray-500 mb-2">Total Transaksi</p>
            <h2 class="text-3xl font-bold text-gray-800 mb-3">{{ $total_transaksi }}</h2>
            <div class="flex items-center text-xs text-gray-400">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
                <span>transaksi berhasil</span>
            </div>
        </div>

        <!-- Total Omzet Card -->
        <div class="group bg-white rounded-2xl border border-gray-200 p-6 shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 rounded-xl bg-blue-50 group-hover:bg-blue-100 transition-colors">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <span class="text-xs font-medium px-2 py-1 rounded-full bg-blue-50 text-blue-700">
                    Rata: Rp {{ number_format($rata_rata_transaksi, 0, ',', '.') }}
                </span>
            </div>

            <p class="text-sm text-gray-500 mb-2">Total Omzet</p>
            <h2 class="text-3xl font-bold text-green-600 mb-3">Rp {{ number_format($omzet, 0, ',', '.') }}</h2>
            <div class="flex items-center text-xs text-gray-400">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                <span>pendapatan bersih</span>
            </div>
        </div>

        <!-- Item Terjual Card -->
        <div class="group bg-white rounded-2xl border border-gray-200 p-6 shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 rounded-xl bg-purple-50 group-hover:bg-purple-100 transition-colors">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <span class="text-xs font-medium px-2 py-1 rounded-full bg-purple-50 text-purple-700">
                    @if($total_transaksi > 0 && $total_obat > 0)
                    {{ number_format($total_obat / $total_transaksi, 1) }}/trans
                    @else
                    0/trans
                    @endif
                </span>
            </div>

            <p class="text-sm text-gray-500 mb-2">Item Terjual</p>
            <h2 class="text-3xl font-bold text-gray-800 mb-3">{{ $total_obat }}</h2>
            <div class="flex items-center text-xs text-gray-400">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>unit obat terjual</span>
            </div>
        </div>

        <!-- Profit Card -->
        <div class="group bg-white rounded-2xl border border-gray-200 p-6 shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 rounded-xl bg-orange-50 group-hover:bg-orange-100 transition-colors">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <span class="text-xs font-medium px-2 py-1 rounded-full bg-orange-50 text-orange-700">
                    @if($omzet > 0 && $profit > 0)
                    {{ number_format(($profit / $omzet) * 100, 1) }}% margin
                    @else
                    0% margin
                    @endif
                </span>
            </div>

            <p class="text-sm text-gray-500 mb-2">Profit</p>
            <h2 class="text-3xl font-bold text-gray-800 mb-3">Rp {{ number_format($profit, 0, ',', '.') }}</h2>
            <div class="flex items-center text-xs text-gray-400">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
                <span>keuntungan bersih</span>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="text-lg font-semibold mb-4">Grafik Omzet</h3>

        <canvas id="omzetChart" height="100"></canvas>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="text-lg font-semibold mb-4">
            Grafik Top Obat Terlaris
        </h3>

        <canvas id="topObatChart" height="160"></canvas>
    </div>


    <script>
        window.topObatRawData = @json($topObat);
        window.reportChartData = @json($omzetChart);
    </script>
    @vite('resources/js/reports.js')

</x-layouts.app>
