<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="meals"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Meal Details"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Meal: {{ ucfirst($meal->type) }}</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <p><strong>Type:</strong> {{ ucfirst($meal->type) }}</p>
                            <p><strong>Date:</strong> {{ $meal->date }}</p>
                            <h6>Foods ({{ $meal->mealFoods->count() }})</h6>
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Quantity (g)</th>
                                        <th>Calories</th>
                                        <th>Protein (g)</th>
                                        <th>Carbs (g)</th>
                                        <th>Fat (g)</th>
                                        <th>Sugar (g)</th>
                                        <th>Fiber (g)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($meal->mealFoods as $mealFood)
                                        <tr>
                                            <td>{{ $mealFood->food->name ?? 'N/A' }}</td>
                                            <td>{{ $mealFood->quantity }}</td>
                                            <td>{{ $mealFood->calories_total }}</td>
                                            <td>{{ $mealFood->protein_total }}</td>
                                            <td>{{ $mealFood->carbs_total }}</td>
                                            <td>{{ $mealFood->fat_total }}</td>
                                            <td>{{ $mealFood->sugar_total ?? 'N/A' }}</td>
                                            <td>{{ $mealFood->fiber_total ?? 'N/A' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td><strong>Totals</strong></td>
                                        <td></td>
                                        <td><strong>{{ $totals['calories'] }}</strong></td>
                                        <td><strong>{{ $totals['protein'] }}</strong></td>
                                        <td><strong>{{ $totals['carbs'] }}</strong></td>
                                        <td><strong>{{ $totals['fat'] }}</strong></td>
                                        <td><strong>{{ $totals['sugar'] }}</strong></td>
                                        <td><strong>{{ $totals['fiber'] }}</strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                            <a href="{{ route('meals.index') }}" class="btn bg-gradient-primary">Back</a>
                        </div>
                    </div>
                </div>
            </div>
            <x-footers.auth></x-footers.auth>
        </div>
    </main>
    <x-plugins></x-plugins>
</x-layout>