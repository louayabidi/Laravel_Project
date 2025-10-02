<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="meal-foods"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Meal Food Details"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Meal Food Details</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <p><strong>Meal:</strong> {{ $mealFood->meal->name ?? 'N/A' }}</p>
                            <p><strong>Food:</strong> {{ $mealFood->food->name ?? 'N/A' }}</p>
                            <p><strong>Quantity:</strong> {{ $mealFood->quantity }}</p>
                            <p><strong>Total Calories:</strong> {{ $mealFood->calories_total }}</p>
                            <p><strong>Total Protein:</strong> {{ $mealFood->protein_total }}</p>
                            <p><strong>Total Carbs:</strong> {{ $mealFood->carbs_total }}</p>
                            <p><strong>Total Fat:</strong> {{ $mealFood->fat_total }}</p>
                            <a href="{{ route('meal-foods.edit', $mealFood->id) }}" class="btn bg-gradient-primary">Edit</a>
                            <a href="{{ route('meal-foods.index') }}" class="btn btn-secondary">Back to List</a>
                        </div>
                    </div>
                </div>
            </div>
            <x-footers.auth></x-footers.auth>
        </div>
    </main>
    <x-plugins></x-plugins>
</x-layout>