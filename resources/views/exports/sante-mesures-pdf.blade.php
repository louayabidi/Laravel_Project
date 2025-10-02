<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #333;
            line-height: 1.6;
        }
        .header {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 30px;
        }
        .header img {
            max-width: 150px;
            margin-bottom: 20px;
        }
        .title {
            font-size: 24px;
            color: #2c3e50;
            margin-bottom: 10px;
        }
        .subtitle {
            font-size: 16px;
            color: #7f8c8d;
            margin-bottom: 30px;
        }
        .info-box {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .alert {
            padding: 15px;
            border-radius: 4px;
            margin: 15px 0;
            font-size: 14px;
        }
        .alert-warning {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeeba;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th {
            background-color: #2c3e50;
            color: white;
            padding: 12px;
            text-align: left;
        }
        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .alert {
            padding: 10px;
            border-radius: 4px;
            margin: 5px 0;
        }
        .alert-warning {
            background-color: #fff3cd;
            color: #856404;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #7f8c8d;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1 class="title">Rapport de Suivi de Santé</h1>
        <p class="subtitle">Généré le {{ now()->format('d/m/Y à H:i') }}</p>
    </div>

    <div class="info-box">
        <p><strong>Période :</strong> 
            @if($mesures->count() > 0)
                {{ $mesures->min('date_mesure')->format('d/m/Y') }} 
                au 
                {{ $mesures->max('date_mesure')->format('d/m/Y') }}
            @else
                {{ $date_debut ?? 'Non spécifié' }} au {{ $date_fin ?? 'Non spécifié' }}
            @endif
        </p>
        <p><strong>Nombre de mesures :</strong> {{ $mesures->count() }}</p>
        @if($mesures->count() == 0)
            <p class="alert alert-warning">Aucune mesure n'a été trouvée pour cette période.</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Poids (kg)</th>
                <th>IMC</th>
                <th>Fréq. Cardiaque</th>
                <th>Tension</th>
            </tr>
        </thead>
        <tbody>
            @foreach($mesures as $mesure)
            <tr>
                <td>{{ $mesure->date_mesure->format('d/m/Y') }}</td>
                <td>{{ $mesure->poids_kg }}</td>
                <td>
                    {{ $mesure->imc }}
                    @if($mesure->imc < 18.5)
                        <br><small>(Insuffisance pondérale)</small>
                    @elseif($mesure->imc < 25)
                        <br><small>(Normal)</small>
                    @elseif($mesure->imc < 30)
                        <br><small>(Surpoids)</small>
                    @else
                        <br><small>(Obésité)</small>
                    @endif
                </td>
                <td>
                    {{ $mesure->freq_cardiaque }} bpm
                    @if($mesure->freq_cardiaque < 60)
                        <br><small>(Basse)</small>
                    @elseif($mesure->freq_cardiaque > 100)
                        <br><small>(Élevée)</small>
                    @else
                        <br><small>(Normale)</small>
                    @endif
                </td>
                <td>
                    {{ $mesure->tension_systolique }}/{{ $mesure->tension_diastolique }}
                    @if($mesure->tension_systolique > 140 || $mesure->tension_diastolique > 90)
                        <br><small>(Élevée)</small>
                    @else
                        <br><small>(Normale)</small>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Ce rapport a été généré automatiquement par l'application de suivi de santé.</p>
    </div>
</body>
</html>