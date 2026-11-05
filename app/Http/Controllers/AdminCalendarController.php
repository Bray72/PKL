<?php

namespace App\Http\Controllers;

use App\Models\Ajuan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminCalendarController extends Controller
{
    public function index(Request $request)
    {
        Carbon::setLocale('id');
        $year = (int) $request->input('year', now()->year);
        $year = ($year >= 2020 && $year <= 2100) ? $year : now()->year;

        // Kapasitas slot audit ditetapkan tetap: 5 slot per minggu.
        $maxQuota = 5;

        $user = $request->user();

        // Ambil semua ajuan pada tahun terpilih dengan filter hak akses admin
        $allAjuans = Ajuan::with('user')
            ->visibleToAdmin($user)
            ->where(function ($q) use ($year) {
                $q->whereYear('tanggal_assessment', $year)
                  ->orWhere(function ($sub) use ($year) {
                      $sub->whereNull('tanggal_assessment')
                          ->whereYear('tanggal_pengajuan', $year);
                  });
            })
            ->get();

        $totalTerjadwal = 0;
        $totalSlotTersedia = 0;
        $totalSlotPenuh = 0;

        $months = collect(range(1, 12))->map(function ($month) use ($year, $allAjuans, $maxQuota, &$totalTerjadwal, &$totalSlotTersedia, &$totalSlotPenuh) {
            $start = Carbon::create($year, $month, 1);
            $weeks = [];
            $cursor = $start->copy()->startOfWeek(Carbon::MONDAY);

            while ($cursor->month === $month || $cursor->lessThan($start->copy()->endOfMonth())) {
                $weekStart = $cursor->copy()->startOfDay();
                $weekEnd = $cursor->copy()->addDays(4)->endOfDay(); // Senin - Jumat

                if ($weekStart->month === $month || $weekEnd->month === $month) {
                    // Cari pengajuan yang jatuh pada rentang minggu ini
                    // Prioritaskan tanggal_assessment jika ada, jika belum ada pakai tanggal_pengajuan
                    $matchedAjuans = $allAjuans->filter(function ($a) use ($weekStart, $weekEnd) {
                        $targetDate = $a->tanggal_assessment ?: $a->tanggal_pengajuan;
                        if (!$targetDate) {
                            return false;
                        }
                        $d = Carbon::parse($targetDate)->startOfDay();
                        return $d->betweenIncluded($weekStart, $weekEnd);
                    });

                    $bookedCount = $matchedAjuans->count();
                    $remainingQuota = max(0, $maxQuota - $bookedCount);

                    $totalTerjadwal += $bookedCount;
                    if ($remainingQuota === 0) {
                        $totalSlotPenuh++;
                    } else {
                        $totalSlotTersedia += $remainingQuota;
                    }

                    // Susun keterangan aplikasi yang terdaftar
                    $note = '-';
                    if ($bookedCount > 0) {
                        $apps = $matchedAjuans->map(function ($a) {
                            $opd = $a->user->opd ?? $a->user->name ?? '';
                            return $a->nama_aplikasi . ($opd ? " ({$opd})" : '');
                        })->values()->all();

                        $note = implode(', ', $apps);
                    }

                    $weeks[] = [
                        'number'          => count($weeks) + 1,
                        'dates'           => $weekStart->format('j M') . ' - ' . $weekEnd->format('j M'),
                        'start_date'      => $weekStart->format('Y-m-d'),
                        'end_date'        => $weekEnd->format('Y-m-d'),
                        'booked_count'    => $bookedCount,
                        'max_quota'       => $maxQuota,
                        'remaining_quota' => $remainingQuota,
                        'status'          => (string) $remainingQuota,
                        'note'            => $note,
                        'ajuans'          => $matchedAjuans->values(),
                    ];
                }
                $cursor->addWeek();
            }

            return [
                'name'  => $start->translatedFormat('F'),
                'weeks' => $weeks,
            ];
        });

        return view('admin.calendar', compact(
            'year',
            'maxQuota',
            'months',
            'totalTerjadwal',
            'totalSlotTersedia',
            'totalSlotPenuh'
        ));
    }
}
