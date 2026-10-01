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
                    ->orWhereHas('user', fn($u) => $u->where('biro', 'like', "%{$search}%")->orWhere('name', 'like', "%{$search}%"));
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $ajuans = $query->latest()->get();

        // Statistics
        $totalbiro = User::where('role_id', 2)->count();
        $totalAjuan = Ajuan::count();
        $prosesCount = Ajuan::whereIn('status', ['diproses', 'ujipetik', 'pending', 'menunggu', 'Sedang Diproses', 'Proses Ujipetik', 'Perlu Verifikasi'])->count();
        $selesaiCount = Ajuan::whereIn('status', ['selesai', 'Selesai'])->count();

        // Quick Verification Tasks & Activity Log
        $pendingVerifikasi = Ajuan::with('user')
            ->whereIn('status', ['pending', 'menunggu', 'perlu_verifikasi', 'Perlu Verifikasi'])
            ->latest()
            ->take(5)
            ->get();

        $recentTemuans = Temuan::with('ajuan.user')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'ajuans',
            'totalbiro',
            'totalAjuan',
            'prosesCount',
            'selesaiCount',
            'pendingVerifikasi',
            'recentTemuans'
        ));
    }
}
