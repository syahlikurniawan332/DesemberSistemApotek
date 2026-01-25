<x-layouts.app>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Laporan & Monitoring
            </h2>
            <span class="text-sm text-gray-500">
                {{ now()->translatedFormat('l, d F Y') }}
            </span>
        </div>
    </x-slot>

    <div class="mb-6 bg-white rounded-lg shadow p-4 border border-gray-200">
        <div class="flex flex-col md:flex-row md:items-center justify-between">
            <div class="mb-4 md:mb-0">
                <h2 class="text-lg font-semibold text-gray-800">Dashboard Penjualan</h2>
                <p class="text-gray-600 text-sm mt-1">
                    Periode: <span class="font-medium">{{ $period['period_name'] ?? 'Bulan Ini' }}</span>
                    ({{ $period['start'] }} - {{ $period['end'] }})
                </p>
            </div>

            <div class="flex flex-wrap gap-2">
                <!-- Filter Period Buttons -->
                <div class="inline-flex rounded-lg border border-gray-200 bg-gray-50 p-1">
                    <a href="{{ route('admin.reports.index', ['period' => 'today']) }}"
                        class="px-4 py-2 text-sm font-medium rounded-md transition-all duration-200 
                          {{ ($current_period ?? 'month') == 'today' 
                             ? 'bg-white text-primary-600 shadow-sm border border-gray-300' 
                             : 'text-gray-700 hover:text-primary-600 hover:bg-gray-100' }}">
                        Hari Ini
                    </a>
                    <a href="{{ route('admin.reports.index', ['period' => 'week']) }}"
                        class="px-4 py-2 text-sm font-medium rounded-md transition-all duration-200 
                          {{ ($current_period ?? 'month') == 'week' 
                             ? 'bg-white text-primary-600 shadow-sm border border-gray-300' 
                             : 'text-gray-700 hover:text-primary-600 hover:bg-gray-100' }}">
                        Minggu Ini
                    </a>
                    <a href="{{ route('admin.reports.index', ['period' => 'month']) }}"
                        class="px-4 py-2 text-sm font-medium rounded-md transition-all duration-200 
                          {{ ($current_period ?? 'month') == 'month' 
                             ? 'bg-white text-primary-600 shadow-sm border border-gray-300' 
                             : 'text-gray-700 hover:text-primary-600 hover:bg-gray-100' }}">
                        Bulan Ini
                    </a>
                    <a href="{{ route('admin.reports.index', ['period' => 'last_month']) }}"
                        class="px-4 py-2 text-sm font-medium rounded-md transition-all duration-200 
                          {{ ($current_period ?? 'month') == 'last_month' 
                             ? 'bg-white text-primary-600 shadow-sm border border-gray-300' 
                             : 'text-gray-700 hover:text-primary-600 hover:bg-gray-100' }}">
                        Bulan Lalu
                    </a>
                    <a href="{{ route('admin.reports.index', ['period' => 'year']) }}"
                        class="px-4 py-2 text-sm font-medium rounded-md transition-all duration-200 
                          {{ ($current_period ?? 'month') == 'year' 
                             ? 'bg-white text-primary-600 shadow-sm border border-gray-300' 
                             : 'text-gray-700 hover:text-primary-600 hover:bg-gray-100' }}">
                        Tahun Ini
                    </a>
                </div>

                <!-- Custom Date Range (Opsional) -->
                <div class="relative">
                    <button type="button"
                        onclick="toggleCustomDateRange()"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition flex items-center">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        Rentang Kustom
                    </button>

                    <!-- Custom Date Range Modal (Hidden by default) -->
                    <div id="customDateRangeModal"
                        class="hidden absolute right-0 mt-2 w-72 bg-white rounded-lg shadow-lg border border-gray-200 p-4 z-10">
                        <form action="{{ route('admin.reports.index') }}" method="GET" class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
                                <input type="date"
                                    name="start_date"
                                    value="{{ request('start_date') }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                                <input type="date"
                                    name="end_date"
                                    value="{{ request('end_date') }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                            </div>
                            <div class="flex justify-between pt-2">
                                <button type="button"
                                    onclick="toggleCustomDateRange()"
                                    class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="px-4 py-2 text-sm bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition">
                                    Terapkan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Reset Filter -->
                @if(request()->has('period') || request()->has('start_date'))
                <a href="{{ route('admin.reports.index') }}"
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition flex items-center">
                    <i class="fas fa-redo mr-2"></i>
                    Reset
                </a>
                @endif
            </div>
        </div>

        <!-- Info tentang filter yang aktif -->
        @if(request()->has('start_date') && request()->has('end_date'))
        <div class="mt-4 p-3 bg-blue-50 border border-blue-100 rounded-lg">
            <div class="flex items-center">
                <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                <p class="text-sm text-blue-700">
                    Menampilkan data dari <strong>{{ request('start_date') }}</strong>
                    sampai <strong>{{ request('end_date') }}</strong>
                </p>
            </div>
        </div>
        @endif
    </div>

    <!-- Grid Cards (Update beberapa teks untuk mencerminkan periode) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Card 1: Total Penjualan -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition-shadow duration-300">
            <div class="p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Penjualan</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-2">
                            {{ $total_sales['formatted'] ?? 'Rp 0' }}
                        </h3>
                        <div class="flex items-center mt-2">
                            @php
                            $salesGrowth = $growth ?? 0;
                            $salesGrowthClass = $salesGrowth >= 0 ? 'text-green-600' : 'text-red-600';
                            $salesGrowthIcon = $salesGrowth >= 0 ? 'fa-arrow-up' : 'fa-arrow-down';
                            @endphp
                            <span class="{{ $salesGrowthClass }} text-sm font-medium flex items-center">
                                <i class="fas {{ $salesGrowthIcon }} mr-1"></i>
                                {{ abs($salesGrowth) }}%
                            </span>
                            <span class="text-gray-500 text-sm ml-2">
                                dari {{ $period['previous_period_name'] ?? 'periode sebelumnya' }}
                            </span>
                        </div>
                    </div>
                    <div class="bg-primary-100 p-3 rounded-lg">
                        <i class="fas fa-wallet text-primary-600 text-xl"></i>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-gray-100">
                    <div class="flex justify-between items-center">
                        <div>
                            <span class="text-gray-500 text-sm">Jumlah Transaksi</span>
                            <p class="font-medium text-gray-700 text-lg">
                                {{ $total_sales['transaction_count'] ?? 0 }}
                            </p>
                        </div>
                        <div class="text-primary-600">
                            <i class="fas fa-receipt text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-2 text-xs text-gray-500">
                        Periode: {{ $period['start'] }} - {{ $period['end'] }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2: Jumlah Transaksi -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition-shadow duration-300">
            <div class="p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Jumlah Transaksi</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-2">
                            {{ $transaction_stats['total'] ?? 0 }}
                        </h3>
                        <div class="flex items-center mt-2">
                            @php
                            $transactionGrowth = $transaction_stats['growth'] ?? 0;
                            $transactionGrowthClass = $transactionGrowth >= 0 ? 'text-green-600' : 'text-red-600';
                            $transactionGrowthIcon = $transactionGrowth >= 0 ? 'fa-arrow-up' : 'fa-arrow-down';
                            @endphp
                            <span class="{{ $transactionGrowthClass }} text-sm font-medium flex items-center">
                                <i class="fas {{ $transactionGrowthIcon }} mr-1"></i>
                                {{ abs($transactionGrowth) }}%
                            </span>
                            <span class="text-gray-500 text-sm ml-2">
                                dari {{ $period['previous_period_name'] ?? 'bulan lalu' }}
                            </span>
                        </div>
                    </div>
                    <div class="bg-success-100 p-3 rounded-lg">
                        <i class="fas fa-shopping-cart text-success-600 text-xl"></i>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-gray-100">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Transaksi {{ $period['period_name'] ?? 'periode ini' }}</span>
                        <span class="font-medium text-gray-700">{{ $transaction_stats['total'] ?? 0 }}</span>
                    </div>
                    <div class="flex justify-between text-sm mt-1">
                        <span class="text-gray-500">{{ $period['previous_period_name'] ?? 'Bulan lalu' }}</span>
                        <span class="font-medium text-gray-700">{{ $transaction_stats['previous_total'] ?? 0 }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 3: Total Item Terjual -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition-shadow duration-300">
            <div class="p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Item Terjual</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-2">
                            {{ number_format($sold_items_stats['total_sold'] ?? 0, 0, ',', '.') }}
                        </h3>
                        <div class="flex items-center mt-2">
                            @php
                            $itemsGrowth = $sold_items_stats['growth'] ?? 0;
                            $itemsGrowthClass = $itemsGrowth >= 0 ? 'text-green-600' : 'text-red-600';
                            $itemsGrowthIcon = $itemsGrowth >= 0 ? 'fa-arrow-up' : 'fa-arrow-down';
                            @endphp
                            <span class="{{ $itemsGrowthClass }} text-sm font-medium flex items-center">
                                <i class="fas {{ $itemsGrowthIcon }} mr-1"></i>
                                {{ abs($itemsGrowth) }}%
                            </span>
                            <span class="text-gray-500 text-sm ml-2">
                                dari {{ $period['previous_period_name'] ?? 'bulan lalu' }}
                            </span>
                        </div>
                    </div>
                    <div class="bg-warning-100 p-3 rounded-lg">
                        <i class="fas fa-boxes text-warning-600 text-xl"></i>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-gray-100">
                    @if($sold_items_stats['top_product'] ?? false)
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Produk paling laris</span>
                        <span class="font-medium text-gray-700">
                            {{ $sold_items_stats['top_product']['name'] }}
                            ({{ $sold_items_stats['top_product']['total_sold'] }})
                        </span>
                    </div>
                    @else
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Produk paling laris</span>
                        <span class="font-medium text-gray-700">-</span>
                    </div>
                    @endif
                    <div class="flex justify-between text-sm mt-1">
                        <span class="text-gray-500">Rata-rata/item transaksi</span>
                        <span class="font-medium text-gray-700">
                            {{ $sold_items_stats['average_per_transaction'] ?? '0.00' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 4: Rata-rata Transaksi -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition-shadow duration-300">
            <div class="p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Rata-rata Transaksi</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-2">
                            {{ $average_stats['formatted_average'] ?? 'Rp 0' }}
                        </h3>
                        <div class="flex items-center mt-2">
                            @php
                            $avgGrowth = $average_stats['growth'] ?? 0;
                            $avgGrowthClass = $avgGrowth >= 0 ? 'text-green-600' : 'text-red-600';
                            $avgGrowthIcon = $avgGrowth >= 0 ? 'fa-arrow-up' : 'fa-arrow-down';
                            @endphp
                            <span class="{{ $avgGrowthClass }} text-sm font-medium flex items-center">
                                <i class="fas {{ $avgGrowthIcon }} mr-1"></i>
                                {{ abs($avgGrowth) }}%
                            </span>
                            <span class="text-gray-500 text-sm ml-2">
                                dari {{ $period['previous_period_name'] ?? 'bulan lalu' }}
                            </span>
                        </div>
                    </div>
                    <div class="bg-info-100 p-3 rounded-lg">
                        <i class="fas fa-chart-line text-info-600 text-xl"></i>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-gray-100">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Transaksi tertinggi</span>
                        <span class="font-medium text-gray-700">
                            {{ $average_stats['formatted_highest'] ?? 'Rp 0' }}
                        </span>
                    </div>
                    <div class="flex justify-between text-sm mt-1">
                        <span class="text-gray-500">Transaksi terendah</span>
                        <span class="font-medium text-gray-700">
                            {{ $average_stats['formatted_lowest'] ?? 'Rp 0' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Setelah grid cards, tambahkan section grafik -->
    <div class="mt-8 mb-8">
        <!-- Header Grafik dengan Filter -->
        <div class="mb-6 bg-white rounded-lg shadow p-4 border border-gray-200">
            <div class="flex flex-col md:flex-row md:items-center justify-between">
                <div class="mb-4 md:mb-0">
                    <h2 class="text-lg font-semibold text-gray-800">Insight & Analisis</h2>
                    <p class="text-gray-600 text-sm mt-1">
                        Visualisasi data penjualan untuk pengambilan keputusan
                    </p>
                </div>

                <div class="flex flex-wrap gap-2">
                    <!-- Filter Periode Grafik -->
                    <div class="inline-flex rounded-lg border border-gray-200 bg-gray-50 p-1">
                        <a href="{{ route('admin.reports.index', array_merge(request()->except('chart_period'), ['chart_period' => 'daily'])) }}"
                            class="px-4 py-2 text-sm font-medium rounded-md transition-all duration-200 
                              {{ ($current_chart_period ?? 'daily') == 'daily' 
                                 ? 'bg-white text-primary-600 shadow-sm border border-gray-300' 
                                 : 'text-gray-700 hover:text-primary-600 hover:bg-gray-100' }}">
                            7 Hari Terakhir
                        </a>
                        <a href="{{ route('admin.reports.index', array_merge(request()->except('chart_period'), ['chart_period' => 'weekly'])) }}"
                            class="px-4 py-2 text-sm font-medium rounded-md transition-all duration-200 
                              {{ ($current_chart_period ?? 'daily') == 'weekly' 
                                 ? 'bg-white text-primary-600 shadow-sm border border-gray-300' 
                                 : 'text-gray-700 hover:text-primary-600 hover:bg-gray-100' }}">
                            4 Minggu Terakhir
                        </a>
                        <a href="{{ route('admin.reports.index', array_merge(request()->except('chart_period'), ['chart_period' => 'monthly'])) }}"
                            class="px-4 py-2 text-sm font-medium rounded-md transition-all duration-200 
                              {{ ($current_chart_period ?? 'daily') == 'monthly' 
                                 ? 'bg-white text-primary-600 shadow-sm border border-gray-300' 
                                 : 'text-gray-700 hover:text-primary-600 hover:bg-gray-100' }}">
                            6 Bulan Terakhir
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grid Grafik -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Grafik 1: Line Chart - Tren Penjualan -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Tren Penjualan</h3>
                            <p class="text-gray-600 text-sm mt-1">
                                Perkembangan total penjualan dan jumlah transaksi
                            </p>
                        </div>
                        <div class="text-primary-600">
                            <i class="fas fa-chart-line text-xl"></i>
                        </div>
                    </div>

                    <div class="h-80">
                        <canvas id="salesTrendChart"></canvas>
                    </div>

                    <!-- Insight dari grafik -->
                    <div class="mt-6 pt-4 border-t border-gray-100">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="p-3 bg-blue-50 rounded-lg">
                                <p class="text-xs text-blue-700 font-medium">Puncak Penjualan</p>
                                <p class="text-sm font-semibold text-gray-800 mt-1">
                                    @php
                                    $salesData = $sales_chart['datasets']['sales']['data'] ?? [];
                                    $maxSales = count($salesData) > 0 ? max($salesData) : 0;
                                    $maxIndex = count($salesData) > 0 ? array_search($maxSales, $salesData) : 0;
                                    $maxLabel = $sales_chart['labels'][$maxIndex] ?? '-';
                                    @endphp
                                    {{ $maxLabel }}: Rp {{ number_format($maxSales, 0, ',', '.') }}
                                </p>
                            </div>
                            <div class="p-3 bg-green-50 rounded-lg">
                                <p class="text-xs text-green-700 font-medium">Transaksi Tertinggi</p>
                                <p class="text-sm font-semibold text-gray-800 mt-1">
                                    @php
                                    $transData = $sales_chart['datasets']['transactions']['data'] ?? [];
                                    $maxTrans = count($transData) > 0 ? max($transData) : 0;
                                    $maxTransIndex = count($transData) > 0 ? array_search($maxTrans, $transData) : 0;
                                    $maxTransLabel = $sales_chart['labels'][$maxTransIndex] ?? '-';
                                    @endphp
                                    {{ $maxTransLabel }}: {{ $maxTrans }} transaksi
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grafik 2: Bar Chart - Produk Terlaris -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Produk Terlaris</h3>
                            <p class="text-gray-600 text-sm mt-1">
                                Top 5 produk dengan penjualan tertinggi
                            </p>
                        </div>
                        <div class="text-warning-600">
                            <i class="fas fa-chart-bar text-xl"></i>
                        </div>
                    </div>

                    <div class="h-80">
                        <canvas id="topProductsChart"></canvas>
                    </div>

                    <!-- Detail produk terlaris -->
                    <div class="mt-6 pt-4 border-t border-gray-100">
                        <h4 class="text-sm font-medium text-gray-700 mb-3">Detail Produk</h4>
                        <div class="space-y-2">
                            @if(isset($products_chart['top_products']) && count($products_chart['top_products']) > 0)
                            @foreach($products_chart['top_products'] as $product)
                            <div class="flex justify-between items-center p-2 hover:bg-gray-50 rounded">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 rounded-full bg-primary-500 mr-3"></div>
                                    <span class="text-sm text-gray-700">{{ $product->product_name }}</span>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-semibold text-gray-800">{{ $product->total_sold }} unit</p>
                                    <p class="text-xs text-gray-500">Rp {{ number_format($product->total_revenue, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            @endforeach
                            @else
                            <p class="text-sm text-gray-500 text-center py-4">Belum ada data penjualan produk</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Insight Cards Bawah -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Insight 1: Hari Terbaik -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div class="p-3 bg-primary-100 rounded-lg mr-4">
                            <i class="fas fa-crown text-primary-600 text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Hari Terbaik</h3>
                            <p class="text-gray-600 text-sm">Penjualan tertinggi dalam periode</p>
                        </div>
                    </div>

                    @if($daily_insights['best_day'] ?? false)
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600 text-sm">Hari</span>
                            <span class="font-medium text-gray-800">{{ $daily_insights['best_day']['name'] }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 text-sm">Tanggal</span>
                            <span class="font-medium text-gray-800">{{ $daily_insights['best_day']['date'] }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 text-sm">Total Penjualan</span>
                            <span class="font-medium text-gray-800">Rp {{ number_format($daily_insights['best_day']['sales'], 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 text-sm">Jumlah Transaksi</span>
                            <span class="font-medium text-gray-800">{{ $daily_insights['best_day']['transactions'] }}</span>
                        </div>
                    </div>
                    @else
                    <p class="text-gray-500 text-center py-6">Belum ada data hari terbaik</p>
                    @endif
                </div>
            </div>

            <!-- Insight 2: Rata-rata Harian -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div class="p-3 bg-green-100 rounded-lg mr-4">
                            <i class="fas fa-calculator text-green-600 text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Rata-rata Harian</h3>
                            <p class="text-gray-600 text-sm">Statistik per hari</p>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600 text-sm">Rata-rata Penjualan/Hari</span>
                            <span class="font-medium text-gray-800">Rp {{ number_format($daily_insights['average_per_day'] ?? 0, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 text-sm">Hari dengan Transaksi</span>
                            <span class="font-medium text-gray-800">{{ $daily_insights['days_with_transactions'] ?? 0 }}/{{ $daily_insights['total_days'] ?? 30 }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2 mt-4">
                            @php
                            $transactionDays = $daily_insights['days_with_transactions'] ?? 0;
                            $totalDays = $daily_insights['total_days'] ?? 30;
                            $percentage = $totalDays > 0 ? ($transactionDays / $totalDays) * 100 : 0;
                            @endphp
                            <div class="bg-green-600 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">
                            {{ round($percentage, 1) }}% hari dalam periode memiliki transaksi
                        </p>
                    </div>
                </div>
            </div>

            <!-- Insight 3: Performa Periode -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div class="p-3 bg-purple-100 rounded-lg mr-4">
                            <i class="fas fa-chart-pie text-purple-600 text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Performa Periode</h3>
                            <p class="text-gray-600 text-sm">Ringkasan {{ $period['period_name'] ?? 'periode ini' }}</p>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="text-center p-3 bg-blue-50 rounded-lg">
                                <p class="text-xs text-blue-700 font-medium">Transaksi/Hari</p>
                                <p class="text-xl font-bold text-gray-800 mt-1">
                                    @php
                                    $avgTransPerDay = $total_days > 0 ? round($transaction_stats['total'] / $total_days, 1) : 0;
                                    @endphp
                                    {{ $avgTransPerDay }}
                                </p>
                            </div>
                            <div class="text-center p-3 bg-green-50 rounded-lg">
                                <p class="text-xs text-green-700 font-medium">Item/Transaksi</p>
                                <p class="text-xl font-bold text-gray-800 mt-1">
                                    {{ $sold_items_stats['average_per_transaction'] ?? '0.0' }}
                                </p>
                            </div>
                        </div>
                        <div class="text-center p-3 bg-yellow-50 rounded-lg mt-4">
                            <p class="text-xs text-yellow-700 font-medium">Nilai Rata-rata Transaksi</p>
                            <p class="text-xl font-bold text-gray-800 mt-1">
                                {{ $average_stats['formatted_average'] ?? 'Rp 0' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-8 mb-8">
        <!-- Header Tabel -->
        <div class="mb-6 bg-white rounded-lg shadow p-4 border border-gray-200">
            <div class="flex flex-col md:flex-row md:items-center justify-between">
                <div class="mb-4 md:mb-0">
                    <h2 class="text-lg font-semibold text-gray-800">Detail Transaksi</h2>
                    <p class="text-gray-600 text-sm mt-1">
                        Ringkasan transaksi {{ $period['period_name'] ?? 'periode ini' }}
                    </p>
                </div>

                <!-- Filter untuk tabel (opsional) -->
                <div class="flex items-center space-x-4">
                    <div class="text-sm text-gray-600">
                        <i class="fas fa-history mr-1"></i>
                        Menampilkan {{ $recent_transactions->count() ?? 0 }} transaksi terbaru
                    </div>
                    <a href="{{ route('admin.reports.index', ['start_date' => $period['raw_start']->format('Y-m-d'), 'end_date' => $period['raw_end']->format('Y-m-d')]) }}"
                        class="px-4 py-2 text-sm font-medium text-primary-600 bg-primary-50 hover:bg-primary-100 rounded-lg transition flex items-center">
                        <i class="fas fa-external-link-alt mr-2"></i>
                        Lihat Semua Transaksi
                    </a>
                </div>
            </div>
        </div>

        <!-- Grid Tabel dan Ringkasan -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Tabel Transaksi Terbaru -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-6">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">Transaksi Terbaru</h3>
                                <p class="text-gray-600 text-sm mt-1">
                                    10 transaksi terakhir dalam periode
                                </p>
                            </div>
                            <div class="text-primary-600">
                                <i class="fas fa-receipt text-xl"></i>
                            </div>
                        </div>

                        <!-- Tabel Responsive -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr class="bg-gray-50">
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            No. Transaksi
                                        </th>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Kasir
                                        </th>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Item
                                        </th>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Total
                                        </th>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Waktu
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @if($recent_transactions && count($recent_transactions) > 0)
                                    @foreach($recent_transactions as $transaction)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $transaction['no_transaction'] }}
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                {{ $transaction['total_items'] }} item
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $transaction['user_name'] }}</div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="text-sm text-gray-900 max-w-xs truncate"
                                                title="{{ $transaction['items'] }}">
                                                {{ $transaction['items'] }}
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <div class="text-sm font-semibold text-gray-900">
                                                {{ $transaction['formatted_total'] }}
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $transaction['formatted_date'] }}</div>
                                            <div class="text-xs text-gray-500">{{ $transaction['time_ago'] }}</div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="5" class="px-4 py-8 text-center text-gray-500">
                                            <div class="flex flex-col items-center justify-center">
                                                <i class="fas fa-receipt text-3xl text-gray-300 mb-2"></i>
                                                <p class="text-sm">Belum ada transaksi dalam periode ini</p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <!-- Footer Tabel -->
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <div class="flex justify-between items-center">
                                <div class="text-sm text-gray-600">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Total {{ $recent_transactions->count() ?? 0 }} transaksi
                                </div>
                                @if($recent_transactions && count($recent_transactions) > 0)
                                <div class="text-sm font-medium text-gray-800">
                                    Total: {{ $recent_transactions->sum('total') ? 'Rp ' . number_format($recent_transactions->sum('total'), 0, ',', '.') : 'Rp 0' }}
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar - Ringkasan Harian -->
            <div>
                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 h-full">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-6">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">Ringkasan Harian</h3>
                                <p class="text-gray-600 text-sm mt-1">
                                    14 hari terakhir
                                </p>
                            </div>
                            <div class="text-success-600">
                                <i class="fas fa-calendar-alt text-xl"></i>
                            </div>
                        </div>

                        <!-- List Ringkasan Harian -->
                        <div class="space-y-4 max-h-[500px] overflow-y-auto pr-2">
                            @if($daily_summary && count($daily_summary) > 0)
                            @foreach($daily_summary as $day)
                            <div class="p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <h4 class="font-medium text-gray-800">{{ $day['formatted_date'] }}</h4>
                                        <p class="text-xs text-gray-500 mt-1">
                                            {{ $day['time_range'] }}
                                        </p>
                                    </div>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                                {{ $day['transaction_count'] > 0 ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $day['transaction_count'] }} transaksi
                                    </span>
                                </div>

                                <div class="grid grid-cols-2 gap-2 mt-3">
                                    <div class="text-center p-2 bg-blue-50 rounded">
                                        <p class="text-xs text-blue-700">Total</p>
                                        <p class="text-sm font-semibold text-gray-800">
                                            {{ $day['formatted_sales'] }}
                                        </p>
                                    </div>
                                    <div class="text-center p-2 bg-green-50 rounded">
                                        <p class="text-xs text-green-700">Rata-rata</p>
                                        <p class="text-sm font-semibold text-gray-800">
                                            {{ $day['formatted_average'] }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @else
                            <div class="text-center py-8 text-gray-500">
                                <i class="fas fa-calendar-times text-3xl text-gray-300 mb-2"></i>
                                <p class="text-sm">Belum ada data harian</p>
                            </div>
                            @endif
                        </div>

                        <!-- Statistik Cepat -->
                        @if($daily_summary && count($daily_summary) > 0)
                        <div class="mt-6 pt-4 border-t border-gray-200">
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Hari tersibuk:</span>
                                    @php
                                    $busiestDay = $daily_summary->sortByDesc('transaction_count')->first();
                                    @endphp
                                    <span class="text-sm font-medium text-gray-800">
                                        {{ $busiestDay['formatted_date'] ?? '-' }}
                                    </span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Penjualan tertinggi:</span>
                                    @php
                                    $highestDay = $daily_summary->sortByDesc('total_sales')->first();
                                    @endphp
                                    <span class="text-sm font-medium text-gray-800">
                                        {{ $highestDay['formatted_sales'] ?? '-' }}
                                    </span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Rata-rata harian:</span>
                                    @php
                                    $avgDaily = $daily_summary->avg('total_sales');
                                    @endphp
                                    <span class="text-sm font-medium text-gray-800">
                                        Rp {{ number_format($avgDaily, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats Bar -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 mb-8">
            <div class="p-4">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="text-center p-3">
                        <p class="text-xs text-gray-500 font-medium">Total Transaksi</p>
                        <p class="text-xl font-bold text-gray-800 mt-1">
                            {{ $transaction_stats['total'] ?? 0 }}
                        </p>
                    </div>
                    <div class="text-center p-3">
                        <p class="text-xs text-gray-500 font-medium">Total Item Terjual</p>
                        <p class="text-xl font-bold text-gray-800 mt-1">
                            {{ number_format($sold_items_stats['total_sold'] ?? 0, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="text-center p-3">
                        <p class="text-xs text-gray-500 font-medium">Nilai Transaksi Tertinggi</p>
                        <p class="text-xl font-bold text-gray-800 mt-1">
                            {{ $average_stats['formatted_highest'] ?? 'Rp 0' }}
                        </p>
                    </div>
                    <div class="text-center p-3">
                        <p class="text-xs text-gray-500 font-medium">Transaksi Rata-rata</p>
                        <p class="text-xl font-bold text-gray-800 mt-1">
                            {{ $average_stats['formatted_average'] ?? 'Rp 0' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Chart.js dari CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- JavaScript untuk toggle custom date range -->
    <script>
        function toggleCustomDateRange() {
            const modal = document.getElementById('customDateRangeModal');
            modal.classList.toggle('hidden');
        }

        // Close modal when clicking outside
        document.addEventListener('click', function(event) {
            const modal = document.getElementById('customDateRangeModal');
            const button = document.querySelector('[onclick="toggleCustomDateRange()"]');

            if (!modal.contains(event.target) && !button.contains(event.target)) {
                modal.classList.add('hidden');
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Grafik 1: Line Chart - Tren Penjualan
            const salesTrendCtx = document.getElementById('salesTrendChart').getContext('2d');

            // Data dari PHP (disimpan di data attribute atau langsung di JS)
            const salesChartData = @json($sales_chart);

            new Chart(salesTrendCtx, {
                type: 'line',
                data: {
                    labels: salesChartData.labels || [],
                    datasets: [{
                        label: salesChartData.datasets?.sales?.label || 'Total Penjualan',
                        data: salesChartData.datasets?.sales?.data || [],
                        borderColor: salesChartData.datasets?.sales?.borderColor || '#3b82f6',
                        backgroundColor: salesChartData.datasets?.sales?.backgroundColor || 'rgba(59, 130, 246, 0.1)',
                        fill: true,
                        tension: 0.4,
                        yAxisID: 'y'
                    }, {
                        label: salesChartData.datasets?.transactions?.label || 'Jumlah Transaksi',
                        data: salesChartData.datasets?.transactions?.data || [],
                        borderColor: salesChartData.datasets?.transactions?.borderColor || '#10b981',
                        backgroundColor: salesChartData.datasets?.transactions?.backgroundColor || 'rgba(16, 185, 129, 0.1)',
                        fill: true,
                        tension: 0.4,
                        yAxisID: 'y1'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    scales: {
                        x: {
                            grid: {
                                display: true,
                                color: 'rgba(0, 0, 0, 0.05)'
                            }
                        },
                        y: {
                            type: 'linear',
                            display: true,
                            position: 'left',
                            title: {
                                display: true,
                                text: 'Total Penjualan (Rp)'
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            },
                            ticks: {
                                callback: function(value) {
                                    if (value >= 1000000) {
                                        return 'Rp' + (value / 1000000).toFixed(1) + 'Jt';
                                    }
                                    if (value >= 1000) {
                                        return 'Rp' + (value / 1000).toFixed(0) + 'K';
                                    }
                                    return 'Rp' + value;
                                }
                            }
                        },
                        y1: {
                            type: 'linear',
                            display: true,
                            position: 'right',
                            title: {
                                display: true,
                                text: 'Jumlah Transaksi'
                            },
                            grid: {
                                drawOnChartArea: false,
                            },
                            ticks: {
                                precision: 0
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label.includes('Penjualan')) {
                                        return label + ': Rp ' + context.parsed.y.toLocaleString('id-ID');
                                    }
                                    return label + ': ' + context.parsed.y + ' transaksi';
                                }
                            }
                        },
                        legend: {
                            position: 'top',
                        }
                    }
                }
            });

            // Grafik 2: Bar Chart - Produk Terlaris
            const topProductsCtx = document.getElementById('topProductsChart').getContext('2d');

            const productsChartData = @json($products_chart);

            new Chart(topProductsCtx, {
                type: 'bar',
                data: {
                    labels: productsChartData.labels || [],
                    datasets: productsChartData.datasets || []
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return 'Terjual: ' + context.parsed.y + ' unit';
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>

</x-layouts.app>