<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use App\Models\Objectif;

class HuggingFaceController extends Controller
{
    public function generateAIResume($userId)
    {
        try {
            \Log::info("=== DÉBUT GÉNÉRATION RÉSUMÉ USER {$userId} ===");
            
            $user = User::with(['objectifs.habitudes'])->findOrFail($userId);
            $promptData = $this->preparePromptData($user);
            
            \Log::info("Données préparées:", ['objectifs_count' => count($promptData['objectifs'])]);
            
            // Si pas d'objectifs, retourner directement le fallback
            if (empty($promptData['objectifs'])) {
                \Log::warning("Aucun objectif trouvé pour l'utilisateur {$userId}");
                return $this->generateNoDataResponse($user);
            }

            $prompt = $this->buildPrompt($promptData);
            
            \Log::info("Prompt préparé, longueur: " . strlen($prompt));

            // Appel Hugging Face
            $aiResponse = $this->callHuggingFaceAPI($prompt);
            
            // Analyser la réponse avec les données en fallback
            $parsedResponse = $this->parseAIResponse($aiResponse, $promptData);
            
            \Log::info("=== RÉSUMÉ HUGGING FACE RÉUSSI ===");

            return response()->json([
                'success' => true,
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email
                ],
                'resume_ia' => $parsedResponse['resume'],
                'analyse_profonde' => $parsedResponse['analysis'],

                'timestamp' => now()->toDateTimeString(),
                'source' => 'hugging_face'
            ]);

        } catch (\Exception $e) {
            \Log::error("=== ERREUR HUGGING FACE: " . $e->getMessage() . " ===");
            
            // Fallback avec les données même en cas d'erreur
            $user = User::find($userId);
            $promptData = $user ? $this->preparePromptData($user) : ['objectifs' => []];
            $fallbackResponse = $this->generateSmartFallback($promptData['objectifs'] ?? []);
            
            return response()->json([
                'success' => true,
                'user' => [
                    'name' => $user->name ?? 'Utilisateur',
                    'email' => $user->email ?? 'N/A'
                ],
                'resume_ia' => $fallbackResponse['resume'],
                'analyse_profonde' => $fallbackResponse['analysis'],
                'timestamp' => now()->toDateTimeString(),
                'source' => 'fallback_simple'
            ], 200);
        }
    }

    private function preparePromptData($user)
    {
        \Log::info("=== PRÉPARATION DONNÉES USER {$user->id} ===");
        \Log::info("User objectifs count: " . $user->objectifs->count());
        
        $objectifsData = [];
        
        foreach ($user->objectifs as $index => $objectif) {
            \Log::info("Objectif {$index}: {$objectif->title} - {$objectif->status}");
            \Log::info("Habitudes count: " . $objectif->habitudes->count());
            
            $habitudes = $objectif->habitudes;
            
            $stats = [
                'total_habitudes' => $habitudes->count(),
                'moyenne_sommeil' => round($habitudes->avg('sommeil_heures') ?? 0, 1),
                'moyenne_sport' => round($habitudes->avg('sport_minutes') ?? 0, 0),
                'moyenne_stress' => round($habitudes->avg('stress_niveau') ?? 0, 1),
                'moyenne_meditation' => round($habitudes->avg('meditation_minutes') ?? 0, 0),
                'moyenne_eau' => round($habitudes->avg('eau_litres') ?? 0, 1),
            ];
            
            \Log::info("Stats calculées:", $stats);
            
            $objectifsData[] = [
                'titre' => $objectif->title,
                'type' => $objectif->status,
                'date_debut' => $objectif->start_date,
                'date_fin' => $objectif->end_date,
                'statistiques' => $stats,
                'jours_ecoules' => \Carbon\Carbon::parse($objectif->start_date)->diffInDays(now()),
                'jours_total' => \Carbon\Carbon::parse($objectif->start_date)->diffInDays($objectif->end_date)
            ];
        }

        \Log::info("Objectifs data préparés:", ['count' => count($objectifsData)]);

        return [
            'user' => [
                'nom' => $user->name,
                'date_inscription' => $user->created_at ? $user->created_at->format('d/m/Y') : 'Date inconnue',
            ],
            'objectifs' => $objectifsData,
            'date_analyse' => now()->format('d/m/Y H:i')
        ];
    }

    private function buildPrompt($data)
    {
        $user = $data['user'];
        $objectifs = $data['objectifs'];
        
        // Construction des données d'objectifs
        $objectifsText = "";
        foreach ($objectifs as $obj) {
            $pourcentage = $obj['jours_total'] > 0 ? 
                round(($obj['jours_ecoules'] / $obj['jours_total']) * 100) : 0;
                
            $objectifsText .= "
## {$obj['titre']} ({$obj['type']})
- Période: {$obj['jours_ecoules']}/{$obj['jours_total']} jours ({$pourcentage}%)
- Habitudes enregistrées: {$obj['statistiques']['total_habitudes']}
- Métriques moyennes:
  * Sommeil: {$obj['statistiques']['moyenne_sommeil']} heures
  * Eau: {$obj['statistiques']['moyenne_eau']} litres  
  * Sport: {$obj['statistiques']['moyenne_sport']} minutes
  * Stress: {$obj['statistiques']['moyenne_stress']}/10
  * Méditation: {$obj['statistiques']['moyenne_meditation']} minutes
";
        }

        $prompt = "Analyse les données de suivi santé suivantes et génère un rapport pour administrateur:

UTILISATEUR: {$user['nom']}
INSCRIT LE: {$user['date_inscription']}

OBJECTIFS ET HABITUDES:
{$objectifsText}

Génère un rapport concis avec:

RESUME: [2-3 phrases sur l'engagement global et la régularité]
ANALYSE: [2-3 points forts ou faibles observables dans les données]  

Réponse attendue:";

        return $prompt;
    }

    private function callHuggingFaceAPI($prompt)
    {
        $apiKey = env('HUGGINGFACE_API_KEY');
        $model = env('HUGGINGFACE_MODEL');
        $baseUrl = env('HUGGINGFACE_API_URL');

        if (!$apiKey || !$model || !$baseUrl) {
            throw new \Exception('Clés de configuration Hugging Face manquantes.');
        }

        $url = rtrim($baseUrl, '/') . '/' . $model;

        $response = Http::withOptions(['verify' => false])
            ->withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json'
            ])
            ->timeout(60)
            ->post($url, [
                'inputs' => $prompt,
                'parameters' => [
                    'max_new_tokens' => 300,
                    'temperature' => 0.7,
                ]
            ]);

        if ($response->failed()) {
            throw new \Exception('Erreur Hugging Face: ' . $response->body());
        }

        return $response->json();
    }

    private function parseAIResponse($aiResponse, $promptData = [])
    {
        \Log::info("Parsing réponse Hugging Face...");

        $text = $this->extractTextFromResponse($aiResponse);
        
        \Log::info("Texte brut: " . substr($text, 0, 300));

        // Nettoyer la réponse
        $cleanText = $this->removePromptRepetition($text);
        
        // Vérifier si le format est respecté
        $hasValidFormat = strpos($cleanText, 'RESUME:') !== false && 
                         strpos($cleanText, 'ANALYSE:') !== false;
        
        if (!$hasValidFormat || empty(trim(str_replace(['RESUME:', 'ANALYSE:'], '', $cleanText)))) {
            \Log::warning("Format non respecté ou réponse vide, génération de fallback");
            return $this->generateSmartFallback($promptData['objectifs'] ?? []);
        }

        // Extraire les sections
        $sections = $this->extractSections($cleanText);
        
        return $sections;
    }

    private function extractTextFromResponse($aiResponse)
    {
        if (isset($aiResponse[0]['generated_text'])) {
            return $aiResponse[0]['generated_text'];
        }
        if (isset($aiResponse['generated_text'])) {
            return $aiResponse['generated_text'];
        }
        if (isset($aiResponse[0]['summary_text'])) {
            return $aiResponse[0]['summary_text'];
        }
        if (is_string($aiResponse)) {
            return $aiResponse;
        }
        
        return json_encode($aiResponse);
    }

    private function removePromptRepetition($text)
    {
        // Supprimer les parties qui répètent le prompt
        $promptKeywords = [
            "Tu dois répondre EXACTEMENT",
            "INSTRUCTIONS STRICTES:", 
            "Génère un rapport concis",
            "Analyse les données de suivi",
            "Réponse attendue:"
        ];
        
        foreach ($promptKeywords as $keyword) {
            $pos = strpos($text, $keyword);
            if ($pos !== false) {
                // Garder seulement ce qui vient avant la répétition du prompt
                $text = substr($text, 0, $pos);
                break;
            }
        }
        
        return trim($text);
    }

    private function extractSections($text)
    {
        $sections = [
            'resume' => "Section 'RESUME:' non trouvée",
            'analysis' => "Section 'ANALYSE:' non trouvée", 
        ];

        // Pattern pour trouver les sections
        $patterns = [
            'resume' => '/RESUME:\s*(.*?)(?=ANALYSE:|$)/s',
            'analysis' => '/ANALYSE:\s*(.*?)/s',
        ];

        foreach ($patterns as $key => $pattern) {
            if (preg_match($pattern, $text, $matches)) {
                $sections[$key] = trim($matches[1]);
            }
        }

        return $sections;
    }

    private function generateSmartFallback($objectifs)
    {
        if (empty($objectifs)) {
            return [
                'resume' => "Aucun objectif ou habitude enregistré pour le moment.",
                'analysis' => "L'utilisateur n'a pas encore créé d'objectifs de suivi santé.",
                'recommendations' => "Suggérer la création d'objectifs personnalisés pour commencer le suivi."
            ];
        }

        // Analyser les données pour générer un rapport basique
        $totalHabitudes = array_sum(array_column(array_column($objectifs, 'statistiques'), 'total_habitudes'));
        $moyenneSommeil = round(array_sum(array_column(array_column($objectifs, 'statistiques'), 'moyenne_sommeil')) / count($objectifs), 1);
        $moyenneStress = round(array_sum(array_column(array_column($objectifs, 'statistiques'), 'moyenne_stress')) / count($objectifs), 1);
        $moyenneSport = round(array_sum(array_column(array_column($objectifs, 'statistiques'), 'moyenne_sport')) / count($objectifs), 0);
        $moyenneEau = round(array_sum(array_column(array_column($objectifs, 'statistiques'), 'moyenne_eau')) / count($objectifs), 1);

        $resume = "Utilisateur avec " . count($objectifs) . " objectifs et {$totalHabitudes} habitudes enregistrées. ";
        $resume .= "Sommeil moyen: {$moyenneSommeil}h, Sport: {$moyenneSport}min, Stress: {$moyenneStress}/10, Eau: {$moyenneEau}L.";

        $analysis = "• " . count($objectifs) . " objectifs suivis\n";
        $analysis .= "• {$totalHabitudes} entrées d'habitudes enregistrées\n";
        $analysis .= "• Données complètes: sommeil, activité, hydratation et stress";

        $recommendations = "• Encourager la régularité dans le suivi quotidien\n";
        $recommendations .= "• Vérifier la cohérence des données enregistrées\n";
        $recommendations .= "• Proposer des objectifs spécifiques selon les besoins";

        return [
            'resume' => $resume,
            'analysis' => $analysis,
            'recommendations' => $recommendations
        ];
    }

    private function generateNoDataResponse($user)
    {
        return response()->json([
            'success' => true,
            'user' => [
                'name' => $user->name,
                'email' => $user->email
            ],
            'resume_ia' => "Aucun objectif ou habitude enregistré pour le moment.",
            'analyse_profonde' => "L'utilisateur n'a pas encore créé d'objectifs de suivi santé.",
            'timestamp' => now()->toDateTimeString(),
            'source' => 'no_data'
        ]);
    }
}