<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class NutritionService
{
    public function searchFoods($query)
    {
        $response = Http::get('https://world.openfoodfacts.org/cgi/search.pl', [
            'search_terms' => $query,
            'search_simple' => 1,
            'json' => 1,
            'fields' => 'product_name,code',
            'page_size' => 10,
        ]);

        return collect($response->json()['products'] ?? [])->map(function ($product) {
            return [
                'id' => $product['code'] ?? uniqid(),
                'name' => $product['product_name'] ?? 'Unknown',
            ];
        })->toArray();
    }

    public function getNutritionDetails($foodName, $quantity)
    {
        $response = Http::get('https://world.openfoodfacts.org/cgi/search.pl', [
            'search_terms' => $foodName,
            'search_simple' => 1,
            'json' => 1,
            'fields' => 'product_name,nutriments',
            'page_size' => 1,
        ]);

        $data = $response->json();
        if (empty($data['products'])) {
            return null;
        }

        $product = $data['products'][0];
        $nutriments = $product['nutriments'] ?? [];
        $scale = $quantity / 100;

        return [
            'name' => $product['product_name'] ?? $foodName,
            'calories' => ($nutriments['energy-kcal_100g'] ?? 0) * $scale,
            'protein' => ($nutriments['proteins_100g'] ?? 0) * $scale,
            'carbs' => ($nutriments['carbohydrates_100g'] ?? 0) * $scale,
            'fat' => ($nutriments['fat_100g'] ?? 0) * $scale,
            'sugar' => ($nutriments['sugars_100g'] ?? 0) * $scale,
            'fiber' => ($nutriments['fiber_100g'] ?? 0) * $scale,
        ];
    }
}