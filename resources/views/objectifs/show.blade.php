@extends('layouts.app')
@section('content')
<h1>{{ $objectif->title }} - Habitudes</h1>

<a href="{{ route('habitudes.create') }}?objectif_id={{ $objectif->id }}" class="btn btn-success mb-3">Ajouter Habitude</a>

<table class="table table-bordered">
<thead>
<tr>
    <th>Date</th>
    <th>Sommeil (h)</th>
    <th>Eau (L)</th>
    <th>Sport (min)</th>
    <th>Stress</th>
    <th>Actions</th>
</tr>
</thead>
<tbody>
@foreach($objectif->habitudes as $habitude)
<tr>
    <td>{{ $habitude->date_jour }}</td>
    <td>{{ $habitude->sommeil_heures }}</td>
    <td>{{ $habitude->eau_litres }}</td>
    <td>{{ $habitude->sport_minutes }}</td>
    <td>{{ $habitude->stress_niveau }}</td>
    <td>
        <a href="{{ route('habitudes.edit', $habitude->habitude_id) }}" class="btn btn-warning btn-sm">Edit</a>
        <form action="{{ route('habitudes.destroy', $habitude->habitude_id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ?')">Delete</button>
        </form>
    </td>
</tr>
@endforeach
</tbody>
</table>
@endsection
