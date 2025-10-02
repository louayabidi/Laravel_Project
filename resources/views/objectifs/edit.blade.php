<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-header.header></x-header.header>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Modifier un Objectif"></x-navbars.navs.auth>

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Modifier l'Objectif</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('objectifs.update', $objectif) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <!-- Colonne de gauche -->
                                    <div class="col-md-6">
                                        <!-- Titre -->
                                        <div class="mb-4">
                                            <label class="form-label fw-bold">Titre de l'objectif</label>
                                            <div class="input-group input-group-outline">
                                                <input type="text" name="title" class="form-control" 
                                                       value="{{ old('title', $objectif->title) }}" 
                                                       placeholder="Ex: Boire plus d'eau" required>
                                            </div>
                                            <small class="form-text text-muted">Modifiez le nom de votre objectif</small>
                                        </div>

                                        <!-- Type d'objectif -->
                                        <div class="mb-4">
                                            <label class="form-label fw-bold">Catégorie</label>
                                            <div class="input-group input-group-outline">
                                                <select name="status" class="form-control" required>
                                                    <option value="Sommeil" {{ $objectif->status == 'Sommeil' ? 'selected' : '' }}>Sommeil</option>
                                                    <option value="Eau" {{ $objectif->status == 'Eau' ? 'selected' : '' }}>Eau</option>
                                                    <option value="Sport" {{ $objectif->status == 'Sport' ? 'selected' : '' }}>Sport</option>
                                                    <option value="Stress" {{ $objectif->status == 'Stress' ? 'selected' : '' }}>Stress</option>
                                                </select>
                                            </div>
                                            <small class="form-text text-muted">Sélectionnez la catégorie de votre objectif</small>
                                        </div>

                                        <!-- Valeur cible -->
                                        <div class="mb-4">
                                            <label class="form-label fw-bold">Valeur cible</label>
                                            <div class="input-group input-group-outline">
                                                <input type="number" name="target_value" class="form-control" 
                                                       value="{{ old('target_value', $objectif->target_value) }}" 
                                                       placeholder="Ex: 8" required>
                                            </div>
                                            <small class="form-text text-muted">Ajustez la valeur à atteindre</small>
                                        </div>
                                    </div>

                                    <!-- Colonne de droite -->
                                    <div class="col-md-6">
                                        <!-- Description -->
                                        <div class="mb-4">
                                            <label class="form-label fw-bold">Description</label>
                                            <div class="input-group input-group-outline">
                                                <textarea name="description" class="form-control" rows="4" 
                                                          placeholder="Décrivez votre objectif en détail...">{{ old('description', $objectif->description) }}</textarea>
                                            </div>
                                            <small class="form-text text-muted">Optionnel - Modifiez la description si nécessaire</small>
                                        </div>

                                        <!-- Période -->
                                        <div class="mb-4">
                                            <label class="form-label fw-bold mb-3">Période de l'objectif</label>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Date de début</label>
                                                        <div class="input-group input-group-outline">
                                                            <input type="date" name="start_date" class="form-control" 
                                                                   value="{{ old('start_date', $objectif->start_date) }}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Date de fin</label>
                                                        <div class="input-group input-group-outline">
                                                            <input type="date" name="end_date" class="form-control" 
                                                                   value="{{ old('end_date', $objectif->end_date) }}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <small class="form-text text-muted">Ajustez la période pour atteindre votre objectif</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Informations de suivi (optionnel) -->
                                <div class="alert alert-info mt-3">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-info-circle me-2"></i>
                                        <span>
                                            <strong>Conseil :</strong> 
                                            Pensez à vérifier la cohérence entre votre valeur cible et la période définie.
                                        </span>
                                    </div>
                                </div>

                                <!-- Boutons d'action -->
                                <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                                    <a href="{{ route('objectifs.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-arrow-left me-2"></i>Annuler et retourner
                                    </a>
                                    <div>
                                        <button type="submit" class="btn bg-gradient-primary px-4">
                                            <i class="fas fa-save me-2"></i>Mettre à jour
                                        </button>
                                    </div>
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