<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-header.header></x-header.header>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="{{ isset($habitude) ? 'Modifier Habitude' : 'Nouvelle Habitude' }}"></x-navbars.navs.auth>

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">
                                    <i class="fas {{ isset($habitude) ? 'fa-edit' : 'fa-plus-circle' }} me-2"></i>
                                    {{ isset($habitude) ? 'Modifier l\'Habitude' : 'Nouvelle Habitude' }}
                                </h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- En-tête informatif -->
                            <div class="alert alert-info mb-4">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-info-circle me-3 fa-lg"></i>
                                    <div>
                                        <strong>Suivi quotidien</strong>
                                        <p class="mb-0">Renseignez vos habitudes pour la journée sélectionnée. Seuls les champs pertinents pour votre objectif sont requis.</p>
                                    </div>
                                </div>
                            </div>

                            <form action="{{ route('objectifs.habitudes.store', $objectifId) }}" method="POST">
                                @csrf
                                @if(isset($habitude))
                                    @method('PUT')
                                @endif
                                <input type="hidden" name="objectif_id" value="{{ $objectifId }}">

                                <div class="row">
                                    <!-- Colonne de gauche -->
                                    <div class="col-md-6">
                                        <!-- Date -->
                                        <div class="mb-4">
                                            <label class="form-label fw-bold">Date du suivi <span class="text-danger">*</span></label>
                                            <div class="input-group input-group-outline">
                                                <input type="date" name="date_jour" class="form-control" 
                                                       value="{{ $habitude->date_jour ?? old('date_jour', date('Y-m-d')) }}" 
                                                       required max="{{ date('Y-m-d') }}">
                                            </div>
                                            <small class="form-text text-muted">Sélectionnez la date du suivi (aujourd'hui ou une date antérieure)</small>
                                        </div>

                                        <!-- Santé physique -->
                                        <div class="mb-4">
                                            <h6 class="text-primary mb-3">
                                                <i class="fas fa-heartbeat me-2"></i>Santé Physique
                                            </h6>
                                            
                                            <div class="mb-3">
                                                <label class="form-label">Sommeil <span class="text-muted">(heures)</span></label>
                                                <div class="input-group input-group-outline">
                                                    <input type="number" step="0.1" min="0" max="24" name="sommeil_heures" 
                                                           class="form-control" placeholder="Ex: 7.5"
                                                           value="{{ $habitude->sommeil_heures ?? old('sommeil_heures') }}">
                                                    <span class="input-group-text">h</span>
                                                </div>
                                                <small class="form-text text-muted">Durée totale de sommeil</small>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Eau consommée <span class="text-muted">(litres)</span></label>
                                                <div class="input-group input-group-outline">
                                                    <input type="number" step="0.1" min="0" max="10" name="eau_litres" 
                                                           class="form-control" placeholder="Ex: 2.0"
                                                           value="{{ $habitude->eau_litres ?? old('eau_litres') }}">
                                                    <span class="input-group-text">L</span>
                                                </div>
                                                <small class="form-text text-muted">Quantité d'eau bue dans la journée</small>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Activité sportive <span class="text-muted">(minutes)</span></label>
                                                <div class="input-group input-group-outline">
                                                    <input type="number" min="0" max="480" name="sport_minutes" 
                                                           class="form-control" placeholder="Ex: 30"
                                                           value="{{ $habitude->sport_minutes ?? old('sport_minutes') }}">
                                                    <span class="input-group-text">min</span>
                                                </div>
                                                <small class="form-text text-muted">Temps d'activité physique</small>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Colonne de droite -->
                                    <div class="col-md-6">
                                        <!-- Bien-être mental -->
                                        <div class="mb-4">
                                            <h6 class="text-success mb-3">
                                                <i class="fas fa-brain me-2"></i>Bien-être Mental
                                            </h6>

                                            <div class="mb-3">
                                                <label class="form-label">Niveau de stress <span class="text-muted">(1-10)</span></label>
                                                <div class="input-group input-group-outline">
                                                    <input type="number" min="1" max="10" name="stress_niveau" 
                                                           class="form-control" placeholder="Ex: 3"
                                                           value="{{ $habitude->stress_niveau ?? old('stress_niveau') }}">
                                                    <span class="input-group-text">/10</span>
                                                </div>
                                                <small class="form-text text-muted">1 = Très calme, 10 = Très stressé</small>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Méditation <span class="text-muted">(minutes)</span></label>
                                                <div class="input-group input-group-outline">
                                                    <input type="number" min="0" max="240" name="meditation_minutes" 
                                                           class="form-control" placeholder="Ex: 15"
                                                           value="{{ $habitude->meditation_minutes ?? old('meditation_minutes') }}">
                                                    <span class="input-group-text">min</span>
                                                </div>
                                                <small class="form-text text-muted">Temps de méditation ou relaxation</small>
                                            </div>
                                        </div>

                                        <!-- Habitudes quotidiennes -->
                                        <div class="mb-4">
                                            <h6 class="text-warning mb-3">
                                                <i class="fas fa-mobile-alt me-2"></i>Habitudes Quotidiennes
                                            </h6>

                                            <div class="mb-3">
                                                <label class="form-label">Temps d'écran <span class="text-muted">(minutes)</span></label>
                                                <div class="input-group input-group-outline">
                                                    <input type="number" min="0" max="960" name="temps_ecran_minutes" 
                                                           class="form-control" placeholder="Ex: 180"
                                                           value="{{ $habitude->temps_ecran_minutes ?? old('temps_ecran_minutes') }}">
                                                    <span class="input-group-text">min</span>
                                                </div>
                                                <small class="form-text text-muted">Temps total passé sur les écrans</small>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Café <span class="text-muted">(tasses)</span></label>
                                                <div class="input-group input-group-outline">
                                                    <input type="number" min="0" max="20" name="cafe_cups" 
                                                           class="form-control" placeholder="Ex: 2"
                                                           value="{{ $habitude->cafe_cups ?? old('cafe_cups') }}">
                                                    <span class="input-group-text">tasses</span>
                                                </div>
                                                <small class="form-text text-muted">Nombre de tasses de café consommées</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Boutons d'action -->
                                <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                                    <a href="{{ route('objectifs.habitudes.index', $objectifId) }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-arrow-left me-2"></i>Retour aux habitudes
                                    </a>
                                    <div>
                                        <button type="reset" class="btn btn-outline-warning me-2">
                                            <i class="fas fa-undo me-2"></i>Réinitialiser
                                        </button>
                                        <button type="submit" class="btn bg-gradient-primary px-4">
                                            <i class="fas {{ isset($habitude) ? 'fa-save' : 'fa-check' }} me-2"></i>
                                            {{ isset($habitude) ? 'Mettre à jour' : 'Enregistrer' }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <x-footers.auth></x-footers.auth>
        </div>
    </main>
    <x-plugins></x-plugins>
</x-layout>