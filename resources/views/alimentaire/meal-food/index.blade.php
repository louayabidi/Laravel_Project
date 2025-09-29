<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="meal-foods"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Meal Foods"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Meal Foods Table</h6>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Meal</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Food</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Quantity</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Calories Total</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Protein Total</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Carbs Total</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Fat Total</th>
                                            <th class="text-secondary opacity-7"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($mealFoods as $mealFood)
                                            <tr>
                                                <td>{{ $mealFood->meal->name ?? 'N/A' }}</td>
                                                <td>{{ $mealFood->food->name ?? 'N/A' }}</td>
                                                <td>{{ $mealFood->quantity }}</td>
                                                <td>{{ $mealFood->calories_total }}</td>
                                                <td>{{ $mealFood->protein_total }}</td>
                                                <td>{{ $mealFood->carbs_total }}</td>
                                                <td>{{ $mealFood->fat_total }}</td>
                                                <td class="align-middle">
                                                    <a href="{{ route('meal-foods.show', $mealFood->id) }}" class="text-secondary font-weight-bold text-xs">Show</a>
                                                    <a href="{{ route('meal-foods.edit', $mealFood->id) }}" class="text-secondary font-weight-bold text-xs">Edit</a>
                                                    <form action="{{ route('meal-foods.destroy', $mealFood->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-danger font-weight-bold text-xs" onclick="return confirm('Are you sure?')">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{ $mealFoods->links() }}
                            <a href="{{ route('meal-foods.create') }}" class="btn bg-gradient-primary">Create New Meal Food</a>
                        </div>
                    </div>
                </div>
            </div>
            <x-footers.auth></x-footers.auth>
        </div>
    </main>
    <x-plugins></x-plugins>
</x-layout>