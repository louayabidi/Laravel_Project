@extends('layout')  {{-- Assume un layout existant --}}

@section('content')
    <h2>Ajouter un repas via photo AI</h2>
    <form action="{{ route('meals.add-by-image') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="image">Uploader une photo de votre repas :</label>
        <input type="file" name="image" accept="image/*" required>
        <select name="meal_type" required>
            <option value="breakfast">Petit-déjeuner</option>
            <option value="lunch">Déjeuner</option>
            <option value="dinner">Dîner</option>
            <option value="snack">Snack</option>
        </select>
        <button type="submit">Analyser et Ajouter</button>
    </form>
@endsection