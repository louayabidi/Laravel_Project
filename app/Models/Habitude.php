<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Habitude extends Model
{
    use HasFactory;

    protected $table = 'habitudes';
    protected $primaryKey = 'habitude_id'; 
    public $incrementing = true; 
    protected $keyType = 'int'; 

    protected $fillable = [
        'objectif_id',
        'date_jour',
        'sommeil_heures',
        'eau_litres',
        'sport_minutes',
        'stress_niveau',
        'meditation_minutes',
        'temps_ecran_minutes',
        'cafe_cups',
    ];

    

public function objectif()
    {
        return $this->belongsTo(Objectif::class, 'objectif_id', 'id');
    }

}
