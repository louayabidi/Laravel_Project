<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreObjectifRequest extends FormRequest
{
    public function authorize()
    {
        return true; // autorise la requête
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'status' => 'required|in:Sommeil,Eau,Sport,Stress',
            'target_value' => 'required|numeric|min:1',
            'start_date' => 'required|date|before_or_equal:end_date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Le titre est obligatoire.',
            'status.required' => 'La catégorie est obligatoire.',
            'status.in' => 'La catégorie doit être Sommeil, Eau, Sport ou Stress.',
            'target_value.required' => 'La valeur cible est obligatoire.',
            'target_value.numeric' => 'La valeur cible doit être un nombre.',
            'target_value.min' => 'La valeur cible doit être au moins 1.',
            'start_date.required' => 'La date de début est obligatoire.',
            'start_date.before_or_equal' => 'La date de début doit être antérieure ou égale à la date de fin.',
            'end_date.required' => 'La date de fin est obligatoire.',
            'end_date.after_or_equal' => 'La date de fin doit être postérieure ou égale à la date de début.',
        ];
    }
}
