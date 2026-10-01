@extends('layout.admin')

@section('content')

<style>

    .document-page {
        background: #f4f7fb;
        min-height: 100vh;
        padding: 30px;
    }

    .page-title {
        font-size: 32px;
        font-weight: 700;
        color: #1f3048;
        margin-bottom: 5px;
    }

    .page-subtitle {
        color: #71829d;
        font-size: 17px;
        margin-bottom: 25px;
    }

    /* =========================
       STAT CARD
    ========================= */

    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 25px;
        border: 1px solid #e1e8f1;
        height: 100%;
        display: flex;
        align-items: center;
        gap: 18px;
        box-shadow: 0 3px 12px rgba(0,0,0,0.03);
    }

    .stat-icon {
        width: 66px;
        height: 66px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 30px;
    }

    .icon-blue {
        background: #edf5ff;
    }

    .icon-purple {
        background: #f5edff;
    }

    .icon-green {
        background: #ecfbf2;
    }

    .icon-pink {
        background: #f8efff;
    }

    .stat-title {
        color: #71829d;
        font-size: 16px;
        margin-bottom: 4px;
    }

    .stat-number {
        color: #1f3048;
        font-size: 30px;
        font-weight: 700;
    }


    /* =========================
       UPLOAD AREA
    ========================= */

    .upload-box {
        margin-top: 35px;
        background: white;
        border: 2px dashed #c9d7e8;
        border-radius: 18px;
        min-height: 300px;

        display: flex;
        align-items: center;
        justify-content: center;

        text-align: center;

        transition: .2s;
    }

    .upload-box.dragover {
        background: #eef6ff;
        border-color: #23456f;
    }

    .upload-icon {
        width: 72px;
        height: 72px;
        background: #f0f5fa;
        border-radius: 50%;

        display: flex;
        align-items: center;
        justify-content: center;

        margin: auto;
        font-size: 34px;
    }

    .upload-title {
        font-size: 18px;
        font-weight: 600;
        color: #293b55;
        margin-top: 15px;
    }

    .upload-or {
        color: #91a1b8;
        margin: 8px 0;
    }

    .btn-pilih {
        background: #213f67;
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 10px;
        font-weight: 600;
    }

    .btn-pilih:hover {
        background: #172f50;
        color: white;
    }

    .upload-info {
        color: #91a1b8;
        margin-top: 15px;
    }


    /* =========================
       FILTER
    ========================= */

    .filter-area {
        margin-top: 25px;
    }

    .search-box {
        border-radius: 10px;
        border: 1px solid #dce4ee;
        padding: 12px 15px;
    }

    .filter-btn {
        background: white;
        border: 1px solid #dce4ee;
        border-radius: 10px;
        padding: 10px 18px;
        color: #50627b;
    }

    .filter-btn.active {
        background: #213f67;
        color: white;
        border-color: #213f67;
    }


    /* =========================
       TABLE
    ========================= */

    .document-table {
        margin-top: 20px;
        background: white;
        border-radius: 15px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
    }

    .document-table table {
        margin: 0;
    }

    .document-table thead {
        background: #f8fafc;
    }

    .document-table th {
        color: #64748b;
        font-size: 14px;
        font-weight: 600;
        padding: 18px;
        border-bottom: 1px solid #e5eaf1;
    }

    .document-table td {
        padding: 18px;
        vertical-align: middle;
        color: #50627b;
    }

    .file-name {
        font-weight: 600;
        color: #2b3d56;
    }

    .file-type {
        display: inline-block;
        padding: 5px 9px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        margin-right: 8px;
    }

    .type-pdf {
        background: #ffe1e1;
        color: #e11d48;
    }

    .type-doc {
        background: #e1edff;
        color: #2563eb;
    }

    .type-xls {
        background: #dcfce7;
        color: #16a34a;
    }

    .type-zip {
        background: #fef3c7;
        color: #d97706;
    }

    .badge-document {
        padding: 7px 12px;
        border-radius: 20px;
        font-size: 12px;
    }

    .badge-surat {
        background: #dbeafe;
        color: #2563eb;
    }

    .badge-laporan {
        background: #dcfce7;
        color: #16a34a;
    }

    .badge-rekomendasi {
        background: #f3e8ff;
        color: #9333ea;
    }

    .badge-bukti {
        background: #ffedd5;
        color: #ea580c;
    }

