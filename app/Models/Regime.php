<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regime extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_regime',
        'valeur_cible',
        'description'
    ];

    public function santeMesures()
    {
        return $this->hasMany(SanteMesure::class);
    }
}
