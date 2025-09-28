<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SanteMesure extends Model
{
    use HasFactory;

    protected $table = 'sante_mesure';

    protected $fillable = [
        'user_id',
        'date_mesure',
        'poids_kg',
        'taille_cm',
        'imc',
        'freq_cardiaque',
        'tension_systolique',
        'tension_diastolique',
        'remarque',
        'regime_id'
    ];

    protected $casts = [
        'date_mesure' => 'date',
        'poids_kg' => 'decimal:2',
        'imc' => 'decimal:2',
    ];

    /**
     * Get the regime associated with the health measurement.
     */
    public function regime()
    {
        return $this->belongsTo(Regime::class);
    }

    /**
     * Get the user that owns the health measurement.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Calculate BMI automatically before saving
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($santeMesure) {
            if ($santeMesure->poids_kg && $santeMesure->taille_cm) {
                $taille_metres = $santeMesure->taille_cm / 100;
                $santeMesure->imc = round($santeMesure->poids_kg / ($taille_metres * $taille_metres), 2);
            }
        });
    }

    /**
     * Check if the measurement requires an alert
     */
    public function needsAlert()
    {
        return $this->isHighBloodPressure() ||
               $this->isAbnormalHeartRate() ||
               $this->isExtremeIMC();
    }

    /**
     * Get health recommendations based on current measurements
     */
    public function getRecommendations()
    {
        $recommendations = [];

        if ($this->imc > 25) {
            $recommendations[] = "Votre IMC est supérieur à la normale. Considérez une consultation avec un nutritionniste.";
        } elseif ($this->imc < 18.5) {
            $recommendations[] = "Votre IMC est inférieur à la normale. Assurez-vous d'avoir une alimentation équilibrée.";
        }

        if ($this->isHighBloodPressure()) {
            $recommendations[] = "Votre tension artérielle est élevée. Surveillez votre consommation de sel et consultez votre médecin.";
        }

        if ($this->isAbnormalHeartRate()) {
            $recommendations[] = "Votre fréquence cardiaque est anormale. Faites un suivi régulier.";
        }

        return $recommendations;
    }

    private function isHighBloodPressure()
    {
        return $this->tension_systolique > 140 || $this->tension_diastolique > 90;
    }

    private function isAbnormalHeartRate()
    {
        return $this->freq_cardiaque < 60 || $this->freq_cardiaque > 100;
    }

    private function isExtremeIMC()
    {
        return $this->imc < 16.5 || $this->imc > 30;
    }
}