</style>


<div class="document-page">

    {{-- ========================================
         HEADER
    ========================================= --}}

    <div>

        <h1 class="page-title">
            Upload Dokumen
        </h1>

        <p class="page-subtitle">
            Kelola dokumen terkait pengujian ITSA —
            surat permohonan, laporan, dan bukti pengujian
        </p>

    </div>


    {{-- ========================================
         ALERT
    ========================================= --}}

    @if(session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif


    @if($errors->any())

        <div class="alert alert-danger">

            <ul class="mb-0">

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- ========================================
         STATISTICS
    ========================================= --}}

    <div class="row g-4">

        <div class="col-md-3">

            <div class="stat-card">

                <div class="stat-icon icon-blue">
                    📁
                </div>

                <div>

                    <div class="stat-title">
                        Total Dokumen
                    </div>

                    <div class="stat-number">
                        {{ $totalDokumen }}
                    </div>

                </div>

            </div>

        </div>


        <div class="col-md-3">

            <div class="stat-card">

                <div class="stat-icon icon-purple">
                    📄
                </div>

                <div>

                    <div class="stat-title">
                        Surat Permohonan
                    </div>

                    <div class="stat-number">
                        {{ $totalSurat }}
                    </div>

                </div>

            </div>

        </div>


        <div class="col-md-3">

            <div class="stat-card">

                <div class="stat-icon icon-green">
                    📋
                </div>

                <div>

                    <div class="stat-title">
                        Laporan & Rekomendasi
                    </div>

                    <div class="stat-number">
                        {{ $totalLaporan }}
                    </div>

                </div>

            </div>

        </div>


        <div class="col-md-3">

            <div class="stat-card">

                <div class="stat-icon icon-pink">
                    💾
                </div>

                <div>

                    <div class="stat-title">
                        Total Ukuran
                    </div>

                    <div class="stat-number">

                        @if($totalUkuran >= 1048576)

                            {{ number_format($totalUkuran / 1048576, 1) }} MB

                        @else

                            {{ number_format($totalUkuran / 1024, 0) }} KB

                        @endif

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- ========================================
         UPLOAD FORM
    ========================================= --}}

    <div style="background: white; border-radius: 16px; padding: 25px; border: 1px solid #e1e8f1; box-shadow: 0 3px 12px rgba(0,0,0,0.03); margin-top: 35px;">
        <form
            action="{{ route('dokumen.store') }}"
            method="POST"
            enctype="multipart/form-data"
            id="uploadForm"
        >

            @csrf

            <div class="row mb-4 g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold" style="color: #50627b;">
                        Pengajuan
                    </label>
                    <select
                        name="ajuan_id"
                        class="form-select search-box"
                        required
                    >
                        <option value="">-- Pilih Pengajuan --</option>
                        @foreach($ajuans as $ajuan)
                            <option value="{{ $ajuan->id }}">Pengajuan #{{ $ajuan->id }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold" style="color: #50627b;">
                        Jenis Dokumen
                    </label>
                    <select
                        name="jenis_dokumen"
                        class="form-select search-box"
                        required
                    >
                        <option value="">-- Pilih Jenis Dokumen --</option>
                        <option value="surat">Surat Permohonan</option>
                        <option value="laporan">Laporan ITSA</option>
                        <option value="surat_rekomendasi">Surat Rekomendasi</option>
                        <option value="bukti_pengujian">Bukti Pengujian</option>
                        <option value="bukti_perbaikan">Bukti Perbaikan</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold" style="color: #50627b;">
                        Temuan <span class="text-muted fw-normal">(Opsional)</span>
                    </label>
                    <select
                        name="temuan_id"
                        class="form-select search-box"
                    >
                        <option value="">-- Tidak terkait temuan --</option>
                    </select>
                </div>
            </div>

            <div class="upload-box" id="dropArea" style="margin-top: 0; min-height: 250px;">
                <div>
                    <div class="upload-icon">
                        ↑
                    </div>
                    <div class="upload-title">
                        Seret & lepas file ke sini
                    </div>
                    <div class="upload-or">
                        atau
                    </div>
                    <label
                        for="fileInput"
                        class="btn btn-pilih"
                    >
                        Pilih File
                    </label>
                    <input
                        type="file"
                        name="file"
                        id="fileInput"
                        hidden
                        required
                    >
                    <div
                        class="upload-info"
                        id="fileName"
                    >
                        PDF, DOC, XLS, ZIP, PNG — Maks. 20 MB
                    </div>
                </div>
            </div>

            <div class="mt-4 text-end">
                <button
                    type="submit"
                    class="btn btn-pilih"
                >
                    Upload Dokumen
                </button>
            </div>

        </form>
    </div>


    {{-- ========================================
         SEARCH + FILTER
    ========================================= --}}

    <div class="filter-area">

        <form
            method="GET"
            action="{{ route('dokumen.index') }}"
        >

            <div class="d-flex flex-wrap gap-2 align-items-center">

                <input
                    type="text"
                    name="search"
                    class="form-control search-box"
                    style="max-width: 360px;"
                    placeholder="Cari nama file atau ID pengajuan"
                    value="{{ request('search') }}"
                >


                <button
                    type="submit"
                    class="filter-btn active"
                >
                    Semua
                </button>


                <a
                    href="{{ route('dokumen.index', ['jenis_dokumen' => 'surat']) }}"
                    class="filter-btn"
                >
                    Surat Permohonan
                </a>


                <a
                    href="{{ route('dokumen.index', ['jenis_dokumen' => 'laporan']) }}"
                    class="filter-btn"
                >
                    Laporan ITSA
                </a>


                <a
                    href="{{ route('dokumen.index', ['jenis_dokumen' => 'surat_rekomendasi']) }}"
                    class="filter-btn"
                >
                    Surat Rekomendasi
                </a>


                <a
                    href="{{ route('dokumen.index', ['jenis_dokumen' => 'bukti_pengujian']) }}"
                    class="filter-btn"
                >
                    Bukti Pengujian
                </a>

            </div>


            <div class="mt-3">

                <select
                    name="ajuan_id"
                    class="form-select"
                    style="max-width: 220px;"
                    onchange="this.form.submit()"
                >

                    <option value="">
                        Semua Pengajuan
                    </option>

                    @foreach($ajuans as $ajuan)

                        <option
                            value="{{ $ajuan->id }}"
                            {{ request('ajuan_id') == $ajuan->id ? 'selected' : '' }}
                        >

                            Pengajuan #{{ $ajuan->id }}

                        </option>

                    @endforeach

                </select>

            </div>

        </form>

    </div>


    {{-- ========================================
         TABLE
    ========================================= --}}

    <div class="document-table">

        <div class="table-responsive">

            <table class="table">

                <thead>

                    <tr>

                        <th>
                            FILE
                        </th>

                        <th>
                            KATEGORI
                        </th>

                        <th>
                            PENGAJUAN
                        </th>

                        <th>
                            UKURAN
                        </th>

                        <th>
                            DIUNGGAH OLEH
                        </th>

                        <th>
                            TANGGAL
                        </th>

                        <th>
                            AKSI
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($dokumens as $dokumen)

                        @php

                            $extension = strtolower(
                                pathinfo(
                                    $dokumen->nama_file,
                                    PATHINFO_EXTENSION
                                )
                            );

                            $typeClass = match($extension) {

                                'pdf' => 'type-pdf',

                                'doc',
                                'docx' => 'type-doc',

                                'xls',
                                'xlsx' => 'type-xls',

                                'zip' => 'type-zip',

                                default => 'type-doc'

                            };

                            $fileSize = 0;

                            if (
                                $dokumen->path_file &&
                                Storage::disk('public')
                                    ->exists($dokumen->path_file)
                            ) {

                                $fileSize = Storage::disk('public')
                                    ->size($dokumen->path_file);

                            }

                        @endphp


                        <tr>

                            {{-- FILE --}}

                            <td>

                                <span
                                    class="file-type {{ $typeClass }}"
                                >
                                    {{ strtoupper($extension) }}
                                </span>

                                <span class="file-name">

                                    {{ Str::limit(
                                        $dokumen->nama_file,
                                        35
                                    ) }}

                                </span>

                            </td>


                            {{-- KATEGORI --}}

                            <td>

                                @php

                                    $badgeClass = match(
                                        $dokumen->jenis_dokumen
                                    ) {

                                        'surat'
                                            => 'badge-surat',

                                        'laporan'
                                            => 'badge-laporan',

                                        'surat_rekomendasi'
                                            => 'badge-rekomendasi',

                                        'bukti_pengujian',
                                        'bukti_perbaikan'
                                            => 'badge-bukti',

                                        default
                                            => 'badge-surat'

                                    };

                                    $label = match(
                                        $dokumen->jenis_dokumen
                                    ) {

                                        'surat'
                                            => 'Surat Permohonan',

                                        'laporan'
                                            => 'Laporan ITSA',

                                        'surat_rekomendasi'
                                            => 'Surat Rekomendasi',

                                        'bukti_pengujian'
                                            => 'Bukti Pengujian',

                                        'bukti_perbaikan'
                                            => 'Bukti Perbaikan'

                                    };

                                @endphp

                                <span
                                    class="badge-document {{ $badgeClass }}"
                                >
                                    {{ $label }}
                                </span>

                            </td>


                            {{-- PENGAJUAN --}}

                            <td>

                                Pengajuan #{{ $dokumen->ajuan_id }}

                            </td>


                            {{-- UKURAN --}}

                            <td>

                                @if($fileSize >= 1048576)

                                    {{ number_format(
                                        $fileSize / 1048576,
                                        1
                                    ) }}
                                    MB

                                @else

                                    {{ number_format(
                                        $fileSize / 1024,
                                        0
                                    ) }}
                                    KB

                                @endif

                            </td>


                            {{-- UPLOADER --}}

                            <td>

                                {{ $dokumen->uploader->name ?? '-' }}

                            </td>


                            {{-- TANGGAL --}}

                            <td>

                                {{ $dokumen->created_at
                                    ->format('d M Y') }}

                            </td>


                            {{-- AKSI --}}

                            <td>

                                <div class="d-flex gap-1">

                                    <a
                                        href="{{ route(
                                            'dokumen.download',
                                            $dokumen->id
                                        ) }}"
                                        class="btn btn-sm btn-success"
                                    >
                                        Download
                                    </a>


                                    <form
                                        action="{{ route(
                                            'dokumen.destroy',
                                            $dokumen->id
                                        ) }}"
                                        method="POST"
                                    >

                                        @csrf

                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm(
                                                'Yakin ingin menghapus dokumen ini?'
                                            )"
                                        >
                                            Hapus
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td
                                colspan="7"
                                class="text-center py-5"
                            >

                                <div class="text-muted">

                                    Belum ada dokumen.

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>


{{-- ========================================
     DRAG & DROP JAVASCRIPT
========================================= --}}

<script>

    const dropArea = document.getElementById('dropArea');

    const fileInput = document.getElementById('fileInput');

    const fileName = document.getElementById('fileName');


    fileInput.addEventListener(
        'change',
        function () {

            if (this.files.length > 0) {

                fileName.innerText =
                    this.files[0].name;

            }

        }
    );


    dropArea.addEventListener(
        'dragover',
        function (e) {

            e.preventDefault();

            dropArea.classList.add(
                'dragover'
            );

        }
    );


    dropArea.addEventListener(
        'dragleave',
        function () {

            dropArea.classList.remove(
                'dragover'
            );

        }
    );


    dropArea.addEventListener(
        'drop',
        function (e) {

            e.preventDefault();

            dropArea.classList.remove(
                'dragover'
            );

            if (e.dataTransfer.files.length > 0) {

                fileInput.files =
                    e.dataTransfer.files;

                fileName.innerText =
                    e.dataTransfer.files[0].name;

            }

        }
    );

</script>

@endsection