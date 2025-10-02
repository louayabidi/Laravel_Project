<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Poids (kg)</th>
            <th>Taille (cm)</th>
            <th>IMC</th>
            <th>Fréquence Cardiaque</th>
            <th>Tension Systolique</th>
            <th>Tension Diastolique</th>
            <th>Remarques</th>
        </tr>
    </thead>
    <tbody>
        @foreach($mesures as $mesure)
        <tr>
            <td>{{ $mesure->date_mesure->format('d/m/Y') }}</td>
            <td>{{ $mesure->poids_kg }}</td>
            <td>{{ $mesure->taille_cm }}</td>
            <td>{{ $mesure->imc }}</td>
            <td>{{ $mesure->freq_cardiaque }}</td>
            <td>{{ $mesure->tension_systolique }}</td>
            <td>{{ $mesure->tension_diastolique }}</td>
            <td>{{ $mesure->remarque }}</td>
        </tr>
        @endforeach
    </tbody>
</table>