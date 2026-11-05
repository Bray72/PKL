@extends('layout.admin')

@section('title', 'Kalender Kuota & Slot Audit - Portal ITSA')

@push('styles')
<style>
    /* ===== HEADER ===== */
    .calendar-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 24px;
        flex-wrap: wrap;
    }
    .calendar-header h1 {
        margin: 0;
        color: #172554;
        font-size: 26px;
        font-weight: 800;
        letter-spacing: -0.02em;
    }
    .calendar-header p {
        margin: 6px 0 0;
        color: #64748b;
        font-size: 13.5px;
    }
    .calendar-controls {
        display: flex;
        align-items: center;
        gap: 10px;
        background: #fff;
        padding: 6px 12px;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 3px rgba(0,0,0,.04);
    }
    .calendar-controls label {
        font-size: 12px;
        font-weight: 700;
        color: #475569;
    }
    .calendar-controls input, .calendar-controls select {
        border: 1px solid #cbd5e1;
        border-radius: 9px;
        padding: 6px 10px;
        font-size: 13px;
        color: #1e293b;
        background: #f8fafc;
        outline: none;
    }
    .calendar-controls input:focus, .calendar-controls select:focus {
        border-color: #2563eb;
        background: #fff;
    }
    .calendar-controls button {
        border: 0;
        border-radius: 9px;
        padding: 7px 14px;
        background: #16305a;
        color: white;
        font-size: 12.5px;
        font-weight: 700;
        cursor: pointer;
        transition: background .15s;
    }
    .calendar-controls button:hover {
        background: #1e3a6e;
    }

    /* ===== STAT SUMMARY CARDS ===== */
    .calendar-stats {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }
    .cstat-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 16px 20px;
        display: flex;
        align-items: center;
        gap: 14px;
        box-shadow: 0 1px 3px rgba(0,0,0,.03);
    }
    .cstat-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .cstat-val {
        font-size: 22px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.1;
    }
    .cstat-label {
        font-size: 12px;
        color: #64748b;
        font-weight: 600;
        margin-top: 2px;
    }

    /* ===== MONTH GRID ===== */
    .calendar-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 24px 20px;
    }
    .month-card {
        background: #fff;
        border-radius: 18px;
        padding: 20px 18px 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 16px rgba(15,39,71,.04);
        display: flex;
        flex-direction: column;
    }
    .month-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 14px;
        padding-bottom: 8px;
        border-bottom: 1.5px solid #f1f5f9;
    }
    .month-card h2 {
        margin: 0;
        font-size: 18px;
        font-weight: 800;
        color: #0f172a;
    }
    .month-badge {
        font-size: 11px;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 20px;
        background: #eff6ff;
        color: #2563eb;
    }

    /* Table */
    .month-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 11.5px;
    }
    .month-table th {
        color: #64748b;
        font-weight: 700;
        padding: 6px 4px;
        text-align: left;
        font-size: 10.5px;
        text-transform: uppercase;
        letter-spacing: .03em;
    }
    .month-table th.center, .month-table td.center {
        text-align: center;
    }
    .month-table td {
        border-top: 1px solid #f1f5f9;
        padding: 9px 4px;
        color: #334155;
        vertical-align: middle;
    }
    .month-table tr:hover td {
        background: #fafcff;
    }

    /* Slot Badge */
    .quota-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 3px 8px;
        border-radius: 8px;
        font-weight: 800;
        font-size: 11.5px;
        min-width: 24px;
    }
    /* Penuh (0 sisa slot) */
    .quota-full {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecdd3;
    }
    /* Tersedia (ada slot sisa) */
    .quota-available {
        background: #fef3c7;
        color: #92400e;
        border: 1px solid #fde68a;
    }
    /* Kosong total (semua slot belum terisi) */
    .quota-open {
        background: #f0fdf4;
        color: #166534;
        border: 1px solid #bbf7d0;
    }

    /* Note & Tooltip */
    .note-cell {
        color: #64748b;
        max-width: 130px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .note-booked {
        color: #0f172a !important;
        font-weight: 600;
    }
    .app-tag {
        display: inline-block;
        background: #f1f5f9;
        color: #1e293b;
        padding: 2px 6px;
        border-radius: 6px;
        font-size: 10.5px;
        margin: 1px 0;
    }

    @media (max-width: 1200px) {
        .calendar-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }
    @media (max-width: 768px) {
        .calendar-header { flex-direction: column; align-items: stretch; }
        .calendar-stats { grid-template-columns: 1fr; }
        .calendar-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')
<div style="padding: 4px 0 24px 0;">

    {{-- Header --}}
    <div class="calendar-header">
        <div>
            <h1>Kalender Kuota & Slot Audit</h1>
            <p>Jadwal pengajuan audit, slot kuota mingguan, dan kapasitas assessment tahun {{ $year }}</p>
        </div>
        
        <form class="calendar-controls" method="GET">
            <label for="year">Tahun:</label>
            <input id="year" name="year" type="number" min="2020" max="2100" value="{{ $year }}" style="width: 76px;">

            <label for="quota" style="margin-left: 6px;">Kapasitas/Minggu:</label>
            <select id="quota" name="quota">
                @foreach([1, 2, 3, 4, 5] as $q)
                    <option value="{{ $q }}" {{ $maxQuota == $q ? 'selected' : '' }}>{{ $q }} Slot</option>
                @endforeach
            </select>

            <button type="submit">Tampilkan</button>
        </form>
    </div>

    {{-- Stats Cards --}}
    <div class="calendar-stats">
        <div class="cstat-card">
            <div class="cstat-icon" style="background: #eff6ff; color: #2563eb;">
                <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <div>
                <div class="cstat-val">{{ $totalTerjadwal }}</div>
                <div class="cstat-label">Pengajuan Terjadwal</div>
            </div>
        </div>

        <div class="cstat-card">
            <div class="cstat-icon" style="background: #f0fdf4; color: #16a34a;">
                <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="cstat-val">{{ $totalSlotTersedia }}</div>
                <div class="cstat-label">Sisa Slot Tersedia (Thn {{ $year }})</div>
            </div>
        </div>

        <div class="cstat-card">
            <div class="cstat-icon" style="background: #fef2f2; color: #dc2626;">
                <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                </svg>
            </div>
            <div>
                <div class="cstat-val">{{ $totalSlotPenuh }}</div>
                <div class="cstat-label">Minggu Kuota Penuh</div>
            </div>
        </div>
    </div>

    {{-- Grid 12 Bulan --}}
    <div class="calendar-grid">
        @foreach($months as $month)
            @php
                $monthBooked = collect($month['weeks'])->sum('booked_count');
            @endphp
            <section class="month-card">
                <div class="month-header">
                    <h2>{{ $month['name'] }}</h2>
                    <span class="month-badge">{{ $monthBooked }} Terjadwal</span>
                </div>

                <table class="month-table">
                    <thead>
                        <tr>
                            <th class="center" style="width: 14%;">Mgg</th>
                            <th style="width: 38%;">Tanggal</th>
                            <th class="center" style="width: 20%;">Slot</th>
                            <th style="width: 28%;">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($month['weeks'] as $week)
                            @php
                                $cls = 'quota-open';
                                if ($week['remaining_quota'] === 0) {
                                    $cls = 'quota-full';
                                } elseif ($week['booked_count'] > 0) {
                                    $cls = 'quota-available';
                                }
                            @endphp
                            <tr>
                                <td class="center font-bold" style="color: #64748b;">
                                    W{{ $week['number'] }}
                                </td>

                                <td style="font-weight: 600; color: #1e293b; white-space: nowrap;">
                                    {{ $week['dates'] }}
                                </td>

                                <td class="center">
                                    <span class="quota-badge {{ $cls }}" title="{{ $week['booked_count'] }} terisi dari {{ $week['max_quota'] }} kuota">
                                        {{ $week['remaining_quota'] }}
                                    </span>
                                </td>

                                <td class="note-cell {{ $week['booked_count'] > 0 ? 'note-booked' : '' }}" title="{{ $week['note'] }}">
                                    @if($week['booked_count'] > 0)
                                        @foreach($week['ajuans'] as $a)
                                            <span class="app-tag">
                                                {{ Str::limit($a->nama_aplikasi, 16) }}
                                            </span>
                                        @endforeach
                                    @else
                                        <span style="color: #94a3b8;">Tersedia</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </section>
        @endforeach
    </div>

</div>
@endsection
