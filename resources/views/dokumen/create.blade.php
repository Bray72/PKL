@extends('layout.admin')

@section('content')

<div class="container-fluid">

    <div class="mb-4">

        <h4>Upload Dokumen</h4>

        <p class="text-muted">
            Upload dokumen untuk Pengajuan #{{ $ajuan->id }}
        </p>

    </div>


    @if($errors->any())

        <div class="alert alert-danger">

            <ul class="mb-0">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    <div class="card shadow-sm">

        <div class="card-body">

            <form action="{{ route('dokumen.store', $ajuan->id) }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf


                <div class="mb-3">

                    <label class="form-label">
                        Jenis Dokumen
                    </label>

                    <select name="jenis_dokumen"
                            class="form-select"
                            required>

                        <option value="">
                            -- Pilih Jenis Dokumen --
                        </option>

                        <option value="surat">
                            Surat
                        </option>

                        <option value="bukti_perbaikan">
                            Bukti Perbaikan
                        </option>

                        <option value="laporan">
                            Laporan
                        </option>

                        <option value="dokumen_pendukung">
                            Dokumen Pendukung
                        </option>

                    </select>

                </div>


                <div class="mb-3">

                    <label class="form-label">
                        Temuan
                    </label>

                    <select name="temuan_id"
                            class="form-select">

                        <option value="">
                            -- Tidak terkait temuan --
                        </option>

                        @foreach($temuans as $temuan)

                            <option value="{{ $temuan->id }}">

                                Temuan #{{ $temuan->id }}

                            </option>

                        @endforeach

                    </select>

                </div>


                <div class="mb-3">

                    <label class="form-label">
                        File
                    </label>

                    <input type="file"
                           name="file"
                           class="form-control"
                           required>

                    <small class="text-muted">
                        Format: PDF, DOC, DOCX, XLS, XLSX, JPG, JPEG, PNG.
                        Maksimal 10 MB.
                    </small>

                </div>


                <div class="d-flex gap-2">

                    <button type="submit"
                            class="btn btn-primary">
                        Upload
                    </button>

                    <a href="{{ route('dokumen.index', $ajuan->id) }}"
                       class="btn btn-secondary">
                        Kembali
                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection