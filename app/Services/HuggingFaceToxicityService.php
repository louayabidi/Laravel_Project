<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class HuggingFaceToxicityService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('HUGGINGFACE_API_KEY');
    }

    public function detectToxicity($text)
    {
        if (!$this->apiKey) {
            Log::warning('Hugging Face API key not set');
            return null;
        }

        try {
            $response = $this->client->post('https://api-inference.huggingface.co/models/unitary/toxic-bert', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => ['inputs' => $text],
                'timeout' => 30
            ]);

            $data = json_decode($response->getBody(), true);

            return $this->parseHuggingFaceResponse($data);

        } catch (\Exception $e) {
            Log::error('Hugging Face toxicity detection failed: ' . $e->getMessage());
            return null;
        }
    }

    private function parseHuggingFaceResponse($data)
    {
        if (!is_array($data) || empty($data[0])) {
            return null;
        }

        $results = [];
        foreach ($data[0] as $item) {
            $results[strtolower($item['label'])] = $item['score'];
        }

        return [
            'toxic' => $results['toxic'] ?? 0,
            'severe_toxic' => $results['severe_toxic'] ?? 0,
            'obscene' => $results['obscene'] ?? 0,
            'threat' => $results['threat'] ?? 0,
            'insult' => $results['insult'] ?? 0,
            'identity_hate' => $results['identity_hate'] ?? 0,
            'max_score' => max($results),
            'is_toxic' => $this->isToxicHuggingFace($results)
        ];
    }

    private function isToxicHuggingFace($scores, $threshold = 0.7)
    {
        return max($scores) > $threshold;
    }
}