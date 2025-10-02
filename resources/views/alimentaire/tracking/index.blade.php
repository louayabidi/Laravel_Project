<x-layout bodyClass="g-sidenav-show bg-gradient-to-br from-indigo-50 to-blue-200 min-h-screen">
    <x-header.header></x-header.header>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Suivi Quotidien des Repas"></x-navbars.navs.auth>
        <div class="container-fluid py-8">
            <!-- Hero Section -->
            <div class="relative mb-8 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 p-8 text-white shadow-xl">
                <div class="absolute inset-0 bg-[url('https://source.unsplash.com/random/1920x1080/?healthy-food')] opacity-20 bg-cover"></div>
                <div class="relative">
                    <h2 class="text-4xl font-bold mb-2 animate__animated animate__fadeIn">Votre Progrès Quotidien</h2>
                    <p class="text-lg opacity-90">Suivez vos objectifs nutritionnels avec style et motivation !</p>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-12 col-lg-10">
                    <div class="card shadow-2xl border-0 bg-white/90 p-6">
                        <div class="card-header p-0 mt-n4 mx-3">
                            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg py-3 px-4">
                                <h6 class="text-white">
                                    <i class="fas fa-bullseye mr-2"></i> Suivi par Rapport à l'Objectif
                                </h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Tabs -->
                            <ul class="nav nav-tabs mb-4" id="nutritionTabs" role="tablist">
                                <li class="nav-item">
                                    <button class="nav-link active" id="goals-tab" data-bs-toggle="tab" data-bs-target="#goals" role="tab" aria-controls="goals" aria-selected="true">Objectifs</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" id="consumption-tab" data-bs-toggle="tab" data-bs-target="#consumption" role="tab" aria-controls="consumption" aria-selected="false">Consommation</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" id="progress-tab" data-bs-toggle="tab" data-bs-target="#progress" role="tab" aria-controls="progress" aria-selected="false">Progrès</button>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <!-- Goals Tab -->
                                <div class="tab-pane fade show active" id="goals" role="tabpanel" aria-labelledby="goals-tab">
                                    <h5 class="text-lg font-semibold text-gray-700 mb-4"><i class="fas fa-bullseye mr-2 text-blue-500"></i> Objectif Actuel</h5>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="flex items-center">
                                            <i class="fas fa-flag-checkered text-blue-500 mr-3"></i>
                                            <p><strong>Type:</strong> {{ ucfirst($goal->goal_type == 'lose' ? 'Perdre du poids' : ($goal->goal_type == 'maintain' ? 'Maintenir le poids' : 'Prendre du poids')) }}</p>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-fire text-blue-500 mr-3"></i>
                                            <p><strong>Calories:</strong> {{ $goal->daily_calories ?? 0 }} kcal</p>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-dumbbell text-blue-500 mr-3"></i>
                                            <p><strong>Protéines:</strong> {{ $goal->daily_protein ?? 0 }} g</p>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-bread-slice text-blue-500 mr-3"></i>
                                            <p><strong>Glucides:</strong> {{ $goal->daily_carbs ?? 0 }} g</p>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-cheese text-blue-500 mr-3"></i>
                                            <p><strong>Lipides:</strong> {{ $goal->daily_fat ?? 0 }} g</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Consumption Tab -->
                                <div class="tab-pane fade" id="consumption" role="tabpanel" aria-labelledby="consumption-tab">
                                    <h5 class="text-lg font-semibold text-gray-700 mb-4"><i class="fas fa-utensils mr-2 text-blue-500"></i> Consommation Aujourd'hui</h5>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="flex items-center">
                                            <i class="fas fa-fire text-blue-500 mr-3"></i>
                                            <p><strong>Calories:</strong> {{ $dailyTotals['calories'] ?? 0 }} kcal
                                                <span data-bs-toggle="tooltip" title="Calories restantes ou dépassées">
                                                    ({{ $remaining['calories'] > 0 ? 'Restant: ' . $remaining['calories'] : 'Dépassé de ' . abs($remaining['calories']) }})
                                                </span>
                                            </p>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-dumbbell text-blue-500 mr-3"></i>
                                            <p><strong>Protéines:</strong> {{ $dailyTotals['protein'] ?? 0 }} g
                                                <span data-bs-toggle="tooltip" title="Protéines restantes ou dépassées">
                                                    ({{ $remaining['protein'] > 0 ? 'Restant: ' . $remaining['protein'] : 'Dépassé de ' . abs($remaining['protein']) }} g)
                                                </span>
                                            </p>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-bread-slice text-blue-500 mr-3"></i>
                                            <p><strong>Glucides:</strong> {{ $dailyTotals['carbs'] ?? 0 }} g
                                                <span data-bs-toggle="tooltip" title="Glucides restants ou dépassés">
                                                    ({{ $remaining['carbs'] > 0 ? 'Restant: ' . $remaining['carbs'] : 'Dépassé de ' . abs($remaining['carbs']) }} g)
                                                </span>
                                            </p>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-cheese text-blue-500 mr-3"></i>
                                            <p><strong>Lipides:</strong> {{ $dailyTotals['fat'] ?? 0 }} g
                                                <span data-bs-toggle="tooltip" title="Lipides restants ou dépassés">
                                                    ({{ $remaining['fat'] > 0 ? 'Restant: ' . $remaining['fat'] : 'Dépassé de ' . abs($remaining['fat']) }} g)
                                                </span>
                                            </p>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-candy-cane text-blue-500 mr-3"></i>
                                            <p><strong>Sucre:</strong> {{ $dailyTotals['sugar'] ?? 0 }} g</p>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-seedling text-blue-500 mr-3"></i>
                                            <p><strong>Fibres:</strong> {{ $dailyTotals['fiber'] ?? 0 }} g</p>
                                        </div>
                                    </div>
                                    <!-- Progress Bars -->
                                    <div class="mt-6">
                                        <h6 class="text-md font-semibold text-gray-600 mb-3">Progression</h6>
                                        <div class="mb-3">
                                            <label class="text-sm text-gray-600">Calories</label>
                                            <div class="progress h-5">
                                                <div class="progress-bar bg-blue-500" role="progressbar" style="width: {{ min(($dailyTotals['calories'] / max($goal->daily_calories, 1)) * 100, 100) }}%;" aria-valuenow="{{ $dailyTotals['calories'] ?? 0 }}" aria-valuemin="0" aria-valuemax="{{ $goal->daily_calories ?? 1 }}"></div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="text-sm text-gray-600">Protéines</label>
                                            <div class="progress h-5">
                                                <div class="progress-bar bg-green-500" role="progressbar" style="width: {{ min(($dailyTotals['protein'] / max($goal->daily_protein, 1)) * 100, 100) }}%;" aria-valuenow="{{ $dailyTotals['protein'] ?? 0 }}" aria-valuemin="0" aria-valuemax="{{ $goal->daily_protein ?? 1 }}"></div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="text-sm text-gray-600">Glucides</label>
                                            <div class="progress h-5">
                                                <div class="progress-bar bg-yellow-500" role="progressbar" style="width: {{ min(($dailyTotals['carbs'] / max($goal->daily_carbs, 1)) * 100, 100) }}%;" aria-valuenow="{{ $dailyTotals['carbs'] ?? 0 }}" aria-valuemin="0" aria-valuemax="{{ $goal->daily_carbs ?? 1 }}"></div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="text-sm text-gray-600">Lipides</label>
                                            <div class="progress h-5">
                                                <div class="progress-bar bg-orange-500" role="progressbar" style="width: {{ min(($dailyTotals['fat'] / max($goal->daily_fat, 1)) * 100, 100) }}%;" aria-valuenow="{{ $dailyTotals['fat'] ?? 0 }}" aria-valuemin="0" aria-valuemax="{{ $goal->daily_fat ?? 1 }}"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Progress Comments Tab -->
                                <div class="tab-pane fade" id="progress" role="tabpanel" aria-labelledby="progress-tab">
                                    <h5 class="text-lg font-semibold text-gray-700 mb-4"><i class="fas fa-chart-line mr-2 text-blue-500"></i> Commentaires sur le Progrès</h5>
                                    <ul class="list-disc pl-5">
                                        <li><strong>Calories:</strong> {{ $messages['calories'] ?? 'Aucun commentaire' }}</li>
                                        <li><strong>Protéines:</strong> {{ $messages['protein'] ?? 'Aucun commentaire' }}</li>
                                        <li><strong>Glucides:</strong> {{ $messages['carbs'] ?? 'Aucun commentaire' }}</li>
                                        <li><strong>Lipides:</strong> {{ $messages['fat'] ?? 'Aucun commentaire' }}</li>
                                    </ul>
                                    <!-- Nutrition Chart -->
                                    @if (!empty($dailyTotals) && ($dailyTotals['calories'] > 0 || $dailyTotals['protein'] > 0 || $dailyTotals['carbs'] > 0 || $dailyTotals['fat'] > 0))
                                        <div class="mt-6">
                                            <h6 class="text-md font-semibold text-gray-600 mb-3">Objectifs vs. Consommation</h6>
                                            <canvas id="nutritionChart" height="200"></canvas>
                                            <div id="chart-error" class="hidden text-red-600 text-sm mt-2"></div>
                                        </div>
                                    @else
                                        <p class="text-gray-600 italic mt-4">Aucune donnée pour afficher le graphique.</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex justify-end space-x-4 mt-6">
                                <a href="{{ route('meal-foods.create') }}" class="inline-flex items-center bg-gradient-to-r from-blue-500 to-indigo-600 text-white text-sm font-semibold px-6 py-3 rounded-lg hover:from-blue-600 hover:to-indigo-700 transform hover:scale-105 transition" data-bs-toggle="tooltip" title="Ajouter un aliment" aria-label="Ajouter un aliment">
                                    <i class="fas fa-plus mr-2"></i> Ajouter un Aliment
                                </a>
                                <a href="{{ route('goals.index') }}" class="inline-flex items-center bg-gray-500 text-white text-sm font-semibold px-6 py-3 rounded-lg hover:bg-gray-600 transform hover:scale-105 transition" data-bs-toggle="tooltip" title="Voir les objectifs" aria-label="Voir les objectifs">
                                    <i class="fas fa-bullseye mr-2"></i> Voir les Objectifs
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
    @push('js')
        <!-- Include Chart.js and Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <style>
            #nutritionChart {
                max-width: 100%;
                height: 200px !important;
                display: block;
            }
        </style>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                // Initialize Bootstrap Tooltips
                const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
                tooltipTriggerList.forEach(el => new bootstrap.Tooltip(el));

                // Nutrition Chart
                const canvas = document.getElementById('nutritionChart');
                const errorDiv = document.getElementById('chart-error');

                if (!canvas) {
                    console.error('Canvas element not found');
                    if (errorDiv) {
                        errorDiv.textContent = 'Erreur : Élément canvas introuvable.';
                        errorDiv.classList.remove('hidden');
                    }
                    return;
                }

                if (!window.Chart) {
                    console.error('Chart.js not loaded');
                    if (errorDiv) {
                        errorDiv.textContent = 'Erreur : Chart.js non chargé.';
                        errorDiv.classList.remove('hidden');
                    }
                    return;
                }

                if (!canvas.getContext) {
                    console.error('Canvas context unavailable');
                    if (errorDiv) {
                        errorDiv.textContent = 'Erreur : Contexte canvas indisponible.';
                        errorDiv.classList.remove('hidden');
                    }
                    return;
                }

                @if (!empty($dailyTotals) && ($dailyTotals['calories'] > 0 || $dailyTotals['protein'] > 0 || $dailyTotals['carbs'] > 0 || $dailyTotals['fat'] > 0))
                    try {
                        const ctx = canvas.getContext('2d');
                        const data = {
                            goals: [{{ $goal->daily_calories ?? 0 }}, {{ $goal->daily_protein ?? 0 }}, {{ $goal->daily_carbs ?? 0 }}, {{ $goal->daily_fat ?? 0 }}],
                            consumed: [{{ $dailyTotals['calories'] ?? 0 }}, {{ $dailyTotals['protein'] ?? 0 }}, {{ $dailyTotals['carbs'] ?? 0 }}, {{ $dailyTotals['fat'] ?? 0 }}]
                        };
                        console.log('Chart Data:', data);

                        if (data.consumed.every(val => val <= 0 || isNaN(val))) {
                            throw new Error('Invalid consumption data: ' + JSON.stringify(data.consumed));
                        }

                        new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: ['Calories', 'Protéines', 'Glucides', 'Lipides'],
                                datasets: [
                                    {
                                        label: 'Objectifs',
                                        data: data.goals,
                                        backgroundColor: 'rgba(33, 150, 243, 0.4)', // Blue
                                        borderColor: '#2196F3',
                                        borderWidth: 1
                                    },
                                    {
                                        label: 'Consommé',
                                        data: data.consumed,
                                        backgroundColor: 'rgba(76, 175, 80, 0.4)', // Green
                                        borderColor: '#4CAF50',
                                        borderWidth: 1
                                    }
                                ]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        title: { display: true, text: 'Valeurs (kcal/g)' }
                                    }
                                },
                                plugins: {
                                    legend: { position: 'top', labels: { font: { size: 14, weight: 'bold' } } },
                                    tooltip: {
                                        callbacks: {
                                            label: ctx => `${ctx.dataset.label}: ${ctx.raw.toFixed(2)}${ctx.datasetIndex === 0 ? ' kcal' : ' g'}`
                                        }
                                    }
                                }
                            }
                        });
                    } catch (error) {
                        console.error('Chart rendering error:', error);
                        if (errorDiv) {
                            errorDiv.textContent = 'Erreur : Impossible de rendre le graphique - ' + error.message;
                            errorDiv.classList.remove('hidden');
                        }
                    }
                @else
                    console.warn('No valid chart data');
                    if (errorDiv) {
                        errorDiv.textContent = 'Aucune donnée pour afficher le graphique.';
                        errorDiv.classList.remove('hidden');
                    }
                @endif

                // Navbar Fallback
                if (typeof navbarColorOnResize === 'function') {
                    const navbar = document.querySelector('.navbar');
                    if (navbar) {
                        try {
                            navbarColorOnResize();
                        } catch (error) {
                            console.error('Navbar error:', error);
                        }
                    } else {
                        console.warn('Navbar not found, skipping navbarColorOnResize.');
                    }
                } else {
                    console.warn('navbarColorOnResize function not defined.');
                }
            });
        </script>
    @endpush
</x-layout>