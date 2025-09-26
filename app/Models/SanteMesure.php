<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SanteMesure extends Model
{
    use HasFactory;

    // Force Laravel à utiliser le nom exact de la table
    protected $table = 'sante_mesure';

    // Si tu veux remplir en mass-assignment
    protected $fillable = [
        'user_id',
        'date_mesure',
        'poids_kg',
        'taille_cm',
        'imc',
        'freq_cardiaque',
        'tension_systolique',
        'tension_diastolique',
        'remarque'
    ];
}
