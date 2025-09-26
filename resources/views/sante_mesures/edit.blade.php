<!-- resources/views/sante_mesures/edit.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Modifier la mesure</h2>

    <form action="{{ route('sante-mesures.update', $mesure->mesure_id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="poids_kg">Poids (kg)</label>
            <input type="number" step="0.01" name="poids_kg" class="form-control" value="{{ $mesure->poids_kg }}">
        </div>
        <div class="mb-3">
            <label for="taille_cm">Taille (cm)</label>
            <input type="number" name="taille_cm" class="form-control" value="{{ $mesure->taille_cm }}">
        </div>
        <div class="mb-3">
            <label for="imc">IMC</label>
            <input type="number" step="0.01" name="imc" class="form-control" value="{{ $mesure->imc }}">
        </div>
        <div class="mb-3">
            <label for="freq_cardiaque">Fréquence cardiaque</label>
            <input type="number" name="freq_cardiaque" class="form-control" value="{{ $mesure->freq_cardiaque }}">
        </div>
        <div class="mb-3">
            <label for="tension_systolique">Tension systolique</label>
            <input type="number" name="tension_systolique" class="form-control" value="{{ $mesure->tension_systolique }}">
        </div>
        <div class="mb-3">
            <label for="tension_diastolique">Tension diastolique</label>
            <input type="number" name="tension_diastolique" class="form-control" value="{{ $mesure->tension_diastolique }}">
        </div>
        <div class="mb-3">
            <label for="remarque">Remarque</label>
            <textarea name="remarque" class="form-control">{{ $mesure->remarque }}</textarea>
        </div>
        <button type="submit" class="btn btn-success">Mettre à jour</button>
        <a href="{{ route('sante-mesures.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
