<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::select('id', 'name', 'email', 'role', 'avatar')
            ->latest()
            ->paginate(5);

        return view('admin.usermanagemen.index', compact('users'));
    }

    public function create()
    {
        $roles = ['admin', 'apoteker'];
        return view('admin.usermanagemen.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,apoteker',
            'avatar' => 'nullable|image|mimes:jpg,png,webp,jpeg|max:1024|dimensions:max_width=1500,max_height=1500',
        ]);

        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar'] = $avatarPath;
        }

        User::create($validated);

        return redirect()->route('admin.usermanagemen.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        $roles = ['admin', 'apoteker'];

        return view('admin.usermanagemen.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,apoteker',
            'avatar' => 'nullable|image|mimes:jpg,png,webp,jpeg|max:1024|dimensions:max_width=1500,max_height=1500',
        ]);

        if ($request->hasFile('avatar')) {
            // Hapus avatar lama jika ada
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar'] = $avatarPath;
        }

        if (! $request->filled('password')) {
            unset($validated['password']);
        }

        if (Auth::id() === $user->id) {
            $validated['role'] = $user->role;
        }

        $user->update($validated);

        return redirect()
            ->route('admin.usermanagemen.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if (Auth::user()->id === $user->id) {
            return redirect()->back()
                ->with('error', 'Anda tidak dapat menghapus diri sendiri.');
        }

        $user->delete();

        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        return redirect()->route('admin.usermanagemen.index')
            ->with('success', 'User berhasil dihapus.');
    }
}
