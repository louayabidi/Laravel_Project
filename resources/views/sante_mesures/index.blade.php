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
