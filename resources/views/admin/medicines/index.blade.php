<x-layouts.app>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Daftar Obat
            </h2>
            <a href="{{ route('admin.medicines.create') }}"
                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                + Tambah Obat
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Notifikasi -->
            @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                {{ session('error') }}
            </div>
            @endif

            <form method="GET" action="{{ route('admin.medicines.index') }}"
                class="mb-5 grid grid-cols-1 sm:grid-cols-[minmax(0,1fr)_220px_auto] gap-3">
                <label class="sr-only" for="medicine-search">Cari obat</label>
                <input id="medicine-search" name="q" value="{{ request('q') }}"
                    placeholder="Cari kode atau nama obat..."
                    class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500">

                <label class="sr-only" for="medicine-category">Kategori</label>
                <select id="medicine-category" name="category"
                    class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500">
                    <option value="">Semua kategori</option>
                    @foreach ($categories as $category)
                    <option value="{{ $category }}" @selected(request('category') === $category)>{{ $category }}</option>
                    @endforeach
                </select>

                <div class="flex gap-2">
                    <button class="px-4 py-2 rounded-lg bg-gray-800 text-white hover:bg-gray-900">Cari</button>
                    @if (request()->hasAny(['q', 'category']))
                    <a href="{{ route('admin.medicines.index') }}"
                        class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50">Reset</a>
                    @endif
                </div>
            </form>

            {{-- Table --}}
            <div class="bg-white rounded-xl shadow overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left text-gray-600">
                        <thead class="bg-gray-100 text-xs uppercase tracking-wide text-gray-700">
                            <tr>
                                <th class="px-4 py-3">Kode</th>
                                <th class="px-4 py-3">Nama Obat</th>
                                <th class="px-4 py-3">Kategori</th>
                                <th class="px-4 py-3">Satuan</th>
                                <th class="px-4 py-3 text-center">Total Stok</th>
                                <th class="px-4 py-3 text-center">Status</th>
                                <th class="px-4 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200">
                            @forelse ($medicines as $medicine)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 font-mono text-xs">
                                    {{ $medicine->kode }}
                                </td>

                                <td class="px-4 py-3 font-medium text-gray-900">
                                    {{ $medicine->nama }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $medicine->kategori }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $medicine->satuan }}
                                </td>

                                <td class="px-4 py-3 text-center font-semibold">
                                    {{ $medicine->total_stok ?? 0 }}
                                </td>

                                <td class="px-4 py-3 text-center">
                                    @if ($medicine->stock_status === 'low')
                                    <span class="px-2 py-1 text-xs font-medium text-red-700 bg-red-100 rounded-full">
                                        Menipis
                                    </span>
                                    @else
                                    <span class="px-2 py-1 text-xs font-medium text-green-700 bg-green-100 rounded-full">
                                        Aman
                                    </span>
                                    @endif
                                </td>

                                <td class="px-4 py-3 text-center">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('admin.medicines.show', $medicine) }}"
                                            class="text-blue-600 hover:underline text-xs">
                                            Detail
                                        </a>
                                        <a href="{{ route('admin.medicines.edit', $medicine) }}"
                                            class="text-yellow-600 hover:underline text-xs">
                                            Edit
                                        </a>
                                        <a href="{{ route('admin.batches.create', $medicine) }}"
                                            class="text-green-600 hover:underline text-xs">
                                            Tambah Batch
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-4 py-6 text-center text-gray-500">
                                    Data obat belum tersedia
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="px-4 py-3 border-t">
                    {{ $medicines->links() }}
                </div>

            </div>
        </div>
</x-layouts.app>
