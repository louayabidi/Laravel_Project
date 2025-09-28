<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Analytic extends Model

{
    use HasFactory;

    protected $table = 'analytics';

    protected $fillable = [
        'user_id', 'daily_calories', 'protein', 'carbs', 'fat', 'week_start', 'week_end'
    ];
}