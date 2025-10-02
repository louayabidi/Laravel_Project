<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="meals"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Create Meal"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Create a New Meal</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('meals.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="type" class="form-label">Meal Type</label>
                                    <select name="type" id="type" class="form-select" required>
                                        <option value="breakfast">Breakfast</option>
                                        <option value="lunch">Lunch</option>
                                        <option value="dinner">Dinner</option>
                                        <option value="snack">Snack</option>
                                    </select>
                                    @error('type')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="date" class="form-label">Date</label>
                                    <input type="date" name="date" id="date" class="form-control" required value="{{ date('Y-m-d') }}">
                                    @error('date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <h6>Foods</h6>
                                <div id="foods-container">
                                    <div class="row mb-3 food-row">
                                        <div class="col-md-6">
                                            <label class="form-label">Food Name</label>
                                            <select name="foods[0][food_id]" class="form-select food-select" required>
                                                <option value="">Select a food</option>
                                                @foreach ($foods as $food)
                                                    <option value="{{ $food->id }}">{{ $food->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('foods.0.food_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Quantity (g)</label>
                                            <input type="number" step="0.01" name="foods[0][quantity]" class="form-control" required placeholder="e.g., 150">
                                            @error('foods.0.quantity')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-danger remove-row mt-4">Remove</button>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" id="add-food-row" class="btn bg-gradient-primary mb-3">Add Food</button>
                                <button type="submit" class="btn bg-gradient-primary">Save</button>
                                <a href="{{ route('meals.index') }}" class="btn btn-secondary">Cancel</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-plugins></x-plugins>

    @push('js')
        <script>
            let rowIndex = 1;
            document.getElementById('add-food-row').addEventListener('click', function () {
                const container = document.getElementById('foods-container');
                const newRow = document.createElement('div');
                newRow.classList.add('row', 'mb-3', 'food-row');
                newRow.innerHTML = `
                    <div class="col-md-6">
                        <label class="form-label">Food Name</label>
                        <select name="foods[${rowIndex}][food_id]" class="form-select food-select" required>
                            <option value="">Select a food</option>
                            @foreach ($foods as $food)
                                <option value="{{ $food->id }}">{{ $food->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Quantity (g)</label>
                        <input type="number" step="0.01" name="foods[${rowIndex}][quantity]" class="form-control" required placeholder="e.g., 150">
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger remove-row mt-4">Remove</button>
                    </div>
                `;
                container.appendChild(newRow);
                rowIndex++;
            });

            document.addEventListener('click', function (e) {
                if (e.target.classList.contains('remove-row') && document.querySelectorAll('.food-row').length > 1) {
                    e.target.closest('.food-row').remove();
                }
            });
        </script>
    @endpush
</x-layout>