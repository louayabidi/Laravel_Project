
<x-layout bodyClass="g-sidenav-show bg-gradient-to-br from-indigo-50 to-blue-200 min-h-screen">
    <x-header.header></x-header.header>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Détails de l'Aliment"></x-navbars.navs.auth>
        <div class="container-fluid py-8">
            <!-- Hero Section -->
            <div class="relative mb-8 overflow-hidden rounded-2xl bg-gradient-to-r from-blue-500 to-indigo-600 p-8 text-white shadow-xl">
                <div class="absolute inset-0 bg-[url('https://source.unsplash.com/random/1920x1080/?healthy-food')] opacity-20 bg-cover bg-center"></div>
                <div class="relative z-10">
                    <h2 class="text-4xl font-bold mb-2 animate__animated animate__fadeIn">{{ $food->name }}</h2>
                    <p class="text-lg opacity-90">Découvrez les détails nutritionnels de cet aliment.</p>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-12 col-lg-8">
                    <div class="card shadow-2xl border-0 bg-white/90 backdrop-blur-md">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-4">
                                    <i class="fas fa-utensils mr-2"></i> Détails: {{ $food->name }}
                                </h6>
                            </div>
                        </div>
                        <div class="card-body p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div class="flex items-center">
                                    <i class="fas fa-utensils text-blue-500 mr-3 text-lg"></i>
                                    <div>
                                        <strong class="text-gray-600">Nom:</strong>
                                        <span class="text-sm">{{ $food->name }}</span>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-tag text-blue-500 mr-3 text-lg"></i>
                                    <div>
                                        <strong class="text-gray-600">Catégorie:</strong>
                                        <span class="text-sm">{{ $food->category }}</span>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-fire text-blue-500 mr-3 text-lg"></i>
                                    <div>
                                        <strong class="text-gray-600">Calories:</strong>
                                        <span class="text-sm">{{ $food->calories }} kcal</span>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-drumstick-bite text-blue-500 mr-3 text-lg"></i>
                                    <div>
                                        <strong class="text-gray-600">Protéines:</strong>
                                        <span class="text-sm">{{ $food->protein }} g</span>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-bread-slice text-blue-500 mr-3 text-lg"></i>
                                    <div>
                                        <strong class="text-gray-600">Glucides:</strong>
                                        <span class="text-sm">{{ $food->carbs }} g</span>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-cheese text-blue-500 mr-3 text-lg"></i>
                                    <div>
                                        <strong class="text-gray-600">Lipides:</strong>
                                        <span class="text-sm">{{ $food->fat }} g</span>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-candy-cane text-blue-500 mr-3 text-lg"></i>
                                    <div>
                                        <strong class="text-gray-600">Sucres:</strong>
                                        <span class="text-sm">{{ $food->sugar }} g</span>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-seedling text-blue-500 mr-3 text-lg"></i>
                                    <div>
                                        <strong class="text-gray-600">Fibres:</strong>
                                        <span class="text-sm">{{ $food->fiber }} g</span>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-check-circle text-blue-500 mr-3 text-lg"></i>
                                    <div>
                                        <strong class="text-gray-600">Personnalisé:</strong>
                                        <span class="text-sm">{{ $food->is_custom ? 'Oui' : 'Non' }}</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Macronutrient Chart -->
                            @if ($food->protein || $food->carbs || $food->fat)
                                <div class="mt-6">
                                    <h3 class="text-lg font-semibold text-gray-700 mb-4">
                                        <i class="fas fa-chart-pie mr-2 text-blue-500"></i> Répartition des Macronutriments
                                    </h3>
                                    <canvas id="nutritionChart" height="200"></canvas>
                                </div>
                            @else
                                <p class="text-muted">Aucune donnée nutritionnelle disponible pour afficher le graphique.</p>
                            @endif
                            <div class="text-right mt-6">
                                <a href="{{ route('foods.index') }}" class="inline-flex items-center bg-gradient-to-r from-gray-400 to-gray-600 text-white font-semibold text-sm px-6 py-3 rounded-lg shadow-md hover:shadow-lg hover:from-gray-500 hover:to-gray-700 transform hover:scale-105 transition-all duration-300" data-bs-toggle="tooltip" title="Retour à la liste">
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

    <!-- Chart.js for Nutrition Chart -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.min.js"></script>

    <!-- Tailwind CSS CDN (for prototyping) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        // Initialize Tooltips (Bootstrap 5 compatible)
        document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(element => {
            new bootstrap.Tooltip(element);
        });

        // Nutrition Chart
        @if ($food->protein || $food->carbs || $food->fat)
            const ctx = document.getElementById('nutritionChart').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Protéines', 'Glucides', 'Lipides'],
                    datasets: [{
                        data: [
                            {{ $food->protein ?? 0 }},
                            {{ $food->carbs ?? 0 }},
                            {{ $food->fat ?? 0 }}
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
    </script>
</x-layout>
