<x-layouts.app>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Buat Transaksi Baru (Sederhana)
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Alert Message -->
            @if(session('error'))
            <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                {{ session('error') }}
            </div>
            @endif

            @if($errors->any())
            <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded" role="alert">
                <p class="font-semibold">Periksa kembali data transaksi:</p>
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <form action="{{ route('apoteker.transactions.store') }}" method="POST" id="transaction-form">
                        @csrf

                        <!-- Display Transaction Code -->
                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Kode Transaksi
                            </label>
                            <input type="text" readonly
                                value="Otomatis saat transaksi disimpan"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50 font-bold">
                            <p class="text-sm text-gray-500 mt-1">Kode final dibuat oleh server agar tetap unik.</p>
                        </div>

                        <!-- Medicines Container untuk multiple items -->
                        <div id="medicines-container" class="mb-6">
                            <!-- Item pertama -->
                            <div class="medicine-item bg-gray-50 p-4 rounded-lg mb-4">
                                <div class="flex justify-between items-center mb-3">
                                    <h3 class="font-bold">Obat #1</h3>
                                    <button type="button" class="remove-medicine text-red-600 hover:text-red-800 text-sm"
                                        onclick="removeMedicine(this)">
                                        Hapus
                                    </button>
                                </div>

                                <!-- Medicine Selection -->
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2">
                                        Pilih Obat *
                                    </label>
                                    <select
                                        name="medicines[0][medicine_id]"
                                        class="medicine-select w-full px-3 py-2 border border-gray-300 rounded-md"
                                        required
                                        onchange="updateMedicineInfo(this)">

                                        <option value="">-- Pilih Obat --</option>
                                        @foreach($medicines as $medicine)
                                        <option value="{{ $medicine->id }}"
                                            data-batches='@json($medicine->batches)'
                                            data-unit="{{ $medicine->satuan }}"
                                            data-name="{{ $medicine->nama }}">
                                            {{ $medicine->nama }}
                                            (Stok: {{ $medicine->batches->sum('stok') }} {{ $medicine->satuan }})
                                        </option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="medicines[0][batch_id]" class="batch-id">
                                </div>

                                <!-- Medicine Info -->
                                <div class="medicine-info mb-4 hidden">
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-3 bg-blue-50 rounded">
                                        <div>
                                            <p class="text-sm text-gray-600">Satuan</p>
                                            <p class="info-unit font-bold">-</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-600">Harga Satuan</p>
                                            <p class="info-price font-bold">Rp 0</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-600">Stok Tersedia</p>
                                            <p class="info-stock font-bold">0</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Quantity Input -->
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2">
                                        Jumlah *
                                    </label>
                                    <div class="flex items-center">
                                        <input type="number" name="medicines[0][quantity]"
                                            class="quantity-input w-32 px-3 py-2 border border-gray-300 rounded-md"
                                            value="1" min="1" required
                                            oninput="updateTotal()">
                                        <span class="quantity-unit ml-2 text-gray-600">-</span>
                                    </div>
                                    <div class="quantity-error text-red-500 text-sm mt-1 hidden">
                                        Jumlah melebihi stok tersedia!
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Button Tambah Obat -->
                        <div class="mb-6">
                            <button type="button" onclick="addMedicine()"
                                class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">
                                + Tambah Obat Lain
                            </button>
                        </div>

                        <!-- Total Calculation -->
                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Total Harga Keseluruhan
                            </label>
                            <div class="p-4 bg-green-50 border border-green-200 rounded-lg">
                                <p id="total-display" class="text-2xl font-bold text-green-700">Rp 0</p>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-between">
                            <a href="{{ route('apoteker.transactions.index') }}"
                                class="text-gray-600 hover:text-gray-900">
                                ← Kembali ke Daftar
                            </a>
                            <button type="submit" id="submit-btn"
                                class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                Simpan Transaksi
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript untuk mengelola multiple medicines -->
    <script>
let medicineCounter = 1;

// Tambah obat baru
function addMedicine() {
    const container = document.getElementById('medicines-container');
    const template = document.querySelector('.medicine-item').cloneNode(true);

    template.querySelectorAll('[name]').forEach(input => {
        const name = input.name.replace(/\[\d+\]/, `[${medicineCounter}]`);
        input.name = name;
        if (input.name.includes('quantity')) {
            input.value = 1;
            input.oninput = () => updateTotal();
        }
    });

    template.querySelector('h3').textContent = `Obat #${medicineCounter + 1}`;
    template.querySelector('.medicine-select').value = '';
    template.querySelector('.medicine-info').classList.add('hidden');
    template.querySelector('.quantity-unit').textContent = '-';
    template.querySelector('.quantity-error').classList.add('hidden');

    container.appendChild(template);
    medicineCounter++;
}

