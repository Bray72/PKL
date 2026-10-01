@extends('layout.opd')

@section('title', 'Remediasi Temuan')

@section('content')

<style>
    .remediasi-header {
        margin-bottom: 28px;
    }

    .remediasi-title {
        margin: 0;
        font-size: 34px;
        font-weight: 800;
        color: #1e293b;
        letter-spacing: -1px;
    }

    .remediasi-subtitle {
        margin: 6px 0 0;
        font-size: 16px;
        color: #64748b;
    }

    .temuan-list {
        display: flex;
        flex-direction: column;
        gap: 18px;
    }

    .temuan-card {
        background: #fff;
        border: 1px solid #dbe3ed;
        border-radius: 17px;
        padding: 25px 28px;
        display: flex;
        align-items: center;
        gap: 20px;
        transition: .2s ease;
    }

    .temuan-card:hover {
        border-color: #c7d2e1;
        box-shadow: 0 5px 18px rgba(15, 39, 71, .06);
    }

    .severity-dot {
        width: 28px;
        height: 28px;
        min-width: 28px;
        border-radius: 50%;
        background: #ef4444;
        box-shadow: 0 0 0 4px #fee2e2;
    }

    .severity-dot.tinggi {
        background: #f97316;
        box-shadow: 0 0 0 4px #ffedd5;
    }

    .severity-dot.sedang {
        background: #f59e0b;
        box-shadow: 0 0 0 4px #fef3c7;
    }

    .severity-dot.rendah {
        background: #22c55e;
        box-shadow: 0 0 0 4px #dcfce7;
    }

    .temuan-content {
        flex: 1;
        min-width: 0;
    }

    .temuan-title-row {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .temuan-title {
        margin: 0;
        font-size: 19px;
        font-weight: 700;
        color: #1e293b;
    }

    .severity-badge {
        display: inline-flex;
        align-items: center;
        padding: 5px 12px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
    }

    .severity-kritis {
        background: #fee2e2;
        color: #dc2626;
    }

    .severity-tinggi {
        background: #ffedd5;
        color: #c2410c;
    }

    .severity-sedang {
        background: #fef3c7;
        color: #a16207;
    }

    .severity-rendah {
        background: #dcfce7;
        color: #15803d;
    }

    .temuan-meta {
        margin-top: 7px;
        font-size: 14px;
        color: #8ca0bd;
    }

    .temuan-status {
        flex-shrink: 0;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .status-badge {
        padding: 8px 14px;
        border-radius: 999px;
        font-size: 13px;
        font-weight: 700;
        white-space: nowrap;
    }

    .status-sudah {
        background: #dcfce7;
        color: #15803d;
    }

    .status-sedang {
        background: #fef3c7;
        color: #a16207;
    }

    .status-belum {
        background: #fee2e2;
        color: #dc2626;
    }

    .temuan-arrow {
        color: #94a3b8;
        font-size: 22px;
    }

    .empty-state {
        background: #fff;
        border: 1px solid #dbe3ed;
        border-radius: 17px;
        padding: 55px 30px;
        text-align: center;
        color: #64748b;
    }

    .empty-icon {
        font-size: 42px;
        margin-bottom: 10px;
    }

    .empty-state h3 {
        margin: 0 0 6px;
        color: #334155;
        font-size: 18px;
    }

    .empty-state p {
        margin: 0;
        font-size: 14px;
    }

    @media (max-width: 768px) {

        .remediasi-title {
            font-size: 27px;
        }

        .temuan-card {
            align-items: flex-start;
            padding: 20px;
        }

        .temuan-status {
            flex-direction: column;
            align-items: flex-end;
            gap: 8px;
        }

        .temuan-title {
            font-size: 16px;
        }
    }

    @media (max-width: 600px) {

        .temuan-card {
            flex-wrap: wrap;
        }

        .temuan-status {
            width: 100%;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            padding-left: 48px;
        }
    }
    
    /* Breakdown Styles */
    .temuan-wrapper {
        background: #fff;
        border: 1px solid #dbe3ed;
        border-radius: 17px;
        overflow: hidden;
        transition: .2s ease;
    }

    .temuan-wrapper:hover {
        border-color: #c7d2e1;
        box-shadow: 0 5px 18px rgba(15, 39, 71, .06);
    }
    
    .temuan-wrapper.is-open {
        border-color: var(--itsa-navy);
        box-shadow: 0 4px 20px rgba(22, 48, 90, 0.08);
    }
    
    .temuan-card {
        padding: 25px 28px;
        display: flex;
        align-items: center;
        gap: 20px;
        cursor: pointer;
        background: transparent;
        border: none;
    }
    
    .temuan-breakdown {
        display: none;
        padding: 0 28px 25px 76px;
        border-top: 1px dashed #e2e8f0;
        margin-top: 5px;
        padding-top: 20px;
    }
    
    .temuan-wrapper.is-open .temuan-breakdown {
        display: block;
    }
    
    .temuan-wrapper.is-open .temuan-arrow {
        transform: rotate(180deg);
    }
    
    .breakdown-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
        margin-bottom: 24px;
    }
    
    .breakdown-section-title {
        font-size: 11px;
        font-weight: 700;
        color: #8ca0bd;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 8px;
    }
    
    .breakdown-text {
        font-size: 14px;
        color: #334155;
        line-height: 1.6;
    }
    
    .breakdown-rekomendasi-box {
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        border-radius: 12px;
        padding: 16px;
        color: #1e3a8a;
        font-size: 14px;
        line-height: 1.6;
    }
    
    .respons-section {
        border-top: 1px dashed #e2e8f0;
        padding-top: 20px;
    }
    
    .respons-empty {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }
    
    .respons-empty-text {
        font-style: italic;
        color: #94a3b8;
        font-size: 14px;
    }
    
    .btn-outline {
        padding: 8px 16px;
        border: 1px solid #cbd5e1;
        background: #fff;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        color: #475569;
        cursor: pointer;
        transition: .15s ease;
    }
    
    .btn-outline:hover {
        background: #f8fafc;
        border-color: #94a3b8;
    }
    
    .update-form {
        display: none;
        margin-top: 16px;
    }
    
    .update-form.is-active {
        display: block;
    }
    
    .status-options {
        display: flex;
        gap: 10px;
        margin-bottom: 16px;
    }
    
    .status-option {
        flex: 1;
        position: relative;
    }
    
    .status-option input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }
    
    .status-option-label {
        display: block;
        padding: 10px 12px;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        text-align: center;
        font-size: 13px;
        font-weight: 600;
        color: #64748b;
        cursor: pointer;
        transition: .15s ease;
    }
    
    .status-option input:checked + .status-option-label {
        border-color: var(--itsa-navy);
        background: #f8fafc;
        color: var(--itsa-navy);
        box-shadow: 0 0 0 1px var(--itsa-navy);
    }
    
    .status-option input:checked[value="Sudah selesai"] + .status-option-label {
        border-color: #22c55e;
        background: #f0fdf4;
        color: #15803d;
        box-shadow: 0 0 0 1px #22c55e;
    }
    
    .form-textarea {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid #cbd5e1;
        border-radius: 12px;
        font-family: inherit;
        font-size: 14px;
        color: #334155;
        resize: vertical;
        min-height: 100px;
        margin-bottom: 16px;
    }
    
    .form-textarea:focus {
        outline: none;
        border-color: var(--itsa-navy);
        box-shadow: 0 0 0 3px rgba(22, 48, 90, 0.1);
    }
    
    .form-actions {
        display: flex;
        gap: 10px;
    }
    
    .btn-primary {
        padding: 10px 20px;
        background: var(--itsa-navy);
        color: #fff;
        border: none;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: .15s ease;
    }
    
    .btn-primary:hover {
        background: var(--itsa-navy-dark);
    }
    
    @media (max-width: 768px) {
        .breakdown-grid {
            grid-template-columns: 1fr;
            gap: 16px;
        }
        
        .temuan-breakdown {
            padding: 0 20px 20px 20px;
        }
        
        .status-options {
            flex-direction: column;
        }
    }
