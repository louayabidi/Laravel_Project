<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    protected $fillable = ['name','title','description','image','criteria','badge_categorie_id'];

    // explicitly set the foreign key
    public function badgeCategorie()
    {
        return $this->belongsTo(BadgeCategorie::class, 'badge_categorie_id');
    }
}

