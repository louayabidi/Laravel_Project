<?php

namespace App\Services;

use App\Models\SanteMesure;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class HealthAnalysisService
{
    protected AiRecommendationServiceLocal $aiService;

    public function __construct(AiRecommendationServiceLocal $aiService = null)
    {
        $this->aiService = $aiService ?? app(AiRecommendationServiceLocal::class);
    }
    /**
     * Analyze health trends and detect anomalies for a user
     */
    public function analyzeHealthTrends(User $user, int $days = 30): array
    {
        $alerts = [];
        $recommendations = [];

        // Get measurements from the last N days
        $measurements = $user->santeMesures()
            ->where('date_mesure', '>=', Carbon::now()->subDays($days))
            ->orderBy('date_mesure')
            ->get();

        if ($measurements->count() < 3) {
            return [
                'alerts' => [],
                'recommendations' => ['Pas assez de données pour une analyse fiable. Continuez à saisir vos mesures régulièrement.']
            ];
        }

        // Analyze each health parameter
        $alerts = array_merge($alerts, $this->analyzeBloodPressure($measurements));
        $alerts = array_merge($alerts, $this->analyzeHeartRate($measurements));
        $alerts = array_merge($alerts, $this->analyzeWeight($measurements));
        $alerts = array_merge($alerts, $this->analyzeBMI($measurements));

        // Generate recommendations based on alerts and current regime
        $recommendations = $this->generateRecommendations($alerts, $measurements, $user);

        return [
            'alerts' => $alerts,
            'recommendations' => $recommendations
        ];
    }

    /**
     * Analyze blood pressure trends
     */
    private function analyzeBloodPressure($measurements): array
    {
        $alerts = [];

        $systolicValues = $measurements->pluck('tension_systolique')->toArray();
        $diastolicValues = $measurements->pluck('tension_diastolique')->toArray();

        $avgSystolic = array_sum($systolicValues) / count($systolicValues);
        $avgDiastolic = array_sum($diastolicValues) / count($diastolicValues);

        // Check for hypertension risk (WHO standards)
        if ($avgSystolic > 140 || $avgDiastolic > 90) {
            $alerts[] = [
                'type' => 'danger',
                'parameter' => 'tension',
                'message' => "Votre tension moyenne est de " . round($avgSystolic) . "/" . round($avgDiastolic) . " mmHg, supérieure aux normes OMS (>140/90). Risque d'hypertension détecté.",
                'severity' => 'high'
            ];
        }

        // Check for recent increase
        if (count($systolicValues) > 7) {
            $recentAvg = array_sum(array_slice($systolicValues, -7)) / 7;
            $olderCount = count($systolicValues) - 7;
            
            if ($olderCount > 0) {
                $olderAvg = array_sum(array_slice($systolicValues, 0, -7)) / $olderCount;

                if ($olderAvg > 0 && (($recentAvg - $olderAvg) / $olderAvg) > 0.15) {
                    $alerts[] = [
                        'type' => 'warning',
                        'parameter' => 'tension',
                        'message' => "Votre tension a augmenté de " . round((($recentAvg - $olderAvg) / $olderAvg) * 100) . "% ces derniers jours. Surveillez attentivement.",
                        'severity' => 'medium'
                    ];
                }
            }
        }

        return $alerts;
    }

    /**
     * Analyze heart rate trends
     */
    private function analyzeHeartRate($measurements): array
    {
        $alerts = [];

        $heartRateValues = $measurements->pluck('freq_cardiaque')->toArray();
        $avgHeartRate = array_sum($heartRateValues) / count($heartRateValues);

        // Check for abnormal heart rate
        if ($avgHeartRate > 100) {
            $alerts[] = [
                'type' => 'warning',
                'parameter' => 'freq_cardiaque',
                'message' => "Votre fréquence cardiaque moyenne est de " . round($avgHeartRate) . " bpm, supérieure à la normale (>100 bpm).",
                'severity' => 'medium'
            ];
        } elseif ($avgHeartRate < 60) {
            $alerts[] = [
                'type' => 'warning',
                'parameter' => 'freq_cardiaque',
                'message' => "Votre fréquence cardiaque moyenne est de " . round($avgHeartRate) . " bpm, inférieure à la normale (<60 bpm).",
                'severity' => 'medium'
            ];
        }

        return $alerts;
    }

    /**
     * Analyze weight trends
     */
    private function analyzeWeight($measurements): array
    {
        $alerts = [];

        $weightValues = $measurements->pluck('poids_kg')->toArray();

        if (count($weightValues) >= 14) {
            $recentWeights = array_slice($weightValues, -14);
            $olderWeights = array_slice($weightValues, 0, -14);

            $recentAvg = array_sum($recentWeights) / count($recentWeights);
            $olderAvg = array_sum($olderWeights) / count($olderWeights);

            $changePercent = (($recentAvg - $olderAvg) / $olderAvg) * 100;

            if (abs($changePercent) > 5) {
                $direction = $changePercent > 0 ? 'augmenté' : 'diminué';
                $alerts[] = [
                    'type' => 'info',
                    'parameter' => 'poids',
                    'message' => "Votre poids a " . $direction . " de " . round(abs($changePercent), 1) . "% ces deux dernières semaines.",
                    'severity' => 'low'
                ];
            }
        }

        return $alerts;
    }

    /**
     * Analyze BMI trends
     */
    private function analyzeBMI($measurements): array
    {
        $alerts = [];

        $bmiValues = $measurements->pluck('imc')->toArray();
        $avgBMI = array_sum($bmiValues) / count($bmiValues);

        if ($avgBMI > 30) {
            $alerts[] = [
                'type' => 'danger',
                'parameter' => 'imc',
                'message' => "Votre IMC moyen est de " . round($avgBMI, 1) . ", indiquant une obésité. Risque élevé pour la santé.",
                'severity' => 'high'
            ];
        } elseif ($avgBMI > 25) {
            $alerts[] = [
                'type' => 'warning',
                'parameter' => 'imc',
                'message' => "Votre IMC moyen est de " . round($avgBMI, 1) . ", indiquant un surpoids.",
                'severity' => 'medium'
            ];
        } elseif ($avgBMI < 18.5) {
            $alerts[] = [
                'type' => 'warning',
                'parameter' => 'imc',
                'message' => "Votre IMC moyen est de " . round($avgBMI, 1) . ", indiquant une insuffisance pondérale.",
                'severity' => 'medium'
            ];
        }

        return $alerts;
    }

    /**
     * Generate personalized recommendations based on alerts and current regime
     */
    private function generateRecommendations($alerts, $measurements, $user): array
    {
        $recommendations = [];

        $alertParameters = array_column($alerts, 'parameter');

        // Get current regime from latest measurement
        $currentRegime = $measurements->last()?->regime;

        // Try AI-powered recommendations first
        $aiRecommendations = $this->generateAiRecommendations($measurements, $currentRegime?->type_regime);
        if (!empty($aiRecommendations)) {
            $recommendations = array_merge($recommendations, $aiRecommendations);
        } else {
            // Fallback to rule-based recommendations
            Log::info('AI recommendations not available, using rule-based system');

            // Generate regime-specific recommendations
            if ($currentRegime) {
                $regimeRecommendations = $this->generateRegimeSpecificRecommendations($currentRegime, $alerts, $measurements);
                $recommendations = array_merge($recommendations, $regimeRecommendations);
            } else {
                // Only show general regime recommendations if no specific regime is selected
                $generalRegimeRecommendations = $this->generateRegimeRecommendations($alerts, $measurements);
                $recommendations = array_merge($recommendations, $generalRegimeRecommendations);
            }
        }

        if (in_array('tension', $alertParameters)) {
            $recommendations[] = "Réduisez votre consommation de sel et consultez votre médecin pour surveiller votre tension.";
            $recommendations[] = "Pratiquez une activité physique régulière et gérez votre stress.";
        }

        if (in_array('freq_cardiaque', $alertParameters)) {
            $recommendations[] = "Consultez un cardiologue pour un bilan complet.";
            $recommendations[] = "Évitez les stimulants comme la caféine en excès.";
        }

        if (in_array('imc', $alertParameters)) {
            $recommendations[] = "Adoptez une alimentation équilibrée et consultez un nutritionniste.";
            $recommendations[] = "Combinez régime alimentaire et activité physique pour atteindre un poids santé.";
        }

        if (in_array('poids', $alertParameters)) {
            $recommendations[] = "Surveillez votre évolution pondérale et consultez un professionnel de santé si nécessaire.";
        }

        // General recommendations
        if (empty($alerts)) {
            $recommendations[] = "Vos mesures sont dans les normes. Continuez vos bonnes habitudes !";
        } else {
            $recommendations[] = "Poursuivez le suivi régulier de vos mesures de santé.";
        }

        return array_unique($recommendations);
    }

    /**
     * Generate regime-specific recommendations based on current regime
     */
    private function generateRegimeSpecificRecommendations($regime, $alerts, $measurements): array
    {
        $recommendations = [];
        $regimeType = $regime->type_regime;
        $targetValue = $regime->valeur_cible;

        // Calculate current averages
        $avgWeight = 0;
        $avgBMI = 0;
        $avgSystolic = 0;
        $avgDiastolic = 0;

        if (!empty($measurements)) {
            $weightValues = $measurements->pluck('poids_kg')->toArray();
            $bmiValues = $measurements->pluck('imc')->toArray();
            $systolicValues = $measurements->pluck('tension_systolique')->toArray();
            $diastolicValues = $measurements->pluck('tension_diastolique')->toArray();

            if (!empty($weightValues)) $avgWeight = array_sum($weightValues) / count($weightValues);
            if (!empty($bmiValues)) $avgBMI = array_sum($bmiValues) / count($bmiValues);
            if (!empty($systolicValues)) $avgSystolic = array_sum($systolicValues) / count($systolicValues);
            if (!empty($diastolicValues)) $avgDiastolic = array_sum($diastolicValues) / count($diastolicValues);
        }

        switch ($regimeType) {
            case 'Diabète':
                $recommendations[] = "🍎 Régime Diabète - Objectif: " . $targetValue . "kg";
                $recommendations[] = "Contrôlez vos glucides : privilégiez les légumes verts, les légumineuses et les céréales complètes.";
                $recommendations[] = "Évitez les sucres raffinés et les aliments à index glycémique élevé.";
                if ($avgBMI > 25) {
                    $recommendations[] = "Votre IMC actuel (" . round($avgBMI, 1) . ") nécessite une surveillance particulière du poids.";
                }
                break;

            case 'Hypertension':
                $recommendations[] = "🏥 Régime Hypertension - Contrôlez votre tension artérielle";
                $recommendations[] = "Réduisez le sel : maximum 6g par jour. Évitez les aliments transformés.";
                $recommendations[] = "Augmentez potassium : consommez bananes, épinards, avocats, tomates.";
                if ($avgSystolic > 140 || $avgDiastolic > 90) {
                    $recommendations[] = "⚠️ Votre tension moyenne (" . round($avgSystolic) . "/" . round($avgDiastolic) . ") dépasse les normes.";
                }
                break;

            case 'Grossesse':
                $recommendations[] = "🤰 Régime de Grossesse - Objectif: " . $targetValue . "kg";
                $recommendations[] = "Augmentez vos apports en fer, calcium, acide folique et protéines.";
                $recommendations[] = "Consommez des produits laitiers, viandes maigres, légumes verts et fruits.";
                $recommendations[] = "Évitez les aliments crus, les fromages non pasteurisés et certains poissons.";
                break;

            case 'Cholestérol élevé (hypercholestérolémie)':
                $recommendations[] = "🥑 Régime Anticholestérol - Réduisez votre cholestérol sanguin";
                $recommendations[] = "Privilégiez les graisses insaturées : huile d'olive, avocats, noix.";
                $recommendations[] = "Limitez viandes rouges et produits laitiers entiers.";
                $recommendations[] = "Augmentez fibres solubles : avoine, légumineuses, fruits.";
                break;

            case 'Maladie cœliaque (intolérance au gluten)':
                $recommendations[] = "🌾 Régime Sans Gluten - Évitez complètement le gluten";
                $recommendations[] = "Aliments autorisés : riz, maïs, quinoa, sarrasin, légumes, fruits, viandes, poissons.";
                $recommendations[] = "Évitez : blé, orge, seigle, avoine (sauf certifiée sans gluten).";
                $recommendations[] = "Vérifiez les étiquettes : gluten peut se cacher dans sauces et produits transformés.";
                break;

            case 'Insuffisance rénale':
                $recommendations[] = "🫘 Régime Rénal - Protégez vos reins";
                $recommendations[] = "Limitez protéines : privilégiez viandes blanches, poissons, œufs.";
                $recommendations[] = "Contrôlez potassium : évitez bananes, oranges, pommes de terre, tomates.";
                $recommendations[] = "Réduisez phosphore : limitez produits laitiers et noix.";
                break;

            default:
                $recommendations[] = "Régime " . $regimeType . " - Suivez les recommandations de votre médecin.";
                break;
        }

        // Add progress tracking if target weight is set
        if ($targetValue && !empty($measurements)) {
            $currentWeight = $measurements->last()->poids_kg;
            $weightDifference = round($currentWeight - $targetValue, 1);
            if (abs($weightDifference) > 0.1) { // Changed from > 1 to > 0.1 for more precision
                $direction = $weightDifference > 0 ? 'perdre' : 'prendre';
                $recommendations[] = "📊 Objectif poids : " . number_format(abs($weightDifference), 1, ',', '') . " kg à " . $direction . " pour atteindre " . number_format($targetValue, 1, ',', '') . " kg.";
            } else {
                $recommendations[] = "✅ Félicitations ! Vous êtes proche de votre objectif de poids (" . number_format($targetValue, 1, ',', '') . " kg).";
            }
        }

        return $recommendations;
    }

    /**
     * Generate general regime recommendations based on health analysis
     */
    private function generateRegimeRecommendations($alerts, $measurements): array
    {
        $recommendations = [];

        $alertParameters = array_column($alerts, 'parameter');
        $avgSystolic = 0;
        $avgDiastolic = 0;
        $avgBMI = 0;

        // Calculate averages for decision making
        if (!empty($measurements)) {
            $systolicValues = $measurements->pluck('tension_systolique')->toArray();
            $diastolicValues = $measurements->pluck('tension_diastolique')->toArray();
            $bmiValues = $measurements->pluck('imc')->toArray();

            if (!empty($systolicValues)) {
                $avgSystolic = array_sum($systolicValues) / count($systolicValues);
            }
            if (!empty($diastolicValues)) {
                $avgDiastolic = array_sum($diastolicValues) / count($diastolicValues);
            }
            if (!empty($bmiValues)) {
                $avgBMI = array_sum($bmiValues) / count($bmiValues);
            }
        }

        // Hypertension detected - recommend hypertension regime
        if (in_array('tension', $alertParameters) && ($avgSystolic > 140 || $avgDiastolic > 90)) {
            $recommendations[] = "🏥 Régime recommandé : Hypertension - Adoptez un régime pauvre en sel avec des aliments riches en potassium (bananes, épinards, avocats).";
        }

        // High BMI - recommend appropriate regime based on severity
        if (in_array('imc', $alertParameters)) {
            if ($avgBMI > 30) {
                $recommendations[] = "⚠️ IMC élevé détecté - Un régime adapté à votre profil de santé serait bénéfique. Consultez un nutritionniste pour un régime personnalisé.";
            } elseif ($avgBMI > 25) {
                $recommendations[] = "⚠️ Surpoids détecté - Considérez un régime équilibré pour atteindre un poids santé.";
            } elseif ($avgBMI < 18.5) {
                $recommendations[] = "⚠️ Insuffisance pondérale - Un régime enrichi pourrait être nécessaire pour atteindre un poids normal.";
            }
        }

        // Diabetes risk indicators
        $diabetesRisk = false;
        if ($avgBMI > 25 && ($avgSystolic > 130 || $avgDiastolic > 85)) {
            $diabetesRisk = true;
        }

        if ($diabetesRisk) {
            $recommendations[] = "🩸 Risque de diabète détecté - Un régime diabétique avec contrôle des glucides serait adapté à votre profil.";
        }

        // Kidney issues - recommend renal regime
        if (in_array('tension', $alertParameters) && $avgSystolic > 140) {
            $recommendations[] = "🫘 Pour protéger vos reins, un régime rénal pauvre en protéines et phosphore pourrait être bénéfique.";
        }

        // High cholesterol indicators (based on BMI and tension correlation)
        if ($avgBMI > 25 && count($measurements) >= 5) {
            $recommendations[] = "🥑 Votre profil suggère un risque cardiovasculaire - Un régime anticholestérol riche en fibres et pauvre en graisses saturées serait adapté.";
        }

        // Pregnancy considerations (if BMI indicates pregnancy weight)
        // This is a simplified detection - in real app would need pregnancy status
        if ($avgBMI > 20 && $avgBMI < 35 && !in_array('tension', $alertParameters)) {
            $recommendations[] = "🤰 Si vous êtes enceinte, un régime prénatal équilibré est essentiel pour votre santé et celle de bébé.";
        }

        // Celiac disease consideration (would need symptom tracking in real app)
        $recommendations[] = "🌾 Si vous présentez des symptômes digestifs, un régime sans gluten pourrait améliorer votre confort intestinal.";

        return $recommendations;
    }

    /**
     * Generate AI-powered recommendations
     */
    private function generateAiRecommendations($measurements, string $regimeType = null): array
    {
        try {
            // Prepare health data for AI analysis
            $healthData = $this->prepareHealthDataForAI($measurements);

            // Get AI recommendations
            $aiRecommendations = $this->aiService->generateHealthRecommendations($healthData, $regimeType);

            // Convert to expected format
            return array_map(function($rec) {
                return $rec['message'];
            }, $aiRecommendations);

        } catch (\Exception $e) {
            Log::error('Failed to generate AI recommendations', [
                'error' => $e->getMessage(),
                'regime_type' => $regimeType
            ]);
            return [];
        }
    }

    /**
     * Prepare health data for AI analysis
     */
    private function prepareHealthDataForAI($measurements): array
    {
        if ($measurements->isEmpty()) {
            return [];
        }

        $latest = $measurements->last();
        $weightHistory = $measurements->pluck('poids_kg')->take(-3)->toArray(); // Last 3 measurements

        // Calculate trends
        $trends = 'stable';
        if (count($weightHistory) >= 2) {
            $first = $weightHistory[0];
            $last = end($weightHistory);
            $change = (($last - $first) / $first) * 100;

            if ($change > 2) $trends = 'increasing';
            elseif ($change < -2) $trends = 'decreasing';
        }

        return [
            'current_weight' => $latest->poids_kg,
            'height' => $latest->taille_cm,
            'bmi' => $latest->imc,
            'target_weight' => $latest->regime?->valeur_cible ?? null,
            'weight_history' => $weightHistory,
            'trends' => $trends,
            'blood_pressure' => [
                'systolic' => $latest->tension_systolique,
                'diastolic' => $latest->tension_diastolique
            ],
            'heart_rate' => $latest->freq_cardiaque,
            'measurement_count' => $measurements->count()
        ];
    }

    /**
     * Calculate z-score for anomaly detection
     */
    private function calculateZScore($value, $values): float
    {
        $mean = array_sum($values) / count($values);
        $variance = 0;

        foreach ($values as $val) {
            $variance += pow($val - $mean, 2);
        }

        $variance /= count($values);
        $stdDev = sqrt($variance);

        if ($stdDev == 0) {
            return 0;
        }

        return ($value - $mean) / $stdDev;
    }
}
