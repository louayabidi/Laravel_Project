<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="meal-foods"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Modifier un Aliment de Repas"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Modifier un aliment de repas</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('meal-foods.update', $mealFood->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="meal_id" class="form-label">Repas</label>
                                    <select name="meal_id" id="meal_id" class="form-select" required>
                                        <option value="">Sélectionner un repas</option>
                                        @foreach ($meals as $meal)
                                            <option value="{{ $meal->id }}" {{ $mealFood->meal_id == $meal->id ? 'selected' : '' }}>
                                                {{ ucfirst($meal->type) }} ({{ $meal->date }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('meal_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3 position-relative">
                                    <label for="food_name" class="form-label">Nom de l'aliment (recherche automatique)</label>
                                    <input type="text" name="food_name" id="food_name" class="form-control" value="{{ $mealFood->food->name }}" required placeholder="Ex: pomme, poulet">
                                    <div id="suggestions-dropdown" class="position-absolute w-100 bg-white border mt-1" style="max-height: 200px; overflow-y: auto; z-index: 1050; display: none;">
                                        <!-- Suggestions will populate here -->
                                    </div>
                                    @error('food_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="quantity" class="form-label">Quantité (en grammes)</label>
                                    <input type="number" name="quantity" id="quantity" class="form-control" step="0.01" min="0.01" value="{{ $mealFood->quantity }}" required placeholder="Ex: 150">
                                    @error('quantity')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn bg-gradient-primary">Enregistrer</button>
                                <a href="{{ route('meal-foods.index') }}" class="btn btn-secondary">Annuler</a>
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

@push('scripts')
<script>
    const foodInput = document.getElementById('food_name');
    const suggestionsDiv = document.getElementById('suggestions-dropdown');

    foodInput.addEventListener('input', async function() {
        const query = this.value.trim();
        if (query.length < 2) {
            suggestionsDiv.style.display = 'none';
            return;
        }

        try {
            const response = await fetch(`/food-suggestions?q=${encodeURIComponent(query)}`);
            const suggestions = await response.json();
            suggestionsDiv.innerHTML = suggestions.map(suggestion => 
                `<div class="p-2 border-bottom suggestion-item" style="cursor: pointer;" onclick="selectFood('${suggestion.name}')">${suggestion.label}</div>`
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

    document.addEventListener('click', function(e) {
        if (!foodInput.contains(e.target) && !suggestionsDiv.contains(e.target)) {
            suggestionsDiv.style.display = 'none';
        }
    });
</script>
@endpush