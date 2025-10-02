
<x-layout bodyClass="g-sidenav-show bg-gray-100">
    <x-header.header></x-header.header>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Modifier votre objectif"></x-navbars.navs.auth>
        <div class="container-fluid py-6">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-8">
                    <div class="card shadow-lg my-4 border-0">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-4">
                                    <i class="fas fa-bullseye me-2"></i> Modifier votre objectif alimentaire
                                </h6>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <form action="{{ route('goals.update', $goal->id) }}" method="POST" id="goalForm">
                                @csrf
                                @method('PUT')

                                <!-- Personal Information Section -->
                                <h6 class="text-uppercase text-sm font-weight-bold mb-4">
                                    <i class="fas fa-user me-2"></i> Informations personnelles
                                </h6>
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="input-group input-group-outline">
                                            <label class="form-label">Âge</label>
                                            <input type="number" name="age" value="{{ $goal->age }}" class="form-control" required>
                                            @error('age')
                                                <span class="text-danger text-sm mt-1">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="input-group input-group-outline">
                                            <label class="form-label">Sexe</label>
                                            <select name="gender" class="form-control" required>
                                                <option value="male" {{ $goal->gender == 'male' ? 'selected' : '' }}>Homme</option>
                                                <option value="female" {{ $goal->gender == 'female' ? 'selected' : '' }}>Femme</option>
                                            </select>
                                            @error('gender')
                                                <span class="text-danger text-sm mt-1">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="input-group input-group-outline">
                                            <label class="form-label">Poids (kg)</label>
                                            <input type="number" step="0.1" name="weight" value="{{ $goal->weight }}" class="form-control" required>
                                            @error('weight')
                                                <span class="text-danger text-sm mt-1">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="input-group input-group-outline">
                                            <label class="form-label">Taille (cm)</label>
                                            <input type="number" step="0.1" name="height" value="{{ $goal->height }}" class="form-control" required>
                                            @error('height')
                                                <span class="text-danger text-sm mt-1">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Activity & Goals Section -->
                                <h6 class="text-uppercase text-sm font-weight-bold mb-4 mt-5">
                                    <i class="fas fa-running me-2"></i> Activité et objectifs
                                </h6>
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="input-group input-group-outline">
                                            <label class="form-label">Niveau d'activité</label>
                                            <select name="activity_level" class="form-control" required data-toggle="tooltip" title="Sélectionnez votre niveau d'activité quotidienne">
                                                <option value="sedentary" {{ $goal->activity_level == 'sedentary' ? 'selected' : '' }}>Sédentaire (peu ou pas d'exercice)</option>
                                                <option value="light" {{ $goal->activity_level == 'light' ? 'selected' : '' }}>Léger (exercice léger 1-3 jours/semaine)</option>
                                                <option value="moderate" {{ $goal->activity_level == 'moderate' ? 'selected' : '' }}>Modéré (exercice modéré 3-5 jours/semaine)</option>
                                                <option value="active" {{ $goal->activity_level == 'active' ? 'selected' : '' }}>Actif (exercice intense 6-7 jours/semaine)</option>
                                                <option value="very_active" {{ $goal->activity_level == 'very_active' ? 'selected' : '' }}>Très actif (exercice très intense ou travail physique)</option>
                                            </select>
                                            @error('activity_level')
                                                <span class="text-danger text-sm mt-1">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="input-group input-group-outline">
                                            <label class="form-label">Type d'objectif</label>
                                            <select name="goal_type" class="form-control" required data-toggle="tooltip" title="Choisissez votre objectif principal">
                                                <option value="lose" {{ $goal->goal_type == 'lose' ? 'selected' : '' }}>Perdre du poids</option>
                                                <option value="maintain" {{ $goal->goal_type == 'maintain' ? 'selected' : '' }}>Maintenir le poids</option>
                                                <option value="gain" {{ $goal->goal_type == 'gain' ? 'selected' : '' }}>Prendre du poids</option>
                                            </select>
                                            @error('goal_type')
                                                <span class="text-danger text-sm mt-1">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Nutrition Goals Section -->
                                <h6 class="text-uppercase text-sm font-weight-bold mb-4 mt-5">
                                    <i class="fas fa-utensils me-2"></i> Objectifs nutritionnels (optionnels)
                                </h6>
                                <div class="row">
                                    <div class="col-md-4 mb-4">
                                        <div class="input-group input-group-outline">
                                            <label class="form-label">Protéines (g/jour)</label>
                                            <input type="number" step="0.1" name="daily_protein" value="{{ $goal->daily_protein }}" class="form-control">
                                            @error('daily_protein')
                                                <span class="text-danger text-sm mt-1">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <div class="input-group input-group-outline">
                                            <label class="form-label">Glucides (g/jour)</label>
                                            <input type="number" step="0.1" name="daily_carbs" value="{{ $goal->daily_carbs }}" class="form-control">
                                            @error('daily_carbs')
                                                <span class="text-danger text-sm mt-1">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <div class="input-group input-group-outline">
                                            <label class="form-label">Lipides (g/jour)</label>
                                            <input type="number" step="0.1" name="daily_fat" value="{{ $goal->daily_fat }}" class="form-control">
                                            @error('daily_fat')
                                                <span class="text-danger text-sm mt-1">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Active Goal Checkbox -->
                                <div class="form-check mb-4">
                                    <input type="checkbox" name="is_active" value="1" class="form-check-input" id="isActive" {{ $goal->is_active ? 'checked' : '' }}>
                                    <label class="form-check-label" for="isActive">
                                        <i class="fas fa-check-circle me-2"></i> Activer cet objectif
                                    </label>
                                    @error('is_active')
                                        <span class="text-danger text-sm mt-1">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Submit Button -->
                                <div class="text-center">
                                    <button type="submit" class="btn bg-gradient-primary w-100 w-md-50 mt-3">
                                        <i class="fas fa-save me-2"></i> Mettre à jour l'objectif
                                        <span class="spinner-border spinner-border-sm ms-2 d-none" role="status" aria-hidden="true"></span>
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

    <!-- Custom JavaScript for Form Enhancements -->
    <script>
        document.getElementById('goalForm').addEventListener('submit', function(e) {
            const submitButton = this.querySelector('button[type="submit"]');
            const spinner = submitButton.querySelector('.spinner-border');
            submitButton.disabled = true;
            spinner.classList.remove('d-none');
        });

        // Initialize tooltips (if using Bootstrap or similar)
        document.querySelectorAll('[data-toggle="tooltip"]').forEach(element => {
            new bootstrap.Tooltip(element);
        });
    </script>
</x-layout>
