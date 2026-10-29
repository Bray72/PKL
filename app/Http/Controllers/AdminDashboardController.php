<?php

namespace App\Http\Controllers;

use App\Models\Ajuan;
use App\Models\Temuan;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        // Query all ajuans with user relation
        $query = Ajuan::with('user');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_aplikasi', 'like', "%{$search}%")
                    ->orWhere('nomor_ajuan', 'like', "%{$search}%")
                    ->orWhereHas('user', fn($u) => $u->where('opd', 'like', "%{$search}%")->orWhere('name', 'like', "%{$search}%"));
            });
        }

        if ($request->filled('status')) {
            $status = strtolower($request->status);
            if ($status === 'diajukan') {
                $query->whereIn('status', ['diajukan', 'Diajukan', 'Pengajuan', 'pengajuan', 'pending', 'menunggu', 'Perlu Verifikasi']);
            } elseif (in_array($status, ['dalam_pengujian', 'dalam pengujian', 'dalam_pengajuan', 'dalam pengajuan', 'proses', 'ujipetik'])) {
                $query->whereIn('status', ['dalam pengujian', 'Dalam Pengujian', 'dalam pengajuan', 'Dalam Pengajuan', 'Proses Pengujian', 'Sedang Diproses', 'diproses', 'ujipetik', 'proses ujipetik']);
            } elseif (in_array($status, ['menunggu_perbaikan', 'menunggu perbaikan', 'perbaikan'])) {
                $query->whereIn('status', ['menunggu perbaikan', 'Menunggu Perbaikan', 'Perlu Perbaikan', 'Perbaikan', 'perbaikan', 'remediasi']);
            } elseif ($status === 'selesai') {
                $query->whereIn('status', ['selesai', 'Selesai']);
            } else {
                $query->where('status', $request->status);
            }
        }

        $ajuans = $query->latest()->get();

        // Statistics
        $totalopd = User::where('role_id', 2)->count();
        $totalAjuan = Ajuan::count();

        // Hitung total untuk masing-masing status
        $diajukanCount = Ajuan::whereIn('status', ['diajukan', 'Diajukan', 'Pengajuan', 'pengajuan', 'pending', 'menunggu', 'Perlu Verifikasi'])->count();
        $dalamPengujianCount = Ajuan::whereIn('status', ['dalam pengujian', 'Dalam Pengujian', 'dalam pengajuan', 'Dalam Pengajuan', 'Proses Pengujian', 'Sedang Diproses', 'diproses', 'ujipetik', 'proses ujipetik'])->count();
        $dalamPengajuanCount = $dalamPengujianCount;
        $menungguPerbaikanCount = Ajuan::whereIn('status', ['menunggu perbaikan', 'Menunggu Perbaikan', 'Perlu Perbaikan', 'Perbaikan', 'perbaikan', 'remediasi'])->count();
        $selesaiCount = Ajuan::whereIn('status', ['selesai', 'Selesai'])->count();

        // Backward compatibility jika ada view yang memakai $prosesCount
        $prosesCount = $dalamPengujianCount;

        // Quick Verification Tasks & Activity Log
        $pendingVerifikasi = Ajuan::with('user')
            ->whereIn('status', ['diajukan', 'Diajukan', 'pending', 'menunggu', 'perlu_verifikasi', 'Perlu Verifikasi', 'Pengajuan'])
            ->latest()
            ->take(5)
            ->get();

        $recentTemuans = Temuan::with('ajuan.user')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'ajuans',
            'totalopd',
            'totalAjuan',
            'diajukanCount',
            'dalamPengujianCount',
            'dalamPengajuanCount',
            'menungguPerbaikanCount',
            'selesaiCount',
            'prosesCount',
            'pendingVerifikasi',
            'recentTemuans'
        ));
    }
}
