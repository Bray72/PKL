<?php

namespace App\Http\Controllers;

use App\Models\Temuan;
use App\Models\Dokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RemediasiController extends Controller
{
    /**
     * Menampilkan semua temuan untuk OPD yang sedang login
     */
    public function index()
    {
        $opd = auth()->user()->opd;

        $temuans = Temuan::with(['ajuan.user'])
            ->whereHas('ajuan.user', function ($query) use ($opd) {
                $query->where('opd', $opd);
            })
            ->latest()
            ->get();

        return view('opd.remediasi', compact('temuans'));
    }

    /**
     * Memperbarui status dan catatan remediasi oleh OPD
     */
    public function update(Request $request, Temuan $temuan)
    {
        $request->validate([
            'catatan_validasi' => 'nullable|string',
            'bukti_perbaikan' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Update status dan catatan
        $temuan->update([
            'status' => 'Perbaikan',
            'catatan_validasi' => $request->catatan_validasi,
        ]);

        // Jika ada gambar yang diupload
        if ($request->hasFile('bukti_perbaikan')) {
            // Hapus dokumen lama jika ada
            $oldDokumen = Dokumen::where('temuan_id', $temuan->id)
                ->where('jenis_dokumen', 'bukti_perbaikan')
                ->first();

            if ($oldDokumen) {
                if ($oldDokumen->path_file) {
                    try {
                        if (Storage::disk('supabase')->exists($oldDokumen->path_file)) {
                            Storage::disk('supabase')->delete($oldDokumen->path_file);
                        }
                    } catch (\Throwable $e) {}

                    if (Storage::disk('public')->exists($oldDokumen->path_file)) {
                        Storage::disk('public')->delete($oldDokumen->path_file);
                    }
                }
                $oldDokumen->delete();
            }

            $file = $request->file('bukti_perbaikan');

            // Simpan ke Supabase Storage di folder dokumen/bukti-perbaikan
            $path = $file->store('dokumen/bukti-perbaikan', 'supabase');

            // Simpan informasi file ke tabel dokumens
            Dokumen::create([
                'ajuan_id' => $temuan->ajuan_id,
                'temuan_id' => $temuan->id,
                'jenis_dokumen' => 'bukti_perbaikan',
                'nama_file' => $file->getClientOriginalName(),
                'path_file' => $path,
                'uploaded_by' => auth()->id(),
            ]);
        }

        return redirect()
            ->route('opd.remediasi')
            ->with('success', 'Status perbaikan berhasil diperbarui.');
    }
}