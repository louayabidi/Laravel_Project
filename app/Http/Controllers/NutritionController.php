<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    protected $fillable = ['user_id', 'type', 'date'];

    public function mealFoods()
    {
        return $this->hasMany(MealFood::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getTotals()
    {
        $totals = [
            'calories' => 0,
            'protein' => 0,
            'carbs' => 0,
            'fat' => 0,
            'sugar' => 0,
            'fiber' => 0,
        ];

        foreach ($this->mealFoods as $mealFood) {
            $totals['calories'] += $mealFood->calories_total;
            $totals['protein'] += $mealFood->protein_total;
            $totals['carbs'] += $mealFood->carbs_total;
            $totals['fat'] += $mealFood->fat_total;
            $totals['sugar'] += $mealFood->sugar_total;
            $totals['fiber'] += $mealFood->fiber_total;
        }

        return $totals;
    }
}