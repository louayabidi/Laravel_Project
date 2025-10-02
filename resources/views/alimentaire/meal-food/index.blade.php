<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="meal-foods"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Aliments de Repas"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Tableau des Aliments de Repas</h6>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Repas</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Aliment</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Quantité</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Calories Total</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Protéines Total</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Glucides Total</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Lipides Total</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Sucre Total</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Fibres Total</th>
                                            <th class="text-secondary opacity-7"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($mealFoods as $mealFood)
                                            <tr>
                                                <td>{{ $mealFood->meal->type ?? 'N/A' }}</td>
                                                <td>{{ $mealFood->food->name ?? 'N/A' }}</td>
                                                <td>{{ $mealFood->quantity }}</td>
                                                <td>{{ $mealFood->calories_total }}</td>
                                                <td>{{ $mealFood->protein_total }}</td>
                                                <td>{{ $mealFood->carbs_total }}</td>
                                                <td>{{ $mealFood->fat_total }}</td>
                                                <td>{{ $mealFood->sugar_total ?? 'N/A' }}</td>
                                                <td>{{ $mealFood->fiber_total ?? 'N/A' }}</td>
                                                <td class="align-middle">
                                                    <a href="{{ route('meal-foods.show', $mealFood->id) }}" class="text-secondary font-weight-bold text-xs">Voir</a>
                                                    <a href="{{ route('meal-foods.edit', $mealFood->id) }}" class="text-secondary font-weight-bold text-xs">Modifier</a>
                                                    <form action="{{ route('meal-foods.destroy', $mealFood->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-danger font-weight-bold text-xs" onclick="return confirm('Êtes-vous sûr ?')">Supprimer</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{ $mealFoods->links() }}
                            <a href="{{ route('meal-foods.create') }}" class="btn bg-gradient-primary">Créer un nouvel aliment de repas</a>
                        </div>
                    </div>
                </div>
            </div>
            <x-footers.auth></x-footers.auth>
        </div>
    </main>
    <x-plugins></x-plugins>
</x-layout>