@extends('layout.admin')

@section('title', 'Kelola Temuan - Portal ITSA')

@push('styles')
<style>

    /* =========================
       HEADER
    ========================= */

    .temuan-page {
        max-width: 1100px;
        margin: 0 auto;
    }

    .page-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 24px;
        flex-wrap: wrap;
    }

    .page-title {
        font-size: 22px;
        font-weight: 800;
        color: #1b365d;
        margin: 0 0 4px;
    }

    .page-subtitle {
        font-size: 13px;
        color: #64748b;
        margin: 0;
    }


    /* =========================
       BUTTON
    ========================= */

    .btn-add {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: #16305a;
        color: #fff;
        border: none;
        border-radius: 11px;
        padding: 10px 20px;
        font-size: 13.5px;
        font-weight: 700;
        cursor: pointer;
        text-decoration: none;
        transition: background .15s;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .btn-add:hover {
        background: #1e3a6e;
        color: #fff;
    }


    /* =========================
       FORM
    ========================= */

    .form-section {
        background: #fff;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 4px rgba(0,0,0,.04);
        padding: 28px 32px 32px;
        margin-bottom: 24px;
    }

    .form-title {
        font-size: 15px;
        font-weight: 800;
        color: #1b365d;
        margin: 0;
    }

    .form-subtitle {
        font-size: 11.5px;
        color: #94a3b8;
        margin: 3px 0 0;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px 24px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .form-group.full {
        grid-column: 1 / -1;
    }

    .form-label {
        font-size: 12.5px;
        font-weight: 700;
        color: #1e293b;
    }

    .req {
        color: #e11d48;
    }

    .form-control {
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        padding: 10px 14px;
        font-size: 13px;
        color: #1e293b;
        background: #f8fafc;
        transition: .15s;
        font-family: 'Plus Jakarta Sans', sans-serif;
        outline: none;
    }

    .form-control:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99,102,241,.12);
        background: #fff;
    }

    textarea.form-control {
        resize: vertical;
        min-height: 90px;
    }


    /* =========================
       BUTTON FORM
    ========================= */

    .btn-primary {
        background: #16305a;
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 11px 24px;
        font-size: 13.5px;
        font-weight: 700;
        cursor: pointer;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .btn-primary:hover {
        background: #1e3a6e;
    }

    .btn-secondary {
        background: transparent;
        color: #64748b;
        border: none;
        border-radius: 10px;
        padding: 11px 20px;
        font-size: 13.5px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .btn-secondary:hover {
        background: #f1f5f9;
        color: #334155;
    }


    /* =========================
       TABLE
    ========================= */

    .table-card {
        background: #fff;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 4px rgba(0,0,0,.04);
        overflow: hidden;
    }

    .table-wrap {
        overflow-x: auto;
    }

    .temuan-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12.5px;
    }

    .temuan-table thead tr {
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        color: #1b365d;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .05em;
    }

    .temuan-table th {
        padding: 13px 16px;
        white-space: nowrap;
        text-align: left;
    }

    .temuan-table tbody tr {
        border-bottom: 1px solid #f1f5f9;
    }

    .temuan-table tbody tr:last-child {
        border-bottom: none;
    }

    .temuan-table tbody tr:hover {
        background: #f8fafc;
    }

    .temuan-table td {
        padding: 13px 16px;
        color: #334155;
        vertical-align: middle;
    }

    .temuan-id {
        font-weight: 700;
        color: #1b365d;
        font-size: 11.5px;
    }

    .ajuan-number {
        font-weight: 600;
        color: #475569;
    }

    .judul-temuan {
        font-weight: 600;
        color: #334155;
    }

    .tanggal {
        font-size: 12px;
        color: #475569;
    }


    /* =========================
       BADGE
    ========================= */

    .badge {
        display: inline-flex;
        align-items: center;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        white-space: nowrap;
    }

    .badge-kritis {
        background: #fff1f2;
        color: #e11d48;
        border: 1px solid #fecdd3;
    }

    .badge-tinggi {
        background: #fff7ed;
        color: #ea580c;
        border: 1px solid #fed7aa;
    }

    .badge-sedang {
        background: #fffbeb;
        color: #d97706;
        border: 1px solid #fde68a;
    }

    .badge-rendah {
        background: #ecfdf5;
        color: #059669;
        border: 1px solid #a7f3d0;
    }

    .badge-status {
        background: #eff6ff;
        color: #2563eb;
        border: 1px solid #bfdbfe;
    }


    /* =========================
       EMPTY
    ========================= */

    .empty-state {
        text-align: center;
        padding: 48px 20px;
    }

    .empty-state p {
        font-size: 13.5px;
        color: #64748b;
        font-weight: 600;
        margin: 12px 0 4px;
    }

    .empty-state span {
        font-size: 12px;
        color: #94a3b8;
    }


    /* =========================
       RESPONSIVE
    ========================= */

    @media (max-width: 700px) {

        .form-grid {
            grid-template-columns: 1fr;
        }

        .form-group.full {
            grid-column: auto;
        }

    }

</style>
@endpush

@section('content')

<div class="temuan-page">

    {{-- HEADER --}}
    <div class="page-header">

        <div>
            <h1 class="page-title">
                Kelola Temuan
            </h1>

            <p class="page-subtitle">
                Catat dan kelola celah keamanan yang ditemukan selama pengujian
            </p>
        </div>

        <a
            href="{{ $showForm
                ? route('admin.temuan.index')
                : route('admin.temuan.index', ['form' => 1]) }}"
            class="btn-add"
        >
            @if($showForm)
                ✕ Tutup Form
            @else
                ＋ Catat Temuan
            @endif
        </a>

    </div>


    {{-- FORM --}}
    @if($showForm || $errors->any())

        <div class="form-section">

            <div style="margin-bottom:22px;">

                <h2 class="form-title">
                    Form Temuan Keamanan
                </h2>

                <p class="form-subtitle">
                    Catat hasil temuan keamanan dari proses assessment
                </p>

            </div>

            <form
                method="POST"
                action="{{ route('admin.temuan.store') }}"
            >

                @csrf

                <div class="form-grid">

                    {{-- ID PENGAJUAN --}}
                    <div class="form-group">

                        <label class="form-label">
                            ID Pengajuan <span class="req">*</span>
                        </label>

                        <select
                            name="ajuan_id"
                            class="form-control"
                            required
                        >

                            <option value="">
                                Pilih pengajuan...
                            </option>

                            @foreach($ajuans as $ajuan)

                                <option
                                    value="{{ $ajuan->id }}"
                                    {{ old('ajuan_id') == $ajuan->id ? 'selected' : '' }}
                                >
                                    {{ $ajuan->nomor_ajuan }}
                                </option>

                            @endforeach

                        </select>

                        @error('ajuan_id')
                            <small style="color:#e11d48;">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    {{-- SEVERITY --}}
                    <div class="form-group">

                        <label class="form-label">
                            Tingkat Risiko <span class="req">*</span>
                        </label>

                        <select
                            name="severity"
                            class="form-control"
                            required
                        >

                            <option
                                value="Sedang"
                                {{ old('severity', 'Sedang') == 'Sedang' ? 'selected' : '' }}
                            >
                                Sedang
                            </option>

                            <option
                                value="Rendah"
                                {{ old('severity') == 'Rendah' ? 'selected' : '' }}
                            >
                                Rendah
                            </option>

                            <option
                                value="Tinggi"
                                {{ old('severity') == 'Tinggi' ? 'selected' : '' }}
                            >
                                Tinggi
                            </option>

                            <option
                                value="Kritis"
                                {{ old('severity') == 'Kritis' ? 'selected' : '' }}
                            >
                                Kritis
                            </option>

                        </select>

                        @error('severity')
                            <small style="color:#e11d48;">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    {{-- JUDUL --}}
                    <div class="form-group full">

                        <label class="form-label">
                            Judul Temuan <span class="req">*</span>
                        </label>

                        <input
                            type="text"
                            name="judul"
                            class="form-control"
                            value="{{ old('judul') }}"
                            placeholder="Contoh: SQL Injection pada /api/login"
                            required
                        >

                        @error('judul')
                            <small style="color:#e11d48;">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    {{-- DESKRIPSI --}}
                    <div class="form-group">

                        <label class="form-label">
                            Deskripsi Teknis
                        </label>

                        <textarea
                            name="deskripsi"
                            class="form-control"
                            placeholder="Jelaskan detail temuan..."
                        >{{ old('deskripsi') }}</textarea>

                        @error('deskripsi')
                            <small style="color:#e11d48;">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    {{-- REKOMENDASI --}}
                    <div class="form-group">

                        <label class="form-label">
                            Rekomendasi Perbaikan
                        </label>

                        <textarea
                            name="rekomendasi"
                            class="form-control"
                            placeholder="Langkah mitigasi yang disarankan..."
                        >{{ old('rekomendasi') }}</textarea>

                        @error('rekomendasi')
                            <small style="color:#e11d48;">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>

                </div>


                <div style="
                    display:flex;
                    gap:12px;
                    margin-top:20px;
                ">

                    <button
                        type="submit"
                        class="btn-primary"
                    >
                        Simpan Temuan
                    </button>

                    <a
                        href="{{ route('admin.temuan.index') }}"
                        class="btn-secondary"
                    >
                        Batal
                    </a>

                </div>

            </form>

        </div>

    @endif


    {{-- TABLE --}}
    <div class="table-card">

        <div class="table-wrap">

            <table class="temuan-table">

                <thead>

                    <tr>
                        <th>ID</th>
                        <th>Pengajuan</th>
                        <th>Judul Temuan</th>
                        <th>Tingkat</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Bukti Gambar</th>
                        <th>Aksi</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse($temuans as $temuan)

                        @php
                            $severity = strtolower($temuan->severity ?? '');

                            $severityClass = match($severity) {
                                'kritis' => 'badge-kritis',
                                'tinggi' => 'badge-tinggi',
                                'sedang' => 'badge-sedang',
                                'rendah' => 'badge-rendah',
                                default => 'badge-status',
                            };
                        @endphp

                        <tr>

                            <td>
                                <span class="temuan-id">
                                    TMN-{{ str_pad($temuan->id, 3, '0', STR_PAD_LEFT) }}
                                </span>
                            </td>

                            <td>
                                <span class="ajuan-number">
                                    {{ $temuan->ajuan->nomor_ajuan ?? '-' }}
                                </span>
                            </td>

                            <td>
                                <span class="judul-temuan">
                                    {{ $temuan->judul }}
                                </span>
                            </td>

                            <td>
                                <span class="badge {{ $severityClass }}">
                                    {{ ucfirst($temuan->severity ?? '-') }}
                                </span>
                            </td>

                            <td>
                                <span class="tanggal">
                                    {{ $temuan->created_at?->format('d M Y') ?? '-' }}
                                </span>
                            </td>

                            <td>
                                <span class="badge badge-status">
                                    {{ $temuan->status ?? '-' }}
                                </span>
                            </td>

                            <td>
                                @php
                                    $dokumen = $temuan->dokumens->firstWhere('jenis_dokumen', 'bukti_perbaikan') ?? $temuan->dokumens->first();
                                @endphp
                                
                                @if($dokumen && $dokumen->path_file)
                                    <a href="{{ asset('storage/' . $dokumen->path_file) }}" target="_blank" class="btn btn-sm" style="background:#f1f5f9; color:#334155; border-radius:6px; padding:6px 12px; font-size:11px; text-decoration:none; font-weight:600;">Lihat Gambar</a>
                                @else
                                    <span style="font-size:11px; color:#94a3b8;">Tidak ada</span>
                                @endif
                            </td>

                            <td>
                                <a href="{{ route('admin.temuan.edit', $temuan->id) }}"
                                    class="btn btn-warning btn-sm">
                                        Edit
                                    </a>

                                <form action="{{ route('admin.temuan.destroy', $temuan->id) }}"
                                    method="POST"
                                    style="display:inline;"
                                    onsubmit="return confirm('Yakin ingin menghapus temuan ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-danger btn-sm">
                                        Delete
                                    </button>

                                </form>
                             </td>
                        </tr>

                    @empty

                        <tr>

                            <td colspan="7">

                                <div class="empty-state">

                                    <p>
                                        Belum ada temuan
                                    </p>

                                    <span>
                                        Klik <strong>＋ Catat Temuan</strong>
                                        untuk menambahkan temuan baru.
                                    </span>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- PAGINATION --}}
        @if($temuans->hasPages())

            <div style="
                padding:14px 20px;
                border-top:1px solid #f1f5f9;
            ">

                {{ $temuans->links() }}

            </div>

        @endif

    </div>

</div>

@endsection