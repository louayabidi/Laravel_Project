<x-layout bodyClass="g-sidenav-show bg-gray-200">
    @push('styles')
    <link href="{{ asset('assets/css/regime-styles.css') }}" rel="stylesheet">
    @endpush

    <x-navbars.sidebar activePage="suivi-sante"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Détails de la Mesure"></x-navbars.navs.auth>
        <!-- End Navbar -->
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <div class="d-flex justify-content-between align-items-center px-3">
                            <h6 class="text-white text-capitalize ps-3">Détails de la Mesure</h6>
                            <div>
                                <a href="{{ route('sante-mesures.edit', $sante_mesure) }}" class="btn btn-sm btn-info me-2">
                                    <i class="material-icons">edit</i> Modifier
                                </a>
                                <a href="{{ route('sante-mesures.index') }}" class="btn btn-sm btn-secondary">
                                    <i class="material-icons">arrow_back</i> Retour
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <!-- Alertes si nécessaire -->
                    @if($alertes)
                        <div class="alert alert-warning alert-with-icon">
                            <i class="material-icons me-2">warning</i>
                            <span data-notify="message">
                                <b>Attention</b> : Certaines mesures nécessitent votre attention
                            </span>
                        </div>
                    @endif

                    <!-- Recommandations -->
                    @if(count($recommendations) > 0)
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="material-icons me-2">tips_and_updates</i>Recommandations</h5>
                            </div>
                            <div class="card-body">
                                <div class="recommendations">
                                    @foreach($recommendations as $recommendation)
                                        <div class="recommendation-item">
                                            <i class="material-icons text-primary me-2">lightbulb</i>
                                            {{ $recommendation }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Informations utilisateur -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="material-icons me-2">person</i>Patient</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <i class="material-icons text-primary me-2">account_circle</i>
                                <h6 class="mb-0">{{ $sante_mesure->user->name }}</h6>
                            </div>
                        </div>
                    </div>

                    <!-- Détails des mesures -->
                    <div class="row">
                        <!-- Mesures principales -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Mesures Principales</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table">
                                        <tr>
                                            <th>Date de mesure :</th>
                                            <td>{{ $sante_mesure->date_mesure->format('d/m/Y') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Poids :</th>
                                            <td>{{ $sante_mesure->poids_kg }} kg</td>
                                        </tr>
                                        <tr>
                                            <th>Taille :</th>
                                            <td>{{ $sante_mesure->taille_cm }} cm</td>
                                        </tr>
                                        <tr>
                                            <th>IMC :</th>
                                            <td>
                                                {{ $sante_mesure->imc }}
                                                <small class="text-muted">
                                                    @if($sante_mesure->imc < 18.5)
                                                        (Insuffisance pondérale)
                                                    @elseif($sante_mesure->imc < 25)
                                                        (Normal)
                                                    @elseif($sante_mesure->imc < 30)
                                                        (Surpoids)
                                                    @else
                                                        (Obésité)
                                                    @endif
                                                </small>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Mesures cardiaques -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Mesures Cardiaques</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table">
                                        <tr>
                                            <th>Fréquence cardiaque :</th>
                                            <td>
                                                {{ $sante_mesure->freq_cardiaque }} bpm
                                                @if($sante_mesure->freq_cardiaque < 60)
                                                    <span class="text-warning">(Basse)</span>
                                                @elseif($sante_mesure->freq_cardiaque > 100)
                                                    <span class="text-warning">(Élevée)</span>
                                                @else
                                                    <span class="text-success">(Normale)</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Tension artérielle :</th>
                                            <td>
                                                {{ $sante_mesure->tension_systolique }}/{{ $sante_mesure->tension_diastolique }} mmHg
                                                @if($sante_mesure->tension_systolique > 140 || $sante_mesure->tension_diastolique > 90)
                                                    <span class="text-warning">(Élevée)</span>
                                                @else
                                                    <span class="text-success">(Normale)</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Information du Régime -->
                    <div class="card mt-4 regime-card">
                        <div class="card-header bg-gradient-info">
                            <h5 class="mb-0 text-white d-flex align-items-center">
                                <i class="material-icons me-2">fitness_center</i>
                                Information du Régime
                            </h5>
                        </div>
                        <div class="card-body">
                            @if($regime)
                                <div class="table-responsive">
                                    <table class="table align-items-center mb-0">
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">
                                                <i class="material-icons text-info me-2 align-middle">sports_gymnastics</i>Type de Régime
                                            </th>
                                            <td class="align-middle ps-3">
                                                <span class="badge bg-gradient-{{ $regime->type_regime == 'Fitnesse' ? 'success' : ($regime->type_regime == 'musculation' ? 'info' : 'warning') }} px-3 py-2">
                                                    <i class="material-icons me-2 align-middle" style="font-size: 1.1rem;">
                                                        @if($regime->type_regime == 'Fitnesse')
                                                            directions_run
                                                        @elseif($regime->type_regime == 'musculation')
                                                            fitness_center
                                                        @else
                                                            trending_up
                                                        @endif
                                                    </i>
                                                    {{ $regime->type_regime }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">
                                                <i class="material-icons text-info me-2 align-middle">track_changes</i>Valeur Cible
                                            </th>
                                            <td class="align-middle ps-3">
                                                <div class="d-flex align-items-center">
                                                    <span class="font-weight-bold me-2">{{ $regime->valeur_cible }}</span>
                                                    <span class="text-secondary">kg</span>
                                                </div>
                                            </td>


                                        @if($regime->description)
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                <i class="material-icons me-2">description</i>Description
                                            </th>
                                            <td class="align-middle">
                                                <p class="text-sm mb-0">{{ $regime->description }}</p>
                                            </td>
                                        </tr>
                                        @endif
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="material-icons text-muted" style="font-size: 3rem;">fitness_center</i>
                                    <p class="text-muted mt-2">Aucun régime associé à cette mesure</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    <!-- Remarques -->
                    @if($sante_mesure->remarque)
                        <div class="card mt-4">
                            <div class="card-header">
                                <h5 class="mb-0">Remarques</h5>
                            </div>
                            <div class="card-body">
                                {{ $sante_mesure->remarque }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
            <x-footers.auth></x-footers.auth>
        </div>
    </main>
    <x-plugins></x-plugins>
</x-layout>
