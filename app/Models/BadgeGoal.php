<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BadgeGoal extends Model
{
    use HasFactory;

    protected $fillable = [
        'badge_id',
        'field',
        'comparison',
        'value',
        'points',
    ];

    public function badge()
    {
        return $this->belongsTo(Badge::class);
    }
}
