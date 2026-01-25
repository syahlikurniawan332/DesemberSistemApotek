<x-layouts.app>
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit User Akun
        </h2>
        <a href="{{ route('admin.usermanagemen.index') }}"
            class="text-gray-600 hover:text-gray-900">
            ← Kembali
        </a>
    </div>

    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

        @if ($errors->any())
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm p-6">
            <form
                action="{{ route('admin.usermanagemen.update',  $user) }}"
                method="post"
                enctype="multipart/form-data"
                class="space-y-4">
                @csrf @method('PUT')

                <div>
                    <label class="block font-medium mb-2">Foto Profil</label>

                    <!-- Avatar Preview -->
                    <div class="flex items-center space-x-4 mb-3">
                        <div class="w-20 h-20 rounded-full overflow-hidden border-2 border-gray-200">
                            <img
                                src="{{ $user->avatar_url }}"
                                alt="Avatar {{ $user->name }}"
                                class="w-full h-full object-cover">
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Avatar saat ini</p>
                            @if($user->avatar)
                            <p class="text-xs text-gray-500 mt-1">
                                <a href="{{ $user->avatar_url }}" target="_blank" class="text-blue-500 hover:underline">
                                    Lihat full size
                                </a>
                            </p>
                            @endif
                        </div>
                    </div>

                    <!-- Upload Field -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Upload Avatar Baru
                        </label>
                        <input
                            type="file"
                            name="avatar"
                            accept="image/*"
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        <p class="text-xs text-gray-500 mt-1">
                            Format: JPEG, PNG, JPG, GIF. Maksimal: 2MB.
                        </p>
                        <!-- Hapus avatar checkbox -->
                        @if($user->avatar)
                        <div class="mt-2 flex items-center">
                            <input type="checkbox"
                                name="remove_avatar"
                                id="remove_avatar"
                                value="1"
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="remove_avatar" class="ml-2 block text-sm text-gray-700">
                                Hapus avatar
                            </label>
                        </div>
                        @endif
                    </div>
                </div>

                <div>
                    <label class="block font-medium">Nama Lengkap</label>
                    <input
                        type="text"
                        name="name"
                        value="{{ old('name', $user->name) }}"
                        class="w-full border rounded p-2"
                        required>
                </div>

                <div>
                    <label class="block font-medium">Email</label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email', $user->email) }}" {{-- Tampilkan data lama --}}
                        class="w-full border rounded p-2"
                        required>
                </div>

                <div>
                    <label class="block font-medium">Password Baru</label>
                    <small class="text-gray-500">(Kosongkan jika tidak ingin mengubah password)</small>
                    <input
                        type="password"
                        name="password"
                        class="w-full border rounded p-2 mt-1">
                </div>

                <div>
                    <label class="block font-medium">Konfirmasi Password Baru</label>
                    <input
                        type="password"
                        name="password_confirmation"
                        class="w-full border rounded p-2">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Role
                    </label>

                    @if(Auth::id() === $user->id)
                    <!-- Jika edit diri sendiri, tampilkan readonly dan kirim hidden input -->
                    <input
                        type="text"
                        value="{{ ucfirst($user->role) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 cursor-not-allowed p-2"
                        readonly>
                    <input type="hidden" name="role" value="{{ $user->role }}">

                    <p class="mt-1 text-xs text-gray-500">
                        Role tidak dapat diubah pada akun yang sedang digunakan.
                    </p>
                    @else
                    <!-- Jika edit user lain, tampilkan select biasa -->
                    <select name="role"
                        class="mt-1 block w-full rounded-md border-gray-300">
                        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>
                            Admin
                        </option>
                        <option value="apoteker" {{ $user->role === 'apoteker' ? 'selected' : '' }}>
                            Apoteker
                        </option>
                    </select>
                    @endif
                </div>

                <div class="flex gap-2">
                    <button
                        type="submit"
                        class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                        ✅ Simpan Perubahan
                    </button>

                    <a
                        href="{{ route('admin.usermanagemen.index') }}"
                        class="px-4 py-2 border rounded hover:bg-gray-50">
                        ❌ Batalkan
                    </a>
                </div>

            </form>
        </div>

</x-layouts.app>