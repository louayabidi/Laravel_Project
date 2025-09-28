<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MealFood extends Model
{
    use HasFactory;

    protected $table = 'meal_foods';

    protected $fillable = [
        'meal_id', 'food_id', 'quantity', 'calories_total', 'protein_total', 'carbs_total', 'fat_total'
    ];

    public function meal()
    {
        return $this->belongsTo(Meal::class);
    }

    public function food()
    {
        return $this->belongsTo(Food::class);
    }
}
