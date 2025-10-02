<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="goals"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Objectifs Alimentaires"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Tableau des Objectifs Alimentaires</h6>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Âge</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Sexe</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Poids (kg)</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Taille (cm)</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Niveau d'Activité</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Type d'Objectif</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">BMR</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Calories Quotidiennes</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Protéines Quotidiennes</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Glucides Quotidiennes</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Lipides Quotidiennes</th>
                                            <th class="text-secondary opacity-7"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($goals as $goal)
                                            <tr>
                                                <td>{{ $goal->age }}</td>
                                                <td>{{ $goal->gender == 'male' ? 'Homme' : 'Femme' }}</td>
                                                <td>{{ $goal->weight }}</td>
                                                <td>{{ $goal->height }}</td>
                                                <td>{{ ucfirst(str_replace('_', ' ', $goal->activity_level)) }}</td>
                                                <td>{{ ucfirst($goal->goal_type == 'lose' ? 'Perdre du poids' : ($goal->goal_type == 'maintain' ? 'Maintenir le poids' : 'Prendre du poids')) }}</td>
                                                <td>{{ $goal->bmr }}</td>
                                                <td>{{ $goal->daily_calories }}</td>
                                                <td>{{ $goal->daily_protein ?? 'N/A' }}</td>
                                                <td>{{ $goal->daily_carbs ?? 'N/A' }}</td>
                                                <td>{{ $goal->daily_fat ?? 'N/A' }}</td>
                                                <td class="align-middle">
                                                    <a href="{{ route('goals.show', $goal->id) }}" class="text-secondary font-weight-bold text-xs">Voir</a>
                                                    <a href="{{ route('goals.edit', $goal->id) }}" class="text-secondary font-weight-bold text-xs">Modifier</a>
                                                    <form action="{{ route('goals.destroy', $goal->id) }}" method="POST" style="display:inline;">
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
                            {{ $goals->links() }}
                            <a href="{{ route('goals.create') }}" class="btn bg-gradient-primary">Créer un nouvel objectif alimentaire</a>
                        </div>
                    </div>
                </div>
            </div>
            <x-footers.auth></x-footers.auth>
        </div>
    </main>
    <x-plugins></x-plugins>
</x-layout>