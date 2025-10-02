
<x-layout bodyClass="g-sidenav-show bg-gradient-to-br from-gray-50 to-blue-100">
    <x-header.header></x-header.header>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Détails de votre objectif"></x-navbars.navs.auth>
        <div class="container-fluid py-6">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-10">
                    <!-- Header Card -->
                    <div class="card shadow-2xl border-0 mb-5">
                        <div class="card-header p-0 position-relative mt-n5 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h4 class="text-white ps-4">
                                    <i class="fas fa-bullseye me-2"></i> Votre objectif alimentaire
                                </h4>
                                <p class="text-white ps-4 mb-0">Suivez vos progrès vers une vie plus saine !</p>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <!-- Personal Information -->
                            <div class="mb-5">
                                <h6 class="text-uppercase text-sm font-weight-bold text-gray-700 mb-3">
                                    <i class="fas fa-user me-2 text-primary"></i> Informations personnelles
                                </h6>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-calendar-alt text-primary me-3"></i>
                                            <div>
                                                <strong>Âge :</strong> {{ $goal->age }} ans
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="d-flex align-items-center">
                                            <i class="fas {{ $goal->gender == 'male' ? 'fa-mars' : 'fa-venus' }} text-primary me-3"></i>
                                            <div>
                                                <strong>Sexe :</strong> {{ ucfirst($goal->gender == 'male' ? 'Homme' : 'Femme') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-weight text-primary me-3"></i>
                                            <div>
                                                <strong>Poids :</strong> {{ $goal->weight }} kg
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-ruler-vertical text-primary me-3"></i>
                                            <div>
                                                <strong>Taille :</strong> {{ $goal->height }} cm
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Activity & Goal -->
                            <div class="mb-5">
                                <h6 class="text-uppercase text-sm font-weight-bold text-gray-700 mb-3">
                                    <i class="fas fa-running me-2 text-primary"></i> Activité & Objectif
                                </h6>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-heartbeat text-primary me-3"></i>
                                            <div>
                                                <strong>Niveau d'activité :</strong> 
                                                {{ ucfirst(str_replace('_', ' ', $goal->activity_level)) }}
                                                <i class="fas fa-info-circle text-gray-500 ms-2" data-toggle="tooltip" title="{{ $goal->activity_level == 'sedentary' ? 'Peu ou pas d\'exercice' : ($goal->activity_level == 'light' ? 'Exercice léger 1-3 jours/semaine' : ($goal->activity_level == 'moderate' ? 'Exercice modéré 3-5 jours/semaine' : ($goal->activity_level == 'active' ? 'Exercice intense 6-7 jours/semaine' : 'Exercice très intense ou travail physique'))) }}"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-flag-checkered text-primary me-3"></i>
                                            <div>
                                                <strong>Objectif :</strong> 
                                                {{ ucfirst($goal->goal_type == 'lose' ? 'Perdre du poids' : ($goal->goal_type == 'maintain' ? 'Maintenir le poids' : 'Prendre du poids')) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-fire text-primary me-3"></i>
                                            <div>
                                                <strong>BMR :</strong> {{ $goal->bmr }} kcal
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-bolt text-primary me-3"></i>
                                            <div>
                                                <strong>Calories quotidiennes :</strong> {{ $goal->daily_calories }} kcal
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Nutrition Goals -->
                            <div class="mb-5">
                                <h6 class="text-uppercase text-sm font-weight-bold text-gray-700 mb-3">
                                    <i class="fas fa-utensils me-2 text-primary"></i> Objectifs nutritionnels
                                </h6>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-drumstick-bite text-primary me-3"></i>
                                            <div>
                                                <strong>Protéines :</strong> {{ $goal->daily_protein ?? 'N/A' }} g
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-bread-slice text-primary me-3"></i>
                                            <div>
                                                <strong>Glucides :</strong> {{ $goal->daily_carbs ?? 'N/A' }} g
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-cheese text-primary me-3"></i>
                                            <div>
                                                <strong>Lipides :</strong> {{ $goal->daily_fat ?? 'N/A' }} g
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Nutrition Breakdown Chart -->
                                @if ($goal->daily_protein || $goal->daily_carbs || $goal->daily_fat)
                                    <div class="mt-4">
                                        <canvas id="nutritionChart" height="200"></canvas>
                                    </div>
                                @endif
                            </div>

                            <!-- Status and Actions -->
                            <div class="mb-4">
                                <h6 class="text-uppercase text-sm font-weight-bold text-gray-700 mb-3">
                                    <i class="fas fa-check-circle me-2 text-primary"></i> Statut
                                </h6>
                                <div class="d-flex align-items-center mb-3">
                                    <i class="fas fa-toggle-{{ $goal->is_active ? 'on' : 'off' }} text-primary me-3"></i>
                                    <div>
                                        <strong>Actif :</strong> {{ $goal->is_active ? 'Oui' : 'Non' }}
                                    </div>
                                </div>
                                @if (!$goal->is_active)
                                    <form action="{{ route('goals.set-active', $goal->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn bg-gradient-success transition duration-300 hover:scale-105" onclick="return confirm('Voulez-vous activer cet objectif ?')">
                                            <i class="fas fa-play me-2"></i> Activer cet objectif
                                            <span class="spinner-border spinner-border-sm ms-2 d-none" role="status" aria-hidden="true"></span>
                                        </button>
                                    </form>
                                @endif
                                <a href="{{ route('goals.index') }}" class="btn bg-gradient-primary transition duration-300 hover:scale-105">
                                    <i class="fas fa-arrow-left me-2"></i> Retour à la liste
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <x-footers.auth></x-footers.auth>
        </div>
    </main>
    <x-plugins></x-plugins>

    <!-- Chart.js for Nutrition Breakdown -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.min.js"></script>
    <script>
        // Nutrition Chart
        @if ($goal->daily_protein || $goal->daily_carbs || $goal->daily_fat)
            const ctx = document.getElementById('nutritionChart').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Protéines', 'Glucides', 'Lipides'],
                    datasets: [{
                        data: [
                            {{ $goal->daily_protein ?? 0 }},
                            {{ $goal->daily_carbs ?? 0 }},
                            {{ $goal->daily_fat ?? 0 }}
                        ],
                        backgroundColor: ['#4CAF50', '#2196F3', '#FF9800'],
                        borderColor: '#fff',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: { font: { size: 14, weight: 'bold' } }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.label + ': ' + context.raw + ' g';
                                }
                            }
                        }
                    }
                }
            });
        @endif

        // Form Submission Spinner
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function(e) {
                const submitButton = this.querySelector('button[type="submit"]');
                const spinner = submitButton.querySelector('.spinner-border');
                submitButton.disabled = true;
                spinner.classList.remove('d-none');
            });
        });

        // Initialize Tooltips
        document.querySelectorAll('[data-toggle="tooltip"]').forEach(element => {
            new bootstrap.Tooltip(element);
        });
    </script>
</x-layout>
