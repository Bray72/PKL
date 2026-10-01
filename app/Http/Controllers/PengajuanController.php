<?php

namespace App\Http\Controllers;

use App\Models\Ajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class PengajuanController extends Controller
{
    /**
     * Tampilkan daftar pengajuan + form inline tambah pengajuan.
     */
    public function index(Request $request)
    {
        $query = Ajuan::with('user');
        $users = User::orderBy('biro')->get();

        // Filter pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_aplikasi', 'like', "%{$search}%")
                    ->orWhere('nomor_ajuan', 'like', "%{$search}%")
                    ->orWhereHas('user', fn($u) => $u
                        ->where('biro', 'like', "%{$search}%")
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
        $totalAjuan   = Ajuan::count();
        $selesaiCount = Ajuan::whereIn('status', ['selesai', 'Selesai'])->count();

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
            'user_id'            => 'required|exists:users,id',
            'nama_aplikasi'      => 'required|string|max:255',
            'tujuan_assessment'  => 'required|string|max:1000',
            'tanggal_assessment' => 'nullable|date',
            'catatan'            => 'nullable|string|max:2000',
            'status'             => 'required|in:Pengajuan,Proses Pengujian,Selesai',
        ], [
            'nama_aplikasi.required'     => 'Nama Aplikasi wajib diisi.',
            'tujuan_assessment.required' => 'Tujuan assessment wajib diisi.',
            'tanggal_assessment.date'    => 'Format tanggal assessment tidak valid.',
        ]);

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
            'user_id' => $validated['user_id'],
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

    public function edit(Ajuan $ajuan)
    {
        $users = User::orderBy('biro')->get();

        return view('admin.pengajuan-edit', compact(
            'ajuan',
            'users'
        ));
    }

    public function update(Request $request, Ajuan $ajuan)
    {
        $validated = $request->validate([
            'user_id'            => 'required|exists:users,id',
            'nama_aplikasi'      => 'required|string|max:255',
            'tujuan_assessment'  => 'required|string|max:1000',
            'tanggal_assessment' => 'nullable|date',
            'catatan'            => 'nullable|string|max:2000',
            'status'             => 'required|in:Pengajuan,Proses Pengujian,Selesai',
        ]);

        $ajuan->update([
            'user_id'            => $validated['user_id'],
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

    public function destroy(Ajuan $ajuan) 
    { 
        $nomorAjuan = $ajuan->nomor_ajuan; 
        
        $ajuan->delete(); 
        
        return redirect() 
            ->route('admin.pengajuan.index') 
            ->with('success', "Pengajuan {$nomorAjuan} berhasil dihapus!"); 
    }
}