// Hapus obat
function removeMedicine(button) {
    if (document.querySelectorAll('.medicine-item').length > 1) {
        button.closest('.medicine-item').remove();
        updateTotal();
    } else {
        alert('Minimal harus ada satu obat dalam transaksi');
    }
}

// Update info obat saat dipilih
function updateMedicineInfo(select) {
    const item = select.closest('.medicine-item');
    const selectedOption = select.options[select.selectedIndex];

    if (!select.value) {
        item.querySelector('.medicine-info').classList.add('hidden');
        return;
    }

    const batches = JSON.parse(selectedOption.dataset.batches);

    if (batches.length === 0) {
        item.querySelector('.info-price').textContent = '-';
        item.querySelector('.info-stock').textContent = '0';
        item.querySelector('.medicine-info').classList.remove('hidden');
        return;
    }

    // Preview harga range (hanya batch yang stok > 0)
    const availableBatches = batches.filter(b => b.stok > 0);
    if (availableBatches.length === 0) {
        item.querySelector('.info-price').textContent = '-';
        item.querySelector('.info-stock').textContent = '0';
    } else {
        const prices = availableBatches.map(b => b.harga_jual);
        const minPrice = Math.min(...prices);
        const maxPrice = Math.max(...prices);

        item.querySelector('.info-price').textContent =
            minPrice === maxPrice 
                ? formatRupiah(minPrice)
                : formatRupiah(minPrice) + ' – ' + formatRupiah(maxPrice);

        const totalStock = availableBatches.reduce((sum, b) => sum + parseInt(b.stok), 0);
        item.querySelector('.info-stock').textContent = totalStock;
    }

    item.querySelector('.info-unit').textContent = selectedOption.dataset.unit;
    item.querySelector('.quantity-unit').textContent = selectedOption.dataset.unit;
    item.querySelector('.medicine-info').classList.remove('hidden');

    validateStock(item);
    updateTotal();
}

// Validasi stok per obat
function validateStock(item) {
    const quantityInput = item.querySelector('.quantity-input');
    const stock = parseInt(item.querySelector('.info-stock').textContent) || 0;
    const quantity = parseInt(quantityInput.value) || 0;
    const errorElement = item.querySelector('.quantity-error');

    if (quantity > stock) {
        errorElement.classList.remove('hidden');
        quantityInput.classList.add('border-red-500');
        return false;
    } else {
        errorElement.classList.add('hidden');
        quantityInput.classList.remove('border-red-500');
        return true;
    }
}

// Hitung subtotal per obat mempertimbangkan stok dan batch FIFO
function calculateSubtotal(quantity, batches) {
    let remaining = quantity;
    let subtotal = 0;

    // Samakan urutan dengan backend: kedaluwarsa terdekat dijual lebih dahulu (FEFO).
    batches.sort((a, b) => new Date(a.tanggal_kadaluarsa) - new Date(b.tanggal_kadaluarsa));

    for (const batch of batches) {
        if (remaining <= 0) break;
        const take = Math.min(remaining, batch.stok);
        subtotal += take * parseFloat(batch.harga_jual);
        remaining -= take;
    }

    return subtotal;
}

// Update total harga keseluruhan
function updateTotal() {
    let total = 0;
    let allValid = true;

    document.querySelectorAll('.medicine-item').forEach(item => {
        const select = item.querySelector('.medicine-select');
        const quantityInput = item.querySelector('.quantity-input');

        if (select.value && quantityInput.value) {
            if (!validateStock(item)) allValid = false;

            const batches = JSON.parse(select.options[select.selectedIndex].dataset.batches);
            const quantity = parseInt(quantityInput.value) || 0;
            const subtotal = calculateSubtotal(quantity, batches);
            total += subtotal;
        }
    });

    document.getElementById('total-display').textContent = formatRupiah(total);

    const submitBtn = document.getElementById('submit-btn');
    submitBtn.disabled = !allValid;
    submitBtn.classList.toggle('bg-blue-600', allValid);
    submitBtn.classList.toggle('bg-gray-400', !allValid);
}

// Format angka ke Rupiah
function formatRupiah(number) {
    return 'Rp ' + number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

// Inisialisasi
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.oninput = () => updateTotal();
    });

    updateTotal();
});
</script>

</x-layouts.app>
