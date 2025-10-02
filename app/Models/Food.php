<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;

    protected $table = 'foods';

    protected $fillable = [
        'name',
        'calories_per_gram',
        'protein_per_gram',
        'carbs_per_gram',
        'fat_per_gram',
        'sugar_per_gram',
        'fiber_per_gram',
    ];
}