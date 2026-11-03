<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Tampilkan daftar akun / Kelola Akun (hanya untuk Superadmin)
     */
    public function index(Request $request)
    {
        $query = User::with('role');

        // Pencarian (nama, email, opd)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('opd', 'like', "%{$search}%");
            });
        }

        // Filter Role
        if ($request->filled('role_id')) {
            $query->where('role_id', $request->role_id);
        }

        // Filter Status Akun (Aktif / Perlu Verifikasi berdasarkan email_verified_at)
        if ($request->filled('status')) {
            if ($request->status === 'aktif') {
                $query->whereNotNull('email_verified_at');
            } elseif ($request->status === 'unverified') {
                $query->whereNull('email_verified_at');
            }
        }

        $users = $query->latest()->paginate(10)->withQueryString();

        // Statistik Kartu
        $totalUsers = User::count();
        $adminCount = User::whereIn('role_id', [1, 2, 3])->count();
        $opdCount = User::where('role_id', 4)->count();

        // Roles untuk dropdown
        $roles = Role::all();

        // Toggle Form Tambah Akun
        $showForm = $request->boolean('form');

        return view('admin.users', compact(
            'users',
            'totalUsers',
            'adminCount',
            'opdCount',
            'roles',
            'showForm'
        ));
    }

    /**
     * Simpan akun baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|string|email|max:255|unique:users,email',
            'password'              => 'required|string|min:8|confirmed',
            'role_id'               => 'required|exists:roles,id',
            'opd'                   => 'nullable|string|max:255',
            'is_verified'           => 'nullable|boolean',
        ], [
            'name.required'         => 'Nama pengguna wajib diisi.',
            'email.required'        => 'Email wajib diisi.',
            'email.unique'          => 'Email sudah terdaftar.',
            'password.required'     => 'Password wajib diisi.',
            'password.min'          => 'Password minimal 8 karakter.',
            'password.confirmed'    => 'Konfirmasi password tidak cocok.',
            'role_id.required'      => 'Peran/Role wajib dipilih.',
        ]);

        User::create([
            'name'              => $validated['name'],
            'email'             => $validated['email'],
            'password'          => Hash::make($validated['password']),
            'role_id'           => $validated['role_id'],
            'opd'               => $validated['opd'] ?? null,
            'email_verified_at' => $request->boolean('is_verified') ? now() : null,
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Akun pengguna berhasil ditambahkan.');
    }

    /**
     * Update akun pengguna
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password'              => 'nullable|string|min:8|confirmed',
            'role_id'               => 'required|exists:roles,id',
            'opd'                   => 'nullable|string|max:255',
            'is_verified'           => 'nullable|boolean',
        ], [
            'name.required'         => 'Nama pengguna wajib diisi.',
            'email.required'        => 'Email wajib diisi.',
            'email.unique'          => 'Email sudah digunakan oleh akun lain.',
            'password.min'          => 'Password baru minimal 8 karakter.',
            'password.confirmed'    => 'Konfirmasi password baru tidak cocok.',
            'role_id.required'      => 'Peran/Role wajib dipilih.',
        ]);

        $updateData = [
            'name'              => $validated['name'],
            'email'             => $validated['email'],
            'role_id'           => $validated['role_id'],
            'opd'               => $validated['opd'] ?? null,
            'email_verified_at' => $request->boolean('is_verified') ? ($user->email_verified_at ?? now()) : null,
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $user->update($updateData);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Akun ' . $user->name . ' berhasil diperbarui.');
    }

    /**
     * Hapus akun pengguna
     */
    public function destroy(User $user)
    {
        // Proteksi agar Superadmin tidak menghapus akunnya sendiri
        if ($user->id === auth()->id()) {
            return redirect()
                ->route('admin.users.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $userName = $user->name;
        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Akun ' . $userName . ' berhasil dihapus.');
    }
}

