<x-layouts.app>
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah User Akun
        </h2>
        <a href="{{ route('admin.usermanagemen.index') }}"
            class="text-gray-600 hover:text-gray-900">
            ← Kembali
        </a>
    </div>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white rounded-xl shadow-sm p-6">
                <form action="{{ route('admin.usermanagemen.store') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    class="space-y-4">
                    @csrf

                    <!-- Avatar Upload -->
                    <div>
                        <label class="block font-medium mb-2">Foto Profil (Opsional)</label>
                        <input
                            type="file"
                            name="avatar"
                            accept="image/*"
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        <p class="text-xs text-gray-500 mt-1">
                            Format: JPEG, PNG, JPG, GIF. Maksimal: 2MB.
                        </p>
                    </div>

                    <div>
                        <label class="block font-medium">Nama</label>
                        <input
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            class="w-full border rounded p-2"
                            required>
                    </div>

                    <div>
                        <label class="block font-medium">Email</label>
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="w-full border rounded p-2"
                            required>
                    </div>

                    <div>
                        <label class="block font-medium">Password</label>
                        <input
                            type="password"
                            name="password"
                            class="w-full border rounded p-2"
                            required>
                    </div>

                    <div>
                        <label class="block font-medium">Konfirmasi Password</label>
                        <input
                            type="password"
                            name="password_confirmation"
                            class="w-full border rounded p-2"
                            required>
                    </div>

                    <div>
                        <label class="block font-medium">Role</label>
                        <select
                            name="role"
                            class="w-full border rounded p-2">
                            <option value="">Pilih Role</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="apoteker" {{ old('role') == 'apoteker' ? 'selected' : '' }}>Apoteker</option>
                        </select>
                    </div>

                    {{-- Actions --}}
                    <div class="flex gap-2">
                        <button
                            type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded">
                            Simpan User
                        </button>

                        <a
                            href="{{ route('admin.usermanagemen.index') }}"
                            class="px-4 py-2 border rounded">
                            Batal
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-layouts.app>