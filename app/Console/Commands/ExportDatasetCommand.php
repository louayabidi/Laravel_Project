<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Objectif;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ExportDatasetCommand extends Command
{
    protected $signature = 'ai:export-dataset';
    protected $description = 'Exporter dataset pour ML (objectifs + features)';

    public function handle()
    {
        $rows = [];
        // header
        $rows[] = implode(',', [
            'objectif_id','user_id','status',
            'target_value','days_total','days_passed','days_remaining',
            'avg_sommeil','avg_eau','avg_sport','avg_stress','avg_meditation','avg_ecran','avg_cafe',
            'regularity','progress_percent','achieved'
        ]);

        $objectifs = Objectif::with('habitudes')->get();

        foreach ($objectifs as $o) {
            $start = Carbon::parse($o->start_date);
            $end = Carbon::parse($o->end_date);
            $today = Carbon::now();

            $daysTotal = max(1, $start->diffInDays($end));
            $daysPassed = max(0, $start->diffInDays(min($today, $end)));
            $daysRemaining = max(0, $today->diffInDays($end, false));

            // build query: habitudes up to end_date (historical label)
            $hab = $o->habitudes()->where('date_jour', '<=', $end->toDateString())->get();

            // compute averages for all metrics
            $avg = fn($col) => $hab->where($col, '!=', null)->avg($col) ?: 0;

            $avg_sommeil = $avg('sommeil_heures');
            $avg_eau = $avg('eau_litres');
            $avg_sport = $avg('sport_minutes');
            $avg_stress = $avg('stress_niveau');
            $avg_meditation = $avg('meditation_minutes');
            $avg_ecran = $avg('temps_ecran_minutes');
            $avg_cafe = $avg('cafe_cups');

            // regularity = proportion de jours entre start and end with any habit logged
            $totalDaysRange = $start->diffInDays($end) + 1;
            $distinctDays = $o->habitudes()->whereBetween('date_jour', [$start->toDateString(), $end->toDateString()])->distinct('date_jour')->count('date_jour');
            $regularity = $totalDaysRange > 0 ? $distinctDays / $totalDaysRange : 0;

            // progress_percent: compare average metric (choose metric by status)
            $metric = match(strtolower($o->status)) {
                'sommeil' => $avg_sommeil,
                'eau' => $avg_eau,
                'sport' => $avg_sport,
                'stress' => $avg_stress,
                default => 0,
            };
            $progress_percent = $o->target_value > 0 ? round(($metric / $o->target_value) * 100, 2) : 0;

            // achieved label: 1 if metric average >= target_value (before or at end_date)
            $achieved = ($metric >= $o->target_value) ? 1 : 0;

            $line = [
                $o->id,
                $o->user_id,
                str_replace(',', '', $o->status),
                $o->target_value,
                $daysTotal,
                $daysPassed,
                $daysRemaining,
                round($avg_sommeil,2),
                round($avg_eau,2),
                round($avg_sport,2),
                round($avg_stress,2),
                round($avg_meditation,2),
                round($avg_ecran,2),
                round($avg_cafe,2),
                round($regularity,3),
                $progress_percent,
                $achieved
            ];

            $rows[] = implode(',', $line);
        }

        $path = 'datasets/objectifs_dataset1.csv';
        Storage::put($path, implode("\n", $rows));
        $this->info("Dataset exported to storage/app/{$path}");
    }
}
