
<x-layout bodyClass="g-sidenav-show bg-gradient-to-br from-indigo-50 to-blue-200 min-h-screen">
    <x-header.header></x-header.header>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Modifier votre repas"></x-navbars.navs.auth>
        <div class="container-fluid py-8">
            <!-- Hero Section -->
            <div class="relative mb-8 overflow-hidden rounded-2xl bg-gradient-to-r from-blue-500 to-indigo-600 p-8 text-white shadow-xl">
                <div class="absolute inset-0 bg-[url('https://source.unsplash.com/random/1920x1080/?healthy-food')] opacity-20 bg-cover bg-center"></div>
                <div class="relative z-10">
                    <h2 class="text-4xl font-bold mb-2 animate__animated animate__fadeIn">Modifier le Repas</h2>
                    <p class="text-lg opacity-90">Mettez à jour les détails de votre {{ ucfirst($meal->type) }}.</p>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-12 col-lg-8">
                    <div class="card shadow-2xl border-0 bg-white/90 backdrop-blur-md">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-4">
                                    <i class="fas fa-utensils mr-2"></i> Modifier {{ ucfirst($meal->type) }}
                                </h6>
                            </div>
                        </div>
                        <div class="card-body p-6">
                            <form action="{{ route('meals.update', $meal->id) }}" method="POST" class="space-y-6">
                                @csrf
                                @method('PUT')
                                <!-- Basic Information -->
                                <div class="border-b border-gray-200 pb-4">
                                    <h3 class="text-lg font-semibold text-gray-700 mb-4">
                                        <i class="fas fa-info-circle mr-2 text-blue-500"></i> Informations de Base
                                    </h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="relative">
                                            <label for="type" class="form-label text-sm font-medium text-gray-600">Type</label>
                                            <div class="flex items-center">
                                                <i class="fas fa-utensils text-blue-500 mr-3"></i>
                                                <select name="type" id="type" class="form-control w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300" required aria-describedby="type-error">
                                                    <option value="breakfast" {{ $meal->type == 'breakfast' ? 'selected' : '' }}>Petit-déjeuner</option>
                                                    <option value="lunch" {{ $meal->type == 'lunch' ? 'selected' : '' }}>Déjeuner</option>
                                                    <option value="dinner" {{ $meal->type == 'dinner' ? 'selected' : '' }}>Dîner</option>
                                                    <option value="snack" {{ $meal->type == 'snack' ? 'selected' : '' }}>Collation</option>
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
                                                <input type="date" name="date" id="date" value="{{ old('date', $meal->date) }}" class="form-control w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300" required aria-describedby="date-error">
                                            </div>
                                            @error('date')
                                                <span id="date-error" class="text-danger text-sm mt-1">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <!-- Foods -->
                                <h6 class="text-lg font-semibold text-gray-700">
                                    <i class="fas fa-shopping-basket mr-2 text-blue-500"></i> Aliments
                                </h6>
                                <div id="foods-container" class="space-y-4">
                                    @foreach ($meal->mealFoods as $index => $mealFood)
                                        <div class="row mb-3 food-row animate__animated animate__fadeIn">
                                            <div class="col-md-6">
                                                <label class="form-label text-sm font-medium text-gray-600">Nom de l'Aliment</label>
                                                <div class="flex items-center">
                                                    <i class="fas fa-utensils text-blue-500 mr-3"></i>
                                                    <select name="foods[{{ $index }}][food_id]" class="form-control w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300" required aria-describedby="food-{{ $index }}-error">
                                                        <option value="">Sélectionnez un aliment</option>
                                                        @foreach ($foods as $food)
                                                            <option value="{{ $food->id }}" {{ $mealFood->food_id == $food->id ? 'selected' : '' }}>{{ $food->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @error("foods.{$index}.food_id")
                                                    <span id="food-{{ $index }}-error" class="text-danger text-sm mt-1">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label text-sm font-medium text-gray-600">Quantité (g)</label>
                                                <div class="flex items-center">
                                                    <i class="fas fa-weight text-blue-500 mr-3"></i>
                                                    <input type="number" step="0.01" name="foods[{{ $index }}][quantity]" value="{{ old("foods.{$index}.quantity", $mealFood->quantity) }}" class="form-control w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300" required placeholder="Ex: 150" aria-describedby="quantity-{{ $index }}-error">
                                                </div>
                                                @error("foods.{$index}.quantity")
                                                    <span id="quantity-{{ $index }}-error" class="text-danger text-sm mt-1">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-md-2">
                                                <button type="button" class="btn btn-danger remove-row mt-4 bg-gradient-to-r from-red-500 to-red-700 text-white font-semibold text-sm px-4 py-2 rounded-lg shadow-md hover:shadow-lg hover:from-red-600 hover:to-red-800 transform hover:scale-105 transition-all duration-300" data-bs-toggle="tooltip" title="Supprimer cet aliment">
                                                    <i class="fas fa-trash mr-2"></i> Supprimer
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <button type="button" id="add-food-row" class="btn bg-gradient-primary mb-3 inline-flex items-center bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-semibold text-sm px-6 py-2 rounded-lg shadow-md hover:shadow-lg hover:from-blue-600 hover:to-indigo-700 transform hover:scale-105 transition-all duration-300" data-bs-toggle="tooltip" title="Ajouter un autre aliment">
                                    <i class="fas fa-plus mr-2"></i> Ajouter un Aliment
                                </button>
                                <div class="text-right">
                                    <button type="submit" class="inline-flex items-center bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-semibold text-sm px-6 py-3 rounded-lg shadow-md hover:shadow-lg hover:from-blue-600 hover:to-indigo-700 transform hover:scale-105 transition-all duration-300 animate__animated animate__pulse animate__infinite animate__slower" data-bs-toggle="tooltip" title="Mettre à jour le repas">
                                        <i class="fas fa-save mr-2"></i> Mettre à jour
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
        let rowIndex = {{ $meal->mealFoods->count() }};
        document.getElementById('add-food-row').addEventListener('click', function () {
            const container = document.getElementById('foods-container');
            const newRow = document.createElement('div');
            newRow.classList.add('row', 'mb-3', 'food-row', 'animate__animated', 'animate__fadeIn');
            newRow.innerHTML = `
                <div class="col-md-6">
                    <label class="form-label text-sm font-medium text-gray-600">Nom de l'Aliment</label>
                    <div class="flex items-center">
                        <i class="fas fa-utensils text-blue-500 mr-3"></i>
                        <select name="foods[${rowIndex}][food_id]" class="form-control w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300" required aria-describedby="food-${rowIndex}-error">
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

        // Remove food row
        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-row')) {
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
