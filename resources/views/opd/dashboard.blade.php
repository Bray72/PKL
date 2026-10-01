@extends('layout.opd')

@section('title', 'Dashboard OPD – Portal ITSA')

@section('content')

    {{-- ===== Page Header ===== --}}
    <div style="margin-bottom: 28px;">
        <h1 style="margin: 0 0 4px; font-size: 24px; font-weight: 800; color: #16305a;">Dashboard OPD</h1>
        <p style="margin: 0; font-size: 13px; color: #64748b;">Pantau status pengujian keamanan aplikasi Anda</p>
    </div>

    {{-- ===== Stat Cards ===== --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4" style="margin-bottom: 28px;">

        {{-- Card 1: Total Pengajuan --}}
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-slate-500 mb-1">Total Pengajuan</p>
                <h3 class="text-2xl font-bold" style="color:#16305a;">{{ $totalAjuan }}</h3>
                <span class="text-[11px] text-slate-400 font-medium mt-1 block">Semua pengajuan</span>
            </div>
            <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background:#eff6ff; color:#1d4ed8;">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
        </div>

        {{-- Card 2: Pengajuan (menunggu / pending) --}}
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-slate-500 mb-1">Pengajuan</p>
                <h3 class="text-2xl font-bold text-sky-600">
                    {{ $pengajuanCount }}
                </h3>
                <span class="text-[11px] text-slate-400 font-medium mt-1 block">Menunggu diproses</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>

        {{-- Card 3: Proses Pengujian --}}
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-slate-500 mb-1">Proses Pengujian</p>
                <h3 class="text-2xl font-bold text-amber-600">{{ $diprosesCount }}</h3>
                <span class="text-[11px] text-slate-400 font-medium mt-1 block">Dalam tahap pengujian</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18"/>
                </svg>
            </div>
        </div>

        {{-- Card 4: Selesai --}}
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-slate-500 mb-1">Selesai</p>
                <h3 class="text-2xl font-bold text-emerald-600">{{ $selesaiCount }}</h3>
                <span class="text-[11px] text-slate-400 font-medium mt-1 block">Lulus uji keamanan</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>

    </div>


    {{-- ===== Status Pengajuan ITSA Table ===== --}}
    <div class="bg-white rounded-[20px] border border-slate-200/80 shadow-xs p-6 space-y-5">

        {{-- Table Header Bar --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-base font-bold" style="color:#16305a; margin:0 0 2px;">Status Pengajuan ITSA</h2>
                <p class="text-xs text-slate-400" style="margin:0;">
                    Per {{ \Carbon\Carbon::now()->translatedFormat('d M Y') }}
                </p>
            </div>

            {{-- Search & Filter --}}
            <form method="GET" action="{{ route('opd.dashboard') }}" class="flex items-center gap-2">
                <div class="relative">
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Cari aplikasi..."
                           class="pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:border-[#16305a] w-48 sm:w-56 transition-all">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>

                <select name="status"
                        onchange="this.form.submit()"
                        class="px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 focus:outline-none focus:ring-2 focus:border-[#16305a]">
                    <option value="">Semua Status</option>
                    <option value="Pengajuan" {{ request('status') == 'Pengajuan' ? 'selected' : '' }}>Pengajuan</option>
                    <option value="Proses Pengujian" {{ request('status') == 'Proses Pengujian' ? 'selected' : '' }}>Proses Pengujian</option>
                    <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </form>
        </div>


        {{-- Table --}}
        <div class="overflow-x-auto rounded-xl border border-slate-100">
            <table class="w-full text-left text-xs border-collapse">

                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 font-bold" style="color:#16305a;">
                        <th class="py-3.5 px-4">No. Ajuan</th>
                        <th class="py-3.5 px-4">Nama Aplikasi</th>
                        <th class="py-3.5 px-4">Tanggal Pengajuan</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-4">Dokumen</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100 text-slate-700">

                    @forelse($ajuans as $ajuan)

                        <tr class="hover:bg-slate-50/80 transition-colors">

                            <td class="py-3.5 px-4 font-semibold" style="color:#16305a;">
                                {{ $ajuan->nomor_ajuan }}
                            </td>

                            <td class="py-3.5 px-4">
                                <div class="font-bold text-slate-800">{{ $ajuan->nama_aplikasi }}</div>
                                <div class="text-[11px] text-slate-400">{{ Str::limit($ajuan->tujuan_assessment, 40) }}</div>
                            </td>

                            <td class="py-3.5 px-4 text-slate-500">
                                {{ $ajuan->tanggal_pengajuan
                                    ? \Carbon\Carbon::parse($ajuan->tanggal_pengajuan)->format('d M Y')
                                    : '-' }}
                            </td>

                            <td class="py-3.5 px-4">
                                @php
                                    $st = strtolower($ajuan->status);
                                @endphp

                                @if ($st === 'selesai')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Selesai
                                    </span>

                                @elseif ($st === 'proses pengujian')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                        Proses Pengujian
                                    </span>

                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-sky-50 text-sky-700 border border-sky-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-sky-500"></span>
                                        Pengajuan
                                    </span>
                                @endif

                            </td>

                            <td class="py-3.5 px-4">
                                @forelse($ajuan->dokumens as $dokumen)
                                    <a href="{{ route('dokumen.download', $dokumen) }}"
                                       class="inline-flex items-center gap-1.5 px-2.5 py-1 mb-1 rounded-lg text-[11px] font-semibold bg-blue-50 text-blue-700 border border-blue-200 hover:bg-blue-100 transition-colors"
                                       title="Unduh {{ $dokumen->nama_file }}">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v12m0 0 4-4m-4 4-4-4m-5 8h18"/>
                                        </svg>
                                        {{ Str::limit($dokumen->nama_file, 24) }}
                                    </a>
                                @empty
                                    <span class="text-slate-400">Belum ada</span>
                                @endforelse
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="py-10 text-center text-slate-400">
                                <div class="space-y-1">
                                    <p class="font-medium text-slate-600">Belum ada data pengajuan</p>
                                    <p class="text-xs">Hubungi admin untuk mengajukan pengujian ITSA</p>
                                </div>
                            </td>
                        </tr>

                    @endforelse

                </tbody>
            </table>
        </div>

    </div>

@endsection
