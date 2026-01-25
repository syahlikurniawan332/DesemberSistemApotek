<x-layouts.app>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Obat: {{ $medicine->nama }}
            </h2>
            <a href="{{ route('admin.medicines.index') }}"
                class="text-gray-600 hover:text-gray-900">
                ← Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white rounded-xl shadow-sm p-6">
                <form action="{{ route('admin.medicines.update', $medicine) }}" method="POST">
                    @csrf @method('PUT')

                    <div class="space-y-6">
                        <!-- Kode (readonly) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Kode Obat
                            </label>
                            <input type="text" readonly
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50"
                                value="{{ $medicine->kode }}">
                        </div>

                        <!-- Nama Obat -->
                        <div>
                            <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">
                                Nama Obat *
                            </label>
                            <input type="text" name="nama" id="nama" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                value="{{ old('nama', $medicine->nama) }}">
                            @error('nama')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Satuan & Kategori -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="satuan" class="block text-sm font-medium text-gray-700 mb-1">
                                    Satuan *
                                </label>
                                <select name="satuan" id="satuan" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                    <option value="">Pilih Satuan</option>
                                    @foreach($units as $unit)
                                    <option value="{{ $unit }}" {{ old('satuan', $medicine->satuan) == $unit ? 'selected' : '' }}>
                                        {{ ucfirst($unit) }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('satuan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="kategori" class="block text-sm font-medium text-gray-700 mb-1">
                                    Kategori *
                                </label>
                                <select name="kategori" id="kategori" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category }}" {{ old('kategori', $medicine->kategori) == $category ? 'selected' : '' }}>
                                        {{ $category }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('kategori')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Minimum Stok -->
                        <div>
                            <label for="min_stok" class="block text-sm font-medium text-gray-700 mb-1">
                                Minimum Stok *
                            </label>
                            <input type="number" name="min_stok" id="min_stok" required min="10"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                value="{{ old('min_stok', $medicine->min_stok) }}">
                            <p class="mt-1 text-sm text-gray-500">Minimal 10</p>
                            @error('min_stok')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="flex justify-end space-x-3 pt-4">
                            <a href="{{ route('admin.medicines.index') }}"
                                class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                                Batal
                            </a>
                            <button type="submit"
                                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                                Update Obat
                            </button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-layouts.app>