<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-header.header></x-header.header>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Détails de l'Aliment de Repas"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Détails de l'Aliment de Repas</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <p><strong>Repas :</strong> {{ $mealFood->meal->type ?? 'N/A' }} ({{ $mealFood->meal->date ?? 'N/A' }})</p>
                            <p><strong>Aliment :</strong> {{ $mealFood->food->name ?? 'N/A' }}</p>
                            <p><strong>Quantité :</strong> {{ $mealFood->quantity }}</p>
                            <p><strong>Calories Totales :</strong> {{ $mealFood->calories_total }}</p>
                            <p><strong>Protéines Totales :</strong> {{ $mealFood->protein_total }} g</p>
                            <p><strong>Glucides Totales :</strong> {{ $mealFood->carbs_total }} g</p>
                            <p><strong>Lipides Totales :</strong> {{ $mealFood->fat_total }} g</p>
                            <p><strong>Sucre Total :</strong> {{ $mealFood->sugar_total ?? 'N/A' }} g</p>
                            <p><strong>Fibres Totales :</strong> {{ $mealFood->fiber_total ?? 'N/A' }} g</p>
                            <a href="{{ route('meal-foods.index') }}" class="btn bg-gradient-primary">Retour</a>
                        </div>
                    </div>
                </div>
            </div>
            <x-footers.auth></x-footers.auth>
        </div>
    </main>
    <x-plugins></x-plugins>
</x-layout>