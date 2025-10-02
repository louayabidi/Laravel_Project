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


    public function getCaloriesAttribute()
    {
        return $this->calories_per_gram * 100;
    }

    public function getProteinAttribute()
    {
        return $this->protein_per_gram * 100;
    }

    public function getCarbsAttribute()
    {
        return $this->carbs_per_gram * 100;
    }

    public function getFatAttribute()
    {
        return $this->fat_per_gram * 100;
    }

    public function getSugarAttribute()
    {
        return $this->sugar_per_gram * 100;
    }

    public function getFiberAttribute()
    {
        return $this->fiber_per_gram * 100;
    }
}