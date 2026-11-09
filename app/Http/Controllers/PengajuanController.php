<?php

namespace App\Http\Controllers;

use App\Models\Ajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class PengajuanController extends Controller
{
    /**
     * Tampilkan daftar pengajuan + form inline tambah pengajuan.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        // Eager load temuans dan dokumens dengan filter hak akses created_by jika bukan superadmin
        $query = Ajuan::with([
            'user',
            'dokumens',
            'temuans' => function ($q) use ($user) {
                if ((int) $user->role_id !== 1) {
                    $q->where('created_by', $user->id);
                }
                $q->with('dokumens');
            }
        ])->visibleToAdmin($user);

        $users = User::orderBy('opd')->get();

        // Filter pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_aplikasi', 'like', "%{$search}%")
                    ->orWhere('nomor_ajuan', 'like', "%{$search}%")
                    ->orWhereHas('user', fn($u) => $u
                        ->where('opd', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%")
                    );
            });
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $ajuans = $query->latest()->paginate(10)->withQueryString();

        // Statistik sederhana
        $visibleAjuans = Ajuan::query()->visibleToAdmin($request->user());
        $totalAjuan   = (clone $visibleAjuans)->count();
        $selesaiCount = (clone $visibleAjuans)->whereIn('status', ['selesai', 'Selesai'])->count();

        // Apakah form tambah pengajuan tampil? (toggled via query string ?form=1)
        $showForm = $request->boolean('form');

        return view('admin.pengajuan', compact(
            'ajuans',
            'totalAjuan',
            'selesaiCount',
            'showForm',
            'users'
        ));
    }

    /**
     * Simpan pengajuan baru ke database.
     * Hanya menggunakan kolom yang sudah ada di tabel ajuans.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_opd'           => 'required_without:user_id|nullable|string|max:255',
            'user_id'            => 'nullable|exists:users,id',
            'nama_aplikasi'      => 'required|string|max:255',
            'tujuan_assessment'  => 'required|string|max:1000',
            'tanggal_assessment' => 'nullable|date',
            'catatan'            => 'nullable|string|max:2000',
            'status'             => 'required|in:Diajukan,Proses Pengujian,Dalam Perbaikan,Selesai',
        ], [
            'nama_opd.required_without' => 'Nama Instansi / OPD wajib diisi.',
            'nama_aplikasi.required'     => 'Nama Aplikasi wajib diisi.',
            'tujuan_assessment.required' => 'Tujuan assessment wajib diisi.',
            'tanggal_assessment.date'    => 'Format tanggal assessment tidak valid.',
        ]);

        // Cari atau hubungkan ke User (OPD) berdasarkan teks input bebas nama_opd
        $userId = $validated['user_id'] ?? null;
        if (!$userId && !empty($validated['nama_opd'])) {
            $namaOpd = trim($validated['nama_opd']);
            
            // 1. Coba cari user OPD yang sudah ada dengan nama OPD atau nama yang sama persis / mirip
            $opdUser = User::where('opd', 'ILIKE', $namaOpd)
                ->orWhere('name', 'ILIKE', $namaOpd)
                ->first();

            // 2. Jika belum ada, buatkan user OPD baru secara otomatis
            if (!$opdUser) {
                $slug = Str::slug($namaOpd);
                $email = ($slug ?: 'opd-' . time()) . '@opd.jatimprov.go.id';
                
                // Pastikan email unik jika kebetulan sudah terpakai
                if (User::where('email', $email)->exists()) {
                    $email = ($slug ?: 'opd') . '-' . Str::random(4) . '@opd.jatimprov.go.id';
                }

                $opdUser = User::create([
                    'name'              => $namaOpd,
                    'email'             => $email,
                    'password'          => Hash::make('password123'),
                    'role_id'           => 4, // Role 4: OPD
                    'opd'               => $namaOpd,
                    'email_verified_at' => now(),
                ]);
            }

            $userId = $opdUser->id;
        }

        // Generate nomor ajuan otomatis: ITSA-YYYY-XXX
        $year = now()->year;

        $lastAjuan = Ajuan::whereYear('created_at', $year)
            ->orderByDesc('id')
            ->first();

        if ($lastAjuan) {
            $lastNumber = (int) substr($lastAjuan->nomor_ajuan, -3);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        $nomorAjuan = sprintf('ITSA-%d-%03d', $year, $nextNumber);

        Ajuan::create([
            'user_id'            => $userId,
            'created_by'         => Auth::id(),
            'nomor_ajuan'        => $nomorAjuan,
            'nama_aplikasi'      => $validated['nama_aplikasi'],
            'tujuan_assessment'  => $validated['tujuan_assessment'],
            'tanggal_assessment' => $validated['tanggal_assessment'] ?? null,
            'catatan'            => $validated['catatan'] ?? null,
            'status'             => $validated['status'],
            'tanggal_pengajuan'  => now()->toDateString(),
        ]);

        return redirect()
            ->route('admin.pengajuan.index')
            ->with('success', "Pengajuan {$nomorAjuan} berhasil ditambahkan!");
    }

    public function edit(Request $request, Ajuan $ajuan)
    {
        $user = $request->user();
        if ((int) $user->role_id !== 1 && $ajuan->created_by !== $user->id) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengedit pengajuan ini.');
        }

        $users = User::orderBy('opd')->get();

        return view('admin.pengajuan-edit', compact(
            'ajuan',
            'users'
        ));
    }

    public function update(Request $request, Ajuan $ajuan)
    {
        $user = $request->user();
        if ((int) $user->role_id !== 1 && $ajuan->created_by !== $user->id) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengubah pengajuan ini.');
        }

        $validated = $request->validate([
            'nama_opd'           => 'nullable|string|max:255',
            'user_id'            => 'nullable|exists:users,id',
            'nama_aplikasi'      => 'required|string|max:255',
            'tujuan_assessment'  => 'required|string|max:1000',
            'tanggal_assessment' => 'nullable|date',
            'catatan'            => 'nullable|string|max:2000',
            'status'             => 'required|in:Diajukan,Proses Pengujian,Dalam Perbaikan,Selesai',
        ]);

        $userId = $validated['user_id'] ?? $ajuan->user_id;

        if (!empty($validated['nama_opd'])) {
            $namaOpd = trim($validated['nama_opd']);
            $opdUser = User::where('opd', 'ILIKE', $namaOpd)
                ->orWhere('name', 'ILIKE', $namaOpd)
                ->first();

            if (!$opdUser) {
                $slug = Str::slug($namaOpd);
                $email = ($slug ?: 'opd-' . time()) . '@opd.jatimprov.go.id';
                
                if (User::where('email', $email)->exists()) {
                    $email = ($slug ?: 'opd') . '-' . Str::random(4) . '@opd.jatimprov.go.id';
                }

                $opdUser = User::create([
                    'name'              => $namaOpd,
                    'email'             => $email,
                    'password'          => Hash::make('password123'),
                    'role_id'           => 4,
                    'opd'               => $namaOpd,
                    'email_verified_at' => now(),
                ]);
            }

            $userId = $opdUser->id;
        }

        $ajuan->update([
            'user_id'            => $userId,
            'nama_aplikasi'      => $validated['nama_aplikasi'],
            'tujuan_assessment'  => $validated['tujuan_assessment'],
            'tanggal_assessment' => $validated['tanggal_assessment'] ?? null,
            'catatan'            => $validated['catatan'] ?? null,
            'status'             => $validated['status'],
        ]);

        return redirect()
            ->route('admin.pengajuan.index')
            ->with('success', "Pengajuan {$ajuan->nomor_ajuan} berhasil diperbarui!");
    }

    public function destroy(Request $request, Ajuan $ajuan) 
    { 
        $user = $request->user();
        if ((int) $user->role_id !== 1 && $ajuan->created_by !== $user->id) {
            abort(403, 'Anda tidak memiliki hak akses untuk menghapus pengajuan ini.');
        }

        $nomorAjuan = $ajuan->nomor_ajuan; 
        
        $ajuan->delete(); 
        
        return redirect() 
            ->route('admin.pengajuan.index') 
            ->with('success', "Pengajuan {$nomorAjuan} berhasil dihapus!"); 
    }
}
