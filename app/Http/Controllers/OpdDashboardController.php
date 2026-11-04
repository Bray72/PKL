<?php

namespace App\Http\Controllers;

use App\Models\Ajuan;
use App\Models\Temuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OpdDashboardController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();

        // Query ajuans for current OPD user
        $query = Ajuan::where('user_id', $userId);

        if ($request->filled('search')) {
            $query->where('nama_aplikasi', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $status = strtolower($request->status);
            if (in_array($status, ['diajukan', 'pengajuan'])) {
                $query->whereIn('status', ['Diajukan', 'diajukan', 'Pengajuan', 'pengajuan', 'pending', 'menunggu']);
            } elseif (in_array($status, ['proses pengujian', 'proses', 'ujipetik'])) {
                $query->whereIn('status', ['Proses Pengujian', 'proses pengujian', 'Sedang Diproses', 'diproses', 'ujipetik']);
            } elseif ($status === 'dalam perbaikan') {
                $query->whereIn('status', ['Dalam Perbaikan', 'dalam perbaikan', 'Perlu Perbaikan', 'remediasi']);
            } elseif ($status === 'selesai') {
                $query->whereIn('status', ['Selesai', 'selesai']);
            } else {
                $query->where('status', $request->status);
            }
        }

        $ajuans = $query
            ->with(['dokumens' => function ($query) {
                $query->whereHas('uploader', function ($query) {
                    $query->where('role_id', 1);
                })->latest();
            }])
            ->latest()
            ->get();

        // Statistics
        $totalAjuan = Ajuan::where('user_id', $userId)->count();

        $diajukanCount = Ajuan::where('user_id', $userId)
            ->whereIn('status', ['Diajukan', 'diajukan', 'Pengajuan', 'pengajuan', 'pending', 'menunggu'])
            ->count();

        $diprosesCount = Ajuan::where('user_id', $userId)
            ->whereIn('status', ['Proses Pengujian', 'proses pengujian', 'Sedang Diproses', 'diproses', 'ujipetik'])
            ->count();

        $perbaikanCount = Ajuan::where('user_id', $userId)
            ->whereIn('status', ['Dalam Perbaikan', 'dalam perbaikan', 'Perlu Perbaikan', 'remediasi'])
            ->count();

        $selesaiCount = Ajuan::where('user_id', $userId)
            ->whereIn('status', ['Selesai', 'selesai'])
            ->count();

        $totalTemuan = Temuan::whereHas('ajuan', fn($q) => $q->where('user_id', $userId))->count();

        return view('opd.dashboard', compact(
            'ajuans',
            'totalAjuan',
            'diajukanCount',
            'diprosesCount',
            'perbaikanCount',
            'selesaiCount',
            'totalTemuan'
        ));
    }
}
