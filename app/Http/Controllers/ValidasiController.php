<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Ajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ValidasiController extends Controller
{
    /**
     * Menampilkan daftar hasil pengujian
     */
    public function index()
    {
        $ajuans = Ajuan::with([
            'user',
            'temuans'
        ])
        ->whereIn('status', [
            'selesai',
            'dikembalikan'
        ])
        ->latest()
        ->get();

        return view('admin.validasi', compact('ajuans'));
    }


    /**
     * Validasi hasil dan terbitkan laporan
     */
    public function validateResult($id)
    {
        $ajuan = Ajuan::with('temuans')->findOrFail($id);

        DB::transaction(function () use ($ajuan) {

            // Status pengajuan menjadi selesai
            $ajuan->update([
                'status' => 'selesai',
            ]);

            // Semua temuan dianggap sudah divalidasi
            $ajuan->temuans()->update([
                'status' => 'tervalidasi',
                'catatan_validasi' => 'Hasil pengujian telah divalidasi oleh Admin ITSA.',
            ]);
        });

        return redirect()
            ->route('admin.validasi.index')
            ->with('success', 'Hasil pengujian berhasil divalidasi dan laporan diterbitkan.');
    }


    /**
     * Mengembalikan hasil kepada OPD
     */
    public function returnToOpd(Request $request, $id)
    {
        $request->validate([
            'catatan_validasi' => 'required|string|max:1000',
        ], [
            'catatan_validasi.required' => 'Catatan pengembalian wajib diisi.',
        ]);

        $ajuan = Ajuan::with('temuans')->findOrFail($id);

        DB::transaction(function () use ($ajuan, $request) {

            // Pengajuan dikembalikan
            $ajuan->update([
                'status' => 'dikembalikan',
            ]);

            // Simpan catatan validasi
            $ajuan->temuans()->update([
                'status' => 'perlu_perbaikan',
                'catatan_validasi' => $request->catatan_validasi,
            ]);
        });

        return redirect()
            ->route('admin.validasi')
            ->with('success', 'Hasil pengujian berhasil dikembalikan kepada OPD.');
    }
}