<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-header.header></x-header.header>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Mesures de Santé"></x-navbars.navs.auth>
        <!-- End Navbar -->
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <div class="d-flex justify-content-between align-items-center px-3">
                            <h6 class="text-white text-capitalize ps-3">Suivi de Santé</h6>
                            @if(auth()->user()->role !== 'admin')
                            <a href="{{ route('sante-mesures.create') }}" class="btn btn-sm btn-info">
                                <i class="material-icons">add</i> Nouvelle Mesure
                            </a>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Filtres -->
                <div class="card-body pt-4">
                    <!-- IA de Diagnostic Préventif -->
                    @if(isset($healthAnalysis))
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-warning">
                                <div class="card-header bg-gradient-warning">
                                    <h5 class="mb-0 text-white d-flex align-items-center">
                                        <i class="material-icons me-2">health_and_safety</i>
                                        IA de Diagnostic Préventif - Analyse des Tendances 
                                    </h5>
                                </div>
                                <div class="card-body">


                                    <!-- Alertes -->
                                    @if(!empty($healthAnalysis['alerts']))
                                    <div class="mb-3">
                                        <h6 class="text-danger"><i class="material-icons me-2">warning</i>Alertes Détectées :</h6>
                                        @foreach($healthAnalysis['alerts'] as $alert)
                                        <div class="alert alert-{{ $alert['type'] == 'danger' ? 'danger' : ($alert['type'] == 'warning' ? 'warning' : 'info') }} d-flex align-items-start mb-2">
                                            <i class="material-icons me-2 mt-1">
                                                @if($alert['type'] == 'danger')error
                                                @elseif($alert['type'] == 'warning')warning
                                                @else info
                                                @endif
                                            </i>
                                            <div>
                                                <strong>{{ $alert['message'] }}</strong>
                                                @if(isset($alert['severity']))
                                                <br><small class="text-muted">
                                                    Sévérité: {{ $alert['severity'] == 'high' ? 'Élevée' : ($alert['severity'] == 'medium' ? 'Moyenne' : 'Faible') }}
                                                </small>
                                                @endif
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    @endif

                                    <!-- Recommandations -->
                                    @if(!empty($healthAnalysis['recommendations']))
                                    <div>
                                        <h6 class="text-success"><i class="material-icons me-2">lightbulb</i>Recommandations Personnalisées :</h6>
                                        <div class="mb-2">
                                            <small class="text-muted">
                                                <i class="fas fa-brain me-1"></i>
                                                Généré par Intelligence Artificielle Locale 
                                            </small>
                                        </div>
                                        <ul class="list-group list-group-flush">
                                            @foreach($healthAnalysis['recommendations'] as $recommendation)
                                            <li class="list-group-item d-flex align-items-start">
                                                <i class="material-icons text-success me-2 mt-1" style="font-size: 1.2rem;">check_circle</i>
                                                <span>{{ $recommendation }}</span>
                                                @if(strpos($recommendation, 'ai_generated') !== false || strpos($recommendation, '🤖') !== false)
                                                    <small class="badge bg-primary ms-2">IA</small>
                                                @endif
                                            </li>
                                            @endforeach
                                        </ul>
                                        <div class="mt-2">
                                            <small class="text-muted">
                                                <i class="fas fa-shield-alt me-1"></i>
                                                Données anonymisées • Analyse basée sur vos mesures de santé
                                            </small>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    <form action="{{ route('sante-mesures.index') }}" method="GET" class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label for="date_debut" class="form-label">Date début</label>
                            <input type="date" class="form-control" id="date_debut" name="date_debut"
                                   value="{{ request('date_debut') }}">
                        </div>
                        <div class="col-md-4">
                            <label for="date_fin" class="form-label">Date fin</label>
                            <input type="date" class="form-control" id="date_fin" name="date_fin"
                                   value="{{ request('date_fin') }}">
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary me-2">Filtrer</button>
                            <a href="{{ route('sante-mesures.export.pdf', ['date_debut' => request('date_debut'), 'date_fin' => request('date_fin')]) }}" class="btn btn-success">
                                <i class="material-icons">picture_as_pdf</i> Exporter en PDF
                            </a>
                        </div>
                    </form>

                    <!-- Graphiques -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card card-chart">
                                <div class="card-header card-header-success">
                                    <h4 class="card-title font-weight-bold">Évolution du Poids</h4>
                                    <p class="card-category">
                                        @if(count($evolutionData['poids']) > 1)
                                            @php
                                                $firstWeight = $evolutionData['poids'][0];
                                                $lastWeight = end($evolutionData['poids']);
                                                $weightChange = $lastWeight - $firstWeight;
                                            @endphp
                                            @if($weightChange != 0)
                                                {{ $weightChange > 0 ? 'Augmentation' : 'Diminution' }} de {{ abs($weightChange) }} kg
                                            @else
                                                Poids stable
                                            @endif
                                        @else
                                            Suivi quotidien
                                        @endif
                                    </p>
                                </div>
                                <div class="card-body">
                                    <div style="position: relative; height: 300px;">
                                        <canvas id="poidsChart" style="max-width: 100%; height: 100%;"></canvas>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="material-icons">access_time</i>
                                        @if($mesures->count() > 1)
                                            {{ $mesures->count() }} mesures sur {{ $mesures->first()->date_mesure->diffInDays($mesures->last()->date_mesure) }} jours
                                        @else
                                            1 mesure
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card card-chart">
                                <div class="card-header card-header-warning">
                                    <h4 class="card-title font-weight-bold">Évolution de l'IMC</h4>
                                    <p class="card-category">
                                        IMC actuel: {{ count($evolutionData['imc']) > 0 ? number_format(end($evolutionData['imc']), 1) : 'N/A' }}
                                        @if(count($evolutionData['imc']) > 1)
                                            @php
                                                $firstBMI = $evolutionData['imc'][0];
                                                $lastBMI = end($evolutionData['imc']);
                                                $bmiChange = $lastBMI - $firstBMI;
                                            @endphp
                                            @if($bmiChange != 0)
                                                ({{ $bmiChange > 0 ? '+' : '' }}{{ number_format($bmiChange, 1) }})
                                            @endif
                                        @endif
                                    </p>
                                </div>
                                <div class="card-body">
                                    <div style="position: relative; height: 300px;">
                                        <canvas id="imcChart" style="max-width: 100%; height: 100%;"></canvas>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="material-icons">info</i>
                                        @if($mesures->count() > 0)
                                            @if($mesures->first()->imc < 18.5)
                                                <span class="text-warning">Insuffisance pondérale</span>
                                            @elseif($mesures->first()->imc < 25)
                                                <span class="text-success">Poids normal</span>
                                            @elseif($mesures->first()->imc < 30)
                                                <span class="text-warning">Surpoids</span>
                                            @else
                                                <span class="text-danger">Obésité</span>
                                            @endif
                                        @else
                                            Aucune mesure
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tableau des mesures -->
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Patient</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date Remplie</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Poids</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">IMC</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Fréq. Cardiaque</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tension</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Régime</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($mesures as $mesure)
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <div class="d-flex align-items-center">
                                                    <i class="material-icons text-primary me-2">account_circle</i>
                                                    <h6 class="mb-0 text-sm">{{ $mesure->user->name }}</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $mesure->date_mesure->format('d/m/Y') }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $mesure->date_remplie ? $mesure->date_remplie->format('d/m/Y') : 'N/A' }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $mesure->poids_kg }} kg</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $mesure->imc }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $mesure->freq_cardiaque }} bpm</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">
                                            {{ $mesure->tension_systolique }}/{{ $mesure->tension_diastolique }}
                                        </p>
                                    </td>
                                    <td>
                                        @if($mesure->regime)
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $mesure->regime->type_regime }}<br>
                                                <small class="text-muted">{{ $mesure->regime->valeur_cible }}kg</small>
                                            </p>
                                        @else
                                            <p class="text-xs text-muted mb-0">Aucun régime</p>
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        <a href="{{ route('sante-mesures.show', $mesure) }}" class="btn btn-link text-primary px-3 mb-0">
                                            <i class="material-icons text-sm me-2">visibility</i>Voir
                                        </a>
                                        @if(auth()->user()->can('update', $mesure))
                                        <a href="{{ route('sante-mesures.edit', $mesure) }}" class="btn btn-link text-warning px-3 mb-0">
                                            <i class="material-icons text-sm me-2">edit</i>Modifier
                                        </a>
                                        @endif
                                        @if(auth()->user()->can('delete', $mesure))
                                        <form action="{{ route('sante-mesures.destroy', $mesure) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-link text-danger px-3 mb-0"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette mesure ?')">
                                                <i class="material-icons text-sm me-2">delete</i>Supprimer
                                            </button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $mesures->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0"></script>
