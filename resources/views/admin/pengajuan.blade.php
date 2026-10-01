@extends('layout.admin')

@section('title', 'Pengajuan ITSA - Portal ITSA')

@push('styles')
<style>
    /* ===== STATUS BADGES ===== */
    .badge-selesai     { background:#ecfdf5; color:#059669; border:1px solid #a7f3d0; }
    .badge-proses      { background:#fffbeb; color:#d97706; border:1px solid #fde68a; }
    .badge-validasi    { background:#eff6ff; color:#2563eb; border:1px solid #bfdbfe; }
    .badge-perbaikan   { background:#fff1f2; color:#e11d48; border:1px solid #fecdd3; }
    .badge-dijadwalkan { background:#f5f3ff; color:#7c3aed; border:1px solid #ddd6fe; }
    .badge-default     { background:#f8fafc; color:#475569; border:1px solid #e2e8f0; }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 600;
        white-space: nowrap;
    }
    .status-dot {
        width: 6px; height: 6px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    /* ===== FORM SECTION ===== */
    .form-section {
        background: #fff;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 4px rgba(0,0,0,.04);
        padding: 28px 32px 32px;
        margin-bottom: 24px;
        animation: slideDown .25s ease;
    }
    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-12px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px 24px;
    }
    @media (max-width: 700px) {
        .form-grid { grid-template-columns: 1fr; }
    }

    .form-group { display: flex; flex-direction: column; gap: 6px; }
    .form-group.full { grid-column: 1 / -1; }

    .form-label {
        font-size: 12.5px;
        font-weight: 700;
        color: #1e293b;
    }
    .form-label .req { color: #e11d48; margin-left: 2px; }

    .form-control {
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        padding: 10px 14px;
        font-size: 13px;
        color: #1e293b;
        background: #f8fafc;
        transition: border-color .15s, box-shadow .15s;
        font-family: 'Plus Jakarta Sans', sans-serif;
        outline: none;
    }
    .form-control:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99,102,241,.12);
        background: #fff;
    }
    .form-control::placeholder { color: #94a3b8; }
    textarea.form-control { resize: vertical; min-height: 90px; }

    /* ===== BUTTONS ===== */
    .btn-primary {
        background: #16305a;
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 11px 24px;
        font-size: 13.5px;
        font-weight: 700;
        cursor: pointer;
        transition: background .15s, transform .1s;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    .btn-primary:hover  { background: #1e3a6e; }
    .btn-primary:active { transform: scale(.97); }

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
        transition: background .15s;
        font-family: 'Plus Jakarta Sans', sans-serif;
        display: inline-block;
    }
    .btn-secondary:hover { background: #f1f5f9; color: #334155; }

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
        transition: background .15s, transform .1s;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    .btn-add:hover { background: #1e3a6e; color:#fff; }
    .btn-add:active { transform: scale(.97); }

    /* ===== TABLE ===== */
    .table-wrap { overflow-x: auto; }

    .pengajuan-table {
        width: 100%; border-collapse: collapse; font-size: 12.5px;
    }
    .pengajuan-table thead tr {
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        color: #1b365d;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .05em;
    }
    .pengajuan-table thead th { padding: 13px 16px; white-space: nowrap; }
    .pengajuan-table tbody tr {
        border-bottom: 1px solid #f1f5f9;
        transition: background .12s;
    }
    .pengajuan-table tbody tr:last-child { border-bottom: none; }
    .pengajuan-table tbody tr:hover { background: #f8fafc; }
    .pengajuan-table td { padding: 13px 16px; color: #334155; vertical-align: middle; }

    .nomor-cell  { font-weight: 700; color: #1b365d; font-size: 11.5px; }
    .opd-name    { font-weight: 700; color: #1e293b; font-size: 12.5px; }
    .date-cell   { font-size: 12px; color: #475569; font-weight: 500; }
    .app-name    { font-weight: 600; color: #334155; }

    .detail-btn {
        background: none;
        border: none;
        color: #6366f1;
        font-weight: 700;
        font-size: 12.5px;
        cursor: pointer;
        padding: 0;
        font-family: 'Plus Jakarta Sans', sans-serif;
        transition: color .12s;
    }
    .detail-btn:hover { color: #4338ca; text-decoration: underline; }

    /* ===== SEARCH BAR ===== */
    .search-wrap { position: relative; width: 240px; }
    @media (max-width: 600px) { .search-wrap { width: 100%; } }
    .search-input {
        width: 100%;
        padding: 9px 14px 9px 36px;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        font-size: 12.5px;
        background: #f8fafc;
        color: #1e293b;
        font-family: 'Plus Jakarta Sans', sans-serif;
        outline: none;
        transition: border-color .15s;
    }
    .search-input:focus { border-color: #6366f1; background: #fff; }
    .search-input::placeholder { color: #94a3b8; }
    .search-icon {
        position: absolute; left: 11px; top: 50%;
        transform: translateY(-50%);
        color: #94a3b8; pointer-events: none;
    }

    /* ===== ALERTS ===== */
    .alert-success {
        background: #ecfdf5;
        border: 1px solid #a7f3d0;
        color: #065f46;
        border-radius: 12px;
        padding: 12px 18px;
        font-size: 13px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 20px;
    }
    .alert-error {
        background: #fff1f2;
        border: 1px solid #fecdd3;
        color: #9f1239;
        border-radius: 12px;
        padding: 12px 18px;
        font-size: 13px;
        font-weight: 600;
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 18px;
    }

    /* ===== PAGINATION ===== */
    .pagination-wrap {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 20px 16px;
        font-size: 12px;
        color: #64748b;
        flex-wrap: wrap;
        gap: 10px;
        border-top: 1px solid #f1f5f9;
    }
    .pagination-links { display: flex; gap: 4px; }
    .pagination-links a,
    .pagination-links span {
        padding: 5px 11px;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        color: #475569;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        transition: background .12s;
    }
    .pagination-links a:hover { background: #f1f5f9; }
    .pagination-links span.active-pg { background: #16305a; color: #fff; border-color: #16305a; }
    .pagination-links span.disabled-pg { color: #cbd5e1; cursor: default; }

    /* ===== EMPTY STATE ===== */
    .empty-state {
        text-align: center;
        padding: 48px 20px;
    }
    .empty-state p { font-size: 13.5px; color: #64748b; font-weight: 600; margin: 12px 0 4px; }
    .empty-state span { font-size: 12px; color: #94a3b8; }

    /* ===== INFO ROW ===== */
    .info-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #f0f9ff;
        border: 1px solid #bae6fd;
        color: #0369a1;
        border-radius: 8px;
        padding: 6px 14px;
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 20px;
    }
</style>
@endpush

@section('content')
<div style="max-width: 1100px; margin: 0 auto;">

    {{-- ===== HEADER ===== --}}
    <div style="display:flex; align-items:flex-start; justify-content:space-between; gap:16px; margin-bottom:24px; flex-wrap:wrap;">
        <div>
            <h1 style="font-size:22px; font-weight:800; color:#1b365d; margin:0 0 4px;">Pengajuan ITSA</h1>
            <p style="font-size:13px; color:#64748b; margin:0;">Daftar semua pengajuan pengujian keamanan aplikasi</p>
        </div>

        {{-- Tombol toggle form --}}
        <a href="{{ $showForm ? route('admin.pengajuan.index') : route('admin.pengajuan.index', ['form' => 1]) }}"
           class="btn-add" id="btnTambah">
            @if($showForm)
                <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                Tutup Form
            @else
                <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 4v16m8-8H4"/>
                </svg>
                 Tambah Pengajuan
            @endif
        </a>
    </div>

    {{-- ===== ALERT SUCCESS ===== --}}
    @if(session('success'))
    <div class="alert-success">
        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- ===== FORM TAMBAH PENGAJUAN ===== --}}
    @if($showForm || $errors->any())
    <div class="form-section" id="formSection">

        <div style="display:flex; align-items:center; gap:10px; margin-bottom:22px;">
            <div style="width:36px;height:36px;background:#eef2ff;border-radius:10px;display:flex;align-items:center;justify-content:center;">
                <svg width="18" height="18" fill="none" stroke="#6366f1" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div>
                <h2 style="font-size:15px; font-weight:800; color:#1b365d; margin:0;">Form Pengajuan ITSA Baru</h2>
                <p style="font-size:11.5px; color:#94a3b8; margin:0;">Isi data aplikasi yang akan diajukan untuk pengujian keamanan</p>
            </div>
        </div>

        {{-- Validation errors --}}
        @if($errors->any())
        <div class="alert-error">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                @foreach($errors->all() as $err)
                    <div>• {{ $err }}</div>
                @endforeach
            </div>
        </div>
        @endif

        <form action="{{ route('admin.pengajuan.store') }}" method="POST" id="formPengajuan">
            @csrf

            <div class="form-grid">

                {{-- Nama OPD (informasi readonly dari user login) --}}
                <select
                    name="user_id"
                    id="user_id"
                    class="form-control"
                    required
                >
                    <option value="">-- Pilih OPD --</option>

                    @foreach ($users as $user)
                        <option value="{{ $user->id }}"
                            {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->biro }}
                        </option>
                    @endforeach
                </select>

                {{-- Nama Aplikasi --}}
                <div class="form-group">
                    <label class="form-label" for="nama_aplikasi">
                        Nama Aplikasi <span class="req">*</span>
                    </label>
                    <input type="text"
                           id="nama_aplikasi"
                           name="nama_aplikasi"
                           class="form-control"
                           placeholder="Nama sistem/aplikasi yang diuji"
                           value="{{ old('nama_aplikasi') }}"
                           required>
                </div>

                {{-- Tujuan Assessment --}}
                <div class="form-group full">
                    <label class="form-label" for="tujuan_assessment">
                        Tujuan Assessment <span class="req">*</span>
                    </label>
                    <textarea id="tujuan_assessment"
                              name="tujuan_assessment"
                              class="form-control"
                              style="min-height:90px;"
                              placeholder="Contoh: Penetration Testing aplikasi sebelum go-live, Assessment keamanan rutin tahunan, Persiapan audit BPK..."
                              required>{{ old('tujuan_assessment') }}</textarea>
                </div>

                {{-- Tanggal Assessment (opsional, bisa diisi admin nanti) --}}
                <div class="form-group">
                    <label class="form-label" for="tanggal_assessment">Tanggal Assessment (opsional)</label>
                    <input type="date"
                           id="tanggal_assessment"
                           name="tanggal_assessment"
                           class="form-control"
                           value="{{ old('tanggal_assessment') }}">
                    <span style="font-size:11px; color:#94a3b8;">Bisa diisi oleh admin ITSA setelah verifikasi</span>
                </div>

                {{-- Catatan --}}
                <div class="form-group">
                    <label class="form-label" for="catatan">Catatan Teknis</label>
                    <textarea id="catatan"
                              name="catatan"
                              class="form-control"
                              placeholder="Keterangan tambahan, informasi teknis, atau permintaan khusus...">{{ old('catatan') }}</textarea>
                </div>

            </div>

            {{-- Info nomor ajuan otomatis --}}
            <div class="info-pill" style="margin-top:18px; margin-bottom:0;">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Nomor ajuan akan dibuat otomatis (format: ITSA-{{ date('Y') }}-XXX)
            </div>

            <div class="form-group">
                <label class="form-label">
                    Status <span class="req">*</span>
                </label>

                <select name="status" class="form-control" required>

                    <option value="Pengajuan"
                        {{ old('status', 'Pengajuan') == 'Pengajuan' ? 'selected' : '' }}>
                        Pengajuan
                    </option>

                    <option value="Proses Pengujian"
                        {{ old('status') == 'Proses Pengujian' ? 'selected' : '' }}>
                        Proses Pengujian
                    </option>

                    <option value="Selesai"
                        {{ old('status') == 'Selesai' ? 'selected' : '' }}>
                        Selesai
                    </option>

                </select>

                @error('status')
                    <small style="color:#e11d48;">
                        {{ $message }}
                    </small>
                @enderror
            </div>

            {{-- Actions --}}
            <div style="display:flex; align-items:center; gap:12px; margin-top:20px;">
                <button type="submit" class="btn-primary" id="btnSimpan">
                    Simpan Pengajuan
                </button>
                <a href="{{ route('admin.pengajuan.index') }}" class="btn-secondary">Batal</a>
            </div>

        </form>
    </div>
    @endif

    {{-- ===== TABEL DAFTAR PENGAJUAN ===== --}}
    <div style="background:#fff; border-radius:20px; border:1px solid #e2e8f0; box-shadow:0 1px 4px rgba(0,0,0,.04); overflow:hidden;">

        {{-- Table Header & Search --}}
        <div style="display:flex; align-items:center; justify-content:space-between; gap:16px; padding:20px 24px 16px; flex-wrap:wrap; border-bottom:1px solid #f1f5f9;">
            <div>
                <p style="font-size:14px; font-weight:800; color:#1b365d; margin:0 0 2px;">Daftar Pengajuan</p>
                <p style="font-size:12px; color:#94a3b8; margin:0;">Total <strong>{{ $totalAjuan }}</strong> pengajuan masuk</p>
            </div>
            <form method="GET" action="{{ route('admin.pengajuan.index') }}" class="search-wrap">
                <svg class="search-icon" width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text"
                       name="search"
                       class="search-input"
                       placeholder="Cari pengajuan..."
                       value="{{ request('search') }}">
            </form>
        </div>

        {{-- Table --}}
        <div class="table-wrap">
            <table class="pengajuan-table">
                <thead>
                    <tr>
                        <th>ID / Nomor</th>
                        <th>OPD</th>
                        <th>Aplikasi</th>
                        <th>Tanggal Ajuan</th>
                        <th>Tujuan Assessment</th>
                        <th>Status</th>
                        <th style="text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ajuans as $ajuan)
                    <tr>
                        {{-- Nomor Ajuan --}}
                        <td>
                            <span class="nomor-cell">{{ $ajuan->nomor_ajuan }}</span>
                        </td>

                        {{-- OPD --}}
                        <td>
                            <div class="opd-name">
                                {{ $ajuan->user->biro ?? ($ajuan->user->name ?? '-') }}
                            </div>
                        </td>

                        {{-- Aplikasi --}}
                        <td>
                            <span class="app-name">{{ $ajuan->nama_aplikasi }}</span>
                        </td>

                        {{-- Tanggal Pengajuan --}}
                        <td>
                            <span class="date-cell">
                                {{ $ajuan->tanggal_pengajuan
                                    ? \Carbon\Carbon::parse($ajuan->tanggal_pengajuan)->format('d M Y')
                                    : '-' }}
                            </span>
                        </td>

                        {{-- Tujuan Assessment (truncated) --}}
                        <td style="max-width:220px;">
                            <span style="font-size:12px; color:#475569; display:block; overflow:hidden; white-space:nowrap; text-overflow:ellipsis; max-width:220px;"
                                  title="{{ $ajuan->tujuan_assessment }}">
                                {{ $ajuan->tujuan_assessment }}
                            </span>
                        </td>

                        {{-- Status --}}
                        <td>
                            @php
                                $s = strtolower($ajuan->status ?? '');
                                if (str_contains($s, 'selesai')) {
                                    $cls = 'badge-selesai'; $dot = '#059669';
                                } elseif (str_contains($s, 'proses') || str_contains($s, 'ujipetik') || str_contains($s, 'diproses')) {
                                    $cls = 'badge-proses'; $dot = '#d97706';
                                } elseif (str_contains($s, 'validasi') || str_contains($s, 'menunggu')) {
                                    $cls = 'badge-validasi'; $dot = '#2563eb';
                                } elseif (str_contains($s, 'perbaikan') || str_contains($s, 'perlu')) {
                                    $cls = 'badge-perbaikan'; $dot = '#e11d48';
                                } elseif (str_contains($s, 'jadwal')) {
                                    $cls = 'badge-dijadwalkan'; $dot = '#7c3aed';
                                } else {
                                    $cls = 'badge-default'; $dot = '#64748b';
                                }
                            @endphp
                            <span class="status-badge {{ $cls }}">
                                <span class="status-dot" style="background:{{ $dot }};"></span>
                                {{ $ajuan->status }}
                            </span>
                        </td>
                        <td style="text-align:center;">
                            <div style="display:flex; justify-content:center; align-items:center; gap:8px;">

                                <a
                                    href="{{ route('admin.pengajuan.edit', $ajuan) }}"
                                    class="btn-edit"
                                >
                                    Edit
                                </a>

                                {{-- Delete --}}
                                <form action="{{ route('admin.pengajuan.destroy', $ajuan->id) }}"
                                    method="POST"
                                    style="display:inline;"
                                    onsubmit="return confirm('Yakin ingin menghapus pengajuan {{ $ajuan->nomor_ajuan }}?');">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            style="
                                                background:none;
                                                border:none;
                                                color:#dc2626;
                                                font-weight:700;
                                                font-size:12.5px;
                                                cursor:pointer;
                                                padding:0;
                                                font-family:'Plus Jakarta Sans', sans-serif;
                                            ">
                                        Hapus
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <svg width="44" height="44" fill="none" stroke="#cbd5e1" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.3"
                                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <p>Belum ada pengajuan</p>
                                <span>Klik <strong>+ Tambah Pengajuan</strong> untuk menambah data baru.</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($ajuans->hasPages())
        <div class="pagination-wrap">
            <span>
                Menampilkan {{ $ajuans->firstItem() }}–{{ $ajuans->lastItem() }}
                dari {{ $ajuans->total() }} data
            </span>
            <div class="pagination-links">
                @if($ajuans->onFirstPage())
                    <span class="disabled-pg">&lsaquo;</span>
                @else
                    <a href="{{ $ajuans->previousPageUrl() }}">&lsaquo;</a>
                @endif

                @foreach($ajuans->getUrlRange(1, $ajuans->lastPage()) as $page => $url)
                    @if($page == $ajuans->currentPage())
                        <span class="active-pg">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach

                @if($ajuans->hasMorePages())
                    <a href="{{ $ajuans->nextPageUrl() }}">&rsaquo;</a>
                @else
                    <span class="disabled-pg">&rsaquo;</span>
                @endif
            </div>
        </div>
        @endif

    </div>

</div>
@endsection

@push('scripts')
<script>
    // Scroll ke form jika ada error validasi
    @if($errors->any())
        document.getElementById('formSection')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
    @endif

    // Loading state saat submit
    const form     = document.getElementById('formPengajuan');
    const btnSimpan = document.getElementById('btnSimpan');
    if (form && btnSimpan) {
        form.addEventListener('submit', function () {
            btnSimpan.textContent = 'Menyimpan...';
            btnSimpan.disabled = true;
        });
    }

    // Auto-submit search saat enter (sudah native), optionally auto on typing delay
    const searchInput = document.querySelector('.search-input');
    if (searchInput) {
        let timer;
        searchInput.addEventListener('input', function () {
            clearTimeout(timer);
            timer = setTimeout(() => this.closest('form').submit(), 600);
        });
    }
</script>
@endpush
