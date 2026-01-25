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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <form method="POST" action="{{ route('apoteker.transactions.update', $transaction) }}">
                        @csrf
                        @method('PUT')

                        @foreach($transaction->transactionDetails as $index => $detail)
                        <div class="medicine-item bg-gray-50 p-4 rounded mb-4">

                            <input type="hidden" name="medicines[{{ $index }}][batch_id]"
                                class="batch-id"
                                value="{{ $detail->batch_id }}">

                            <div class="mb-3">
                                <label class="font-bold">Obat</label>
                                <select class="medicine-select" disabled>
                                    <option>
                                        {{ $detail->batch->medicine->nama }}
                                    </option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="font-bold">Jumlah</label>
                                <input type="number"
                                    name="medicines[{{ $index }}][quantity]"
                                    class="quantity-input border rounded px-2 py-1"
                                    value="{{ $detail->jumlah }}"
                                    min="1">
                            </div>

                            <div class="text-sm text-gray-600">
                                Stok tersedia:
                                {{ $detail->batch->stok + $detail->jumlah }}
                            </div>

                        </div>
                        @endforeach

                        <button type="submit"
                            class="px-6 py-2 bg-blue-600 text-white rounded">
                            Update Transaksi
                        </button>
                    </form>


                </div>
            </div>
        </div>
    </div>

    <!-- SCRIPT SAMA DENGAN CREATE -->
    <script>
        let medicineCounter = {
            {
                count($medicinesInTransaction)
            }
        };

        function addMedicine() {
            const container = document.getElementById('medicines-container');
            const template = document.querySelector('.medicine-item').cloneNode(true);

            // Reset dan update
            const newIndex = medicineCounter;
            template.querySelectorAll('[name]').forEach(input => {
                const name = input.name.replace(/\[\d+\]/, `[${newIndex}]`);
                input.name = name;
                input.value = input.type === 'number' ? 1 : '';

                if (input.name.includes('quantity')) {
                    input.oninput = () => updateTotal();
                }
            });

            // Hapus hidden field transaction_detail_id untuk obat baru
            const hiddenId = template.querySelector('input[type="hidden"]');
            if (hiddenId && hiddenId.name.includes('transaction_detail_id')) {
                hiddenId.remove();
            }

            // Update UI
            template.querySelector('h3').textContent = `Obat #${newIndex + 1}`;
            template.querySelector('.medicine-select').value = '';
            template.querySelector('.medicine-info').classList.add('hidden');
            template.querySelector('.info-unit').textContent = '-';
            template.querySelector('.info-price').textContent = 'Rp 0';
            template.querySelector('.info-stock').textContent = '0';
            template.querySelector('.quantity-unit').textContent = '-';
            template.querySelector('.quantity-error').classList.add('hidden');

            // Ganti label "Obat Utama" dengan tombol hapus
            const headerDiv = template.querySelector('.flex.justify-between');
            if (headerDiv.querySelector('.text-gray-500')) {
                headerDiv.querySelector('.text-gray-500').outerHTML =
                    '<button type="button" class="remove-medicine text-red-600 hover:text-red-800 text-sm" onclick="removeMedicine(this)">Hapus</button>';
            }

            container.appendChild(template);
            medicineCounter++;
        }

        function removeMedicine(button) {
            if (document.querySelectorAll('.medicine-item').length > 1) {
                button.closest('.medicine-item').remove();
                updateTotal();
                // Re-number items
                document.querySelectorAll('.medicine-item').forEach((item, index) => {
                    item.querySelector('h3').textContent = `Obat #${index + 1}`;
                });
            } else {
                alert('Minimal harus ada satu obat dalam transaksi');
            }
        }

        function updateMedicineInfo(select) {
            const item = select.closest('.medicine-item');
            const selectedOption = select.options[select.selectedIndex];

            if (select.value) {
                item.querySelector('.medicine-info').classList.remove('hidden');

                const batches = JSON.parse(selectedOption.dataset.batches);
                const totalStock = batches.reduce((sum, batch) => sum + parseInt(batch.stok), 0);
                const price = batches.length > 0 ? batches[0].harga_jual : 0;

                item.querySelector('.info-unit').textContent = selectedOption.dataset.unit;
                item.querySelector('.info-price').textContent = formatRupiah(price);
                item.querySelector('.info-stock').textContent = totalStock;
                item.querySelector('.quantity-unit').textContent = selectedOption.dataset.unit;

                validateStock(item);
            } else {
                item.querySelector('.medicine-info').classList.add('hidden');
            }
            updateTotal();
        }

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

        function updateTotal() {
            let total = 0;
            let allValid = true;

            document.querySelectorAll('.medicine-item').forEach(item => {
                const select = item.querySelector('.medicine-select');
                const quantityInput = item.querySelector('.quantity-input');

                if (select.value && quantityInput.value) {
                    if (!validateStock(item)) {
                        allValid = false;
                    }

                    const batches = JSON.parse(select.options[select.selectedIndex].dataset.batches);
                    const price = batches.length > 0 ? batches[0].harga_jual : 0;
                    const quantity = parseInt(quantityInput.value) || 0;
                    total += price * quantity;
                }
            });

            document.getElementById('total-display').textContent = formatRupiah(total);

            const submitBtn = document.getElementById('submit-btn');
            submitBtn.disabled = !allValid;
            submitBtn.classList.toggle('bg-blue-600', allValid);
            submitBtn.classList.toggle('bg-gray-400', !allValid);
        }

        function formatRupiah(number) {
            return 'Rp ' + number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        // Inisialisasi
        document.addEventListener('DOMContentLoaded', function() {
            // Set event listener untuk semua quantity input
            document.querySelectorAll('.quantity-input').forEach(input => {
                input.oninput = () => updateTotal();
            });

            // Trigger updateMedicineInfo untuk yang sudah terpilih
            document.querySelectorAll('.medicine-select').forEach(select => {
                if (select.value) {
                    updateMedicineInfo(select);
                }
            });

            // Validasi awal
            updateTotal();
        });
    </script>
</x-layouts.app>