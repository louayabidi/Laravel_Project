<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-header.header></x-header.header>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Ajouter un Repas par Image"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Ajouter un Repas par Photo (AI)</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('meals.add-by-image') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="meal_type" class="form-label">Type de Repas</label>
                                    <select name="meal_type" id="meal_type" class="form-select" required>
                                        <option value="breakfast">Petit-déjeuner</option>
                                        <option value="lunch">Déjeuner</option>
                                        <option value="dinner">Dîner</option>
                                        <option value="snack">Collation</option>
                                    </select>
                                    @error('meal_type')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="image" class="form-label">Photo du Repas</label>
                                    <input type="file" name="image" id="image" class="form-control" accept="image/jpeg,image/png,image/jpg" required>
                                    @error('image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn bg-gradient-primary">Analyser et Ajouter</button>
                                <a href="{{ route('meals.index') }}" class="btn btn-secondary">Annuler</a>
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