<script>
console.log('Script chargé');

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM chargé');

    // Données pour les graphiques
    const evolutionData = @json($evolutionData);
    console.log('Données:', evolutionData);

    // Graphique du poids
    const poidsCanvas = document.getElementById('poidsChart');
    console.log('Canvas poids trouvé:', poidsCanvas);

    if (poidsCanvas && evolutionData && evolutionData.dates && evolutionData.dates.length > 0) {
        console.log('Création graphique poids...');
        new Chart(poidsCanvas, {
            type: 'line',
            data: {
                labels: evolutionData.dates,
                datasets: [{
                    label: 'Poids (kg)',
                    data: evolutionData.poids,
                    borderColor: '#4CAF50',
                    backgroundColor: 'rgba(76, 175, 80, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#4CAF50',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8,
                    pointHoverBackgroundColor: '#4CAF50',
                    pointHoverBorderColor: '#fff',
                    pointHoverBorderWidth: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            font: {
                                size: 14,
                                weight: 'bold'
                            },
                            usePointStyle: true,
                            padding: 20
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderColor: '#4CAF50',
                        borderWidth: 1,
                        cornerRadius: 8,
                        displayColors: false,
                        callbacks: {
                            title: function(context) {
                                return 'Date: ' + context[0].label;
                            },
                            label: function(context) {
                                return 'Poids: ' + context.parsed.y + ' kg';
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Date des mesures',
                            font: {
                                size: 14,
                                weight: 'bold'
                            },
                            padding: { top: 10 }
                        },
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 12
                            }
                        }
                    },
                    y: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Poids (kg)',
                            font: {
                                size: 14,
                                weight: 'bold'
                            },
                            padding: { bottom: 10 }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)',
                            lineWidth: 1
                        },
                        ticks: {
                            font: {
                                size: 12
                            },
                            callback: function(value) {
                                return value + ' kg';
                            }
                        }
                    }
                },
                elements: {
                    point: {
                        hoverRadius: 8
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            }
        });
        console.log('Graphique poids créé');
    }

    // Graphique de l'IMC
    const imcCanvas = document.getElementById('imcChart');
    console.log('Canvas IMC trouvé:', imcCanvas);

    if (imcCanvas && evolutionData && evolutionData.dates && evolutionData.dates.length > 0) {
        console.log('Création graphique IMC...');
        new Chart(imcCanvas, {
            type: 'line',
            data: {
                labels: evolutionData.dates,
                datasets: [{
                    label: 'IMC',
                    data: evolutionData.imc,
                    borderColor: '#FF5722',
                    backgroundColor: 'rgba(255, 87, 34, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#FF5722',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8,
                    pointHoverBackgroundColor: '#FF5722',
                    pointHoverBorderColor: '#fff',
                    pointHoverBorderWidth: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            font: {
                                size: 14,
                                weight: 'bold'
                            },
                            usePointStyle: true,
                            padding: 20
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderColor: '#FF5722',
                        borderWidth: 1,
                        cornerRadius: 8,
                        displayColors: false,
                        callbacks: {
                            title: function(context) {
                                return 'Date: ' + context[0].label;
                            },
                            label: function(context) {
                                let imc = context.parsed.y;
                                let category = '';
                                if (imc < 18.5) category = ' (Insuffisance pondérale)';
                                else if (imc < 25) category = ' (Normal)';
                                else if (imc < 30) category = ' (Surpoids)';
                                else category = ' (Obésité)';
                                return 'IMC: ' + imc + category;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Date des mesures',
                            font: {
                                size: 14,
                                weight: 'bold'
                            },
                            padding: { top: 10 }
                        },
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 12
                            }
                        }
                    },
                    y: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Indice de Masse Corporelle (IMC)',
                            font: {
                                size: 14,
                                weight: 'bold'
                            },
                            padding: { bottom: 10 }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)',
                            lineWidth: 1
                        },
                        ticks: {
                            font: {
                                size: 12
                            }
                        },
                        suggestedMin: 15,
                        suggestedMax: 35
                    }
                },
                elements: {
                    point: {
                        hoverRadius: 8
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            }
        });
        console.log('Graphique IMC créé');
    }
});
</script>
        </main>
        <x-plugins></x-plugins>
</x-layout>
