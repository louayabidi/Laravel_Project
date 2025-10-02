
<x-layout bodyClass="g-sidenav-show bg-gradient-to-br from-indigo-50 to-blue-200 min-h-screen">
    <x-header.header></x-header.header>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Objectifs Alimentaires"></x-navbars.navs.auth>
        <div class="container-fluid py-8">
            <!-- Hero Section -->
            <div class="relative mb-8 overflow-hidden rounded-2xl bg-gradient-to-r from-blue-500 to-indigo-600 p-8 text-white shadow-xl">
                <div class="absolute inset-0 bg-[url('https://source.unsplash.com/random/1920x1080/?healthy-food')] opacity-20 bg-cover bg-center"></div>
                <div class="relative z-10">
                    <h2 class="text-4xl font-bold mb-2 animate__animated animate__fadeIn">Vos Objectifs Alimentaires</h2>
                    <p class="text-lg opacity-90">Prenez le contrôle de votre santé avec des objectifs personnalisés et suivez vos progrès vers une vie plus saine !</p>
                    <a href="{{ route('goals.create') }}" class="mt-4 inline-block bg-white text-blue-600 font-semibold py-3 px-6 rounded-full hover:bg-blue-100 transition-transform transform hover:scale-105">
                        <i class="fas fa-plus mr-2"></i> Créer un nouvel objectif
                    </a>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-12 col-lg-10">
                    <!-- Goals Card -->
                    <div class="card shadow-2xl border-0 bg-white/90 backdrop-blur-md">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-4">
                                    <i class="fas fa-bullseye mr-2"></i> Tableau des Objectifs Alimentaires
                                </h6>
                            </div>
                        </div>
                        <div class="card-body p-6">
                            <div class="table-responsive">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr class="text-gray-600">
                                            <th class="text-uppercase text-xs font-semibold opacity-80">Âge</th>
                                            <th class="text-uppercase text-xs font-semibold opacity-80">Sexe</th>
                                            <th class="text-uppercase text-xs font-semibold opacity-80">Poids</th>
                                            <th class="text-uppercase text-xs font-semibold opacity-80">Taille</th>
                                            <th class="text-uppercase text-xs font-semibold opacity-80">Activité</th>
                                            <th class="text-uppercase text-xs font-semibold opacity-80">Objectif</th>
                                            <th class="text-uppercase text-xs font-semibold opacity-80">BMR</th>
                                            <th class="text-uppercase text-xs font-semibold opacity-80">Calories</th>
                                            <th class="text-uppercase text-xs font-semibold opacity-80">Protéines</th>
                                            <th class="text-uppercase text-xs font-semibold opacity-80">Glucides</th>
                                            <th class="text-uppercase text-xs font-semibold opacity-80">Lipides</th>
                                            <th class="text-uppercase text-xs font-semibold opacity-80">Statut</th>
                                            <th class="text-uppercase text-xs font-semibold opacity-80">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($goals as $goal)
                                            <tr class="hover:bg-gray-50 transition-all duration-300">
                                                <td class="px-4 py-3">
                                                    <span class="text-sm">{{ $goal->age }} ans</span>
                                                </td>
                                                <td class="px-4 py-3">
                                                    <i class="fas {{ $goal->gender == 'male' ? 'fa-mars' : 'fa-venus' }} text-blue-500 mr-2"></i>
                                                    <span class="text-sm">{{ $goal->gender == 'male' ? 'Homme' : 'Femme' }}</span>
                                                </td>
                                                <td class="px-4 py-3">
                                                    <span class="text-sm">{{ $goal->weight }} kg</span>
                                                </td>
                                                <td class="px-4 py-3">
                                                    <span class="text-sm">{{ $goal->height }} cm</span>
                                                </td>
                                                <td class="px-4 py-3">
                                                    <span class="text-sm" data-bs-toggle="tooltip" title="{{ $goal->activity_level == 'sedentary' ? 'Peu ou pas d\'exercice' : ($goal->activity_level == 'light' ? 'Exercice léger 1-3 jours/semaine' : ($goal->activity_level == 'moderate' ? 'Exercice modéré 3-5 jours/semaine' : ($goal->activity_level == 'active' ? 'Exercice intense 6-7 jours/semaine' : 'Exercice très intense ou travail physique'))) }}">
                                                        {{ ucfirst(str_replace('_', ' ', $goal->activity_level)) }}
                                                    </span>
                                                </td>
                                                <td class="px-4 py-3">
                                                    <span class="text-sm font-medium {{ $goal->goal_type == 'lose' ? 'text-red-500' : ($goal->goal_type == 'maintain' ? 'text-green-500' : 'text-blue-500') }}">
                                                        {{ ucfirst($goal->goal_type == 'lose' ? 'Perdre' : ($goal->goal_type == 'maintain' ? 'Maintenir' : 'Prendre')) }}
                                                    </span>
                                                </td>
                                                <td class="px-4 py-3">
                                                    <span class="text-sm">{{ $goal->bmr }} kcal</span>
                                                </td>
                                                <td class="px-4 py-3">
                                                    <span class="text-sm">{{ $goal->daily_calories }} kcal</span>
                                                </td>
                                                <td class="px-4 py-3">
                                                    <span class="text-sm">{{ $goal->daily_protein ?? 'N/A' }} g</span>
                                                </td>
                                                <td class="px-4 py-3">
                                                    <span class="text-sm">{{ $goal->daily_carbs ?? 'N/A' }} g</span>
                                                </td>
                                                <td class="px-4 py-3">
                                                    <span class="text-sm">{{ $goal->daily_fat ?? 'N/A' }} g</span>
                                                </td>
                                                <td class="px-4 py-3">
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $goal->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                        <i class="fas fa-circle mr-1 {{ $goal->is_active ? 'text-green-500' : 'text-gray-500' }}"></i>
                                                        {{ $goal->is_active ? 'Actif' : 'Inactif' }}
                                                    </span>
                                                </td>
                                                <td class="px-4 py-3 flex space-x-3 items-center">
                                                    <a href="{{ route('goals.show', $goal->id) }}" class="inline-flex items-center bg-gradient-to-r from-blue-500 to-blue-700 text-white font-semibold text-sm px-4 py-2 rounded-lg shadow-md hover:shadow-lg hover:from-blue-600 hover:to-blue-800 transform hover:scale-105 transition-all duration-300 animate__animated animate__pulse animate__infinite animate__slower" data-bs-toggle="tooltip" title="Voir les détails" aria-label="Voir les détails de l'objectif">
                                                        <i class="fas fa-eye mr-2"></i> Voir
                                                    </a>
                                                    <a href="{{ route('goals.edit', $goal->id) }}" class="inline-flex items-center bg-gradient-to-r from-yellow-400 to-yellow-600 text-white font-semibold text-sm px-4 py-2 rounded-lg shadow-md hover:shadow-lg hover:from-yellow-500 hover:to-yellow-700 transform hover:scale-105 transition-all duration-300 animate__animated animate__pulse animate__infinite animate__slower" data-bs-toggle="tooltip" title="Modifier l'objectif" aria-label="Modifier l'objectif">
                                                        <i class="fas fa-edit mr-2"></i> Modifier
                                                    </a>
                                                    <form action="{{ route('goals.destroy', $goal->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="inline-flex items-center bg-gradient-to-r from-red-500 to-red-700 text-white font-semibold text-sm px-4 py-2 rounded-lg shadow-md hover:shadow-lg hover:from-red-600 hover:to-red-800 transform hover:scale-105 transition-all duration-300 animate__animated animate__pulse animate__infinite animate__slower" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet objectif ?')" data-bs-toggle="tooltip" title="Supprimer l'objectif" aria-label="Supprimer l'objectif">
                                                            <i class="fas fa-trash mr-2"></i> Supprimer
                                                        </button>
                                                    </form>
                                                    @if (!$goal->is_active)
                                                        <form action="{{ route('goals.set-active', $goal->id) }}" method="POST" class="inline">
                                                            @csrf
                                                            <button type="submit" class="inline-flex items-center bg-gradient-to-r from-green-500 to-green-700 text-white font-semibold text-sm px-4 py-2 rounded-lg shadow-md hover:shadow-lg hover:from-green-600 hover:to-green-800 transform hover:scale-105 transition-all duration-300 animate__animated animate__pulse animate__infinite animate__slower" onclick="return confirm('Voulez-vous activer cet objectif ?')" data-bs-toggle="tooltip" title="Activer l'objectif" aria-label="Activer l'objectif">
                                                                <i class="fas fa-play mr-2"></i> Activer
                                                            </button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4">
                                {{ $goals->links('pagination::tailwind') }}
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

    <!-- Tailwind CSS CDN (for prototyping) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        // Initialize Tooltips (Bootstrap 5 compatible)
        document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(element => {
            new bootstrap.Tooltip(element);
        });
    </script>
</x-layout>