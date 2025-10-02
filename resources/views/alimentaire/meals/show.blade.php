
<x-layout bodyClass="g-sidenav-show bg-gradient-to-br from-indigo-50 to-blue-200 min-h-screen">
    <x-header.header></x-header.header>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Détails de votre repas"></x-navbars.navs.auth>
        <div class="container-fluid py-8">
            <!-- Hero Section -->
<div class="relative mb-8 overflow-hidden rounded-2xl bg-gradient-to-r from-blue-500 to-indigo-600 h-48 p-8 text-white shadow-xl">
                <div class="absolute inset-0 bg-[url('https://source.unsplash.com/random/1920x1080/?healthy-food')] opacity-20 bg-cover bg-center"></div>
                <div class="relative z-10">
                    <h2 class="text-4xl font-bold mb-2 animate__animated animate__fadeIn">{{ ucfirst($meal->type) }}</h2>
                    <p class="text-lg opacity-90">Découvrez les détails nutritionnels de ce repas.</p>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-12 col-lg-10">
                    <div class="card shadow-2xl border-0 bg-white/90 backdrop-blur-md">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-4">
                                    <i class="fas fa-utensils mr-2"></i> Repas: {{ ucfirst($meal->type) }}
                                </h6>
                            </div>
                        </div>
                        <div class="card-body p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div class="flex items-center">
                                    <i class="fas fa-utensils text-blue-500 mr-3 text-lg"></i>
                                    <div>
                                        <strong class="text-gray-600">Type:</strong>
                                        <span class="text-sm">{{ ucfirst($meal->type) }}</span>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-calendar-alt text-blue-500 mr-3 text-lg"></i>
                                    <div>
                                        <strong class="text-gray-600">Date:</strong>
                                        <span class="text-sm">{{ $meal->date }}</span>
                                    </div>
                                </div>
                            </div>
                            <h6 class="text-lg font-semibold text-gray-700 mb-4">
                                <i class="fas fa-shopping-basket mr-2 text-blue-500"></i> Aliments ({{ $meal->mealFoods->count() }})
                            </h6>
                            <div class="table-responsive mb-6">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr class="text-gray-600">
                                            <th class="text-uppercase text-xs font-semibold opacity-80">Nom</th>
                                            <th class="text-uppercase text-xs font-semibold opacity-80">Quantité (g)</th>
                                            <th class="text-uppercase text-xs font-semibold opacity-80">Calories (kcal)</th>
                                            <th class="text-uppercase text-xs font-semibold opacity-80">Protéines (g)</th>
                                            <th class="text-uppercase text-xs font-semibold opacity-80">Glucides (g)</th>
                                            <th class="text-uppercase text-xs font-semibold opacity-80">Lipides (g)</th>
                                            <th class="text-uppercase text-xs font-semibold opacity-80">Sucres (g)</th>
                                            <th class="text-uppercase text-xs font-semibold opacity-80">Fibres (g)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($meal->mealFoods as $mealFood)
                                            <tr class="hover:bg-gray-50 transition-all duration-300">
                                                <td class="px-4 py-3">{{ $mealFood->food->name ?? 'N/A' }}</td>
                                                <td class="px-4 py-3">{{ number_format($mealFood->quantity, 2) }}</td>
                                                <td class="px-4 py-3">{{ number_format($mealFood->calories_total ?? 0, 2) }}</td>
                                                <td class="px-4 py-3">{{ number_format($mealFood->protein_total ?? 0, 2) }}</td>
                                                <td class="px-4 py-3">{{ number_format($mealFood->carbs_total ?? 0, 2) }}</td>
                                                <td class="px-4 py-3">{{ number_format($mealFood->fat_total ?? 0, 2) }}</td>
                                                <td class="px-4 py-3">{{ number_format($mealFood->sugar_total ?? 0, 2) }}</td>
                                                <td class="px-4 py-3">{{ number_format($mealFood->fiber_total ?? 0, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="bg-gray-100">
                                            <td class="px-4 py-3"><strong>Totaux</strong></td>
                                            <td class="px-4 py-3"></td>
                                            <td class="px-4 py-3"><strong>{{ number_format($totals['calories'] ?? 0, 2) }}</strong></td>
                                            <td class="px-4 py-3"><strong>{{ number_format($totals['protein'] ?? 0, 2) }}</strong></td>
                                            <td class="px-4 py-3"><strong>{{ number_format($totals['carbs'] ?? 0, 2) }}</strong></td>
                                            <td class="px-4 py-3"><strong>{{ number_format($totals['fat'] ?? 0, 2) }}</strong></td>
                                            <td class="px-4 py-3"><strong>{{ number_format($totals['sugar'] ?? 0, 2) }}</strong></td>
                                            <td class="px-4 py-3"><strong>{{ number_format($totals['fiber'] ?? 0, 2) }}</strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- Macronutrient Chart -->
                            @if (!empty($totals) && ($totals['protein'] > 0 || $totals['carbs'] > 0 || $totals['fat'] > 0))
                                <div class="mt-6">
                                    <h3 class="text-lg font-semibold text-gray-700 mb-4">
                                        <i class="fas fa-chart-pie mr-2 text-blue-500"></i> Répartition des Macronutriments
                                    </h3>
                                    <div class="relative">
                                        <canvas id="nutritionChart" height="200"></canvas>
                                        <div id="chart-error" class="hidden text-red-600 text-sm mt-2"></div>
                                    </div>
                                </div>
                            @else
                                <p class="text-gray-600 italic">Aucune donnée nutritionnelle disponible pour afficher le graphique.</p>
                            @endif
                            <div class="text-right mt-6">
                                <a href="{{ route('meals.index') }}" class="inline-flex items-center bg-gradient-to-r from-gray-400 to-gray-600 text-white font-semibold text-sm px-6 py-3 rounded-lg shadow-md hover:shadow-lg hover:from-gray-500 hover:to-gray-700 transform hover:scale-105 transition-all duration-300" data-bs-toggle="tooltip" title="Retour à la liste" aria-label="Retour à la liste">
                                    <i class="fas fa-arrow-left mr-2"></i> Retour
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

    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Animate.css for animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" integrity="sha512-c42qTSw/wPZ3/5LBzD+Bw5f7bSF2oxou6wEb+I/lqeaKV5FDIfMvvRp772y4jcJLKuGUOpbJMdg/BTl50fJYAw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Bootstrap 5 JavaScript CDN (without integrity to avoid 403 errors) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Chart.js for Nutrition Chart (alternative CDN) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>

    <!-- Tailwind CSS CDN (for prototyping) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        // Initialize Tooltips (Bootstrap 5 compatible)
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof bootstrap !== 'undefined') {
                document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(element => {
                    new bootstrap.Tooltip(element);
                });
            } else {
                console.warn('Bootstrap JavaScript is not loaded. Tooltips will not be initialized.');
            }
        });

        // Nutrition Chart with Enhanced Error Handling
        document.addEventListener('DOMContentLoaded', function () {
            const canvas = document.getElementById('nutritionChart');
            const errorDiv = document.getElementById('chart-error');

            // Check if Chart.js is loaded
            if (typeof Chart === 'undefined') {
                console.error('Chart.js is not loaded.');
                if (errorDiv) {
                    errorDiv.textContent = 'Erreur : Impossible de charger Chart.js. Vérifiez votre connexion ou essayez plus tard.';
                    errorDiv.classList.remove('hidden');
                }
                return;
            }

            // Check if canvas exists
            if (!canvas || !canvas.getContext) {
                console.error('Canvas element not found or context unavailable.');
                if (errorDiv) {
                    errorDiv.textContent = 'Erreur : Élément de graphique introuvable.';
                    errorDiv.classList.remove('hidden');
                }
                return;
            }

            @if (!empty($totals) && ($totals['protein'] > 0 || $totals['carbs'] > 0 || $totals['fat'] > 0))
                try {
                    const ctx = canvas.getContext('2d');
                    const protein = {{ $totals['protein'] ?? 0 }};
                    const carbs = {{ $totals['carbs'] ?? 0 }};
                    const fat = {{ $totals['fat'] ?? 0 }};

                    // Log totals for debugging
                    console.log('Nutrition Totals:', { protein, carbs, fat });

                    // Validate data
                    if (isNaN(protein) || isNaN(carbs) || isNaN(fat) || (protein <= 0 && carbs <= 0 && fat <= 0)) {
                        throw new Error('Invalid or zero nutrition data: ' + JSON.stringify({ protein, carbs, fat }));
                    }

                    new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: ['Protéines', 'Glucides', 'Lipides'],
                            datasets: [{
                                data: [protein, carbs, fat],
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
                                            return context.label + ': ' + context.raw.toFixed(2) + ' g';
                                        }
                                    }
                                }
                            }
                        }
                    });
                } catch (error) {
                    console.error('Error initializing chart:', error);
                    if (errorDiv) {
                        errorDiv.textContent = 'Erreur : Impossible d\'afficher le graphique. Données invalides ou manquantes.';
                        errorDiv.classList.remove('hidden');
                    }
                }
            @else
                console.warn('No valid nutrition data available for chart.');
                if (errorDiv) {
                    errorDiv.textContent = 'Aucune donnée nutritionnelle disponible pour afficher le graphique.';
                    errorDiv.classList.remove('hidden');
                }
            @endif
        });

        // Fallback for material-dashboard.min.js navbar error
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof navbarColorOnResize === 'function') {
                try {
                    const navbar = document.querySelector('.navbar');
                    if (navbar) {
                        navbarColorOnResize();
                    } else {
                        console.warn('Navbar element not found for navbarColorOnResize.');
                    }
                } catch (error) {
                    console.error('Error in navbarColorOnResize:', error);
                }
            }
        });
    </script>
</x-layout>
