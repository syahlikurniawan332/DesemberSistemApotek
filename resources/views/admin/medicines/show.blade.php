<x-layouts.app>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Obat: {{ $medicine->nama }}
            </h2>
            <a href="{{ route('admin.medicines.index') }}"
                class="text-gray-600 hover:text-gray-900">
                ← Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">}

            <div class="bg-white rounded-xl shadow-sm p-6">
                <!-- Info Obat -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-500">Kode Obat</p>
                            <p class="text-lg font-bold text-blue-600">{{ $medicine->kode }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Nama Obat</p>
                            <p class="text-lg font-medium text-gray-900">{{ $medicine->nama }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Kategori</p>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                {{ $medicine->kategori }}
                            </span>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-500">Satuan</p>
                            <p class="text-lg font-medium text-gray-900">{{ $medicine->satuan }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Minimum Stok</p>
                            <p class="text-lg font-medium text-gray-900">{{ $medicine->min_stok }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Tanggal Dibuat</p>
                            <p class="text-sm text-gray-900">{{ $medicine->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Batch List -->
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Batch Obat</h3>

                    @if($medicine->batches->count() > 0)
                    <div class="overflow-hidden rounded-lg border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">No. Batch</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Stok</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Kadaluarsa</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Harga</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($medicine->batches as $batch)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $batch->no_batch }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-500">{{ $batch->stok }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-500">{{ $batch->tanggal_kadaluarsa->format('d/m/Y') }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-500">Rp {{ number_format($batch->harga_jual, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-sm">
                                        @if($batch->transactionDetails()->exists())
                                        <span class="text-gray-400 text-xs italic">
                                            Terkunci
                                        </span>
                                        @else
                                        <a href="{{ route('admin.batches.edit', [$medicine, $batch]) }}"
                                            class="text-green-600 hover:underline text-xs">
                                            Edit
                                        </a>
                                        @endif

                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <p class="text-gray-500 text-center py-4">Belum ada batch untuk obat ini.</p>
                    @endif
                </div>

                <!-- Actions -->
                <div class="flex justify-end space-x-3 mt-8 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.batches.create', $medicine) }}"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Tambah Batch
                    </a>

                    <a href="{{ route('admin.medicines.edit', $medicine) }}"
                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                        Edit Obat
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-layouts.app>