<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;

class AiRecommendationService
{
    protected Client $client;
    protected array $config;

    public function __construct()
    {
        $this->config = config('ai');
        $this->client = new Client([
            'base_uri' => $this->config['openai']['base_url'],
            'timeout' => $this->config['openai']['timeout'],
            'headers' => [
                'Authorization' => 'Bearer ' . $this->config['openai']['api_key'],
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    /**
     * Génère des recommandations IA pour la santé
     */
    public function generateHealthRecommendations(array $healthData, string $regimeType = null): array
    {
        // Vérifier le cache
        if ($this->config['cache']['enabled']) {
            $cacheKey = $this->generateCacheKey($healthData, $regimeType);
            $cached = Cache::get($cacheKey);
            if ($cached) {
                Log::info('AI recommendations served from cache', ['cache_key' => $cacheKey]);
                return $cached;
            }
        }

        // Vérifier le rate limiting
        if ($this->config['rate_limiting']['enabled'] && !$this->checkRateLimit()) {
            Log::warning('AI rate limit exceeded, using fallback');
            return $this->getFallbackRecommendations($healthData, $regimeType);
        }

        try {
            // Anonymiser les données
            $anonymizedData = $this->anonymizeData($healthData);

            // Générer le prompt
            $prompt = $this->buildHealthPrompt($anonymizedData, $regimeType);

            // Appeler OpenAI
            $response = $this->callOpenAI($prompt);

            // Parser la réponse
            $recommendations = $this->parseRecommendations($response);

            // Mettre en cache
            if ($this->config['cache']['enabled']) {
                Cache::put($cacheKey, $recommendations, $this->config['cache']['ttl']);
            }

            // Logger
            if ($this->config['logging']['enabled']) {
                Log::info('AI recommendations generated', [
                    'regime_type' => $regimeType,
                    'recommendations_count' => count($recommendations),
                    'anonymized' => true
                ]);
            }

            return $recommendations;

        } catch (\Exception $e) {
            Log::error('AI recommendation generation failed', [
                'error' => $e->getMessage(),
                'regime_type' => $regimeType
            ]);

            return $this->getFallbackRecommendations($healthData, $regimeType);
        }
    }

    /**
     * Appelle l'API OpenAI
     */
    protected function callOpenAI(string $prompt): string
    {
        $payload = [
            'model' => $this->config['openai']['model'],
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'Vous êtes un expert en nutrition et santé. Fournissez des recommandations personnalisées, sécurisées et basées sur des données médicales. Répondez en français.'
                ],
                [
                    'role' => 'user',
                    'content' => $prompt
                ]
            ],
            'max_tokens' => $this->config['openai']['max_tokens'],
            'temperature' => $this->config['openai']['temperature'],
        ];

        $response = $this->client->post('/chat/completions', [
            'json' => $payload
        ]);

        $body = $response->getBody()->getContents();
        $data = json_decode($body, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::error('Failed to parse OpenAI JSON response', [
                'error' => json_last_error_msg(),
                'body' => $body
            ]);
            return '';
        }

        if (!isset($data['choices']) || !is_array($data['choices']) || empty($data['choices']) ||
            !isset($data['choices'][0]) || !isset($data['choices'][0]['message']['content'])) {
            Log::error('Invalid OpenAI response structure', [
                'response' => $data,
                'body' => $body
            ]);
            return '';
        }

        return $data['choices'][0]['message']['content'];
    }

    /**
     * Construit le prompt pour les recommandations santé
     */
    protected function buildHealthPrompt(array $healthData, string $regimeType = null): string
    {
        $prompt = "En tant qu'expert en nutrition et santé, analysez ces données de santé et fournissez des recommandations personnalisées :\n\n";

        $prompt .= "DONNÉES DE SANTÉ :\n";
        $prompt .= "- Poids actuel : {$healthData['current_weight']} kg\n";
        $prompt .= "- Taille : {$healthData['height']} cm\n";
        $prompt .= "- IMC : {$healthData['bmi']}\n";
        $prompt .= "- Objectif de poids : {$healthData['target_weight']} kg\n";
        $prompt .= "- Évolution du poids (3 dernières mesures) : " . implode(', ', $healthData['weight_history']) . " kg\n";
        $prompt .= "- Tendances : {$healthData['trends']}\n";

        if ($regimeType) {
            $prompt .= "\nCONDITION MÉDICALE : {$regimeType}\n";
            $prompt .= "Adaptez les recommandations spécifiquement pour cette condition médicale.\n";
        }

        $prompt .= "\nINSTRUCTIONS :\n";
        $prompt .= "1. Fournissez 3-5 recommandations concrètes et actionnables\n";
        $prompt .= "2. Prenez en compte la condition médicale si spécifiée\n";
        $prompt .= "3. Soyez encourageant et positif\n";
        $prompt .= "4. Incluez des conseils nutritionnels et d'activité physique\n";
        $prompt .= "5. Mentionnez les signes d'alerte à surveiller\n";
        $prompt .= "6. Structurez la réponse en points clairs\n";

        $prompt .= "\nRÉPONSE ATTENDUE :\n";
        $prompt .= "- Recommandation 1 : [texte]\n";
        $prompt .= "- Recommandation 2 : [texte]\n";
        $prompt .= "- etc.\n";

        return $prompt;
    }

    /**
     * Parse les recommandations depuis la réponse OpenAI
     */
    protected function parseRecommendations(string $response): array
    {
        $recommendations = [];

        // Parser les lignes commençant par "-"
        $lines = explode("\n", $response);
        foreach ($lines as $line) {
            $line = trim($line);
            if (str_starts_with($line, '-')) {
                $content = trim(substr($line, 1));
                if (!empty($content)) {
                    $recommendations[] = [
                        'type' => 'ai_generated',
                        'message' => $content,
                        'priority' => 'medium',
                        'source' => 'openai'
                    ];
                }
            }
        }

        // Si pas de recommandations parsées, créer une recommandation générale
        if (empty($recommendations)) {
            $recommendations[] = [
                'type' => 'ai_generated',
                'message' => 'Continuez à surveiller vos mesures de santé régulièrement. Consultez un professionnel de santé pour des conseils personnalisés.',
                'priority' => 'low',
                'source' => 'openai'
            ];
        }

        return $recommendations;
    }

    /**
     * Anonymise les données avant envoi à OpenAI
     */
    protected function anonymizeData(array $data): array
    {
        if (!$this->config['anonymization']['enabled']) {
            return $data;
        }

        $anonymized = $data;

        // Supprimer les données personnelles
        if ($this->config['anonymization']['remove_personal_data']) {
            unset($anonymized['user_id'], $anonymized['user_name'], $anonymized['email']);
        }

        // Hasher les identifiants si nécessaire
        if ($this->config['anonymization']['hash_identifiers']) {
            // Implémentation du hashage si nécessaire
        }

        return $anonymized;
    }

    /**
     * Vérifie les limites de taux
     */
    protected function checkRateLimit(): bool
    {
        $key = 'ai_requests_' . now()->format('Y-m-d-H-i');

        $maxAttempts = $this->config['rate_limiting']['max_requests_per_minute'];

        return !RateLimiter::tooManyAttempts($key, $maxAttempts);
    }

    /**
     * Génère une clé de cache
     */
    protected function generateCacheKey(array $healthData, string $regimeType = null): string
    {
        $dataHash = md5(json_encode([
            'weight' => $healthData['current_weight'],
            'height' => $healthData['height'],
            'target' => $healthData['target_weight'],
            'regime' => $regimeType,
            'trends' => $healthData['trends']
        ]));

        return $this->config['cache']['prefix'] . '_' . $dataHash;
    }

    /**
     * Recommandations de fallback en cas d'erreur IA
     */
    protected function getFallbackRecommendations(array $healthData, string $regimeType = null): array
    {
        $recommendations = [
            [
                'type' => 'fallback',
                'message' => 'Continuez à suivre vos mesures de santé régulièrement.',
                'priority' => 'low',
                'source' => 'system'
            ]
        ];

        if ($regimeType) {
            $recommendations[] = [
                'type' => 'fallback',
                'message' => "Pour votre condition {$regimeType}, consultez les recommandations générales de votre médecin.",
                'priority' => 'medium',
                'source' => 'system'
            ];
        }

        return $recommendations;
    }

    /**
     * Analyse les tendances de santé avec IA
     */
    public function analyzeHealthTrends(array $measurements): array
    {
        try {
            $prompt = $this->buildTrendAnalysisPrompt($measurements);
            $response = $this->callOpenAI($prompt);

            return [
                'analysis' => $response,
                'source' => 'ai',
                'confidence' => 'high'
            ];

        } catch (\Exception $e) {
            Log::error('AI trend analysis failed', ['error' => $e->getMessage()]);

            return [
                'analysis' => 'Analyse des tendances non disponible actuellement.',
                'source' => 'fallback',
                'confidence' => 'low'
            ];
        }
    }

    /**
     * Construit le prompt pour l'analyse des tendances
     */
    protected function buildTrendAnalysisPrompt(array $measurements): string
    {
        $prompt = "Analysez ces mesures de santé et identifiez les tendances :\n\n";

        foreach (array_slice($measurements, -10) as $index => $measurement) {
            $prompt .= "Mesure " . ($index + 1) . ": ";
            $prompt .= "Date: {$measurement['date']}, ";
            $prompt .= "Poids: {$measurement['poids_kg']}kg, ";
            $prompt .= "Taille: {$measurement['taille_cm']}cm\n";
        }

        $prompt .= "\nIdentifiez :\n";
        $prompt .= "1. La tendance générale du poids\n";
        $prompt .= "2. La régularité des mesures\n";
        $prompt .= "3. Les périodes de stabilité/changement\n";
        $prompt .= "4. Recommandations basées sur ces tendances\n";

        return $prompt;
    }
}
