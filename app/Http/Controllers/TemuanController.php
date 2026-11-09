<?php

namespace App\Http\Controllers;

use App\Models\Temuan;
use App\Models\Ajuan;
use App\Models\Dokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TemuanController extends Controller
{
    /**
     * Tampilkan daftar temuan + form inline tambah temuan.
     */
    public function index(Request $request)
    {
        $admin = $request->user();

        // Ambil temuan sesuai hak akses admin (role 1 melihat semua, role 2 & 3 melihat buatannya sendiri)
        $temuans = Temuan::with('ajuan')
            ->visibleToAdmin($admin)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        // Ambil data pengajuan untuk dropdown sesuai hak akses admin
        $ajuans = Ajuan::visibleToAdmin($admin)
            ->latest()
            ->get();

        // Apakah form tambah temuan ditampilkan?
        $showForm = true;
        $selectedAjuanId = $request->integer('ajuan_id') ?: old('ajuan_id');

        return view('admin.temuan', compact(
            'temuans',
            'ajuans',
            'showForm',
            'selectedAjuanId'
        ));
    }

    /**
     * Simpan temuan baru
     */
    public function store(Request $request)
    {
        $admin = $request->user();

        $validated = $request->validate([
            'ajuan_id' => 'required|exists:ajuans,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'severity' => 'required|in:Rendah,Sedang,Tinggi,Kritis',
            'rekomendasi' => 'nullable|string',
            'dokumen' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:20480',
        ], [
            'dokumen.mimes' => 'Format file dokumen temuan harus berupa PDF atau gambar (JPG, PNG, WEBP).',
            'dokumen.max' => 'Ukuran file dokumen temuan maksimal 20 MB.',
        ]);

        // Pastikan admin hanya bisa membuat temuan pada ajuan yang dia miliki hak aksesnya
        if ((int) $admin->role_id !== 1) {
            $isAjuanVisible = Ajuan::where('id', $validated['ajuan_id'])
                ->where('created_by', $admin->id)
                ->exists();

            if (!$isAjuanVisible) {
                abort(403, 'Anda tidak memiliki hak akses untuk menambahkan temuan pada pengajuan ini.');
            }
        }

        $temuan = Temuan::create([
            'ajuan_id' => $validated['ajuan_id'],
            'created_by' => Auth::id(),
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'severity' => $validated['severity'],
            'rekomendasi' => $validated['rekomendasi'] ?? null,
            'status' => 'Menunggu Remediasi', 
        ]);

        // Simpan file lampiran dokumen temuan jika diupload
        if ($request->hasFile('dokumen')) {
            $file = $request->file('dokumen');
            $namaFile = $file->getClientOriginalName();
            $path = null;

            try {
                $path = $file->store('dokumen/temuan', 'supabase');
            } catch (\Throwable $e) {
                // fallback lokal jika koneksi supabase gagal
            }

            if (!$path) {
                $path = $file->store('dokumen/temuan', 'public');
            }

            Dokumen::create([
                'ajuan_id' => $temuan->ajuan_id,
                'temuan_id' => $temuan->id,
                'jenis_dokumen' => 'bukti_pengujian',
                'nama_file' => $namaFile,
                'path_file' => $path,
                'uploaded_by' => Auth::id(),
            ]);
        }

        return redirect()
            ->route('admin.pengajuan.index')
            ->with('success', 'Temuan berhasil ditambahkan.');
    }

    /**
     * Tampilkan halaman/form edit
     */
    public function edit(Request $request, Temuan $temuan)
    {
        $admin = $request->user();
        if ((int) $admin->role_id !== 1 && $temuan->created_by !== $admin->id) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengedit temuan ini.');
        }

        $ajuans = Ajuan::visibleToAdmin($admin)
            ->latest()
            ->get();

        return view('admin.temuan-edit', compact(
            'temuan',
            'ajuans'
        ));
    }

    /**
     * Update temuan
     */
    public function update(Request $request, Temuan $temuan)
    {
        $admin = $request->user();
        if ((int) $admin->role_id !== 1 && $temuan->created_by !== $admin->id) {
            abort(403, 'Anda tidak memiliki hak akses untuk memperbarui temuan ini.');
        }

        $validated = $request->validate([
            'ajuan_id' => 'required|exists:ajuans,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'severity' => 'required|in:Rendah,Sedang,Tinggi,Kritis',
            'rekomendasi' => 'nullable|string',
            'status' => 'required|string|max:255',
            'dokumen' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:20480',
        ], [
            'dokumen.mimes' => 'Format file dokumen temuan harus berupa PDF atau gambar (JPG, PNG, WEBP).',
            'dokumen.max' => 'Ukuran file dokumen temuan maksimal 20 MB.',
        ]);

        // Pastikan ajuan baru yang dipilih juga merupakan ajuan milik admin jika bukan superadmin
        if ((int) $admin->role_id !== 1) {
            $isAjuanVisible = Ajuan::where('id', $validated['ajuan_id'])
                ->where('created_by', $admin->id)
                ->exists();

            if (!$isAjuanVisible) {
                abort(403, 'Anda tidak memiliki hak akses untuk memindahkan temuan ke pengajuan ini.');
            }
        }

        $temuan->update([
            'ajuan_id' => $validated['ajuan_id'],
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'severity' => $validated['severity'],
            'rekomendasi' => $validated['rekomendasi'] ?? null,
            'status' => $validated['status'],
        ]);

        // Jika upload file baru saat update
        if ($request->hasFile('dokumen')) {
            $file = $request->file('dokumen');
            $namaFile = $file->getClientOriginalName();
            $path = null;

            try {
                $path = $file->store('dokumen/temuan', 'supabase');
            } catch (\Throwable $e) {}

            if (!$path) {
                $path = $file->store('dokumen/temuan', 'public');
            }

            Dokumen::create([
                'ajuan_id' => $temuan->ajuan_id,
                'temuan_id' => $temuan->id,
                'jenis_dokumen' => 'bukti_pengujian',
                'nama_file' => $namaFile,
                'path_file' => $path,
                'uploaded_by' => Auth::id(),
            ]);
        }

        return redirect()
            ->route('admin.temuan.index')
            ->with('success', 'Temuan berhasil diperbarui.');
    }

    /**
     * Hapus temuan
     */
    public function destroy(Request $request, Temuan $temuan)
    {
        $admin = $request->user();
        if ((int) $admin->role_id !== 1 && $temuan->created_by !== $admin->id) {
            abort(403, 'Anda tidak memiliki hak akses untuk menghapus temuan ini.');
        }

        $temuan->delete();

        return redirect()
            ->route('admin.temuan.index')
            ->with('success', 'Temuan berhasil dihapus.');
    }
}
