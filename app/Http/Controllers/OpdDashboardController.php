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

        $statuses = ['Pengajuan', 'Proses Pengujian', 'Selesai'];

        if ($request->filled('status') && in_array($request->status, $statuses, true)) {
            $query->where('status', $request->status);
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

        $pengajuanCount = Ajuan::where('user_id', $userId)
            ->where('status', 'Pengajuan')
            ->count();

        $diprosesCount = Ajuan::where('user_id', $userId)
            ->where('status', 'Proses Pengujian')
            ->count();

        $selesaiCount = Ajuan::where('user_id', $userId)
            ->where('status', 'Selesai')
            ->count();

        $totalTemuan = Temuan::whereHas('ajuan', fn($q) => $q->where('user_id', $userId))->count();

        return view('opd.dashboard', compact(
            'ajuans',
            'totalAjuan',
            'pengajuanCount',
            'diprosesCount',
            'selesaiCount',
            'totalTemuan'
        ));
    }
}