</style>


{{-- HEADER --}}
<div class="remediasi-header">

    <h1 class="remediasi-title">
        Remediasi Temuan
    </h1>

    <p class="remediasi-subtitle">
        Lihat temuan keamanan dari Tim ITSA dan perbarui status perbaikan Anda
    </p>

</div>


{{-- DAFTAR TEMUAN --}}
@if($temuans->count() > 0)

    <div class="temuan-list">

        @foreach($temuans as $temuan)

            @php
                $severity = strtolower($temuan->severity ?? 'sedang');
                $status = strtolower($temuan->status ?? 'belum diperbaiki');

                $severityClass = match($severity) {
                    'kritis' => 'severity-kritis',
                    'tinggi' => 'severity-tinggi',
                    'sedang' => 'severity-sedang',
                    'rendah' => 'severity-rendah',
                    default => 'severity-sedang',
                };

                $dotClass = match($severity) {
                    'kritis' => '',
                    'tinggi' => 'tinggi',
                    'sedang' => 'sedang',
                    'rendah' => 'rendah',
                    default => 'sedang',
                };

                $statusClass = match($status) {
                    'Selesa' => 'status-sudah',
                    'belum diperbaiki' => 'status-belum',
                    default => 'status-sedang',
                };
            @endphp


            <div class="temuan-wrapper" id="temuan-{{ $temuan->id }}">
                <div class="temuan-card" onclick="toggleTemuan('{{ $temuan->id }}')">
                    {{-- Severity --}}
                    <div class="severity-dot {{ $dotClass }}"></div>

                    {{-- Content --}}
                    <div class="temuan-content">
                        <div class="temuan-title-row">
                            <h2 class="temuan-title">
                                {{ $temuan->judul }}
                            </h2>
                            <span class="severity-badge {{ $severityClass }}">
                                {{ ucfirst($temuan->severity) }}
                            </span>
                        </div>

                        <div class="temuan-meta">
                            {{ $temuan->ajuan->user->biro ?? '-' }}
                            ·
                            TMN-{{ str_pad($temuan->id, 3, '0', STR_PAD_LEFT) }}
                            ·
                            {{ $temuan->created_at?->format('d M Y') }}
                        </div>
                    </div>

                    {{-- Status --}}
                    <div class="temuan-status">
                        <span class="status-badge {{ $statusClass }}">
                            {{ $temuan->status ?? 'Belum Diperbaiki' }}
                        </span>
                        <span class="temuan-arrow">
                            ▾
                        </span>
                    </div>
                </div>
                
                {{-- Breakdown / Detail --}}
                <div class="temuan-breakdown">
                    <div class="breakdown-grid">
                        <div>
                            <div class="breakdown-section-title">DESKRIPSI TEMUAN</div>
                            <div class="breakdown-text">
                                {{ $temuan->deskripsi ?: 'Tidak ada deskripsi.' }}
                            </div>
                        </div>
                        <div>
                            <div class="breakdown-section-title">REKOMENDASI PERBAIKAN</div>
                            <div class="breakdown-rekomendasi-box">
                                {{ $temuan->rekomendasi ?: 'Tidak ada rekomendasi.' }}
                            </div>
                        </div>
                    </div>
                    
                    <div class="respons-section">
                        <div class="breakdown-section-title">RESPONS PERBAIKAN OPD</div>
                        
                        <div class="respons-empty" id="respons-empty-{{ $temuan->id }}">
                            <div class="respons-empty-text">
                                {{ $temuan->catatan_validasi ?: 'Belum ada catatan perbaikan dari OPD.' }}
                            </div>
                            <button type="button" class="btn-outline" onclick="showUpdateForm('{{ $temuan->id }}')">
                                Update Status
                            </button>
                        </div>
                        
                        <div class="update-form" id="update-form-{{ $temuan->id }}">
                            <form action="{{ route('opd.remediasi.update', $temuan->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                

                                
                                <div class="breakdown-section-title" style="margin-bottom: 12px; text-transform: none; color: #475569;">Catatan / Bukti Perbaikan</div>
                                <textarea name="catatan_validasi" class="form-textarea" placeholder="Jelaskan langkah perbaikan yang telah dilakukan, sertakan commit hash, screenshot, atau referensi lainnya...">{{ $temuan->catatan_validasi }}</textarea>
                                
                                <div class="form-group">
                                    <label for="bukti_perbaikan">
                                        Gambar Bukti Perbaikan
                                    </label>

                                    @php
                                        $bukti = \App\Models\Dokumen::where('temuan_id', $temuan->id)->where('jenis_dokumen', 'bukti_perbaikan')->first();
                                    @endphp

                                    @if($bukti)
                                        <div style="margin-bottom: 12px; padding: 12px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px;">
                                            <p style="margin: 0 0 8px 0; font-size: 13px; color: #64748b;">File saat ini:</p>
                                            <div style="display: flex; align-items: center; gap: 10px;">
                                                <a href="{{ Storage::url($bukti->path_file) }}" target="_blank" style="color: var(--itsa-navy); text-decoration: none; font-weight: 600; font-size: 14px;">
                                                    📄 {{ $bukti->nama_file }}
                                                </a>
                                            </div>
                                            <p style="margin: 8px 0 0 0; font-size: 12px; color: #94a3b8;">* Upload file baru di bawah ini jika ingin mengganti file yang sudah ada.</p>
                                        </div>
                                    @endif

                                    <div class="upload-box">
                                        <div class="upload-content">
                                            <div class="upload-icon">
                                                📷
                                            </div>

                                            <div>
                                                <strong>Pilih gambar bukti perbaikan</strong>
                                                <p>
                                                    JPG, JPEG, PNG atau WEBP
                                                    • Maksimal 2 MB
                                                </p>
                                            </div>
                                        </div>

                                        <input
                                            type="file"
                                            name="bukti_perbaikan"
                                            id="bukti_perbaikan"
                                            accept=".jpg,.jpeg,.png,.webp"
                                        >
                                    </div>

                                    @error('bukti_perbaikan')
                                        <small class="text-danger" style="color: #dc2626; display: block; margin-top: 5px;">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>

                                <div class="form-actions">
                                    <button type="submit" class="btn-primary">Simpan Pembaruan</button>
                                    <button type="button" class="btn-outline" onclick="hideUpdateForm('{{ $temuan->id }}')">Batal</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        @endforeach

    </div>

@else

    {{-- Tidak ada temuan --}}
    <div class="empty-state">

        <div class="empty-icon">
            ✓
        </div>

        <h3>
            Tidak ada temuan
        </h3>

        <p>
            Belum terdapat temuan keamanan untuk biro Anda.
        </p>

    </div>

@endif

@endsection

@push('scripts')
<script>
    function toggleTemuan(id) {
        const wrapper = document.getElementById('temuan-' + id);
        // Tutup form update kalau ada
        const form = document.getElementById('update-form-' + id);
        const empty = document.getElementById('respons-empty-' + id);
        if (form.classList.contains('is-active')) {
            hideUpdateForm(id);
        }
        wrapper.classList.toggle('is-open');
    }

    function showUpdateForm(id) {
        document.getElementById('respons-empty-' + id).style.display = 'none';
        document.getElementById('update-form-' + id).classList.add('is-active');
    }

    function hideUpdateForm(id) {
        document.getElementById('update-form-' + id).classList.remove('is-active');
        document.getElementById('respons-empty-' + id).style.display = 'flex';
    }
</script>
@endpush