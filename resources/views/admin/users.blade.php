@extends('layout.admin')

@section('title', 'Kelola Akun - Portal ITSA')

@push('styles')
<style>
    /* ===== HEADER ===== */
    .page-kicker {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .08em;
        text-transform: uppercase;
        color: #2563eb;
        margin-bottom: 6px;
    }
    .page-kicker::before {
        content: "";
        width: 14px;
        height: 2px;
        background: #2563eb;
        border-radius: 2px;
    }
    .page-header-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 16px;
        margin-bottom: 24px;
        flex-wrap: wrap;
    }
    .page-title {
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 4px 0;
    }
    .page-subtitle {
        font-size: 13px;
        color: #64748b;
        margin: 0;
    }

    /* ===== STATS GRID ===== */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }
    @media (max-width: 1024px) {
        .stats-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }
    @media (max-width: 640px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
    }
    .stat-card {
        background: #fff;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: 0 1px 3px rgba(0,0,0,.03);
    }
    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .stat-icon-blue   { background: #eff6ff; color: #2563eb; }
    .stat-icon-green  { background: #f0fdf4; color: #16a34a; }
    .stat-icon-amber  { background: #fffbeb; color: #d97706; }
    .stat-icon-purple { background: #faf5ff; color: #9333ea; }

    .stat-body {
        flex: 1;
        min-width: 0;
    }
    .stat-label {
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
        margin-bottom: 4px;
    }
    .stat-val {
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.1;
    }
    .stat-sub {
        font-size: 11px;
        color: #94a3b8;
        margin-top: 4px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* ===== MAIN CONTENT CARD ===== */
    .content-card {
        background: #fff;
        border-radius: 24px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 3px rgba(0,0,0,.04);
        padding: 24px;
    }

    /* ===== TOOLBAR ===== */
    .toolbar-row {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }
    .search-box {
        position: relative;
        flex: 1;
        min-width: 260px;
    }
    .search-box svg {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        width: 16px;
        height: 16px;
        color: #94a3b8;
        pointer-events: none;
    }
    .search-input {
        width: 100%;
        padding: 10px 14px 10px 38px;
        font-size: 13px;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        background: #f8fafc;
        outline: none;
        transition: .15s;
    }
    .search-input:focus {
        border-color: #2563eb;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(37,99,235,.08);
    }
    .filter-select {
        padding: 10px 16px;
        font-size: 13px;
        font-weight: 500;
        color: #334155;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        background: #fff;
        outline: none;
        cursor: pointer;
        min-width: 130px;
    }
    .filter-select:focus {
        border-color: #2563eb;
    }
    .count-badge {
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
        margin-left: auto;
    }

    /* ===== BUTTONS ===== */
    .btn-add {
        background: #1b365d;
        color: #fff;
        padding: 10px 18px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        box-shadow: 0 2px 6px rgba(27,54,93,.2);
        border: none;
        cursor: pointer;
        transition: .15s;
    }
    .btn-add:hover {
        background: #12243e;
        color: #fff;
    }

    /* ===== TABLE ===== */
    .user-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 13px;
    }
    .user-table th {
        background: #f8fafc;
        color: #64748b;
        font-weight: 700;
        font-size: 11.5px;
        text-transform: uppercase;
        letter-spacing: .04em;
        padding: 12px 16px;
        text-align: left;
        border-bottom: 1px solid #e2e8f0;
    }
    .user-table td {
        padding: 14px 16px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
        color: #1e293b;
    }
    .user-table tr:last-child td {
        border-bottom: none;
    }
    .user-table tbody tr:hover td {
        background: #f8fafc;
    }

    /* User Cell */
    .user-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .user-avatar {
        width: 38px;
        height: 38px;
        border-radius: 12px;
        background: #1b365d;
        color: #fff;
        font-weight: 800;
        font-size: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .user-name {
        font-weight: 700;
        color: #0f172a;
        margin: 0;
        line-height: 1.2;
    }
    .user-email {
        font-size: 12px;
        color: #64748b;
        margin: 2px 0 0;
    }

    /* Badges */
    .role-badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 600;
    }
    .role-superadmin { background: #fdf2f8; color: #be185d; border: 1px solid #fbcfe8; }
    .role-admin      { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
    .role-opd        { background: #f8fafc; color: #334155; border: 1px solid #e2e8f0; }

    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 600;
    }
    .status-pill-active { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
    .status-pill-active .dot { width: 6px; height: 6px; background: #22c55e; border-radius: 50%; }

    .status-pill-unverified { background: #fffbeb; color: #b45309; border: 1px solid #fde68a; }
    .status-pill-unverified .dot { width: 6px; height: 6px; background: #f59e0b; border-radius: 50%; }

    /* Action Buttons */
    .btn-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #e2e8f0;
        background: #fff;
        color: #64748b;
        cursor: pointer;
        transition: .15s;
    }
    .btn-icon:hover {
        background: #f1f5f9;
        color: #0f172a;
    }
    .btn-icon-danger:hover {
        background: #fee2e2;
        color: #dc2626;
        border-color: #fecdd3;
    }

    /* Modal / Form */
    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.45);
        backdrop-filter: blur(4px);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 16px;
    }
    .modal-card {
        background: #fff;
        width: 100%;
        max-width: 520px;
        border-radius: 24px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        border: 1px solid #e2e8f0;
        overflow: hidden;
        animation: popIn .2s ease;
    }
    @keyframes popIn {
        from { opacity: 0; transform: scale(.95); }
        to   { opacity: 1; transform: scale(1); }
    }
    .modal-header {
        padding: 20px 24px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .modal-header h3 {
        margin: 0;
        font-size: 17px;
        font-weight: 800;
        color: #0f172a;
    }
    .modal-body {
        padding: 24px;
        max-height: 80vh;
        overflow-y: auto;
    }
    .form-group {
        margin-bottom: 16px;
    }
    .form-group label {
        display: block;
        font-size: 12px;
        font-weight: 700;
        color: #334155;
        margin-bottom: 6px;
    }
    .form-group .req {
        color: #ef4444;
    }
    .form-input {
        width: 100%;
        padding: 10px 14px;
        font-size: 13px;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        outline: none;
        transition: .15s;
    }
    .form-input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37,99,235,.1);
    }
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }
    .modal-footer {
        padding: 16px 24px;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }
    .btn-secondary {
        background: #fff;
        border: 1px solid #cbd5e1;
        color: #475569;
        font-weight: 600;
        padding: 9px 16px;
        border-radius: 10px;
        cursor: pointer;
        font-size: 13px;
    }
    .btn-primary {
        background: #1b365d;
        border: none;
        color: #fff;
        font-weight: 700;
        padding: 9px 20px;
        border-radius: 10px;
        cursor: pointer;
        font-size: 13px;
    }
    .btn-primary:hover {
        background: #12243e;
    }
</style>
@endpush

@section('content')
<div style="padding: 4px 0 24px 0;">

    {{-- Alert Messages --}}
    @if(session('success'))
        <div style="background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 12px 18px; border-radius: 12px; margin-bottom: 20px; font-size: 13px; font-weight: 600; display: flex; align-items: center; gap: 8px;">
            <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background: #fef2f2; border: 1px solid #fecdd3; color: #991b1b; padding: 12px 18px; border-radius: 12px; margin-bottom: 20px; font-size: 13px; font-weight: 600; display: flex; align-items: center; gap: 8px;">
            <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div style="background: #fef2f2; border: 1px solid #fecdd3; color: #991b1b; padding: 14px 18px; border-radius: 12px; margin-bottom: 20px; font-size: 13px;">
            <p style="font-weight: 700; margin: 0 0 6px 0;">Terdapat kesalahan pada input:</p>
            <ul style="margin: 0; padding-left: 18px;">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Page Header --}}
    <div class="page-header-row">
        <div>
            <div class="page-kicker">Management Portal</div>
            <h1 class="page-title">Kelola Akun</h1>
            <p class="page-subtitle">Kelola akses pengguna OPD dan administrator pada Portal ITSA</p>
        </div>
        <div>
            <button type="button" class="btn-add" onclick="openCreateModal()">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Akun
            </button>
        </div>
    </div>

    {{-- Stat Cards --}}
    <div class="stats-grid">
        {{-- Card 1: Total Akun --}}
        <div class="stat-card">
            <div class="stat-icon stat-icon-blue">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <div class="stat-body">
                <div class="stat-label">Total Akun</div>
                <div class="stat-val">{{ $totalUsers }}</div>
                <div class="stat-sub">Semua pengguna terdaftar</div>
            </div>
        </div>

        {{-- Card 2: Akun Aktif --}}
        <div class="stat-card">
            <div class="stat-icon stat-icon-green">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="stat-body">
                <div class="stat-label">Akun Aktif</div>
                <div class="stat-val">{{ $activeUsers }}</div>
                <div class="stat-sub">{{ $totalUsers > 0 ? round(($activeUsers / $totalUsers) * 100) : 0 }}% dari total akun</div>
            </div>
        </div>

        {{-- Card 3: Perlu Verifikasi --}}
        <div class="stat-card">
            <div class="stat-icon stat-icon-amber">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div class="stat-body">
                <div class="stat-label">Perlu Verifikasi</div>
                <div class="stat-val">{{ $unverifiedUsers }}</div>
                <div class="stat-sub">Menunggu persetujuan...</div>
            </div>
        </div>

        {{-- Card 4: Administrator --}}
        <div class="stat-card">
            <div class="stat-icon stat-icon-purple">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
            </div>
            <div class="stat-body">
                <div class="stat-label">Administrator</div>
                <div class="stat-val">{{ $adminCount }}</div>
                <div class="stat-sub">Memiliki akses tim ITSA</div>
            </div>
        </div>
    </div>

    {{-- Main Table Card --}}
    <div class="content-card">
        <form method="GET" action="{{ route('admin.users.index') }}" class="toolbar-row" id="filterForm">
            {{-- Search --}}
            <div class="search-box">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari nama, email, atau instansi/OPD..."
                       class="search-input" onkeydown="if(event.key === 'Enter') this.form.submit()">
            </div>

            {{-- Filter Role --}}
            <select name="role_id" class="filter-select" onchange="this.form.submit()">
                <option value="">Semua Peran</option>
                @foreach($roles as $r)
                    <option value="{{ $r->id }}" {{ request('role_id') == $r->id ? 'selected' : '' }}>
                        {{ ucfirst($r->name) }}
                    </option>
                @endforeach
            </select>

            {{-- Filter Status --}}
            <select name="status" class="filter-select" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="unverified" {{ request('status') == 'unverified' ? 'selected' : '' }}>Perlu Verifikasi</option>
            </select>

            <span class="count-badge">{{ $users->total() }} akun ditemukan</span>
        </form>

        {{-- Table --}}
        <div style="overflow-x: auto;">
            <table class="user-table">
                <thead>
                    <tr>
                        <th>Pengguna</th>
                        <th>Instansi / OPD</th>
                        <th>Peran</th>
                        <th>Status</th>
                        <th>Aktivitas Terakhir</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>
                                <div class="user-cell">
                                    <div class="user-avatar">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="user-name">{{ $user->name }}</p>
                                        <p class="user-email">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span style="font-weight: 600; color: #334155;">{{ $user->opd ?: '-' }}</span>
                            </td>
                            <td>
                                @php
                                    $roleName = strtolower($user->role->name ?? '');
                                    $roleClass = match(true) {
                                        str_contains($roleName, 'superadmin') => 'role-superadmin',
                                        str_contains($roleName, 'admin') => 'role-admin',
                                        default => 'role-opd',
                                    };
                                @endphp
                                <span class="role-badge {{ $roleClass }}">
                                    {{ ucfirst($user->role->name ?? 'User') }}
                                </span>
                            </td>
                            <td>
                                @if($user->email_verified_at)
                                    <span class="status-pill status-pill-active">
                                        <span class="dot"></span>
                                        Aktif
                                    </span>
                                @else
                                    <span class="status-pill status-pill-unverified">
                                        <span class="dot"></span>
                                        Perlu Verifikasi
                                    </span>
                                @endif
                            </td>
                            <td style="color: #64748b; font-size: 12px;">
                                {{ $user->updated_at ? $user->updated_at->diffForHumans() : '-' }}
                            </td>
                            <td style="text-align: right;">
                                <div style="display: inline-flex; gap: 6px;">
                                    <button type="button" class="btn-icon" title="Edit Akun"
                                            onclick='openEditModal(@json($user))'>
                                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                        </svg>
                                    </button>

                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun {{ $user->name }}?')"
                                              style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-icon btn-icon-danger" title="Hapus Akun">
                                                <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 40px 16px; color: #94a3b8;">
                                <p style="font-weight: 600; margin: 0 0 4px 0;">Tidak ada akun ditemukan</p>
                                <span style="font-size: 12px;">Coba ubah kata kunci pencarian atau filter status</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div style="margin-top: 20px;">
            {{ $users->links() }}
        </div>
    </div>
</div>

{{-- Modal Create Akun --}}
<div id="createModal" class="modal-overlay" style="display: none;">
    <div class="modal-card">
        <div class="modal-header">
            <h3>Tambah Akun Pengguna</h3>
            <button type="button" class="btn-icon" onclick="closeCreateModal()">✕</button>
        </div>
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Lengkap <span class="req">*</span></label>
                    <input type="text" name="name" class="form-input" required placeholder="Contoh: Siti Rahayu, S.Kom">
                </div>

                <div class="form-group">
                    <label>Email <span class="req">*</span></label>
                    <input type="email" name="email" class="form-input" required placeholder="nama@jatimprov.go.id">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Peran / Role <span class="req">*</span></label>
                        <select name="role_id" class="form-input" required>
                            @foreach($roles as $r)
                                <option value="{{ $r->id }}">{{ ucfirst($r->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Instansi / OPD</label>
                        <input type="text" name="opd" class="form-input" placeholder="Dinas Kesehatan, dsb.">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Password <span class="req">*</span></label>
                        <input type="password" name="password" class="form-input" required minlength="8" placeholder="Minimal 8 karakter">
                    </div>
                    <div class="form-group">
                        <label>Konfirmasi Password <span class="req">*</span></label>
                        <input type="password" name="password_confirmation" class="form-input" required minlength="8" placeholder="Ulangi password">
                    </div>
                </div>

                <div class="form-group" style="margin-top: 10px;">
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                        <input type="checkbox" name="is_verified" value="1" checked style="width: 16px; height: 16px;">
                        <span>Verifikasi Akun Sekarang (Status Aktif)</span>
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeCreateModal()">Batal</button>
                <button type="submit" class="btn-primary">Simpan Akun</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Edit Akun --}}
<div id="editModal" class="modal-overlay" style="display: none;">
    <div class="modal-card">
        <div class="modal-header">
            <h3>Edit Akun Pengguna</h3>
            <button type="button" class="btn-icon" onclick="closeEditModal()">✕</button>
        </div>
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Lengkap <span class="req">*</span></label>
                    <input type="text" id="edit_name" name="name" class="form-input" required>
                </div>

                <div class="form-group">
                    <label>Email <span class="req">*</span></label>
                    <input type="email" id="edit_email" name="email" class="form-input" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Peran / Role <span class="req">*</span></label>
                        <select id="edit_role_id" name="role_id" class="form-input" required>
                            @foreach($roles as $r)
                                <option value="{{ $r->id }}">{{ ucfirst($r->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Instansi / OPD</label>
                        <input type="text" id="edit_opd" name="opd" class="form-input">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Ganti Password <small style="color: #64748b; font-weight: normal;">(Kosongkan jika tidak diganti)</small></label>
                        <input type="password" name="password" class="form-input" minlength="8" placeholder="Password baru">
                    </div>
                    <div class="form-group">
                        <label>Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" class="form-input" minlength="8" placeholder="Ulangi password baru">
                    </div>
                </div>

                <div class="form-group" style="margin-top: 10px;">
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                        <input type="checkbox" id="edit_is_verified" name="is_verified" value="1" style="width: 16px; height: 16px;">
                        <span>Akun Terverifikasi (Status Aktif)</span>
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeEditModal()">Batal</button>
                <button type="submit" class="btn-primary">Perbarui Akun</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openCreateModal() {
        document.getElementById('createModal').style.display = 'flex';
    }
    function closeCreateModal() {
        document.getElementById('createModal').style.display = 'none';
    }

    function openEditModal(user) {
        document.getElementById('editForm').action = '/admin/users/' + user.id;
        document.getElementById('edit_name').value = user.name || '';
        document.getElementById('edit_email').value = user.email || '';
        document.getElementById('edit_role_id').value = user.role_id || '';
        document.getElementById('edit_opd').value = user.opd || '';
        document.getElementById('edit_is_verified').checked = !!user.email_verified_at;
        document.getElementById('editModal').style.display = 'flex';
    }
    function closeEditModal() {
        document.getElementById('editModal').style.display = 'none';
    }

    // Tutup modal jika user klik background
    window.onclick = function(event) {
        let cModal = document.getElementById('createModal');
        let eModal = document.getElementById('editModal');
        if (event.target === cModal) closeCreateModal();
        if (event.target === eModal) closeEditModal();
    }
</script>
@endsection

