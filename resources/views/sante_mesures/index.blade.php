<!DOCTYPE html>
<html>
<head>
    <title>Mesures de Santé</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Liste des Mesures de Santé</h2>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Utilisateur</th>
                <th>Date de mesure</th>
                <th>Poids (kg)</th>
                <th>Taille (cm)</th>
                <th>IMC</th>
                <th>Fréquence cardiaque</th>
                <th>Tension systolique</th>
                <th>Tension diastolique</th>
                <th>Remarque</th>
            </tr>
        </thead>
        <tbody>
            @forelse($mesures as $mesure)
                <tr>
                    <td>{{ $mesure->mesure_id }}</td>
                    <td>{{ $mesure->user_id }}</td> <!-- si tu veux le nom, tu peux faire $mesure->user->name avec relation -->
                    <td>{{ $mesure->date_mesure }}</td>
                    <td>{{ $mesure->poids_kg ?? '-' }}</td>
                    <td>{{ $mesure->taille_cm ?? '-' }}</td>
                    <td>{{ $mesure->imc ?? '-' }}</td>
                    <td>{{ $mesure->freq_cardiaque ?? '-' }}</td>
                    <td>{{ $mesure->tension_systolique ?? '-' }}</td>
                    <td>{{ $mesure->tension_diastolique ?? '-' }}</td>
                    <td>{{ $mesure->remarque ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center">Aucune mesure disponible</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Bootstrap JS (optionnel) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
