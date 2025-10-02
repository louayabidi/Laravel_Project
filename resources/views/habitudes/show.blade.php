<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-header.header></x-header.header>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Détails de l'Habitude"></x-navbars.navs.auth>

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="text-white text-capitalize ps-3 mb-0">
                                        <i class="fas fa-chart-line me-2"></i>Habitude du {{ \Carbon\Carbon::parse($habitude->date_jour)->format('d/m/Y') }}
                                    </h6>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <!-- En-tête informatif -->
                            <div class="alert alert-info mb-4">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-info-circle me-3 fa-lg"></i>
                                    <div>
                                        <strong>Résumé de votre journée</strong>
                                        <p class="mb-0">Voici le détail complet de vos habitudes pour cette date.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Santé Physique -->
                                <div class="col-md-6 mb-4">
                                    <div class="card border">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0 text-primary">
                                                <i class="fas fa-heartbeat me-2"></i>Santé Physique
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-bed text-primary me-3"></i>
                                                    <span>Sommeil</span>
                                                </div>
                                                <span class="fw-bold">{{ $habitude->sommeil_heures ?? 'N/A' }} <small class="text-muted">heures</small></span>
                                            </div>
                                            
                                            <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-tint text-info me-3"></i>
                                                    <span>Eau consommée</span>
                                                </div>
                                                <span class="fw-bold">{{ $habitude->eau_litres ?? 'N/A' }} <small class="text-muted">litres</small></span>
                                            </div>
                                            
                                            <div class="d-flex justify-content-between align-items-center py-2">
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-running text-success me-3"></i>
                                                    <span>Activité sportive</span>
                                                </div>
                                                <span class="fw-bold">{{ $habitude->sport_minutes ?? 'N/A' }} <small class="text-muted">minutes</small></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Bien-être Mental -->
                                <div class="col-md-6 mb-4">
                                    <div class="card border">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0 text-success">
                                                <i class="fas fa-brain me-2"></i>Bien-être Mental
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-exclamation-triangle text-warning me-3"></i>
                                                    <span>Niveau de stress</span>
                                                </div>
                                                <span class="fw-bold">{{ $habitude->stress_niveau ?? 'N/A' }} <small class="text-muted">/10</small></span>
                                            </div>
                                            
                                            <div class="d-flex justify-content-between align-items-center py-2">
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-spa text-success me-3"></i>
                                                    <span>Méditation</span>
                                                </div>
                                                <span class="fw-bold">{{ $habitude->meditation_minutes ?? 'N/A' }} <small class="text-muted">minutes</small></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Habitudes Quotidiennes -->
                                <div class="col-md-6 mb-4">
                                    <div class="card border">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0 text-warning">
                                                <i class="fas fa-mobile-alt me-2"></i>Habitudes Quotidiennes
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-desktop text-secondary me-3"></i>
                                                    <span>Temps d'écran</span>
                                                </div>
                                                <span class="fw-bold">{{ $habitude->temps_ecran_minutes ?? 'N/A' }} <small class="text-muted">minutes</small></span>
                                            </div>
                                            
                                            <div class="d-flex justify-content-between align-items-center py-2">
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-coffee text-brown me-3"></i>
                                                    <span>Café</span>
                                                </div>
                                                <span class="fw-bold">{{ $habitude->cafe_cups ?? 'N/A' }} <small class="text-muted">tasses</small></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Résumé et Actions -->
                                <div class="col-md-6 mb-4">
                                    <div class="card border">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0 text-info">
                                                <i class="fas fa-cog me-2"></i>Actions
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="d-grid gap-2">
                                                <a href="{{ route('objectifs.habitudes.index', $objectif->id) }}" class="btn btn-outline-secondary">
                                                    <i class="fas fa-arrow-left me-2"></i>Retour aux habitudes
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Statistiques rapides (optionnel) -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="card border">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0 text-dark">
                                                <i class="fas fa-chart-bar me-2"></i>Aperçu de la journée
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row text-center">
                                                <div class="col-md-3 col-6 mb-3">
                                                    <div class="border rounded p-3">
                                                        <i class="fas fa-bed fa-2x text-primary mb-2"></i>
                                                        <h5 class="mb-1">{{ $habitude->sommeil_heures ?? '0' }}h</h5>
                                                        <small class="text-muted">Sommeil</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-6 mb-3">
                                                    <div class="border rounded p-3">
                                                        <i class="fas fa-tint fa-2x text-info mb-2"></i>
                                                        <h5 class="mb-1">{{ $habitude->eau_litres ?? '0' }}L</h5>
                                                        <small class="text-muted">Eau</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-6 mb-3">
                                                    <div class="border rounded p-3">
                                                        <i class="fas fa-running fa-2x text-success mb-2"></i>
                                                        <h5 class="mb-1">{{ $habitude->sport_minutes ?? '0' }}min</h5>
                                                        <small class="text-muted">Sport</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-6 mb-3">
                                                    <div class="border rounded p-3">
                                                        <i class="fas fa-brain fa-2x text-warning mb-2"></i>
                                                        <h5 class="mb-1">{{ $habitude->stress_niveau ?? '0' }}/10</h5>
                                                        <small class="text-muted">Stress</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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

<style>
.text-brown {
    color: #8B4513;
}
</style>