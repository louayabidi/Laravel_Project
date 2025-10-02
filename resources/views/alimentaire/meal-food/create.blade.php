<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="meal-foods"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Create Meal Food"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Create New Meal Food</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('meal-foods.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="meal_id" class="form-label">Meal</label>
                                    <select name="meal_id" id="meal_id" class="form-select" required>
                                        <option value="">Select a Meal</option>
                                        @foreach ($meals as $meal)
                                            <option value="{{ $meal->id }}">{{ $meal->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('meal_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="food_id" class="form-label">Food</label>
                                    <select name="food_id" id="food_id" class="form-select" required>
                                        <option value="">Select a Food</option>
                                        @foreach ($foods as $food)
                                            <option value="{{ $food->id }}">{{ $food->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('food_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="quantity" class="form-label">Quantity</label>
                                    <input type="number" name="quantity" id="quantity" class="form-control" step="0.01" required>
                                    @error('quantity')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="calories_total" class="form-label">Total Calories</label>
                                    <input type="number" name="calories_total" id="calories_total" class="form-control" step="0.01" required>
                                    @error('calories_total')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="protein_total" class="form-label">Total Protein</label>
                                    <input type="number" name="protein_total" id="protein_total" class="form-control" step="0.01" required>
                                    @error('protein_total')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="carbs_total" class="form-label">Total Carbs</label>
                                    <input type="number" name="carbs_total" id="carbs_total" class="form-control" step="0.01" required>
                                    @error('carbs_total')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="fat_total" class="form-label">Total Fat</label>
                                    <input type="number" name="fat_total" id="fat_total" class="form-control" step="0.01" required>
                                    @error('fat_total')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn bg-gradient-primary">Save</button>
                                <a href="{{ route('meal-foods.index') }}" class="btn btn-secondary">Cancel</a>
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