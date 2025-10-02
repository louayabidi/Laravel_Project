
<x-layout bodyClass="g-sidenav-show bg-gradient-to-br from-indigo-50 to-blue-200 min-h-screen">
    <x-header.header></x-header.header>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Ajouter un Repas"></x-navbars.navs.auth>
        <div class="container-fluid py-8">
            <!-- Hero Section -->
            <div class="relative mb-8 overflow-hidden rounded-2xl bg-gradient-to-r from-blue-500 to-indigo-600 p-8 text-white shadow-xl">
                <div class="absolute inset-0 bg-[url('https://source.unsplash.com/random/1920x1080/?healthy-food')] opacity-20 bg-cover bg-center"></div>
                <div class="relative z-10">
                    <h2 class="text-4xl font-bold mb-2 animate__animated animate__fadeIn">Créer un Nouveau Repas</h2>
                    <p class="text-lg opacity-90">Ajoutez un repas pour suivre votre nutrition !</p>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-12 col-lg-8">
                    <div class="card shadow-2xl border-0 bg-white/90 backdrop-blur-md">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-4">
                                    <i class="fas fa-utensils mr-2"></i> Ajouter un Repas
                                </h6>
                            </div>
                        </div>
                        <div class="card-body p-6">
                            <form action="{{ route('meals.store') }}" method="POST" class="space-y-6">
                                @csrf
                                <div class="relative">
                                    <label for="type" class="form-label text-sm font-medium text-gray-600">Type de Repas</label>
                                    <div class="flex items-center">
                                        <i class="fas fa-utensils text-blue-500 mr-3"></i>
                                        <select name="type" id="type" class="form-select w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300" required aria-describedby="type-error">
                                            <option value="breakfast">Petit-déjeuner</option>
                                            <option value="lunch">Déjeuner</option>
                                            <option value="dinner">Dîner</option>
                                            <option value="snack">Collation</option>
                                        </select>
                                    </div>
                                    @error('type')
                                        <span id="type-error" class="text-danger text-sm mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="relative">
                                    <label for="date" class="form-label text-sm font-medium text-gray-600">Date</label>
                                    <div class="flex items-center">
                                        <i class="fas fa-calendar-alt text-blue-500 mr-3"></i>
                                        <input type="date" name="date" id="date" class="form-control w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300" required value="{{ date('Y-m-d') }}" aria-describedby="date-error">
                                    </div>
                                    @error('date')
                                        <span id="date-error" class="text-danger text-sm mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                                <h6 class="text-lg font-semibold text-gray-700">
                                    <i class="fas fa-shopping-basket mr-2 text-blue-500"></i> Aliments
                                </h6>
                                <div id="foods-container" class="space-y-4">
                                    <div class="row mb-3 food-row animate__animated animate__fadeIn">
                                        <div class="col-md-6">
                                            <label class="form-label text-sm font-medium text-gray-600">Nom de l'Aliment</label>
                                            <div class="flex items-center">
                                                <i class="fas fa-utensils text-blue-500 mr-3"></i>
                                                <select name="foods[0][food_id]" class="form-select w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 food-select" required aria-describedby="food-0-error">
                                                    <option value="">Sélectionnez un aliment</option>
                                                    @foreach ($foods as $food)
                                                        <option value="{{ $food->id }}">{{ $food->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('foods.0.food_id')
                                                <span id="food-0-error" class="text-danger text-sm mt-1">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label text-sm font-medium text-gray-600">Quantité (g)</label>
                                            <div class="flex items-center">
                                                <i class="fas fa-weight text-blue-500 mr-3"></i>
                                                <input type="number" step="0.01" name="foods[0][quantity]" class="form-control w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300" required placeholder="Ex: 150" aria-describedby="quantity-0-error">
                                            </div>
                                            @error('foods.0.quantity')
                                                <span id="quantity-0-error" class="text-danger text-sm mt-1">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-danger remove-row mt-4 bg-gradient-to-r from-red-500 to-red-700 text-white font-semibold text-sm px-4 py-2 rounded-lg shadow-md hover:shadow-lg hover:from-red-600 hover:to-red-800 transform hover:scale-105 transition-all duration-300" data-bs-toggle="tooltip" title="Supprimer cet aliment">
                                                <i class="fas fa-trash mr-2"></i> Supprimer
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" id="add-food-row" class="btn bg-gradient-primary mb-3 inline-flex items-center bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-semibold text-sm px-6 py-2 rounded-lg shadow-md hover:shadow-lg hover:from-blue-600 hover:to-indigo-700 transform hover:scale-105 transition-all duration-300" data-bs-toggle="tooltip" title="Ajouter un autre aliment">
                                    <i class="fas fa-plus mr-2"></i> Ajouter un Aliment
                                </button>
                                <div class="flex space-x-4">
                                    <button type="submit" class="inline-flex items-center bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-semibold text-sm px-6 py-3 rounded-lg shadow-md hover:shadow-lg hover:from-blue-600 hover:to-indigo-700 transform hover:scale-105 transition-all duration-300 animate__animated animate__pulse animate__infinite animate__slower" data-bs-toggle="tooltip" title="Enregistrer le repas">
                                        <i class="fas fa-save mr-2"></i> Enregistrer
                                    </button>
                                    <a href="{{ route('meals.index') }}" class="inline-flex items-center bg-gradient-to-r from-gray-400 to-gray-600 text-white font-semibold text-sm px-6 py-3 rounded-lg shadow-md hover:shadow-lg hover:from-gray-500 hover:to-gray-700 transform hover:scale-105 transition-all duration-300" data-bs-toggle="tooltip" title="Retour à la liste">
                                        <i class="fas fa-arrow-left mr-2"></i> Annuler
                                    </a>
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

    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Animate.css for animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" integrity="sha512-c42qTSw/wPZ3/5LBzD+Bw5f7bSF2oxou6wEb+I/lqeaKV5FDIfMvvRp772y4jcJLKuGUOpbJMdg/BTl50fJYAw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Bootstrap 5 JavaScript CDN (without integrity to avoid 403 errors) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

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

        // Real-time validation feedback
        document.querySelectorAll('input, select').forEach(input => {
            input.addEventListener('input', function () {
                if (this.checkValidity()) {
                    this.classList.remove('border-red-500');
                    this.classList.add('border-green-500');
                } else {
                    this.classList.remove('border-green-500');
                    this.classList.add('border-red-500');
                }
            });
        });

        // Dynamic food row addition with animation
        let rowIndex = 1;
        document.getElementById('add-food-row').addEventListener('click', function () {
            const container = document.getElementById('foods-container');
            const newRow = document.createElement('div');
            newRow.classList.add('row', 'mb-3', 'food-row', 'animate__animated', 'animate__fadeIn');
            newRow.innerHTML = `
                <div class="col-md-6">
                    <label class="form-label text-sm font-medium text-gray-600">Nom de l'Aliment</label>
                    <div class="flex items-center">
                        <i class="fas fa-utensils text-blue-500 mr-3"></i>
                        <select name="foods[${rowIndex}][food_id]" class="form-select w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 food-select" required aria-describedby="food-${rowIndex}-error">
                            <option value="">Sélectionnez un aliment</option>
                            @foreach ($foods as $food)
                                <option value="{{ $food->id }}">{{ $food->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div id="food-${rowIndex}-error"></div>
                </div>
                <div class="col-md-4">
                    <label class="form-label text-sm font-medium text-gray-600">Quantité (g)</label>
                    <div class="flex items-center">
                        <i class="fas fa-weight text-blue-500 mr-3"></i>
                        <input type="number" step="0.01" name="foods[${rowIndex}][quantity]" class="form-control w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300" required placeholder="Ex: 150" aria-describedby="quantity-${rowIndex}-error">
                    </div>
                    <div id="quantity-${rowIndex}-error"></div>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger remove-row mt-4 bg-gradient-to-r from-red-500 to-red-700 text-white font-semibold text-sm px-4 py-2 rounded-lg shadow-md hover:shadow-lg hover:from-red-600 hover:to-red-800 transform hover:scale-105 transition-all duration-300" data-bs-toggle="tooltip" title="Supprimer cet aliment">
                        <i class="fas fa-trash mr-2"></i> Supprimer
                    </button>
                </div>
            `;
            container.appendChild(newRow);
            rowIndex++;
            // Reinitialize tooltips for new buttons
            if (typeof bootstrap !== 'undefined') {
                document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(element => {
                    new bootstrap.Tooltip(element);
                });
            }
        });

        // Remove food row with minimum row check
        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-row') && document.querySelectorAll('.food-row').length > 1) {
                const row = e.target.closest('.food-row');
                row.classList.add('animate__fadeOut');
                setTimeout(() => row.remove(), 500);
            }
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
