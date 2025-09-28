<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="analytics"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Analytic Details"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Analytic: {{ $analytic->week_start }} - {{ $analytic->week_end }}</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <p><strong>Daily Calories:</strong> {{ $analytic->daily_calories }}</p>
                            <p><strong>Protein:</strong> {{ $analytic->protein }}</p>
                            <p><strong>Carbs:</strong> {{ $analytic->carbs }}</p>
                            <p><strong>Fat:</strong> {{ $analytic->fat }}</p>
                            <p><strong>Week Start:</strong> {{ $analytic->week_start }}</p>
                            <p><strong>Week End:</strong> {{ $analytic->week_end }}</p>
                            <a href="{{ route('analytics.index') }}" class="btn bg-gradient-primary">Back</a>
                        </div>
                    </div>
                </div>
            </div>
            <x-footers.auth></x-footers.auth>
        </div>
    </main>
    <x-plugins></x-plugins>
</x-layout>