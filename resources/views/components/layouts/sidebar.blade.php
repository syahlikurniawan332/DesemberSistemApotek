<div class="flex-shrink-0">
    <div class="lg:hidden fixed top-4 left-4 z-50">
        <button id="sidebar-toggle"
            class="p-2 rounded-lg bg-white shadow-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-green-500 transition duration-200">
            <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    <div id="sidebar-overlay"
        class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden"></div>

    <aside id="sidebar"
        class="fixed lg:relative top-0 left-0 h-full w-64 bg-white shadow-xl transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out z-40 border-r border-gray-100 lg:h-full">
        <nav class="p-4 space-y-1 h-full overflow-y-auto">
            <a href="{{ route('dashboard') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 
                      {{ request()->routeIs('dashboard') 
                         ? 'bg-green-50 text-green-700 border-r-4 border-green-600 font-semibold' 
                         : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <div class="w-6 h-6 flex items-center justify-center">
                    <svg class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-green-600' : 'text-gray-400' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                </div>
                <span>Dashboard</span>
            </a>

            @if (Auth::user()->role === 'admin')

            <a href="{{ route('admin.medicines.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200
                {{ request()->routeIs('admin.medicines.*') 
                ? 'bg-green-50 text-green-700 border-r-4 border-green-600 font-semibold'
                : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <div class="w-6 h-6 flex items-center justify-center">
                    <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                    </svg>
                </div>
                <span>Data Master</span>
                @if($stokRendah > 0)
                <span class="ml-auto bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">
                    {{ $stokRendah }}
                </span>
                @endif
            </a>

            <a href="{{ route('admin.usermanagemen.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.usermanagemen.*')
                ? 'bg-green-50 text-green-700 border-r-4 border-green-600 font-semibold'
                : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <div class="w-6 h-6 flex items-center justify-center">
                    <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <span>User Management</span>
            </a>

            <a href="{{ route('admin.reports.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.reports.*')
                ? 'bg-green-50 text-green-700 border-r-4 border-green-600 font-semibold'
                : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <div class="w-6 h-6 flex items-center justify-center">
                    <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <span>Laporan & Monitoring</span>
            </a>

            @endif

            @if (Auth::user()->role === 'apoteker')

            <a href="{{ route('apoteker.transactions.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('apoteker.transactions.*') 
                ? 'bg-green-50 text-green-700 border-r-4 border-green-600 font-semibold' 
                : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">

                <div class="w-6 h-6 flex items-center justify-center">
                    <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <span>Transaksi</span>
            </a>

            @endif
        </nav>

        <div class="lg:hidden absolute bottom-0 left-0 right-0 p-4 border-t border-gray-100 bg-white">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-green-100 text-green-600 font-semibold">
                        {{ str(Auth::user()->name ?? 'A')->substr(0, 1) }}
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name ?? 'Administrator' }}</p>
                        <p class="text-xs text-gray-500">{{ Auth::user()->email ?? 'admin@apotek.com' }}</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="p-2 rounded-lg text-gray-500 hover:bg-gray-100 hover:text-red-600 transition duration-200"
                        title="Logout">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>
</div>
