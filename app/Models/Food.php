<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{


    protected $table = 'foods';
    use HasFactory;

    protected $fillable = [
        'name', 'category', 'calories', 'protein', 'carbs', 'fat', 'sugar', 'fiber', 'is_custom'
    ];

    public function mealFoods()
    {
        return $this->hasMany(MealFood::class);
    }
}
