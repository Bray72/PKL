@extends('layout.admin')

@section('title', 'Dashboard Admin ITSA - Portal ITSA')

@section('content')

    <div class="max-w-7xl mx-auto space-y-6">

        <!-- Hero Welcome Banner -->
        <div
             class="bg-gradient-to-r from-[#1b365d] via-[#1e3a64] to-[#0f2747] rounded-[24px] p-6 sm:p-8 text-white shadow-md relative overflow-hidden flex flex-col sm:flex-row sm:items-center justify-between gap-6">

            <!-- Abstract Background Shapes -->
            <div
                 class="absolute -right-10 -bottom-10 w-64 h-64 bg-indigo-500/10 rounded-full blur-2xl pointer-events-none">
            </div>

            <div
                 class="absolute right-48 -top-10 w-40 h-40 bg-sky-400/10 rounded-full blur-xl pointer-events-none">
            </div>


            <div class="relative z-10 space-y-2">

                <div
                     class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-md px-3 py-1 rounded-full text-xs font-medium text-indigo-200 border border-white/10">

                    <span
                          class="w-2 h-2 rounded-full bg-indigo-400 animate-pulse"></span>

                    System Control & Management

                </div>

                <h2
                    class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white">

                    Dashboard Administrator ITSA

                </h2>

                <p class="text-slate-200 text-sm max-w-xl font-normal">

                    Kelola pengajuan uji keamanan informasi dari seluruh BIRO Pemprov Jawa Timur, verifikasi berkas, dan pantau status assessment.

                </p>

            </div>


            <div
                 class="relative z-10 shrink-0 flex flex-wrap sm:flex-nowrap gap-2.5">

                <button type="button"
                        class="w-full sm:w-auto px-4 py-2.5 bg-white/10 hover:bg-white/20 text-white font-semibold text-xs rounded-xl border border-white/20 transition-all flex items-center justify-center gap-2 cursor-pointer">

                </button>

                <button type="button"
                        class="w-full sm:w-auto px-4 py-2.5 bg-indigo-500 hover:bg-indigo-600 text-white font-bold text-xs rounded-xl shadow-sm transition-all flex items-center justify-center gap-2 cursor-pointer active:scale-95">

                </button>

            </div>

        </div>


        <!-- Stat Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">


            <!-- Card 1: Total OPD -->
            <div
                 class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center justify-between">

                <div>

                    <p class="text-xs font-medium text-slate-500 mb-1">BIRO
                        Terdaftar</p>

                    <h3 class="text-2xl font-bold text-[#1b365d]">
                        {{ $totalbiro }}</h3>

                    <span
                          class="text-[11px] text-indigo-600 font-semibold inline-flex items-center gap-0.5 mt-1">

                        Akun BIRO Aktif

                    </span>

                </div>

                <div
                     class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-700 flex items-center justify-center">

                    <svg class="w-6 h-6"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m3 0h1m-1-4h.01M9 16h.01M9 12h.01M9 8h.01M15 16h.01M15 12h.01M15 8h.01" />

                    </svg>

                </div>

            </div>


            <!-- Card 2: Total Ajuan -->
            <div
                 class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center justify-between">

                <div>

                    <p class="text-xs font-medium text-slate-500 mb-1">Total
                        Ajuan Masuk</p>

                    <h3 class="text-2xl font-bold text-[#1b365d]">
                        {{ $totalAjuan }}</h3>

                </div>

                <div
                     class="w-12 h-12 rounded-xl bg-blue-50 text-[#1b365d] flex items-center justify-center">

                    <svg class="w-6 h-6"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />

                    </svg>

                </div>

            </div>


            <!-- Card 4: Selesai -->
            <div
                 class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center justify-between">

                <div>

                    <p class="text-xs font-medium text-slate-500 mb-1">Assessment
                        Selesai</p>

                    <h3 class="text-2xl font-bold text-emerald-600">
                        {{ $selesaiCount }}</h3>

                    <span class="text-[11px] text-slate-400 font-medium mt-1 block">Laporan
                        & Sertifikat terbit</span>

                </div>

                <div
                     class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">

                    <svg class="w-6 h-6"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />

                    </svg>

                </div>

            </div>


        </div>


        <!-- Grid: Main Table & Sidebar Overview -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">


            <!-- Table Section (2 Cols) -->
            <div
                 class="lg:col-span-2 bg-white rounded-[24px] border border-slate-200/80 shadow-xs p-6 space-y-5">


                <!-- Header & Filters -->
                <div
                     class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">

                    <div>

                        <h3 class="text-lg font-bold text-[#1b365d]">

                            Semua Pengajuan Assessment BIRO

                        </h3>

                        <p class="text-xs text-slate-500">

                            Kelola dan ubah status pengajuan dari seluruh BIRO

                        </p>

                    </div>


                    <!-- Search Input Form -->
                    <form method="GET"
                          action="{{ route('admin.dashboard') }}"
                          class="relative">

                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Cari BIRO / aplikasi..."
                               class="pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#1b365d]/20 focus:border-[#1b365d] w-full sm:w-56 transition-all">

                        <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />

                        </svg>

                    </form>

                </div>


                <!-- Status Filter Pills -->
                <div class="flex items-center gap-2 overflow-x-auto pb-1">

                    <a href="{{ route('admin.dashboard') }}"
                       class="px-3 py-1.5 {{ !request('status') ? 'bg-[#1b365d] text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }} text-xs font-semibold rounded-lg shrink-0 transition-colors">

                        Semua ({{ $totalAjuan }})

                    </a>

                    <a href="{{ route('admin.dashboard', ['status' => 'pending']) }}"
                       class="px-3 py-1.5 {{ request('status') == 'pending' ? 'bg-[#1b365d] text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }} text-xs font-medium rounded-lg shrink-0 transition-colors">

                        Menunggu Review

                    </a>

                    <a href="{{ route('admin.dashboard', ['status' => 'ujipetik']) }}"
                       class="px-3 py-1.5 {{ request('status') == 'ujipetik' ? 'bg-[#1b365d] text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }} text-xs font-medium rounded-lg shrink-0 transition-colors">

                        Ujipetik

                    </a>

                    <a href="{{ route('admin.dashboard', ['status' => 'selesai']) }}"
                       class="px-3 py-1.5 {{ request('status') == 'selesai' ? 'bg-[#1b365d] text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }} text-xs font-medium rounded-lg shrink-0 transition-colors">

                        Selesai ({{ $selesaiCount }})

                    </a>

                </div>


                <!-- Table -->
                <div
                     class="overflow-x-auto rounded-xl border border-slate-100">

                    <table class="w-full text-left text-xs border-collapse">

                        <thead>

                            <tr
                                class="bg-slate-50 border-b border-slate-200 text-[#1b365d] font-bold">

                                <th class="py-3.5 px-4">No. Ajuan</th>

                                <th class="py-3.5 px-4">BIRO</th>

                                <th class="py-3.5 px-4">Aplikasi</th>

                                <th class="py-3.5 px-4">Status</th>

                            </tr>

                        </thead>

                        <tbody class="divide-y divide-slate-100 text-slate-700">

                            @forelse($ajuans as $ajuan)

                                <tr
                                    class="hover:bg-slate-50/80 transition-colors">

                                    <td
                                        class="py-3.5 px-4 font-semibold text-[#1b365d]">

                                        {{ $ajuan->nomor_ajuan }}

                                    </td>

                                    <td class="py-3.5 px-4">

                                        <div class="font-bold text-slate-800">
                                            {{ $ajuan->user->biro ?? ($ajuan->user->name ?? '-') }}
                                        </div>

                                        <div
                                             class="text-[11px] text-slate-400">
                                            Tgl:
                                            {{ $ajuan->tanggal_pengajuan ? \Carbon\Carbon::parse($ajuan->tanggal_pengajuan)->format('d M Y') : '-' }}
                                        </div>

                                    </td>

                                    <td class="py-3.5 px-4 font-medium">

                                        {{ $ajuan->nama_aplikasi }}

                                    </td>

                                    <td class="py-3.5 px-4">

                                        @if (in_array(strtolower($ajuan->status), ['selesai']))

                                            <span
                                                  class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">

                                                <span
                                                      class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>

                                                {{ $ajuan->status }}

                                            </span>

                                        @elseif(in_array(strtolower($ajuan->status), ['diproses', 'ujipetik', 'proses ujipetik']))

                                            <span
                                                  class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-700 border border-amber-200">

                                                <span
                                                      class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>

                                                {{ $ajuan->status }}

                                            </span>

                                        @else

                                            <span
                                                  class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-rose-50 text-rose-700 border border-rose-200">

                                                <span
                                                      class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-pulse"></span>

                                                {{ $ajuan->status }}

                                            </span>

                                        @endif

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="5"
                                        class="py-8 text-center text-slate-400">

                                        <p class="font-medium text-slate-600">
                                            Belum ada pengajuan BIRO</p>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>


            </div>


            <!-- Sidebar / Action Card (1 Col) -->
            <div class="space-y-5">

                <!-- Activity Log Widget -->
                <div
                     class="bg-white rounded-[24px] border border-slate-200/80 shadow-xs p-6 space-y-4">

                    <h4 class="text-base font-bold text-[#1b365d]">

                        Aktivitas Temuan Terkini

                    </h4>


                    <div
                         class="space-y-3 text-xs border-l-2 border-slate-100 pl-4">

                        @forelse($recentTemuans as $temuan)

                            <div class="relative">

                                <span
                                      class="w-2.5 h-2.5 rounded-full bg-amber-500 absolute -left-[21px] top-1 ring-4 ring-white"></span>

                                <p class="font-semibold text-slate-800">
                                    {{ $temuan->judul }}</p>

                                <p class="text-slate-500 text-[11px]">
                                    {{ $temuan->ajuan->nama_aplikasi ?? '-' }} •
                                    <span
                                          class="font-bold uppercase text-amber-600">{{ $temuan->severity }}</span>
                                </p>

                                <span
                                      class="text-[10px] text-slate-400">{{ $temuan->created_at->format('H:i') }}
                                    WIB</span>

                            </div>

                        @empty

                            <p class="text-xs text-slate-400 py-2">Belum ada
                                aktivitas temuan</p>

                        @endforelse

                    </div>

                </div>


            </div>


        </div>

    </div>

@endsection