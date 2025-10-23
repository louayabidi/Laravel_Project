<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Objectif;
use Illuminate\Support\Facades\Http;
use App\Models\User;
class IAObController extends Controller
{
    public function predict($id) 
    {
        $objectif = Objectif::find($id);
        
        if (!$objectif) {
            return response()->json([
                'message' => 'Objectif non trouvé'
            ], 404);
        }

        $habitudes = $objectif->habitudes;

        if ($habitudes->count() === 0) {
            return response()->json([
                'message' => 'Pas assez de données pour cet objectif'
            ], 400);
        }

        $data = [
            'avg_sommeil' => $habitudes->avg('sommeil_heures') ?? 0,
            'avg_eau' => $habitudes->avg('eau_litres') ?? 0,
            'avg_sport' => $habitudes->avg('sport_minutes') ?? 0,
            'avg_stress' => $habitudes->avg('stress_niveau') ?? 0,
            'avg_meditation' => $habitudes->avg('meditation_minutes') ?? 0,
            'avg_ecran' => $habitudes->avg('temps_ecran_minutes') ?? 0,
            'avg_cafe' => $habitudes->avg('cafe_cups') ?? 0,
        ];

        try {
            $response = Http::timeout(10)->post('http://host.docker.internal:5001/predict', $data);
            
            if (!$response->successful()) {
                throw new \Exception('Erreur HTTP: ' . $response->status());
            }
            
            $responseData = $response->json();

            if (!isset($responseData['probability'])) {
                return response()->json([
                    'message' => 'Le serveur ML n\'a pas renvoyé de probabilité',
                    'server_response' => $responseData
                ], 500);
            }

            return response()->json([
                'objectif' => $objectif->title,
                'probabilité_atteinte' => $responseData['probability'] . '%',
            ]);

        } catch (\Exception $e) {
            \Log::error('Erreur prédiction IA: ' . $e->getMessage());
            
            return response()->json([
                'message' => 'Erreur de communication avec le serveur ML',
                'error' => $e->getMessage()
            ], 500);
        }
    }


}