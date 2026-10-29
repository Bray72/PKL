<?php

namespace App\Http\Controllers;

use App\Models\Ajuan;
use App\Models\Dokumen;
use App\Models\Temuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DokumenController extends Controller
{
    /**
     * Halaman utama Upload Dokumen
     */
    public function index(Request $request)
    {
        $query = Dokumen::with(['ajuan', 'temuan', 'uploader'])
            ->latest();

        // Search nama file
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('nama_file', 'ILIKE', "%{$search}%")
                  ->orWhere('jenis_dokumen', 'ILIKE', "%{$search}%");
            });
        }

        // Filter jenis dokumen
        if ($request->filled('jenis_dokumen')) {
            $query->where(
                'jenis_dokumen',
                $request->jenis_dokumen
            );
        }

        // Filter pengajuan
        if ($request->filled('ajuan_id')) {
            $query->where(
                'ajuan_id',
                $request->ajuan_id
            );
        }

        $dokumens = $query->get();

        $ajuans = Ajuan::with(['user', 'temuans'])->latest()->get();

        // Statistik
        $totalDokumen = Dokumen::count();

        $totalSurat = Dokumen::where(
            'jenis_dokumen',
            'surat'
        )->count();

        $totalLaporan = Dokumen::whereIn(
            'jenis_dokumen',
            ['laporan', 'surat_rekomendasi']
        )->count();

        // Hitung ukuran file
        $totalUkuran = 0;

        foreach ($dokumens as $dokumen) {
            if ($dokumen->path_file) {
                try {
                    if (Storage::disk('supabase')->exists($dokumen->path_file)) {
                        $totalUkuran += Storage::disk('supabase')->size($dokumen->path_file);
                        continue;
                    }
                } catch (\Throwable $e) {}

                if (Storage::disk('public')->exists($dokumen->path_file)) {
                    $totalUkuran += Storage::disk('public')->size($dokumen->path_file);
                }
            }
        }

        return view('dokumen.index', compact(
            'dokumens',
            'ajuans',
            'totalDokumen',
            'totalSurat',
            'totalLaporan',
            'totalUkuran'
        ));
    }


    /**
     * Upload dokumen ke Supabase
     */
    public function store(Request $request)
    {

        $request->validate([
            'ajuan_id' => 'required|exists:ajuans,id',
            'temuan_id' => 'nullable|exists:temuans,id',
            'jenis_dokumen' => 'required|string|max:100',
            'file' => 'required|file|max:20480',
        ]);

        $file = $request->file('file');

        if (!$file) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        $namaFile = $file->getClientOriginalName();

        // Simpan langsung ke Supabase Storage
        $path = $file->store('dokumen', 'supabase');

        if (!$path) {
            return back()->with('error', 'File gagal disimpan ke Supabase.');
        }

        Dokumen::create([
            'ajuan_id' => $request->ajuan_id,
            'temuan_id' => $request->filled('temuan_id')
                ? $request->temuan_id
                : null,
            'jenis_dokumen' => $request->jenis_dokumen,
            'nama_file' => $namaFile,
            'path_file' => $path,
            'uploaded_by' => auth()->id(),
        ]);

        return redirect()
            ->route('dokumen.index')
            ->with('success', 'Dokumen berhasil diupload ke Supabase.');
    }


    /**
     * Download dokumen
     */
    public function download(Dokumen $dokumen)
    {
        $user = Auth::user();

        // Admin dapat mengunduh semua dokumen, sedangkan OPD hanya dokumen
        // yang terkait dengan pengajuannya sendiri.
        abort_unless(
            $user->role_id === 1 || $dokumen->ajuan?->user_id === $user->id,
            403
        );

        if (!$dokumen->path_file) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        // Cek di disk supabase
        try {
            if (Storage::disk('supabase')->exists($dokumen->path_file)) {
                return Storage::disk('supabase')->download(
                    $dokumen->path_file,
                    $dokumen->nama_file
                );
            }
        } catch (\Throwable $e) {}

        // Fallback cek di disk public lokal
        if (Storage::disk('public')->exists($dokumen->path_file)) {
            return Storage::disk('public')->download(
                $dokumen->path_file,
                $dokumen->nama_file
            );
        }

        return back()->with('error', 'File tidak ditemukan di server.');
    }


    /**
     * Hapus dokumen
     */
    public function destroy($id)
    {
        $dokumen = Dokumen::findOrFail($id);

        if ($dokumen->path_file) {
            try {
                if (Storage::disk('supabase')->exists($dokumen->path_file)) {
                    Storage::disk('supabase')->delete($dokumen->path_file);
                }
            } catch (\Throwable $e) {}

            if (Storage::disk('public')->exists($dokumen->path_file)) {
                Storage::disk('public')->delete($dokumen->path_file);
            }
        }

        $dokumen->delete();

        return redirect()
            ->route('dokumen.index')
            ->with(
                'success',
                'Dokumen berhasil dihapus.'
            );
    }
}
