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
                            <!-- ✅ Bloc erreurs Laravel -->
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <strong> Des erreurs ont été détectées :</strong>
                                    <ul class="mb-0 mt-2">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

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

                            <form action="{{ route('objectifs.habitudes.store', $objectifId) }}" method="POST" novalidate>
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
                                                       value="{{ old('date_jour', $habitude->date_jour ?? date('Y-m-d')) }}">
                                            </div>
                                            @error('date_jour')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <!-- Santé physique -->
                                        <h6 class="text-primary mb-3"><i class="fas fa-heartbeat me-2"></i>Santé Physique</h6>

                                        <div class="mb-3">
                                            <label class="form-label">Sommeil (heures)</label>
                                            <div class="input-group input-group-outline">
                                                <input type="number" name="sommeil_heures" class="form-control"
                                                       value="{{ old('sommeil_heures', $habitude->sommeil_heures ?? '') }}">
                                                <span class="input-group-text">h</span>
                                            </div>
                                            @error('sommeil_heures')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Eau consommée (litres)</label>
                                            <div class="input-group input-group-outline">
                                                <input type="number" name="eau_litres" class="form-control"
                                                       value="{{ old('eau_litres', $habitude->eau_litres ?? '') }}">
                                                <span class="input-group-text">L</span>
                                            </div>
                                            @error('eau_litres')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Activité sportive (minutes)</label>
                                            <div class="input-group input-group-outline">
                                                <input type="number" name="sport_minutes" class="form-control"
                                                       value="{{ old('sport_minutes', $habitude->sport_minutes ?? '') }}">
                                                <span class="input-group-text">min</span>
                                            </div>
                                            @error('sport_minutes')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Colonne de droite -->
                                    <div class="col-md-6">
                                        <h6 class="text-success mb-3"><i class="fas fa-brain me-2"></i>Bien-être Mental</h6>

                                        <div class="mb-3">
                                            <label class="form-label">Niveau de stress (1–10)</label>
                                            <div class="input-group input-group-outline">
                                                <input type="number" name="stress_niveau" class="form-control"
                                                       value="{{ old('stress_niveau', $habitude->stress_niveau ?? '') }}">
                                                <span class="input-group-text">/10</span>
                                            </div>
                                            @error('stress_niveau')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Méditation (minutes)</label>
                                            <div class="input-group input-group-outline">
                                                <input type="number" name="meditation_minutes" class="form-control"
                                                       value="{{ old('meditation_minutes', $habitude->meditation_minutes ?? '') }}">
                                                <span class="input-group-text">min</span>
                                            </div>
                                            @error('meditation_minutes')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <h6 class="text-warning mb-3"><i class="fas fa-mobile-alt me-2"></i>Habitudes Quotidiennes</h6>

                                        <div class="mb-3">
                                            <label class="form-label">Temps d'écran (minutes)</label>
                                            <div class="input-group input-group-outline">
                                                <input type="number" name="temps_ecran_minutes" class="form-control"
                                                       value="{{ old('temps_ecran_minutes', $habitude->temps_ecran_minutes ?? '') }}">
                                                <span class="input-group-text">min</span>
                                            </div>
                                            @error('temps_ecran_minutes')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Café (tasses)</label>
                                            <div class="input-group input-group-outline">
                                                <input type="number" name="cafe_cups" class="form-control"
                                                       value="{{ old('cafe_cups', $habitude->cafe_cups ?? '') }}">
                                                <span class="input-group-text">tasses</span>
                                            </div>
                                            @error('cafe_cups')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Boutons -->
                                <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                                    <a href="{{ route('objectifs.habitudes.index', $objectifId) }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-arrow-left me-2"></i>Retour
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
