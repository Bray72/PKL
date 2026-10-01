@extends('layout.admin')

@section('content')

<style>
    .temuan-edit-wrapper {
        max-width: 1050px;
        margin: 0 auto;
        padding: 30px 20px 50px;
    }

    .temuan-header {
        margin-bottom: 24px;
    }

    .temuan-header h2 {
        margin: 0;
        font-size: 24px;
        font-weight: 700;
        color: #1f2937;
    }

    .temuan-header p {
        margin: 6px 0 0;
        font-size: 14px;
        color: #6b7280;
    }

    .temuan-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
        overflow: hidden;
    }

    .temuan-card-header {
        padding: 20px 24px;
        border-bottom: 1px solid #eef0f3;
        background: #fafbfc;
    }

    .temuan-card-header h3 {
        margin: 0;
        font-size: 16px;
        font-weight: 650;
        color: #1f2937;
    }

    .temuan-card-header span {
        display: block;
        margin-top: 4px;
        font-size: 13px;
        color: #6b7280;
    }

    .temuan-form {
        padding: 26px 24px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group.full {
        grid-column: 1 / -1;
    }

    .form-label {
        display: block;
        margin-bottom: 8px;
        font-size: 13px;
        font-weight: 600;
        color: #374151;
    }

    .required {
        color: #dc2626;
    }

    .form-control-custom {
        width: 100%;
        padding: 11px 13px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        background: #ffffff;
        color: #1f2937;
        font-size: 14px;
        outline: none;
        transition: all 0.2s ease;
        box-sizing: border-box;
    }

    .form-control-custom:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.10);
    }

    textarea.form-control-custom {
        min-height: 120px;
        resize: vertical;
        line-height: 1.6;
    }

    select.form-control-custom {
        cursor: pointer;
    }

    .form-help {
        margin-top: 6px;
        font-size: 12px;
        color: #9ca3af;
    }

    .error-message {
        margin-top: 6px;
        font-size: 12px;
        color: #dc2626;
    }

    .status-section {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .form-footer {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 10px;
        padding-top: 22px;
        margin-top: 6px;
        border-top: 1px solid #eef0f3;
    }

    .btn-custom {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        min-width: 120px;
        padding: 10px 17px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-cancel {
        background: #f3f4f6;
        color: #374151;
    }

    .btn-cancel:hover {
        background: #e5e7eb;
        color: #1f2937;
    }

    .btn-save {
        background: #2563eb;
        color: #ffffff;
    }

    .btn-save:hover {
        background: #1d4ed8;
    }

    .alert-error {
        margin-bottom: 20px;
        padding: 12px 15px;
        border-radius: 8px;
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #991b1b;
        font-size: 13px;
    }

    .alert-error ul {
        margin: 6px 0 0 18px;
        padding: 0;
    }

    @media (max-width: 768px) {
        .temuan-edit-wrapper {
            padding: 20px 15px 40px;
        }

        .form-grid,
        .status-section {
            grid-template-columns: 1fr;
        }

        .form-group.full {
            grid-column: auto;
        }

        .form-footer {
            flex-direction: column-reverse;
            align-items: stretch;
        }

        .btn-custom {
            width: 100%;
        }
    }
</style>

<div class="temuan-edit-wrapper">

{{-- Header --}}
<div class="temuan-header">
    <h2>Edit Temuan</h2>
    <p>Perbarui informasi temuan dan status pemeriksaan.</p>
</div>

{{-- Validation Error --}}
@if ($errors->any())
    <div class="alert-error">
        <strong>Terdapat kesalahan pada form.</strong>

        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="temuan-card">

    {{-- Card Header --}}
    <div class="temuan-card-header">
        <h3>Informasi Temuan</h3>
        <span>Silakan perbarui data temuan sesuai hasil pemeriksaan.</span>
    </div>

    <form action="{{ route('admin.temuan.update', $temuan->id) }}"
          method="POST"
          class="temuan-form">

        @csrf
        @method('PUT')

        <div class="form-grid">

            {{-- Pengajuan --}}
            <div class="form-group">
                <label class="form-label">
                    Pengajuan <span class="required">*</span>
                </label>

                <select name="ajuan_id"
                        class="form-control-custom"
                        required>

                    <option value="">Pilih pengajuan</option>

                    @foreach ($ajuans as $ajuan)
                        <option value="{{ $ajuan->id }}"
                            {{ old('ajuan_id', $temuan->ajuan_id) == $ajuan->id ? 'selected' : '' }}>

                            {{ $ajuan->judul ?? 'Pengajuan #' . $ajuan->id }}

                        </option>
                    @endforeach

                </select>

                @error('ajuan_id')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            {{-- Judul --}}
            <div class="form-group">
                <label class="form-label">
                    Judul Temuan <span class="required">*</span>
                </label>

                <input type="text"
                       name="judul"
                       class="form-control-custom"
                       value="{{ old('judul', $temuan->judul) }}"
                       placeholder="Masukkan judul temuan"
                       required>

                @error('judul')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            {{-- Deskripsi --}}
            <div class="form-group full">
                <label class="form-label">
                    Deskripsi
                </label>

                <textarea name="deskripsi"
                          class="form-control-custom"
                          placeholder="Jelaskan detail temuan...">{{ old('deskripsi', $temuan->deskripsi) }}</textarea>

                <div class="form-help">
                    Jelaskan kondisi atau permasalahan yang ditemukan.
                </div>

                @error('deskripsi')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            {{-- Severity --}}
            <div class="form-group">
                <label class="form-label">
                    Tingkat Severity <span class="required">*</span>
                </label>

                <select name="severity"
                        class="form-control-custom"
                        required>

                    <option value="Rendah"
                        {{ old('severity', $temuan->severity) == 'Rendah' ? 'selected' : '' }}>
                        Rendah
                    </option>

                    <option value="Sedang"
                        {{ old('severity', $temuan->severity) == 'Sedang' ? 'selected' : '' }}>
                        Sedang
                    </option>

                    <option value="Tinggi"
                        {{ old('severity', $temuan->severity) == 'Tinggi' ? 'selected' : '' }}>
                        Tinggi
                    </option>

                    <option value="Kritis"
                        {{ old('severity', $temuan->severity) == 'Kritis' ? 'selected' : '' }}>
                        Kritis
                    </option>

                </select>

                @error('severity')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            {{-- Status --}}
            <div class="form-group">
                <label class="form-label">
                    Status <span class="required">*</span>
                </label>

                <select name="status"
                        class="form-control-custom"
                        required>

                    <option value="Menunggu Remediasi"
                        {{ old('status', $temuan->status) == 'Menunggu Remediasi' ? 'selected' : '' }}>
                        Menunggu Remediasi
                    </option>

                    <option value="Selesai"
                        {{ old('status', $temuan->status) == 'Selesai' ? 'selected' : '' }}>
                        Selesai
                    </option>

                </select>

                @error('status')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            {{-- Rekomendasi --}}
            <div class="form-group full">
                <label class="form-label">
                    Rekomendasi
                </label>

                <textarea name="rekomendasi"
                          class="form-control-custom"
                          placeholder="Masukkan rekomendasi perbaikan...">{{ old('rekomendasi', $temuan->rekomendasi) }}</textarea>

                <div class="form-help">
                    Masukkan rekomendasi atau tindakan yang perlu dilakukan.
                </div>

                @error('rekomendasi')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

        </div>

        {{-- Footer --}}
        <div class="form-footer">

            <a href="{{ route('admin.temuan.index') }}"
               class="btn-custom btn-cancel">
                Batal
            </a>

            <button type="submit"
                    class="btn-custom btn-save">
                Simpan Perubahan
            </button>

        </div>

    </form>

</div>
```

</div>

@endsection
