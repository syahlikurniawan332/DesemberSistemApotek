<x-layouts.app>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Tambah Batch
            </h2>
            <a href="{{ route('admin.medicines.index') }}"
                class="text-gray-600 hover:text-gray-900">
                ← Kembali
            </a>
        </div>


        <div class="py-6">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

                <div class="bg-white rounded-xl shadow-sm p-6">
                    <form
                        action="{{ route('admin.batches.store', $medicine) }}"
                        method="POST"
                        class="space-y-4">
                        @csrf

                        

                        {{-- Tanggal Masuk --}}
                        <div>
                            <label class="block font-medium">Tanggal Masuk</label>
                            <input
                                type="date"
                                name="tanggal_masuk"
                                value="{{ old('tanggal_masuk') }}"
                                class="w-full border rounded p-2"
                                required>
                        </div>

                        {{-- Tanggal Kadaluarsa --}}
                        <div>
                            <label class="block font-medium">Tanggal Kadaluarsa</label>
                            <input
                                type="date"
                                name="tanggal_kadaluarsa"
                                value="{{ old('tanggal_kadaluarsa') }}"
                                class="w-full border rounded p-2"
                                required>
                        </div>

                        {{-- Stok --}}
                        <div>
                            <label class="block font-medium">Stok</label>
                            <input
                                type="number"
                                name="stok"
                                value="{{ old('stok', 0) }}"
                                min="0"
                                class="w-full border rounded p-2"
                                required>
                        </div>

                        {{-- Harga Beli --}}
                        <div>
                            <label class="block font-medium">Harga Beli</label>
                            <input
                                type="number"
                                step="0.01"
                                name="harga_beli"
                                value="{{ old('harga_beli') }}"
                                class="w-full border rounded p-2"
                                required>
                        </div>

                        {{-- Harga Jual --}}
                        <div>
                            <label class="block font-medium">Harga Jual</label>
                            <input
                                type="number"
                                step="0.01"
                                name="harga_jual"
                                value="{{ old('harga_jual') }}"
                                class="w-full border rounded p-2"
                                required>
                        </div>

                        {{-- Actions --}}
                        <div class="flex gap-2">
                            <button
                                type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded">
                                Simpan Batch
                            </button>

                            <a
                                href="{{ route('admin.medicines.show', $medicine) }}"
                                class="px-4 py-2 border rounded">
                                Batal
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </x-slot>
</x-layouts.app>