
<x-layout bodyClass="g-sidenav-show bg-gradient-to-br from-indigo-50 to-blue-200 min-h-screen">
    <x-header.header></x-header.header>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Créer un Objectif Alimentaire"></x-navbars.navs.auth>
        <div class="container-fluid py-8">
            <!-- Hero Section -->
            <div class="relative mb-8 overflow-hidden rounded-2xl bg-gradient-to-r from-blue-500 to-indigo-600 p-8 text-white shadow-xl">
                <div class="absolute inset-0 bg-[url('https://source.unsplash.com/random/1920x1080/?healthy-food')] opacity-20 bg-cover bg-center"></div>
                <div class="relative z-10">
                    <h2 class="text-4xl font-bold mb-2 animate__animated animate__fadeIn">Créez Votre Objectif Alimentaire</h2>
                    <p class="text-lg opacity-90">Définissez vos objectifs pour une vie plus saine avec un plan personnalisé !</p>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-12 col-lg-8">
                    <div class="card shadow-2xl border-0 bg-white/90 backdrop-blur-md">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-4">
                                    <i class="fas fa-bullseye mr-2"></i> Nouveau Objectif
                                </h6>
                            </div>
                        </div>
                        <div class="card-body p-6">
                            <form action="{{ route('goals.store') }}" method="POST" class="space-y-6">
                                @csrf
                                <!-- Personal Information -->
                                <div class="border-b border-gray-200 pb-4">
                                    <h3 class="text-lg font-semibold text-gray-700 mb-4">
                                        <i class="fas fa-user mr-2 text-blue-500"></i> Informations Personnelles
                                    </h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="relative">
                                            <label for="age" class="form-label text-sm font-medium text-gray-600">Âge</label>
                                            <div class="flex items-center">
                                                <i class="fas fa-calendar-alt text-blue-500 mr-3"></i>
                                                <input type="number" id="age" name="age" class="form-control w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300" required placeholder="Ex. 30" aria-describedby="age-error">
                                            </div>
                                            @error('age')
                                                <span id="age-error" class="text-danger text-sm mt-1">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="relative">
                                            <label for="gender" class="form-label text-sm font-medium text-gray-600">Sexe</label>
                                            <div class="flex items-center">
                                                <i class="fas fa-venus-mars text-blue-500 mr-3"></i>
                                                <select id="gender" name="gender" class="form-control w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300" required>
                                                    <option value="" disabled selected>Choisir...</option>
                                                    <option value="male">Homme</option>
                                                    <option value="female">Femme</option>
                                                </select>
                                            </div>
                                            @error('gender')
                                                <span id="gender-error" class="text-danger text-sm mt-1">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="relative">
                                            <label for="weight" class="form-label text-sm font-medium text-gray-600">Poids (kg)</label>
                                            <div class="flex items-center">
                                                <i class="fas fa-weight text-blue-500 mr-3"></i>
                                                <input type="number" id="weight" name="weight" step="0.1" class="form-control w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300" required placeholder="Ex. 70.0" aria-describedby="weight-error">
                                            </div>
                                            @error('weight')
                                                <span id="weight-error" class="text-danger text-sm mt-1">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="relative">
                                            <label for="height" class="form-label text-sm font-medium text-gray-600">Taille (cm)</label>
                                            <div class="flex items-center">
                                                <i class="fas fa-ruler-vertical text-blue-500 mr-3"></i>
                                                <input type="number" id="height" name="height" step="0.1" class="form-control w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300" required placeholder="Ex. 170.0" aria-describedby="height-error">
                                            </div>
                                            @error('height')
                                                <span id="height-error" class="text-danger text-sm mt-1">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Activity & Goal -->
                                <div class="border-b border-gray-200 pb-4">
                                    <h3 class="text-lg font-semibold text-gray-700 mb-4">
                                        <i class="fas fa-running mr-2 text-blue-500"></i> Activité & Objectif
                                    </h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="relative">
                                            <label for="activity_level" class="form-label text-sm font-medium text-gray-600">Niveau d'Activité</label>
                                            <div class="flex items-center">
                                                <i class="fas fa-heartbeat text-blue-500 mr-3"></i>
                                                <select id="activity_level" name="activity_level" class="form-control w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300" required>
                                                    <option value="" disabled selected>Choisir...</option>
                                                    <option value="sedentary">Sédentaire (Peu ou pas d'exercice)</option>
                                                    <option value="light">Léger (1-3 jours/semaine)</option>
                                                    <option value="moderate">Modéré (3-5 jours/semaine)</option>
                                                    <option value="active">Actif (6-7 jours/semaine)</option>
                                                    <option value="very_active">Très Actif (Exercice intense ou travail physique)</option>
                                                </select>
                                            </div>
                                            @error('activity_level')
                                                <span id="activity_level-error" class="text-danger text-sm mt-1">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="relative">
                                            <label for="goal_type" class="form-label text-sm font-medium text-gray-600">Type d'Objectif</label>
                                            <div class="flex items-center">
                                                <i class="fas fa-flag-checkered text-blue-500 mr-3"></i>
                                                <select id="goal_type" name="goal_type" class="form-control w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300" required>
                                                    <option value="" disabled selected>Choisir...</option>
                                                    <option value="lose">Perdre du poids</option>
                                                    <option value="maintain">Maintenir le poids</option>
                                                    <option value="gain">Prendre du poids</option>
                                                </select>
                                            </div>
                                            @error('goal_type')
                                                <span id="goal_type-error" class="text-danger text-sm mt-1">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Nutrition Goals -->
                                <div class="pb-4">
                                    <h3 class="text-lg font-semibold text-gray-700 mb-4">
                                        <i class="fas fa-utensils mr-2 text-blue-500"></i> Objectifs Nutritionnels (Optionnel)
                                    </h3>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div class="relative">
                                            <label for="daily_protein" class="form-label text-sm font-medium text-gray-600">Protéines (g)</label>
                                            <div class="flex items-center">
                                                <i class="fas fa-drumstick-bite text-blue-500 mr-3"></i>
                                                <input type="number" id="daily_protein" name="daily_protein" step="0.1" class="form-control w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300" placeholder="Ex. 100.0" aria-describedby="daily_protein-error">
                                            </div>
                                            @error('daily_protein')
                                                <span id="daily_protein-error" class="text-danger text-sm mt-1">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="relative">
                                            <label for="daily_carbs" class="form-label text-sm font-medium text-gray-600">Glucides (g)</label>
                                            <div class="flex items-center">
                                                <i class="fas fa-bread-slice text-blue-500 mr-3"></i>
                                                <input type="number" id="daily_carbs" name="daily_carbs" step="0.1" class="form-control w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300" placeholder="Ex. 200.0" aria-describedby="daily_carbs-error">
                                            </div>
                                            @error('daily_carbs')
                                                <span id="daily_carbs-error" class="text-danger text-sm mt-1">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="relative">
                                            <label for="daily_fat" class="form-label text-sm font-medium text-gray-600">Lipides (g)</label>
                                            <div class="flex items-center">
                                                <i class="fas fa-cheese text-blue-500 mr-3"></i>
                                                <input type="number" id="daily_fat" name="daily_fat" step="0.1" class="form-control w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300" placeholder="Ex. 50.0" aria-describedby="daily_fat-error">
                                            </div>
                                            @error('daily_fat')
                                                <span id="daily_fat-error" class="text-danger text-sm mt-1">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Active Status -->
                                <div class="flex items-center space-x-4">
                                    <label for="is_active" class="text-sm font-medium text-gray-600">Activer cet objectif</label>
                                    <input type="checkbox" id="is_active" name="is_active" value="1" class="form-check-input h-5 w-5 text-blue-500 focus:ring-blue-500 rounded" checked>
                                    @error('is_active')
                                        <span id="is_active-error" class="text-danger text-sm mt-1">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Submit Button -->
                                <div class="text-right">
                                    <button type="submit" class="inline-flex items-center bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-semibold text-sm px-6 py-3 rounded-lg shadow-md hover:shadow-lg hover:from-blue-600 hover:to-indigo-700 transform hover:scale-105 transition-all duration-300 animate__animated animate__pulse animate__infinite animate__slower" data-bs-toggle="tooltip" title="Enregistrer votre objectif">
                                        <i class="fas fa-save mr-2"></i> Enregistrer
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

    <!-- Tailwind CSS CDN (for prototyping) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        // Initialize Tooltips (Bootstrap 5 compatible)
        document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(element => {
            new bootstrap.Tooltip(element);
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
    </script>
</x-layout>