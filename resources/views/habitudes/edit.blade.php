<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-header.header></x-header.header>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Modifier l'Habitude"></x-navbars.navs.auth>

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">
                                    <i class="fas fa-edit me-2"></i>Modifier l'Habitude
                                </h6>
                            </div>
                        </div>
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <strong>Des erreurs ont été détectées :</strong>
                                    <ul class="mb-0 mt-2">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="alert alert-info mb-4">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-info-circle me-3 fa-lg"></i>
                                    <div>
                                        <strong>Modification du suivi</strong>
                                        <p class="mb-0">Mettez à jour vos habitudes pour la journée du {{ \Carbon\Carbon::parse($habitude->date_jour)->format('d/m/Y') }}.</p>
                                    </div>
                                </div>
                            </div>

                            <form action="{{ route('habitudes.update', $habitude) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label class="form-label fw-bold">Date du suivi <span class="text-danger">*</span></label>
                                            <div class="input-group input-group-outline">
                                                <input type="date" name="date_jour" class="form-control @error('date_jour') is-invalid @enderror" 
                                                       value="{{ old('date_jour', $habitude->date_jour) }}">
                                            </div>
                                            @error('date_jour')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="mb-4">
                                            <h6 class="text-primary mb-3">
                                                <i class="fas fa-heartbeat me-2"></i>Santé Physique
                                            </h6>
                                            
                                            <div class="mb-3">
                                                <label class="form-label">Sommeil <span class="text-muted">(heures)</span></label>
                                                <div class="input-group input-group-outline">
                                                    <input type="number" step="0.1" name="sommeil_heures" 
                                                           class="form-control @error('sommeil_heures') is-invalid @enderror" 
                                                           value="{{ old('sommeil_heures', $habitude->sommeil_heures) }}">
                                                    <span class="input-group-text">h</span>
                                                </div>
                                                @error('sommeil_heures')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Eau consommée <span class="text-muted">(litres)</span></label>
                                                <div class="input-group input-group-outline">
                                                    <input type="number" step="0.1" name="eau_litres" 
                                                           class="form-control @error('eau_litres') is-invalid @enderror" 
                                                           value="{{ old('eau_litres', $habitude->eau_litres) }}">
                                                    <span class="input-group-text">L</span>
                                                </div>
                                                @error('eau_litres')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Activité sportive <span class="text-muted">(minutes)</span></label>
                                                <div class="input-group input-group-outline">
                                                    <input type="number" name="sport_minutes" 
                                                           class="form-control @error('sport_minutes') is-invalid @enderror" 
                                                           value="{{ old('sport_minutes', $habitude->sport_minutes) }}">
                                                    <span class="input-group-text">min</span>
                                                </div>
                                                @error('sport_minutes')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
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
                                                    <input type="number" name="stress_niveau" 
                                                           class="form-control @error('stress_niveau') is-invalid @enderror" 
                                                           value="{{ old('stress_niveau', $habitude->stress_niveau) }}">
                                                    <span class="input-group-text">/10</span>
                                                </div>
                                                @error('stress_niveau')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Méditation <span class="text-muted">(minutes)</span></label>
                                                <div class="input-group input-group-outline">
                                                    <input type="number" name="meditation_minutes" 
                                                           class="form-control @error('meditation_minutes') is-invalid @enderror" 
                                                           value="{{ old('meditation_minutes', $habitude->meditation_minutes) }}">
                                                    <span class="input-group-text">min</span>
                                                </div>
                                                @error('meditation_minutes')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
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
                                                    <input type="number" name="temps_ecran_minutes" 
                                                           class="form-control @error('temps_ecran_minutes') is-invalid @enderror" 
                                                           value="{{ old('temps_ecran_minutes', $habitude->temps_ecran_minutes) }}">
                                                    <span class="input-group-text">min</span>
                                                </div>
                                                @error('temps_ecran_minutes')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Café <span class="text-muted">(tasses)</span></label>
                                                <div class="input-group input-group-outline">
                                                    <input type="number" name="cafe_cups" 
                                                           class="form-control @error('cafe_cups') is-invalid @enderror" 
                                                           value="{{ old('cafe_cups', $habitude->cafe_cups) }}">
                                                    <span class="input-group-text">tasses</span>
                                                </div>
                                                @error('cafe_cups')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Boutons d'action -->
                                <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                                    <a href="{{ route('objectifs.habitudes.index', $habitude->objectif_id) }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-arrow-left me-2"></i>Retour aux habitudes
                                    </a>
                                    <div>
                                        <a href="{{ route('objectifs.habitudes.index', $habitude->objectif_id) }}" class="btn btn-outline-secondary me-2">
                                            <i class="fas fa-times me-2"></i>Annuler
                                        </a>
                                        <button type="submit" class="btn bg-gradient-primary px-4">
                                            <i class="fas fa-save me-2"></i>Mettre à jour
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