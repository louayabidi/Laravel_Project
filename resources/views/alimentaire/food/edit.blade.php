
<x-layout bodyClass="g-sidenav-show bg-gradient-to-br from-indigo-50 to-blue-200 min-h-screen">
    <x-header.header></x-header.header>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Modifier un Aliment"></x-navbars.navs.auth>
        <div class="container-fluid py-8">
            <!-- Hero Section -->
            <div class="relative mb-8 overflow-hidden rounded-2xl bg-gradient-to-r from-blue-500 to-indigo-600 p-8 text-white shadow-xl">
                <div class="absolute inset-0 bg-[url('https://source.unsplash.com/random/1920x1080/?healthy-food')] opacity-20 bg-cover bg-center"></div>
                <div class="relative z-10">
                    <h2 class="text-4xl font-bold mb-2 animate__animated animate__fadeIn">Modifier l'Aliment</h2>
                    <p class="text-lg opacity-90">Mettez à jour les informations nutritionnelles pour {{ $food->name }}.</p>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-12 col-lg-8">
                    <div class="card shadow-2xl border-0 bg-white/90 backdrop-blur-md">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-4">
                                    <i class="fas fa-utensils mr-2"></i> Modifier {{ $food->name }}
                                </h6>
                            </div>
                        </div>
                        <div class="card-body p-6">
                            <form action="{{ route('foods.update', $food->id) }}" method="POST" class="space-y-6">
                                @csrf
                                @method('PUT')
                                <!-- Basic Information -->
                                <div class="border-b border-gray-200 pb-4">
                                    <h3 class="text-lg font-semibold text-gray-700 mb-4">
                                        <i class="fas fa-info-circle mr-2 text-blue-500"></i> Informations de Base
                                    </h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="relative">
                                            <label for="name" class="form-label text-sm font-medium text-gray-600">Nom</label>
                                            <div class="flex items-center">
                                                <i class="fas fa-utensils text-blue-500 mr-3"></i>
                                                <input type="text" id="name" name="name" value="{{ old('name', $food->name) }}" class="form-control w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300" required aria-describedby="name-error">
                                            </div>
                                            @error('name')
                                                <span id="name-error" class="text-danger text-sm mt-1">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="relative">
                                            <label for="category" class="form-label text-sm font-medium text-gray-600">Catégorie</label>
                                            <div class="flex items-center">
                                                <i class="fas fa-tag text-blue-500 mr-3"></i>
                                                <input type="text" id="category" name="category" value="{{ old('category', $food->category) }}" class="form-control w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300" required aria-describedby="category-error">
                                            </div>
                                            @error('category')
                                                <span id="category-error" class="text-danger text-sm mt-1">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <!-- Nutritional Information -->
                                <div class="border-b border-gray-200 pb-4">
                                    <h3 class="text-lg font-semibold text-gray-700 mb-4">
                                        <i class="fas fa-chart-pie mr-2 text-blue-500"></i> Informations Nutritionnelles
                                    </h3>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div class="relative">
                                            <label for="calories" class="form-label text-sm font-medium text-gray-600">Calories (kcal)</label>
                                            <div class="flex items-center">
                                                <i class="fas fa-fire text-blue-500 mr-3"></i>
                                                <input type="number" id="calories" name="calories" step="0.01" value="{{ old('calories', $food->calories) }}" class="form-control w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300" required aria-describedby="calories-error">
                                            </div>
                                            @error('calories')
                                                <span id="calories-error" class="text-danger text-sm mt-1">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="relative">
                                            <label for="protein" class="form-label text-sm font-medium text-gray-600">Protéines (g)</label>
                                            <div class="flex items-center">
                                                <i class="fas fa-drumstick-bite text-blue-500 mr-3"></i>
                                                <input type="number" id="protein" name="protein" step="0.01" value="{{ old('protein', $food->protein) }}" class="form-control w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300" required aria-describedby="protein-error">
                                            </div>
                                            @error('protein')
                                                <span id="protein-error" class="text-danger text-sm mt-1">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="relative">
                                            <label for="carbs" class="form-label text-sm font-medium text-gray-600">Glucides (g)</label>
                                            <div class="flex items-center">
                                                <i class="fas fa-bread-slice text-blue-500 mr-3"></i>
                                                <input type="number" id="carbs" name="carbs" step="0.01" value="{{ old('carbs', $food->carbs) }}" class="form-control w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300" required aria-describedby="carbs-error">
                                            </div>
                                            @error('carbs')
                                                <span id="carbs-error" class="text-danger text-sm mt-1">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="relative">
                                            <label for="fat" class="form-label text-sm font-medium text-gray-600">Lipides (g)</label>
                                            <div class="flex items-center">
                                                <i class="fas fa-cheese text-blue-500 mr-3"></i>
                                                <input type="number" id="fat" name="fat" step="0.01" value="{{ old('fat', $food->fat) }}" class="form-control w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300" required aria-describedby="fat-error">
                                            </div>
                                            @error('fat')
                                                <span id="fat-error" class="text-danger text-sm mt-1">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="relative">
                                            <label for="sugar" class="form-label text-sm font-medium text-gray-600">Sucres (g)</label>
                                            <div class="flex items-center">
                                                <i class="fas fa-candy-cane text-blue-500 mr-3"></i>
                                                <input type="number" id="sugar" name="sugar" step="0.01" value="{{ old('sugar', $food->sugar) }}" class="form-control w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300" required aria-describedby="sugar-error">
                                            </div>
                                            @error('sugar')
                                                <span id="sugar-error" class="text-danger text-sm mt-1">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="relative">
                                            <label for="fiber" class="form-label text-sm font-medium text-gray-600">Fibres (g)</label>
                                            <div class="flex items-center">
                                                <i class="fas fa-seedling text-blue-500 mr-3"></i>
                                                <input type="number" id="fiber" name="fiber" step="0.01" value="{{ old('fiber', $food->fiber) }}" class="form-control w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300" required aria-describedby="fiber-error">
                                            </div>
                                            @error('fiber')
                                                <span id="fiber-error" class="text-danger text-sm mt-1">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <!-- Custom Status -->
                                <div class="flex items-center space-x-4">
                                    <label for="is_custom" class="text-sm font-medium text-gray-600">Aliment personnalisé</label>
                                    <input type="checkbox" id="is_custom" name="is_custom" value="1" class="form-check-input h-5 w-5 text-blue-500 focus:ring-blue-500 rounded" {{ old('is_custom', $food->is_custom) ? 'checked' : '' }}>
                                    @error('is_custom')
                                        <span id="is_custom-error" class="text-danger text-sm mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                                <!-- Submit Button -->
                                <div class="text-right">
                                    <button type="submit" class="inline-flex items-center bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-semibold text-sm px-6 py-3 rounded-lg shadow-md hover:shadow-lg hover:from-blue-600 hover:to-indigo-700 transform hover:scale-105 transition-all duration-300 animate__animated animate__pulse animate__infinite animate__slower" data-bs-toggle="tooltip" title="Mettre à jour l'aliment">
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

    <!-- Bootstrap 5 JavaScript CDN (without integrity attribute to avoid 403 errors) -->
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
