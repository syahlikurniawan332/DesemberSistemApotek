<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-semibold text-gray-900 leading-tight">
                {{ __('Profile Pengguna') }}
            </h2>
            <a href="{{ route(Auth::user()->role === 'admin'
            ? 'dashboard'
            : 'dashboard') }}"
                class="text-gray-600 hover:text-gray-900">
                ← Kembali
            </a>

        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <!-- Sidebar Profil -->
                <div class="lg:col-span-1">
                    <!-- Card Foto Profil -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="text-center">
                            <!-- Foto Profil -->
                            <div class="relative inline-block mb-5">
                                @if (empty($user->avatar))
                                <div class="w-32 h-32 rounded-full bg-gray-200 flex items-center justify-center border-4 border-white shadow-lg">
                                    <i class="fas fa-user text-6xl text-gray-400"></i>
                                </div>
                                @else
                                <img src="{{ $user->avatar_url }}"
                                    alt="Foto Profil {{ $user->name }}"
                                    class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-lg">
                                @endif
                                <div class="absolute bottom-2 right-2 w-8 h-8 bg-green-500 rounded-full border-4 border-white flex items-center justify-center">
                                    <i class="fas fa-check text-white text-xs"></i>
                                </div>
                            </div>

                            <!-- Nama dan Email -->
                            <h2 class="text-xl font-bold text-gray-800 truncate">{{ $user->name }}</h2>
                            <p class="text-gray-500 text-sm truncate">{{ $user->email }}</p>

                            <!-- Badge Role -->
                            <div class="mt-4">
                                @php
                                $roleColors = [
                                'admin' => 'from-red-500 to-red-600',
                                'kasir' => 'from-blue-500 to-blue-600',
                                'gudang' => 'from-green-500 to-green-600',
                                'manager' => 'from-purple-500 to-purple-600',
                                'superadmin' => 'from-orange-500 to-orange-600'
                                ];
                                $roleColor = $roleColors[$user->role] ?? 'from-gray-500 to-gray-600';
                                @endphp
                                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-gradient-to-r {{ $roleColor }} text-white shadow-sm">
                                    <i class="fas fa-user-tag mr-2"></i>
                                    {{ ucfirst($user->role) }}
                                </span>
                            </div>

                            <!-- Tanggal Bergabung -->
                            <div class="mt-6 pt-6 border-t border-gray-100">
                                <div class="flex items-center justify-center text-gray-500 text-sm">
                                    <i class="fas fa-calendar-plus mr-2"></i>
                                    <span>Bergabung {{ $user->created_at->format('d M Y') }}</span>
                                </div>
                                <div class="mt-2 flex items-center justify-center text-gray-500 text-sm">
                                    <i class="fas fa-clock mr-2"></i>
                                    <span>{{ $user->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Konten Utama -->
                <div class="lg:col-span-3">
                    <!-- Informasi Pribadi -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-8">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">Informasi Pribadi</h3>
                                <p class="text-gray-600 text-sm mt-1">Detail informasi akun Anda</p>
                            </div>
                            @if ($user->role === 'admin')
                            <a href="{{ route('admin.usermanagemen.edit', $user) }}"
                                class="mt-3 sm:mt-0 px-5 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-medium rounded-lg transition-all duration-200 shadow-sm hover:shadow-md flex items-center">
                                <i class="fas fa-edit mr-2"></i> Edit Profil
                            </a>
                            @else
                            <a href="#edit-profile"
                                class="mt-3 sm:mt-0 px-5 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-medium rounded-lg transition-all duration-200 shadow-sm hover:shadow-md flex items-center">
                                <i class="fas fa-edit mr-2"></i> Edit Profil
                            </a>
                            @endif
                        </div>

                        <!-- Grid Informasi -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nama -->
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">
                                    <i class="fas fa-user mr-2 text-gray-400"></i>Nama Lengkap
                                </label>
                                <div class="px-4 py-3 bg-gray-50 rounded-lg border border-gray-200">
                                    <p class="text-gray-900 font-medium">{{ $user->name }}</p>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">
                                    <i class="fas fa-envelope mr-2 text-gray-400"></i>Email
                                </label>
                                <div class="px-4 py-3 bg-gray-50 rounded-lg border border-gray-200">
                                    <p class="text-gray-900 font-medium">{{ $user->email }}</p>
                                </div>
                            </div>

                            <!-- Role -->
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">
                                    <i class="fas fa-user-tag mr-2 text-gray-400"></i>Role
                                </label>
                                <div class="px-4 py-3 bg-gray-50 rounded-lg border border-gray-200">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                    @switch($user->role)
                                        @case('admin') bg-red-100 text-red-800 @break
                                        @case('apoteker') bg-blue-100 text-blue-800 @break
                                        @default bg-gray-100 text-gray-800
                                    @endswitch">
                                        <i class="fas 
                                        @switch($user->role)
                                            @case('admin') fa-user-shield @break
                                            @case('apoteker') fa-cash-register @break
                                            @default fa-user
                                        @endswitch 
                                        mr-2"></i>
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">
                                    <i class="fas fa-circle mr-2 text-gray-400"></i>Status
                                </label>
                                <div class="px-4 py-3 bg-gray-50 rounded-lg border border-gray-200">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                    @if (auth()->check() && auth()->id() === $user->id)
                                        bg-gradient-to-r from-green-100 to-green-50 text-green-800
                                    @else
                                        bg-gradient-to-r from-gray-100 to-gray-50 text-gray-800
                                    @endif">
                                        <i class="fas 
                                        @if (auth()->check() && auth()->id() === $user->id)
                                            fa-wifi text-green-500
                                        @else
                                            fa-moon text-gray-500
                                        @endif 
                                        mr-2"></i>
                                        @if (auth()->check() && auth()->id() === $user->id)
                                        Online
                                        @else
                                        Offline
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Statistik Tambahan -->
                        <div class="mt-10 pt-8 border-t border-gray-200">
                            <h4 class="text-lg font-semibold text-gray-900 mb-6">Statistik Akun</h4>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <div class="text-center p-4 bg-blue-50 rounded-xl">
                                    <div class="text-2xl font-bold text-blue-600">{{ $user->transactions_count }}</div>
                                    <div class="text-sm text-gray-600 mt-1">Total Transaksi</div>
                                </div>

                                <div class="text-center p-4 bg-green-50 rounded-xl">
                                    <div class="text-2xl font-bold text-green-600">{{ $user->batches_count }}</div>
                                    <div class="text-sm text-gray-600 mt-1">Batch Ditambahkan</div>
                                </div>

                                <div class="text-center p-4 bg-yellow-50 rounded-xl">
                                    <div class="text-2xl font-bold text-yellow-600">{{ (int) $user->created_at->diffInDays(now()) }}</div>
                                    <div class="text-sm text-gray-600 mt-1">Hari Aktif</div>
                                </div>

                                <div class="text-center p-4 bg-purple-50 rounded-xl">
                                    <div class="text-2xl font-bold text-purple-600">@if (auth()->check() && auth()->id() === $user->id) Ya @else Tidak @endif</div>
                                    <div class="text-sm text-gray-600 mt-1">Sedang Login</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($user->role === 'apoteker')
                    <div id="edit-profile" class="mt-6 bg-white rounded-xl shadow-sm border border-gray-200 p-6 scroll-mt-6">
                        @include('profile.partials.update-profile-information-form')
                    </div>

                    <div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        @include('profile.partials.update-password-form')
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
