<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-header.header></x-header.header>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Créer un Aliment"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Créer un Aliment</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('foods.store') }}" method="POST">
                                @csrf
                                <div class="mb-3 position-relative">
                                    <label for="food_name" class="form-label">Nom de l'aliment (recherche automatique)</label>
                                    <input type="text" name="food_name" id="food_name" class="form-control" required placeholder="Ex: pomme, poulet">
                                    <div id="suggestions-dropdown" class="position-absolute w-100 bg-white border mt-1" style="max-height: 200px; overflow-y: auto; z-index: 1050; display: none;">
                                        <!-- Suggestions will populate here -->
                                    </div>
                                    @error('food_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn bg-gradient-primary">Enregistrer</button>
                                <a href="{{ route('foods.index') }}" class="btn btn-secondary">Annuler</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <x-footers.auth></x-footers.auth>
        </div>
    </main>
    <x-plugins></x-plugins>

    @push('js')
        <script>
            const foodInput = document.getElementById('food_name');
            const suggestionsDiv = document.getElementById('suggestions-dropdown');

            foodInput.addEventListener('input', async function () {
                const query = this.value.trim();
                if (query.length < 2) {
                    suggestionsDiv.style.display = 'none';
                    return;
                }

                try {
                    const response = await fetch(`/food-suggestions?q=${encodeURIComponent(query)}`);
                    const suggestions = await response.json();
                    suggestionsDiv.innerHTML = suggestions.map(suggestion => 
                        `<div class="p-2 border-bottom suggestion-item" style="cursor: pointer;" onclick="selectFood('${suggestion.name}')">${suggestion.name}</div>`
                    ).join('');
                    suggestionsDiv.style.display = suggestions.length ? 'block' : 'none';
                } catch (error) {
                    console.error('Error fetching suggestions:', error);
                }
            });

            function selectFood(name) {
                foodInput.value = name;
                suggestionsDiv.style.display = 'none';
            }

            document.addEventListener('click', function (e) {
                if (!foodInput.contains(e.target) && !suggestionsDiv.contains(e.target)) {
                    suggestionsDiv.style.display = 'none';
                }
            });
        </script>
    @endpush
</x-layout>