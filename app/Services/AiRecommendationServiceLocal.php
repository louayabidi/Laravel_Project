<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class AiRecommendationServiceLocal
{
    protected $config;

    public function __construct()
    {
        $this->config = [
            'model_dir' => base_path('ai_env/models'),
            'predict_script' => base_path('ai_env/predict_ensemble_simple.py'),
            'cache' => [
                'enabled' => true,
                'ttl' => 3600 // 1 heure
            ]
        ];
    }

    /**
     * Générer des recommandations de santé basées sur les données de l'utilisateur et le type de régime
     */
    public function generateHealthRecommendations(array $healthData, string $regimeType = null): array
    {
        try {
            // Vérifier le cache
            if ($this->config['cache']['enabled']) {
                $cacheKey = $this->generateCacheKey($healthData, $regimeType);
                $cached = Cache::get($cacheKey);
                if ($cached) {
                    Log::info('Local AI recommendations served from cache', [
                        'cache_key' => $cacheKey,
                        'regime_type' => $regimeType
                    ]);
                    return $cached;
                }
            }

            // Ajouter le type de régime aux données de santé
            $healthDataWithRegime = array_merge($healthData, [
                'regime_type' => $regimeType
            ]);

            // Appeler le script Python avec les données complètes
            $recommendations = $this->callPythonPredictor($healthDataWithRegime);

            // Mettre en cache
            if ($this->config['cache']['enabled']) {
                $cacheKey = $this->generateCacheKey($healthData, $regimeType);
                Cache::put($cacheKey, $recommendations, $this->config['cache']['ttl']);
            }

            // Logger avec détails
            Log::info('Local AI recommendations generated', [
                'regime_type' => $regimeType,
                'bmi' => $healthData['bmi'] ?? null,
                'tension_sys' => $healthData['tension_systolique'] ?? null,
                'recommendations_count' => count($recommendations),
                'model_used' => 'local_ml_model'
            ]);

            return $recommendations;

        } catch (\Exception $e) {
            Log::error('Local AI recommendation generation failed', [
                'error' => $e->getMessage(),
                'regime_type' => $regimeType,
                'health_data' => $healthData
            ]);

            return $this->getFallbackRecommendations($healthData, $regimeType);
        }
    }

    /**
     * Générer des recommandations avec tous les détails (prédictions individuelles, importance, explications)
     */
    public function generateHealthRecommendationsWithDetails(array $healthData, string $regimeType = null): array
    {
        try {
            // Ajouter le type de régime aux données de santé
            $healthDataWithRegime = array_merge($healthData, [
                'regime_type' => $regimeType
            ]);

            // Appeler le script Python
            $fullResponse = $this->callPythonPredictorFull($healthDataWithRegime);

            return $fullResponse;

        } catch (\Exception $e) {
            Log::error('Full AI recommendation generation failed', [
                'error' => $e->getMessage(),
                'regime_type' => $regimeType,
                'health_data' => $healthData
            ]);

            throw $e;
        }
    }

    /**
     * Appeler le script Python et retourner la réponse complète
     */
    protected function callPythonPredictorFull(array $healthData): array
    {
        $pythonScript = $this->config['predict_script'];
        $modelDir = $this->config['model_dir'];

        // Préparer les données
        $inputJson = json_encode($healthData);

        // Créer le processus Python
        $process = new Process([
            'python',
            $pythonScript,
            $inputJson,
            $modelDir
        ]);

        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        // Parser la sortie
        $output = $process->getOutput();
        $result = json_decode($output, true);

        if (!$result || !$result['success']) {
            throw new \Exception($result['error'] ?? 'Erreur de prédiction');
        }

        // Retourner la réponse complète avec tous les détails
        return $result;
    }

    /**
     * Appeler le script Python de prédiction avec ensemble de modèles
     */
    protected function callPythonPredictor(array $healthData): array
    {
        $pythonScript = $this->config['predict_script'];
        $modelDir = $this->config['model_dir'];

        // Préparer les données
        $inputJson = json_encode($healthData);

        // Créer le processus Python
        $process = new Process([
            'python',
            $pythonScript,
            $inputJson,
            $modelDir
        ]);

        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        // Parser la sortie
        $output = $process->getOutput();
        $result = json_decode($output, true);

        if (!$result || !$result['success']) {
            throw new \Exception($result['error'] ?? 'Erreur de prédiction');
        }

        // Retourner les recommandations avec métadonnées d'explainability
        $recommendations = $result['recommendations'] ?? [];
        
        // Ajouter les métadonnées du modèle ensemble
        foreach ($recommendations as &$rec) {
            $rec['model_type'] = 'ensemble';
            $rec['confidence'] = $result['confidence_percent'] ?? 'N/A';
        }

        return $recommendations;
    }

    /**
     * Générer une clé de cache
     */
    protected function generateCacheKey(array $healthData, ?string $regimeType): string
    {
        $dataHash = md5(json_encode($healthData));
        $regimeHash = md5($regimeType ?? 'default');
        return "ai_recommendations_{$dataHash}_{$regimeHash}";
    }

    /**
     * Recommandations par défaut en cas d'erreur
     */
    protected function getFallbackRecommendations(array $healthData, ?string $regimeType): array
    {
        $bmi = $healthData['bmi'] ?? 0;

        $recommendations = [];

        // Recommandations basées sur l'IMC
        if ($bmi > 30) {
            $recommendations[] = [
                'type' => 'weight',
                'message' => 'Votre IMC indique une obésité. Combinez régime alimentaire et activité physique.',
                'priority' => 'high',
                'source' => 'fallback'
            ];
        } elseif ($bmi > 25) {
            $recommendations[] = [
                'type' => 'weight',
                'message' => 'Votre IMC indique un surpoids. Une perte de poids progressive est recommandée.',
                'priority' => 'medium',
                'source' => 'fallback'
            ];
        }

        // Recommandations basées sur la tension
        $sys = $healthData['tension_systolique'] ?? 0;
        if ($sys > 140) {
            $recommendations[] = [
                'type' => 'blood_pressure',
                'message' => 'Votre tension artérielle est élevée. Consultez un médecin.',
                'priority' => 'high',
                'source' => 'fallback'
            ];
        }

        // Recommandations générales
        if (empty($recommendations)) {
            $recommendations[] = [
                'type' => 'general',
                'message' => 'Maintenez un mode de vie sain avec une alimentation équilibrée et de l\'exercice régulier.',
                'priority' => 'medium',
                'source' => 'fallback'
            ];
        }

        return $recommendations;
    }
}
