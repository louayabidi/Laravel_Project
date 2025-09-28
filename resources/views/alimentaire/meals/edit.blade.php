<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="meals"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Edit Meal"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Edit Meal</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('meals.update', $meal->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="input-group input-group-outline mb-3">
                                    <label class="form-label">Type</label>
                                    <select name="type" class="form-control" required>
                                        <option value="breakfast" {{ $meal->type == 'breakfast' ? 'selected' : '' }}>Breakfast</option>
                                        <option value="lunch" {{ $meal->type == 'lunch' ? 'selected' : '' }}>Lunch</option>
                                        <option value="dinner" {{ $meal->type == 'dinner' ? 'selected' : '' }}>Dinner</option>
                                        <option value="snack" {{ $meal->type == 'snack' ? 'selected' : '' }}>Snack</option>
                                    </select>
                                </div>
                                <div class="input-group input-group-outline mb-3">
                                    <label class="form-label">Date</label>
                                    <input type="date" name="date" value="{{ $meal->date }}" class="form-control" required>
                                </div>
                                <h6>Foods</h6>
                                <div id="foods-container">
                                    @foreach ($meal->mealFoods as $index => $mealFood)
                                        <div class="row mb-3 food-row">
                                            <div class="col-md-6">
                                                <select name="foods[{{ $index }}][food_id]" class="form-control" required>
                                                    @foreach ($foods as $food)
                                                        <option value="{{ $food->id }}" {{ $mealFood->food_id == $food->id ? 'selected' : '' }}>{{ $food->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="number" step="0.01" name="foods[{{ $index }}][quantity]" value="{{ $mealFood->quantity }}" class="form-control" placeholder="Quantity" required>
                                            </div>
                                            <div class="col-md-2">
                                                <button type="button" class="btn btn-danger remove-row">Remove</button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <button type="button" id="add-food-row" class="btn bg-gradient-primary mb-3">Add Food</button>
                                <button type="submit" class="btn bg-gradient-primary">Update</button>
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

@push('js')
<script>
    let rowIndex = {{ $meal->mealFoods->count() }};
    document.getElementById('add-food-row').addEventListener('click', function() {
        const container = document.getElementById('foods-container');
        const newRow = document.createElement('div');
        newRow.classList.add('row', 'mb-3', 'food-row');
        newRow.innerHTML = `
            <div class="col-md-6">
                <select name="foods[${rowIndex}][food_id]" class="form-control" required>
                    @foreach ($foods as $food)
                        <option value="{{ $food->id }}">{{ $food->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <input type="number" step="0.01" name="foods[${rowIndex}][quantity]" class="form-control" placeholder="Quantity" required>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger remove-row">Remove</button>
            </div>
        `;
        container.appendChild(newRow);
        rowIndex++;
    });

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-row')) {
            e.target.closest('.food-row').remove();
        }
    });
</script>
@endpush