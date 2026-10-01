@extends('layout.admin')

@section('title', 'Edit Pengajuan - Portal ITSA')

@push('styles')
<style>
    .edit-page {
        max-width: 900px;
        margin: 0 auto;
    }

    .page-title {
        font-size: 22px;
        font-weight: 800;
        color: #1b365d;
        margin-bottom: 5px;
    }

    .page-subtitle {
        font-size: 13px;
        color: #64748b;
        margin-bottom: 24px;
    }

    .form-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 30px;
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

    .full {
        grid-column: 1 / -1;
    }

    .form-label {
        font-size: 12.5px;
        font-weight: 700;
        color: #1e293b;
    }

    .form-control {
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        padding: 10px 14px;
        font-size: 13px;
        background: #f8fafc;
        outline: none;
    }

    textarea.form-control {
        min-height: 100px;
        resize: vertical;
    }

    .btn-primary {
        background: #16305a;
        color: white;
        border: none;
        border-radius: 10px;
        padding: 11px 24px;
        font-weight: 700;
        cursor: pointer;
    }

    .btn-secondary {
        display: inline-block;
        padding: 11px 20px;
        border-radius: 10px;
        color: #64748b;
        text-decoration: none;
    }

    .error {
        color: #e11d48;
        font-size: 11px;
    }

    @media (max-width: 700px) {
        .form-grid {
            grid-template-columns: 1fr;
        }

        .full {
            grid-column: auto;
        }
    }
</style>
@endpush


@section('content')

<div class="edit-page">

    <h1 class="page-title">
        Edit Pengajuan
    </h1>

    <p class="page-subtitle">
        Ubah data pengajuan {{ $ajuan->nomor_ajuan }}
    </p>


    <div class="form-card">

        <form
            method="POST"
            action="{{ route('admin.pengajuan.update', $ajuan) }}"
        >

            @csrf
            @method('PUT')


            <div class="form-grid">

                {{-- NOMOR AJUAN --}}
                <div class="form-group">

                    <label class="form-label">
                        Nomor Pengajuan
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        value="{{ $ajuan->nomor_ajuan }}"
                        readonly
                    >

                </div>


                {{-- INSTANSI --}}
                <div class="form-group">

                    <label class="form-label">
                        BIRO
                    </label>

                    <select
                        name="user_id"
                        class="form-control"
                        required
                    >

                        @foreach($users as $user)

                            <option
                                value="{{ $user->id }}"
                                {{ old('user_id', $ajuan->user_id) == $user->id ? 'selected' : '' }}
                            >
                                {{ $user->biro }}
                            </option>

                        @endforeach

                    </select>

                    @error('user_id')
                        <small class="error">
                            {{ $message }}
                        </small>
                    @enderror

                </div>


                {{-- NAMA APLIKASI --}}
                <div class="form-group full">

                    <label class="form-label">
                        Nama Aplikasi
                    </label>

                    <input
                        type="text"
                        name="nama_aplikasi"
                        class="form-control"
                        value="{{ old('nama_aplikasi', $ajuan->nama_aplikasi) }}"
                        required
                    >

                    @error('nama_aplikasi')
                        <small class="error">
                            {{ $message }}
                        </small>
                    @enderror

                </div>


                {{-- TUJUAN --}}
                <div class="form-group full">

                    <label class="form-label">
                        Tujuan Assessment
                    </label>

                    <textarea
                        name="tujuan_assessment"
                        class="form-control"
                        required
                    >{{ old('tujuan_assessment', $ajuan->tujuan_assessment) }}</textarea>

                    @error('tujuan_assessment')
                        <small class="error">
                            {{ $message }}
                        </small>
                    @enderror

                </div>


                {{-- TANGGAL ASSESSMENT --}}
                <div class="form-group">

                    <label class="form-label">
                        Tanggal Assessment
                    </label>

                    <input
                        type="date"
                        name="tanggal_assessment"
                        class="form-control"
                        value="{{ old('tanggal_assessment', $ajuan->tanggal_assessment) }}"
                    >

                </div>


                {{-- STATUS --}}
                <div class="form-group">

                    <label class="form-label">
                        Status
                    </label>

                    <select
                        name="status"
                        class="form-control"
                        required
                    >

                        @foreach([
                            'Pengajuan',
                            'Proses Pengujian',
                            'Selesai'
                        ] as $status)

                            <option
                                value="{{ $status }}"
                                {{ old('status', $ajuan->status) == $status ? 'selected' : '' }}
                            >
                                {{ $status }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- CATATAN --}}
                <div class="form-group full">

                    <label class="form-label">
                        Catatan
                    </label>

                    <textarea
                        name="catatan"
                        class="form-control"
                    >{{ old('catatan', $ajuan->catatan) }}</textarea>

                </div>

            </div>


            <div style="
                display:flex;
                gap:10px;
                margin-top:25px;
            ">

                <button
                    type="submit"
                    class="btn-primary"
                >
                    Simpan Perubahan
                </button>

                <a
                    href="{{ route('admin.pengajuan.index') }}"
                    class="btn-secondary"
                >
                    Batal
                </a>

            </div>

        </form>

    </div>

</div>

@endsection