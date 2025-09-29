<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-header.header></x-header.header>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Habitude Details"></x-navbars.navs.auth>

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Habitude du {{ $habitude->date_jour }}</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <p><strong>Sommeil (heures) :</strong> {{ $habitude->sommeil_heures ?? 'N/A' }}</p>
                            <p><strong>Eau (litres) :</strong> {{ $habitude->eau_litres ?? 'N/A' }}</p>
                            <p><strong>Sport (minutes) :</strong> {{ $habitude->sport_minutes ?? 'N/A' }}</p>
                            <p><strong>Stress (niveau) :</strong> {{ $habitude->stress_niveau ?? 'N/A' }}</p>
                            <p><strong>Méditation (minutes) :</strong> {{ $habitude->meditation_minutes ?? 'N/A' }}</p>
                            <p><strong>Temps écran (minutes) :</strong> {{ $habitude->temps_ecran_minutes ?? 'N/A' }}</p>
                            <p><strong>Café (tasses) :</strong> {{ $habitude->cafe_cups ?? 'N/A' }}</p>

                            <a href="{{ route('habitudes.index') }}" class="btn bg-gradient-primary">Retour</a>
                        </div>
                    </div>
                </div>
            </div>

            <x-footers.auth></x-footers.auth>
        </div>
    </main>
    <x-plugins></x-plugins>
</x-layout>
