
<x-layout bodyClass="g-sidenav-show bg-gradient-to-br from-indigo-50 to-blue-200 min-h-screen">
    <x-header.header></x-header.header>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Liste des Repas"></x-navbars.navs.auth>
        <div class="container-fluid py-8">
            <!-- Hero Section -->
            <div class="relative mb-8 overflow-hidden rounded-2xl bg-gradient-to-r from-blue-500 to-indigo-600 p-8 text-white shadow-xl">
                <div class="absolute inset-0 bg-[url('https://source.unsplash.com/random/1920x1080/?healthy-food')] opacity-20 bg-cover bg-center"></div>
                <div class="relative z-10">
                    <h2 class="text-4xl font-bold mb-2 animate__animated animate__fadeIn">Vos Repas</h2>
                    <p class="text-lg opacity-90">Gérez vos repas pour un suivi nutritionnel précis !</p>
                    <a href="{{ route('meals.create') }}" class="mt-4 inline-block bg-white text-blue-600 font-semibold py-3 px-6 rounded-full hover:bg-blue-100 transition-transform transform hover:scale-105">
                        <i class="fas fa-plus mr-2"></i> Créer un nouveau repas
                    </a>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-12 col-lg-10">
                    <div class="card shadow-2xl border-0 bg-white/90 backdrop-blur-md">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-4">
                                    <i class="fas fa-utensils mr-2"></i> Tableau des Repas
                                </h6>
                            </div>
                        </div>
                        <div class="card-body p-6">
                            <div class="table-responsive">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr class="text-gray-600">
                                            <th class="text-uppercase text-xs font-semibold opacity-80">Type</th>
                                            <th class="text-uppercase text-xs font-semibold opacity-80">Date</th>
                                            <th class="text-uppercase text-xs font-semibold opacity-80">Calories Totales (kcal)</th>
                                            <th class="text-uppercase text-xs font-semibold opacity-80">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($meals as $meal)
                                            <tr class="hover:bg-gray-50 transition-all duration-300">
                                                <td class="px-4 py-3">
                                                    <span class="text-sm">{{ ucfirst($meal->type) }}</span>
                                                </td>
                                                <td class="px-4 py-3">
                                                    <span class="text-sm">{{ $meal->date }}</span>
                                                </td>
                                                <td class="px-4 py-3">
                                                    <span class="text-sm">{{ $meal->getTotals()['calories'] }}</span>
                                                </td>
                                                <td class="px-4 py-3 flex space-x-3 items-center">
                                                    <a href="{{ route('meals.show', $meal->id) }}" class="inline-flex items-center bg-gradient-to-r from-blue-500 to-blue-700 text-white font-semibold text-sm px-4 py-2 rounded-lg shadow-md hover:shadow-lg hover:from-blue-600 hover:to-blue-800 transform hover:scale-105 transition-all duration-300 animate__animated animate__pulse animate__infinite animate__slower" data-bs-toggle="tooltip" title="Voir les détails" aria-label="Voir les détails du repas">
                                                        <i class="fas fa-eye mr-2"></i> Voir
                                                    </a>
                                                    <a href="{{ route('meals.edit', $meal->id) }}" class="inline-flex items-center bg-gradient-to-r from-yellow-400 to-yellow-600 text-white font-semibold text-sm px-4 py-2 rounded-lg shadow-md hover:shadow-lg hover:from-yellow-500 hover:to-yellow-700 transform hover:scale-105 transition-all duration-300 animate__animated animate__pulse animate__infinite animate__slower" data-bs-toggle="tooltip" title="Modifier le repas" aria-label="Modifier le repas">
                                                        <i class="fas fa-edit mr-2"></i> Modifier
                                                    </a>
                                                    <button type="button" class="inline-flex items-center bg-gradient-to-r from-red-500 to-red-700 text-white font-semibold text-sm px-4 py-2 rounded-lg shadow-md hover:shadow-lg hover:from-red-600 hover:to-red-800 transform hover:scale-105 transition-all duration-300 animate__animated animate__pulse animate__infinite animate__slower" data-bs-toggle="modal" data-bs-target="#confirmDelete{{ $meal->id }}" data-bs-toggle="tooltip" title="Supprimer le repas" aria-label="Supprimer le repas">
                                                        <i class="fas fa-trash mr-2"></i> Supprimer
                                                    </button>
                                                    <!-- Delete Confirmation Modal -->
                                                    <div class="modal fade" id="confirmDelete{{ $meal->id }}" tabindex="-1" aria-labelledby="confirmDeleteLabel{{ $meal->id }}" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="confirmDeleteLabel{{ $meal->id }}">Confirmer la suppression</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Êtes-vous sûr de vouloir supprimer le repas "{{ ucfirst($meal->type) }}" du {{ $meal->date }} ?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                                    <form action="{{ route('meals.destroy', $meal->id) }}" method="POST" class="inline">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-danger">Supprimer</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4">
                                {{ $meals->links('pagination::tailwind') }}
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
