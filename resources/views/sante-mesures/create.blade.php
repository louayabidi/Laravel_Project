{{-- 1. Utiliser le composant 'layout' --}}
<x-layout bodyClass="g-sidenav-show bg-gray-200">
    @push('styles')
    <link href="{{ asset('assets/css/sante-mesures.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/regime-styles.css') }}" rel="stylesheet">
    @endpush

    <x-header.header></x-header.header>


    {{-- 3. Votre contenu spécifique --}}
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">

        {{-- Navbar en utilisant le composant --}}
        <x-navbars.navs.auth titlePage="Suivi Santé"></x-navbars.navs.auth>

        <div class="container-fluid py-4">

            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Ajouter une mesure de santé</h6>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">

                                <div class="container mt-3">
                                    <form action="{{ route('sante-mesures.store') }}" method="POST">
                                        @csrf

                                        <!-- Messages d'erreur -->
                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul class="mb-0">
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif

                                        <div class="row">
                                            <!-- Colonne gauche -->
                                            <div class="col-md-6">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5 class="mb-0">Informations Principales</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="mb-3">
                                                            <label for="date_mesure" class="form-label">Date de mesure</label>
                                                            <input type="date" name="date_mesure" id="date_mesure"
                                                                   class="form-control border p-2" required
                                                                   value="{{ old('date_mesure', date('Y-m-d')) }}"
                                                                   max="{{ date('Y-m-d') }}">
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="poids_kg" class="form-label">Poids (kg)</label>
                                                            <input type="number" step="0.1" name="poids_kg" id="poids_kg"
                                                                   class="form-control border p-2" required
                                                                   value="{{ old('poids_kg') }}"
                                                                   min="20" max="300">
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="taille_cm" class="form-label">Taille (cm)</label>
                                                            <input type="number" name="taille_cm" id="taille_cm"
                                                                   class="form-control border p-2" required
                                                                   value="{{ old('taille_cm') }}"
                                                                   min="50" max="300">
                                                        </div>




                                                        <div class="mb-3">
                                                            <label class="form-label">IMC (calculé automatiquement)</label>
                                                            <div id="imc_display" class="form-control border p-2 bg-light">
                                                                -
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Section Régime -->
                                                <div class="card mt-4 regime-card">
                                                    <div class="card-header bg-gradient-info position-relative">
                                                        <h5 class="mb-0 text-white d-flex align-items-center">
                                                            <i class="material-icons me-2">fitness_center</i>
                                                            Information du Régime
                                                        </h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <div id="new_regime_fields">
                                                            <div class="mb-4">
                                                                <label for="type_regime" class="form-label">
                                                                    <i class="material-icons">sports_gymnastics</i>
                                                                    Type de Régime
                                                                </label>
                                                                <div class="regime-select-wrapper">
                                                                    <select name="type_regime" id="type_regime"
                                                                            class="form-control border p-2">
                                                                        <option value="">Sélectionner un type</option>
                                                                        <option value="Fitnesse" class="regime-option regime-fitnesse"
                                                                                {{ old('type_regime') == 'Fitnesse' ? 'selected' : '' }}>
                                                                            <i class="material-icons">directions_run</i> Fitnesse
                                                                        </option>
                                                                        <option value="musculation" class="regime-option regime-musculation"
                                                                                {{ old('type_regime') == 'musculation' ? 'selected' : '' }}>
                                                                            <i class="material-icons">fitness_center</i> Musculation
                                                                        </option>
                                                                        <option value="prise_de_poids" class="regime-option regime-prise-poids"
                                                                                {{ old('type_regime') == 'prise_de_poids' ? 'selected' : '' }}>
                                                                            <i class="material-icons">trending_up</i> Prise de poids
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="mb-4">
                                                                <label for="valeur_cible" class="form-label">
                                                                    <i class="material-icons">track_changes</i>
                                                                    Valeur Cible
                                                                </label>
                                                                <div class="input-group">
                                                                    <input type="number" step="0.01" name="valeur_cible"
                                                                           id="valeur_cible" class="form-control border"
                                                                           value="{{ old('valeur_cible') }}"
                                                                           placeholder="Entrez votre objectif">
                                                                    <span class="input-group-text">kg</span>
                                                                </div>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="description" class="form-label">
                                                                    <i class="material-icons">description</i>
                                                                    Description du Régime
                                                                </label>
                                                                <textarea name="description" id="description"
                                                                          class="form-control border p-2" rows="3"
                                                                          placeholder="Décrivez votre régime et vos objectifs...">{{ old('description') }}</textarea>
                                                                <small class="form-text text-muted">
                                                                    Détaillez vos objectifs et habitudes alimentaires
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Colonne droite -->
                                            <div class="col-md-6">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5 class="mb-0">Mesures Cardiaques</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="mb-3">
                                                            <label for="freq_cardiaque" class="form-label">
                                                                Fréquence cardiaque (bpm)
                                                            </label>
                                                            <input type="number" name="freq_cardiaque" id="freq_cardiaque"
                                                                   class="form-control border p-2" required
                                                                   value="{{ old('freq_cardiaque') }}"
                                                                   min="30" max="220">
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="tension_systolique" class="form-label">
                                                                Tension artérielle systolique (mmHg)
                                                            </label>
                                                            <input type="number" name="tension_systolique" id="tension_systolique"
                                                                   class="form-control border p-2" required
                                                                   value="{{ old('tension_systolique') }}"
                                                                   min="70" max="250">
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="tension_diastolique" class="form-label">
                                                                Tension artérielle diastolique (mmHg)
                                                            </label>
                                                            <input type="number" name="tension_diastolique" id="tension_diastolique"
                                                                   class="form-control border p-2" required
                                                                   value="{{ old('tension_diastolique') }}"
                                                                   min="40" max="150">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Remarques -->
                                        <div class="card mt-4">
                                            <div class="card-header">
                                                <h5 class="mb-0">Remarques (optionnel)</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <textarea name="remarque" id="remarque" class="form-control border p-2"
                                                              rows="3">{{ old('remarque') }}</textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Boutons -->
                                        <div class="mt-4">
                                            <button type="submit" class="btn btn-success">
                                                <i class="material-icons">save</i> Enregistrer
                                            </button>
                                            <a href="{{ route('sante-mesures.index') }}" class="btn btn-secondary">
                                                <i class="material-icons">cancel</i> Annuler
                                            </a>
                                        </div>
                                    </form>
                                </div>

                                @push('scripts')
                                <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    // Initialize regime type select styling
                                    const typeRegimeSelect = document.getElementById('type_regime');

                                    typeRegimeSelect.addEventListener('change', function() {
                                        const selectedOption = this.options[this.selectedIndex];
                                        this.className = 'form-control border p-2';
                                        if (this.value) {
                                            this.classList.add('regime-' + this.value.toLowerCase());
                                        }
                                    });

                                    // Fonction pour calculer l'IMC
                                    function calculerIMC() {
                                        const poids = document.getElementById('poids_kg').value;
                                        const taille = document.getElementById('taille_cm').value;
                                        const imcDisplay = document.getElementById('imc_display');

                                        if (poids && taille) {
                                            const tailleMetre = taille / 100;
                                            const imc = (poids / (tailleMetre * tailleMetre)).toFixed(2);
                                            imcDisplay.textContent = imc;

                                            // Ajouter une classe de couleur selon l'IMC
                                            imcDisplay.className = 'form-control border p-2';
                                            if (imc < 18.5) {
                                                imcDisplay.classList.add('text-warning');
                                                imcDisplay.textContent += ' (Insuffisance pondérale)';
                                            } else if (imc < 25) {
                                                imcDisplay.classList.add('text-success');
                                                imcDisplay.textContent += ' (Normal)';
                                            } else if (imc < 30) {
                                                imcDisplay.classList.add('text-warning');
                                                imcDisplay.textContent += ' (Surpoids)';
                                            } else {
                                                imcDisplay.classList.add('text-danger');
                                                imcDisplay.textContent += ' (Obésité)';
                                            }
                                        } else {
                                            imcDisplay.textContent = '-';
                                            imcDisplay.className = 'form-control border p-2 bg-light';
                                        }
                                    }

                                    // Écouter les changements de poids et taille
                                    document.getElementById('poids_kg').addEventListener('input', calculerIMC);
                                    document.getElementById('taille_cm').addEventListener('input', calculerIMC);

                                    // Calculer l'IMC initial si des valeurs sont présentes
                                    calculerIMC();
                                });
                                </script>
                                @endpush
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
