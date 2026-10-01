<?php

namespace App\Http\Controllers;

use App\Models\Temuan;
use App\Models\Ajuan;
use Illuminate\Http\Request;

class TemuanController extends Controller
{
    /**
     * Tampilkan daftar temuan + form inline tambah temuan.
     */
    public function index(Request $request)
    {
        // Ambil semua temuan beserta data pengajuan
        $temuans = Temuan::with('ajuan')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        // Ambil data pengajuan untuk dropdown
        $ajuans = Ajuan::latest()->get();

        // Apakah form tambah temuan ditampilkan?
        $showForm = $request->boolean('form');

        return view('admin.temuan', compact(
            'temuans',
            'ajuans',
            'showForm'
        ));
    }

    /**
     * Simpan temuan baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ajuan_id' => 'required|exists:ajuans,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'severity' => 'required|in:Rendah,Sedang,Tinggi,Kritis',
            'rekomendasi' => 'nullable|string',
        ]);

        Temuan::create([
            'ajuan_id' => $validated['ajuan_id'],
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'severity' => $validated['severity'],
            'rekomendasi' => $validated['rekomendasi'] ?? null,
            'status' => 'Menunggu Remediasi', 
        ]);

        return redirect()
            ->route('admin.temuan.index')
            ->with('success', 'Temuan berhasil ditambahkan.');
    }

    /**
     * Tampilkan halaman/form edit
     */
    public function edit(Temuan $temuan)
    {
        $ajuans = Ajuan::latest()->get();

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
        $validated = $request->validate([
            'ajuan_id' => 'required|exists:ajuans,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'severity' => 'required|in:Rendah,Sedang,Tinggi,Kritis',
            'rekomendasi' => 'nullable|string',
            'status' => 'required|string|max:255',
        ]);

        $temuan->update([
            'ajuan_id' => $validated['ajuan_id'],
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'severity' => $validated['severity'],
            'rekomendasi' => $validated['rekomendasi'] ?? null,
            'status' => $validated['status'],
        ]);

        return redirect()
            ->route('admin.temuan.index')
            ->with('success', 'Temuan berhasil diperbarui.');
    }

    /**
     * Hapus temuan
     */
    public function destroy(Temuan $temuan)
    {
        $temuan->delete();

        return redirect()
            ->route('admin.temuan.index')
            ->with('success', 'Temuan berhasil dihapus.');
    }
}