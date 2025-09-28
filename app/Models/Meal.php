<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'type', 'date'
    ];

    public function mealFoods()
    {
        return $this->hasMany(MealFood::class);
    }
}
