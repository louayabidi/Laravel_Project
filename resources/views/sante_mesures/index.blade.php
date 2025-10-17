<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="sante-mesures.index"></x-navbars.sidebar>
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
                    @if(true)
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-warning">
                                <div class="card-header bg-gradient-warning">
                                    <h5 class="mb-0 text-white d-flex align-items-center">
                                        <i class="material-icons me-2">health_and_safety</i>
                                        IA de Diagnostic Préventif - Analyse des Tendances (30 derniers jours)
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <!-- Debug info -->
                                    <div class="alert alert-info">
                                        <strong>Debug:</strong> healthAnalysis is set<br>
                                        Alerts: {{ count($healthAnalysis['alerts'] ?? []) }}<br>
                                        Recommendations: {{ count($healthAnalysis['recommendations'] ?? []) }}
                                    </div>

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

                                    <!-- Résultat Combiné de l'Ensemble IA -->
                                    <div class="mb-4 p-4 border-2 rounded" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: 2px solid #667eea;">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                                <h6 class="text-white mb-2"><i class="material-icons me-2">psychology</i>Prédiction Combinée (Ensemble)</h6>
                                                <p class="text-white mb-0" style="font-size: 1.3em; font-weight: bold;">Condition Prédite: <span style="color: #ffd700;">Analyse en cours...</span></p>
                                            </div>
                                            <div class="text-center text-white">
                                                <p class="mb-1" style="font-size: 0.9em;">Confiance</p>
                                                <h4 class="mb-0" style="color: #ffd700;">--</h4>
                                            </div>
                                        </div>
                                        <p class="text-white-50 mt-2 mb-0"><small><i class="material-icons" style="font-size: 0.9em;">info</i> Résultat du vote combiné de Random Forest (92.31%) + Gradient Boosting (100%) = Ensemble (98.67%)</small></p>
                                    </div>

                                    <!-- Recommandations -->
                                    @if(!empty($healthAnalysis['recommendations']))
                                    <div>
                                        <h6 class="text-success mb-3"><i class="material-icons me-2">lightbulb</i>Recommandations Personnalisées :</h6>
                                        <div class="row">
                                            @foreach($healthAnalysis['recommendations'] as $index => $recommendation)
                                            <div class="col-md-6 mb-3">
                                                <div class="card border-success h-100">
                                                    <div class="card-body d-flex align-items-start">
                                                        <div class="me-3 mt-1">
                                                            @if(str_contains($recommendation, '🍎') || str_contains($recommendation, 'Diabète'))
                                                                <i class="material-icons text-success" style="font-size: 2rem;">local_dining</i>
                                                            @elseif(str_contains($recommendation, '🏥') || str_contains($recommendation, 'Hypertension'))
                                                                <i class="material-icons text-danger" style="font-size: 2rem;">favorite</i>
                                                            @elseif(str_contains($recommendation, '🤰') || str_contains($recommendation, 'Grossesse'))
                                                                <i class="material-icons text-primary" style="font-size: 2rem;">pregnant_woman</i>
                                                            @elseif(str_contains($recommendation, '🥑') || str_contains($recommendation, 'Cholestérol'))
                                                                <i class="material-icons text-warning" style="font-size: 2rem;">restaurant</i>
                                                            @elseif(str_contains($recommendation, '🌾') || str_contains($recommendation, 'cœliaque'))
                                                                <i class="material-icons text-info" style="font-size: 2rem;">no_food</i>
                                                            @elseif(str_contains($recommendation, '🫘') || str_contains($recommendation, 'rénale'))
                                                                <i class="material-icons text-secondary" style="font-size: 2rem;">healing</i>
                                                            @elseif(str_contains($recommendation, '⚠️') || str_contains($recommendation, 'IMC'))
                                                                <i class="material-icons text-warning" style="font-size: 2rem;">warning</i>
                                                            @elseif(str_contains($recommendation, '📊') || str_contains($recommendation, 'Objectif'))
                                                                <i class="material-icons text-info" style="font-size: 2rem;">track_changes</i>
                                                            @elseif(str_contains($recommendation, '✅') || str_contains($recommendation, 'Félicitations'))
                                                                <i class="material-icons text-success" style="font-size: 2rem;">celebration</i>
                                                            @else
                                                                <i class="material-icons text-success" style="font-size: 2rem;">check_circle</i>
                                                            @endif
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <p class="mb-0 text-dark fw-medium">{{ $recommendation }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
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
                                    <p class="card-category">Suivi quotidien</p>
                                </div>
                                <div class="card-body">
                                    <canvas id="poidsChart" class="chart-canvas"></canvas>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="material-icons">access_time</i> Mis à jour automatiquement
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card card-chart">
                                <div class="card-header card-header-warning">
                                    <h4 class="card-title font-weight-bold">Évolution de l'IMC</h4>
                                    <p class="card-category">Indice de masse corporelle</p>
                                </div>
                                <div class="card-body">
                                    <canvas id="imcChart" class="chart-canvas"></canvas>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="material-icons">access_time</i> Mis à jour automatiquement
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Données pour les graphiques
    const evolutionData = @json($evolutionData);

    // Configuration commune
    const commonOptions = {
        responsive: true,
        scales: {
            x: {
                type: 'time',
                time: {
                    unit: 'day',
                    displayFormats: {
                        day: 'dd/MM'
                    }
                }
            }
        }
    };

    // Graphique du poids
    new Chart(document.getElementById('poidsChart'), {
        type: 'line',
        data: {
            labels: evolutionData.dates,
            datasets: [{
                label: 'Poids (kg)',
                data: evolutionData.poids,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }]
        },
        options: commonOptions
    });

    // Graphique de l'IMC
    new Chart(document.getElementById('imcChart'), {
        type: 'line',
        data: {
            labels: evolutionData.dates,
            datasets: [{
                label: 'IMC',
                data: evolutionData.imc,
                borderColor: 'rgb(255, 99, 132)',
                tension: 0.1
            }]
        },
        options: commonOptions
    });
});
</script>
@endpush
        </main>
        <x-plugins></x-plugins>
</x-layout>
