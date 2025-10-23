<?php

namespace App\Http\Controllers;

use App\Services\AiRecommendationServiceLocal;
use Illuminate\Http\Request;

class AiTestController extends Controller
{
    protected $aiService;

    public function __construct(AiRecommendationServiceLocal $aiService)
    {
        $this->aiService = $aiService;
    }

    public function index()
    {
        return view('ai-test.index');
    }

    public function test(Request $request)
    {
        $validated = $request->validate([
            'bmi' => 'required|numeric|min:10|max:60',
            'tension_systolique' => 'required|numeric|min:80|max:200',
            'tension_diastolique' => 'required|numeric|min:40|max:130',
            'freq_cardiaque' => 'required|numeric|min:40|max:150',
            'condition' => 'required|string',
        ]);

        try {
            $healthData = [
                'bmi' => (float) $validated['bmi'],
                'tension_systolique' => (int) $validated['tension_systolique'],
                'tension_diastolique' => (int) $validated['tension_diastolique'],
                'freq_cardiaque' => (int) $validated['freq_cardiaque'],
            ];

            $fullResponse = $this->aiService->generateHealthRecommendationsWithDetails(
                $healthData,
                $validated['condition']
            );

            return response()->json([
                'success' => true,
                'data' => $fullResponse,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function sample()
    {
        $samples = [
            [
                'name' => 'Diabète',
                'bmi' => 30,
                'tension_systolique' => 142,
                'tension_diastolique' => 92,
                'freq_cardiaque' => 86,
                'condition' => 'Diabète',
            ],
            [
                'name' => 'Hypertension',
                'bmi' => 25,
                'tension_systolique' => 160,
                'tension_diastolique' => 100,
                'freq_cardiaque' => 90,
                'condition' => 'Hypertension',
            ],
            [
                'name' => 'Normal',
                'bmi' => 22,
                'tension_systolique' => 120,
                'tension_diastolique' => 80,
                'freq_cardiaque' => 70,
                'condition' => 'Normal',
            ],
        ];

        return response()->json($samples);
    }
}
