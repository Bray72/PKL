@extends('layout.admin')

@section('title', 'Validasi Hasil Pengujian')

@section('content')

<style>
    .validasi-header {
        margin-bottom: 28px;
    }

    .validasi-header h1 {
        margin: 0;
        font-size: 32px;
        font-weight: 800;
        color: #102d52;
    }

    .validasi-header p {
        margin-top: 6px;
        font-size: 17px;
        color: #5f7b9e;
    }

    .validasi-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 28px;
    }

    .validasi-card {
        background: #ffffff;
        border: 2px solid #dce5ef;
        border-radius: 16px;
        padding: 28px 30px;
        transition: .2s ease;
    }

    .validasi-card:hover {
        border-color: #234b78;
        box-shadow: 0 8px 20px rgba(15, 39, 71, .08);
    }

    .validasi-card.selected {
        border-color: #234b78;
    }

    .validasi-card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 20px;
    }

    .validasi-title {
        margin: 0;
        font-size: 23px;
        font-weight: 800;
        color: #102d52;
    }

    .validasi-instansi {
        margin-top: 6px;
        font-size: 17px;
        color: #5f7b9e;
    }

    .status-badge {
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 600;
        white-space: nowrap;
    }

    .status-menunggu {
        background: #dceaff;
        color: #2057b5;
    }

    .status-selesai {
        background: #d8f8e5;
        color: #08753e;
    }

    .status-dikembalikan {
        background: #ffe1e1;
        color: #c62828;
    }

    .validasi-info {
        margin-top: 22px;
        font-size: 15px;
        color: #7890ad;
    }

    .temuan-wrapper {
        margin-top: 24px;
        padding-top: 22px;
        border-top: 1px solid #e5ebf2;
    }

    .temuan-title {
        font-size: 16px;
        font-weight: 700;
        color: #294c73;
        margin-bottom: 12px;
    }

    .temuan-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 8px;
        color: #355474;
        font-size: 15px;
    }

    .temuan-dot {
        width: 8px;
        height: 8px;
        margin-top: 7px;
        border-radius: 50%;
        background: #ef4444;
        flex-shrink: 0;
    }

    .temuan-dot.medium {
        background: #f97316;
    }

    .temuan-dot.low {
        background: #eab308;
    }

    .validasi-actions {
        display: flex;
        gap: 12px;
        margin-top: 24px;
    }

    .btn-validasi {
        flex: 1;
        border: none;
        border-radius: 11px;
        padding: 13px 16px;
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
        transition: .2s ease;
    }

    .btn-validasi-primary {
        background: #00a844;
        color: white;
    }

    .btn-validasi-primary:hover {
        background: #008c39;
    }

    .btn-validasi-return {
        background: white;
        color: #dc2626;
        border: 1px solid #fecaca;
    }

    .btn-validasi-return:hover {
        background: #fff5f5;
    }

    .empty-validasi {
        background: white;
        border: 1px solid #dce5ef;
        border-radius: 16px;
        padding: 50px;
        text-align: center;
        color: #7188a3;
    }

    .empty-validasi h3 {
        margin: 0 0 8px;
        color: #294c73;
    }

    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(15, 39, 71, .45);
        z-index: 100;
        align-items: center;
        justify-content: center;
    }

    .modal-overlay.show {
        display: flex;
    }

    .modal-box {
        width: min(500px, calc(100% - 40px));
        background: white;
        border-radius: 16px;
        padding: 28px;
        box-shadow: 0 20px 50px rgba(0,0,0,.2);
    }

    .modal-box h3 {
        margin-top: 0;
        color: #102d52;
    }

    .modal-box textarea {
        width: 100%;
        min-height: 120px;
        border: 1px solid #d5deea;
        border-radius: 10px;
        padding: 12px;
        resize: vertical;
        font-family: inherit;
        margin-top: 10px;
    }

    .modal-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 18px;
    }

    .modal-cancel {
        border: 1px solid #d5deea;
        background: white;
        padding: 10px 18px;
        border-radius: 9px;
        cursor: pointer;
    }

    .modal-submit {
        border: none;
        background: #dc2626;
        color: white;
        padding: 10px 18px;
        border-radius: 9px;
        cursor: pointer;
        font-weight: 600;
    }

    @media (max-width: 900px) {
        .validasi-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 600px) {
        .validasi-header h1 {
            font-size: 26px;
        }

        .validasi-card-header {
            flex-direction: column;
        }

        .validasi-actions {
            flex-direction: column;
        }
    }
</style>


<div class="validasi-header">

    <h1>Validasi Hasil Pengujian</h1>

    <p>
        Lakukan validasi ulang dan penerbitan laporan akhir ITSA
    </p>

