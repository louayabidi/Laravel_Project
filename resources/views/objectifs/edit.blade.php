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
                            
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <strong>Erreurs de validation :</strong>
                                    <ul class="mb-0 mt-2">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('objectifs.update', $objectif) }}" method="POST" novalidate>
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <!-- Colonne gauche -->
                                    <div class="col-md-6">
                                        <!-- Titre -->
                                        <div class="mb-4">
                                            <label class="form-label fw-bold">Titre de l'objectif</label>
                                            <div class="input-group input-group-outline">
                                                <input 
                                                    type="text" 
                                                    name="title" 
                                                    class="form-control @error('title') is-invalid @enderror"
                                                    value="{{ old('title', $objectif->title) }}" 
                                                    placeholder="Ex: Boire plus d'eau">
                                            </div>
                                            @error('title')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <!-- Catégorie -->
                                        <div class="mb-4">
                                            <label class="form-label fw-bold">Catégorie</label>
                                            <div class="input-group input-group-outline">
                                                <select name="status" class="form-control @error('status') is-invalid @enderror">
                                                    <option value="Sommeil" {{ old('status', $objectif->status) == 'Sommeil' ? 'selected' : '' }}>Sommeil</option>
                                                    <option value="Eau" {{ old('status', $objectif->status) == 'Eau' ? 'selected' : '' }}>Eau</option>
                                                    <option value="Sport" {{ old('status', $objectif->status) == 'Sport' ? 'selected' : '' }}>Sport</option>
                                                    <option value="Stress" {{ old('status', $objectif->status) == 'Stress' ? 'selected' : '' }}>Stress</option>
                                                </select>
                                            </div>
                                            @error('status')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <!-- Valeur cible -->
                                        <div class="mb-4">
                                            <label class="form-label fw-bold">Valeur cible</label>
                                            <div class="input-group input-group-outline">
                                                <input 
                                                    type="number" 
                                                    name="target_value" 
                                                    class="form-control @error('target_value') is-invalid @enderror"
                                                    value="{{ old('target_value', $objectif->target_value) }}" 
                                                    placeholder="Ex: 8">
                                            </div>
                                            @error('target_value')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Colonne droite -->
                                    <div class="col-md-6">
                                        <!-- Description -->
                                        <div class="mb-4">
                                            <label class="form-label fw-bold">Description</label>
                                            <div class="input-group input-group-outline">
                                                <textarea 
                                                    name="description" 
                                                    class="form-control @error('description') is-invalid @enderror" 
                                                    rows="4" 
                                                    placeholder="Décrivez votre objectif en détail...">{{ old('description', $objectif->description) }}</textarea>
                                            </div>
                                            @error('description')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <!-- Période -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-4">
                                                    <label class="form-label fw-bold">Date de début</label>
                                                    <div class="input-group input-group-outline">
                                                        <input 
                                                            type="date" 
                                                            name="start_date" 
                                                            class="form-control @error('start_date') is-invalid @enderror"
                                                            value="{{ old('start_date', $objectif->start_date) }}">
                                                    </div>
                                                    @error('start_date')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-4">
                                                    <label class="form-label fw-bold">Date de fin</label>
                                                    <div class="input-group input-group-outline">
                                                        <input 
                                                            type="date" 
                                                            name="end_date" 
                                                            class="form-control @error('end_date') is-invalid @enderror"
                                                            value="{{ old('end_date', $objectif->end_date) }}">
                                                    </div>
                                                    @error('end_date')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Boutons -->
                                <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                                    <a href="{{ route('objectifs.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-arrow-left me-2"></i>Annuler
                                    </a>
                                    <button type="submit" class="btn bg-gradient-primary px-4">
                                        <i class="fas fa-save me-2"></i>Mettre à jour
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
