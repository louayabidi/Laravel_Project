<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="tracking"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Suivi Quotidien des Repas"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Suivi Quotidien par Rapport à l'Objectif</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5>Objectif Actuel</h5>
                            <ul>
                                <li>Calories Quotidiennes: {{ $goal->daily_calories }}</li>
                                <li>Protéines Quotidiennes: {{ $goal->daily_protein }} g</li>
                                <li>Glucides Quotidiennes: {{ $goal->daily_carbs }} g</li>
                                <li>Lipides Quotidiennes: {{ $goal->daily_fat }} g</li>
                            </ul>
                            
                            <h5>Consommation Aujourd'hui</h5>
                            <ul>
                                <li>Calories: {{ $dailyTotals['calories'] }} (Restant: {{ $remaining['calories'] > 0 ? $remaining['calories'] : 'Dépassé de ' . abs($remaining['calories']) }})</li>
                                <li>Protéines: {{ $dailyTotals['protein'] }} g (Restant: {{ $remaining['protein'] > 0 ? $remaining['protein'] : 'Dépassé de ' . abs($remaining['protein']) }} g)</li>
                                <li>Glucides: {{ $dailyTotals['carbs'] }} g (Restant: {{ $remaining['carbs'] > 0 ? $remaining['carbs'] : 'Dépassé de ' . abs($remaining['carbs']) }} g)</li>
                                <li>Lipides: {{ $dailyTotals['fat'] }} g (Restant: {{ $remaining['fat'] > 0 ? $remaining['fat'] : 'Dépassé de ' . abs($remaining['fat']) }} g)</li>
                                <li>Sucre: {{ $dailyTotals['sugar'] }} g</li>
                                <li>Fibres: {{ $dailyTotals['fiber'] }} g</li>
                            </ul>
                            
                            <h5>Commentaires sur le Progrès</h5>
                            <ul>
                                <li>Calories: {{ $messages['calories'] }}</li>
                                <li>Protéines: {{ $messages['protein'] }}</li>
                                <li>Glucides: {{ $messages['carbs'] }}</li>
                                <li>Lipides: {{ $messages['fat'] }}</li>
                            </ul>
                            
                            <a href="{{ route('meal-foods.create') }}" class="btn bg-gradient-primary">Ajouter un Aliment à un Repas</a>
                            <a href="{{ route('goals.index') }}" class="btn btn-secondary">Voir les Objectifs</a>
                        </div>
                    </div>
                </div>
            </div>
            <x-footers.auth></x-footers.auth>
        </div>
    </main>
    <x-plugins></x-plugins>
</x-layout>