</div>


@if(session('success'))

    <div style="
        background:#d8f8e5;
        color:#08753e;
        padding:14px 18px;
        border-radius:10px;
        margin-bottom:20px;
    ">
        {{ session('success') }}
    </div>

@endif


@if($ajuans->count())

    <div class="validasi-grid">

        @foreach($ajuans as $ajuan)

            <div class="validasi-card">

                <div class="validasi-card-header">

                    <div>

                        <h2 class="validasi-title">
                            {{ $ajuan->nama_aplikasi }}
                        </h2>

                        <div class="validasi-instansi">

                            {{ $ajuan->user->instansi ?? 'Instansi tidak tersedia' }}

                        </div>

                    </div>


                    @if($ajuan->status === 'selesai')

                        <span class="status-badge status-selesai">
                            Selesai
                        </span>

                    @elseif($ajuan->status === 'dikembalikan')

                        <span class="status-badge status-dikembalikan">
                            Dikembalikan
                        </span>

                    @else

                        <span class="status-badge status-menunggu">
                            Menunggu Validasi
                        </span>

                    @endif

                </div>


                <div class="validasi-info">

                    ID:
                    {{ $ajuan->nomor_ajuan }}

                    ·

                    PIC:
                    {{ $ajuan->user->name ?? '-' }}

                </div>


                @if($ajuan->temuans->count())

                    <div class="temuan-wrapper">

                        <div class="temuan-title">
                            Temuan yang ditemukan:
                        </div>


                        @foreach($ajuan->temuans as $temuan)

                            <div class="temuan-item">

                                <span class="temuan-dot
                                    @if(strtolower($temuan->severity) === 'medium')
                                        medium
                                    @elseif(strtolower($temuan->severity) === 'low')
                                        low
                                    @endif
                                "></span>

                                <span>
                                    {{ $temuan->judul }}
                                </span>

                            </div>

                        @endforeach

                    </div>

                @endif


                @if($ajuan->status === 'menunggu_validasi')

                    <div class="validasi-actions">

                        {{-- VALIDASI --}}

                        <form method="POST"
                              action="{{ route('admin.validasi.validate', $ajuan->id) }}"
                              style="flex:1;">

                            @csrf

                            <button type="submit"
                                    class="btn-validasi btn-validasi-primary"
                                    style="width:100%;"
                                    onclick="return confirm('Apakah Anda yakin ingin memvalidasi dan menerbitkan laporan ini?')">

                                ✓ Validasi & Terbitkan Laporan

                            </button>

                        </form>


                        {{-- KEMBALIKAN --}}

                        <button type="button"
                                class="btn-validasi btn-validasi-return"
                                onclick="openReturnModal({{ $ajuan->id }})">

                            ✕ Kembalikan ke OPD

                        </button>

                    </div>

                @endif

            </div>

        @endforeach

    </div>

@else

    <div class="empty-validasi">

        <h3>Belum Ada Hasil Pengujian</h3>

        <p>
            Belum ada pengajuan yang menunggu proses validasi.
        </p>

    </div>

@endif


{{-- =========================================================
     MODAL KEMBALIKAN KE OPD
========================================================= --}}

<div class="modal-overlay" id="returnModal">

    <div class="modal-box">

        <h3>Kembalikan ke OPD</h3>

        <p style="color:#7188a3;">
            Berikan catatan mengenai hasil yang perlu diperbaiki oleh OPD.
        </p>


        <form method="POST"
              id="returnForm">

            @csrf

            <label style="
                font-weight:600;
                color:#294c73;
            ">
                Catatan Validasi
            </label>

            <textarea
                name="catatan_validasi"
                required
                placeholder="Masukkan catatan untuk OPD..."></textarea>


            <div class="modal-actions">

                <button type="button"
                        class="modal-cancel"
                        onclick="closeReturnModal()">

                    Batal

                </button>

                <button type="submit"
                        class="modal-submit">

                    Kembalikan ke OPD

                </button>

            </div>

        </form>

    </div>

</div>


<script>

    function openReturnModal(id)
    {
        const modal = document.getElementById('returnModal');
        const form = document.getElementById('returnForm');

        form.action = "{{ url('/admin/validasi') }}/" + id + "/return";

        modal.classList.add('show');
    }


    function closeReturnModal()
    {
        const modal = document.getElementById('returnModal');

        modal.classList.remove('show');
    }


    document.getElementById('returnModal').addEventListener('click', function(event)
    {
        if (event.target === this) {
            closeReturnModal();
        }
    });

</script>

@endsection