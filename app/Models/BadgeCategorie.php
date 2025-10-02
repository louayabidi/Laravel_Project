<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BadgeCategorie extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'description','icon'
    ];

    public function badges()
    {
        return $this->hasMany(Badge::class);
    }
}
