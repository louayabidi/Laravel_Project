<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Objectif extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','title', 'description',  'target_value', 'start_date', 'end_date', 'status'
    ];
    public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}

    public function habitudes()
    {
        return $this->hasMany(Habitude::class, 'objectif_id', 'id');
    }
    protected static function booted()
{
    static::deleting(function ($objectif) {
        $objectif->habitudes()->each(function ($habitude) {
            $habitude->delete();
        });
    });
}

public function calculateProgress(): float
{
    $column = match (strtolower($this->status)) {
        'sommeil' => 'sommeil_heures',
        'eau' => 'eau_litres',
        'sport' => 'sport_minutes',
        'stress' => 'stress_niveau',
        default => null,
    };

    if (!$column || !$this->target_value) return 0;

    $start = Carbon::parse($this->start_date);
    $end = Carbon::parse($this->end_date);
    $daysTotal = max(1, $start->diffInDays($end) + 1);

    $habitudes = $this->habitudes()->get()->keyBy('date_jour');

    $daysReached = 0;

    for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
        $dayStr = $date->toDateString();

        if (!isset($habitudes[$dayStr])) {
            continue; // aucun enregistrement → fail
        }

        $value = $habitudes[$dayStr]->{$column};

        if ($value === null) {
            continue; // valeur vide → fail
        }

        $success = match(strtolower($this->status)) {
            'stress' => $value <= $this->target_value,
            default => $value >= $this->target_value,
        };

        if ($success) {
            $daysReached++;
        }
    }

    $progress = ($daysReached / $daysTotal) * 100;

    return round(min(max($progress, 0), 100), 1);
}


}
