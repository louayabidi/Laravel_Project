<x-layout bodyClass="g-sidenav-show bg-gray-200">
    @push('styles')
        <link href="{{ asset('assets/css/sante-mesures.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/regime-styles.css') }}" rel="stylesheet">
    @endpush

    <x-header.header></x-header.header>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Ajouter une mesure de santé"></x-navbars.navs.auth>

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Ajouter une mesure de santé</h6>
                            </div>
                        </div>

                        <div class="card-body">
                            <form action="{{ route('sante-mesures.store') }}" method="POST">
                                @csrf

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
                                        <div class="mb-4">
                                            <label for="date_mesure" class="form-label fw-bold">
                                                Date de mesure
                                            </label>
                                            <input type="date" name="date_mesure" id="date_mesure"
                                                   class="form-control @error('date_mesure') is-invalid @enderror"
                                                   value="{{ old('date_mesure', now()->format('Y-m-d')) }}" readonly>
                                            @error('date_mesure')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="mb-4">
                                            <label for="poids_kg" class="form-label fw-bold">Poids (kg)</label>
                                            <input type="number" step="0.1" name="poids_kg" id="poids_kg"
                                                   class="form-control @error('poids_kg') is-invalid @enderror"
                                                   value="{{ old('poids_kg') }}" min="20" max="300">
                                            @error('poids_kg')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="mb-4">
                                            <label for="taille_cm" class="form-label fw-bold">Taille (cm)</label>
                                            <input type="number" name="taille_cm" id="taille_cm"
                                                   class="form-control @error('taille_cm') is-invalid @enderror"
                                                   value="{{ old('taille_cm') }}" min="50" max="300">
                                            @error('taille_cm')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label fw-bold">IMC (calculé automatiquement)</label>
                                            <div id="imc_display" class="form-control bg-light">
                                                -
                                            </div>
                                        </div>

                                        <!-- Régime -->
                                        <div class="mb-4">
                                            <label for="type_regime" class="form-label fw-bold">Type de Régime</label>
                                            <select name="type_regime" id="type_regime"
                                                    class="form-control @error('type_regime') is-invalid @enderror">
                                                <option value="">Sélectionner un type</option>
                                                <option value="Diabète" {{ old('type_regime') == 'Diabète' ? 'selected' : '' }}>Diabète</option>
                                                <option value="Hypertension" {{ old('type_regime') == 'Hypertension' ? 'selected' : '' }}>Hypertension</option>
                                                <option value="Grossesse" {{ old('type_regime') == 'Grossesse' ? 'selected' : '' }}>Grossesse</option>
                                                <option value="Cholestérol" {{ old('type_regime') == 'Cholestérol' ? 'selected' : '' }}>Cholestérol élevé</option>
                                            </select>
                                            @error('type_regime')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="mb-4">
                                            <label for="valeur_cible" class="form-label fw-bold">Valeur cible</label>
                                            <input type="number" step="0.01" name="valeur_cible" id="valeur_cible"
                                                   class="form-control @error('valeur_cible') is-invalid @enderror"
                                                   value="{{ old('valeur_cible') }}">
                                            @error('valeur_cible')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="mb-4">
                                            <label for="description" class="form-label fw-bold">Description du Régime</label>
                                            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description') }}</textarea>
                                            @error('description')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Colonne droite -->
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label for="freq_cardiaque" class="form-label fw-bold">Fréquence cardiaque (bpm)</label>
                                            <input type="number" name="freq_cardiaque" id="freq_cardiaque"
                                                   class="form-control @error('freq_cardiaque') is-invalid @enderror"
                                                   value="{{ old('freq_cardiaque') }}" min="30" max="220">
                                            @error('freq_cardiaque')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="mb-4">
                                            <label for="tension_systolique" class="form-label fw-bold">Tension systolique (mmHg)</label>
                                            <input type="number" name="tension_systolique" id="tension_systolique"
                                                   class="form-control @error('tension_systolique') is-invalid @enderror"
                                                   value="{{ old('tension_systolique') }}" min="70" max="250">
                                            @error('tension_systolique')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="mb-4">
                                            <label for="tension_diastolique" class="form-label fw-bold">Tension diastolique (mmHg)</label>
                                            <input type="number" name="tension_diastolique" id="tension_diastolique"
                                                   class="form-control @error('tension_diastolique') is-invalid @enderror"
                                                   value="{{ old('tension_diastolique') }}" min="40" max="150">
                                            @error('tension_diastolique')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="mb-4">
                                            <label for="remarque" class="form-label fw-bold">Remarques</label>
                                            <textarea name="remarque" id="remarque" class="form-control">{{ old('remarque') }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <!-- Boutons -->
                                <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                                    <a href="{{ route('sante-mesures.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-arrow-left me-2"></i>Retour à la liste
                                    </a>
                                    <button type="submit" class="btn bg-gradient-primary px-4">
                                        <i class="fas fa-save me-2"></i>Enregistrer
                                    </button>
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

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const poids = document.getElementById('poids_kg');
            const taille = document.getElementById('taille_cm');
            const imcDisplay = document.getElementById('imc_display');

            function calculerIMC() {
                const p = parseFloat(poids.value);
                const t = parseFloat(taille.value);
                if (p && t) {
                    const imc = (p / ((t / 100) ** 2)).toFixed(2);
                    imcDisplay.textContent = imc;
                    imcDisplay.className = 'form-control';
                    if (imc < 18.5) {
                        imcDisplay.textContent += ' (Insuffisance pondérale)';
                        imcDisplay.classList.add('text-warning');
                    } else if (imc < 25) {
                        imcDisplay.textContent += ' (Normal)';
                        imcDisplay.classList.add('text-success');
                    } else if (imc < 30) {
                        imcDisplay.textContent += ' (Surpoids)';
                        imcDisplay.classList.add('text-warning');
                    } else {
                        imcDisplay.textContent += ' (Obésité)';
                        imcDisplay.classList.add('text-danger');
                    }
                } else {
                    imcDisplay.textContent = '-';
                    imcDisplay.className = 'form-control bg-light';
                }
            }

            poids.addEventListener('input', calculerIMC);
            taille.addEventListener('input', calculerIMC);
            calculerIMC();
        });
    </script>
    @endpush
</x-layout>
