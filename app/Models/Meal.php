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

    public function getTotals()
    {
        return $this->mealFoods->reduce(function ($carry, $mealFood) {
            return [
                'calories' => $carry['calories'] + $mealFood->calories_total,
                'protein' => $carry['protein'] + $mealFood->protein_total,
                'carbs' => $carry['carbs'] + $mealFood->carbs_total,
                'fat' => $carry['fat'] + $mealFood->fat_total,
                'sugar' => $carry['sugar'] + ($mealFood->sugar_total ?? 0),
                'fiber' => $carry['fiber'] + ($mealFood->fiber_total ?? 0),
            ];
        }, ['calories' => 0, 'protein' => 0, 'carbs' => 0, 'fat' => 0, 'sugar' => 0, 'fiber' => 0]);
    }
}