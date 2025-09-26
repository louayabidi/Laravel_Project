{{-- 1. Utiliser le composant 'layout' --}}
<x-layout bodyClass="">

    {{-- 2. INCLURE LA BARRE LATÉRALE. Chemin standard : navbars/navs/sidebar.blade.php --}}
    @include('components.navbars.navs.sidebar')

    {{-- 3. Votre contenu spécifique --}}
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">

        {{-- Je suppose que la navbar du haut a aussi été déplacée --}}
        @include('navbars.navs.auth')

        <div class="container-fluid py-4">

            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Ajouter une mesure de santé</h6>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">

                                <div class="container mt-3">
                                    <form action="{{ route('sante-mesures.store') }}" method="POST">
                                        @csrf
                                        {{-- ... Votre formulaire ... --}}
                                        <div class="mb-3">
                                            <label for="user_id" class="form-label">Utilisateur (ID)</label>
                                            <input type="number" name="user_id" class="form-control border p-2" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="date_mesure" class="form-label">Date de mesure</label>
                                            <input type="date" name="date_mesure" class="form-control border p-2" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="remarque" class="form-label">Remarque</label>
                                            <textarea name="remarque" class="form-control border p-2"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-success">Ajouter</button>
                                        <a href="{{ route('sante-mesures.index') }}" class="btn btn-secondary">Annuler</a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @include('components.footers.auth')

        </div>
    </main>

    @include('components.config')

</x-layout>
