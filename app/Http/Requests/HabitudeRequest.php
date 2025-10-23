<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HabitudeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // autorise tous les utilisateurs connectés
    }

    public function rules(): array
    {
        return [
            'date_jour' => ['required', 'date', 'before_or_equal:today'],
            'sommeil_heures' => ['nullable', 'numeric', 'min:0', 'max:24'],
            'eau_litres' => ['nullable', 'numeric', 'min:0', 'max:10'],
            'sport_minutes' => ['nullable', 'integer', 'min:0', 'max:480'],
            'stress_niveau' => ['nullable', 'integer', 'min:1', 'max:10'],
            'meditation_minutes' => ['nullable', 'integer', 'min:0', 'max:240'],
            'temps_ecran_minutes' => ['nullable', 'integer', 'min:0', 'max:960'],
            'cafe_cups' => ['nullable', 'integer', 'min:0', 'max:20'],
        ];
    }

    public function messages(): array
    {
        return [
            'date_jour.required' => 'La date du jour est obligatoire.',
            'date_jour.before_or_equal' => 'La date ne peut pas être dans le futur.',
            'sommeil_heures.max' => 'Le sommeil ne peut pas dépasser 24 heures.',
            'stress_niveau.max' => 'Le niveau de stress doit être entre 1 et 10.',
            'eau_litres.max' => 'Vous ne pouvez pas entrer plus de 10 litres.',
            'sport_minutes.max' => 'La durée du sport est limitée à 480 minutes.',
        ];
    }
}
