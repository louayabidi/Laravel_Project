<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-header.header></x-header.header>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Créer un Objectif"></x-navbars.navs.auth>

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Créer un Objectif</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('objectifs.store') }}" method="POST">
                                @csrf

                                <div class="row">
                                    <!-- Colonne de gauche -->
                                    <div class="col-md-6">
                                        <!-- Titre -->
                                        <div class="mb-4">
                                            <label class="form-label fw-bold">Titre de l'objectif</label>
                                            <div class="input-group input-group-outline">
                                                <input type="text" name="title" class="form-control" placeholder="Ex: Boire plus d'eau" required>
                                            </div>
                                            <small class="form-text text-muted">Donnez un nom clair à votre objectif</small>
                                        </div>

                                        <!-- Catégorie -->
                                        <div class="mb-4">
                                            <label class="form-label fw-bold">Catégorie</label>
                                            <div class="input-group input-group-outline">
                                                <select name="status" class="form-control" required>
                                                    <option value="" disabled selected>Choisissez une catégorie</option>
                                                    <option value="Sommeil">Sommeil</option>
                                                    <option value="Eau">Eau</option>
                                                    <option value="Sport">Sport</option>
                                                    <option value="Stress">Stress</option>
                                                </select>
                                            </div>
                                            <small class="form-text text-muted">Sélectionnez le domaine de votre objectif</small>
                                        </div>

                                        <!-- Valeur cible -->
                                        <div class="mb-4">
                                            <label class="form-label fw-bold">Valeur cible</label>
                                            <div class="input-group input-group-outline">
                                                <input type="number" name="target_value" class="form-control" placeholder="Ex: 8" required>
                                            </div>
                                            <small class="form-text text-muted">Définissez la valeur à atteindre</small>
                                        </div>
                                    </div>

                                    <!-- Colonne de droite -->
                                    <div class="col-md-6">
                                        <!-- Description -->
                                        <div class="mb-4">
                                            <label class="form-label fw-bold">Description</label>
                                            <div class="input-group input-group-outline">
                                                <textarea name="description" class="form-control" rows="4" placeholder="Décrivez votre objectif en détail..."></textarea>
                                            </div>
                                            <small class="form-text text-muted">Optionnel - Expliquez le contexte ou les détails</small>
                                        </div>

                                        <!-- Période -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-4">
                                                    <label class="form-label fw-bold">Date de début</label>
                                                    <div class="input-group input-group-outline">
                                                        <input type="date" name="start_date" class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-4">
                                                    <label class="form-label fw-bold">Date de fin</label>
                                                    <div class="input-group input-group-outline">
                                                        <input type="date" name="end_date" class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <small class="form-text text-muted d-block mb-3">Définissez la période pour atteindre votre objectif</small>
                                    </div>
                                </div>

                                <!-- Boutons d'action -->
                                <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                                    <a href="{{ route('objectifs.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-arrow-left me-2"></i>Retour à la liste
                                    </a>
                                    <button type="submit" class="btn bg-gradient-primary px-4">
                                        <i class="fas fa-save me-2"></i>Enregistrer l'objectif
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
</x-layout>