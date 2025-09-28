<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="foods"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Food Details"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Food: {{ $food->name }}</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <p><strong>Name:</strong> {{ $food->name }}</p>
                            <p><strong>Category:</strong> {{ $food->category }}</p>
                            <p><strong>Calories:</strong> {{ $food->calories }}</p>
                            <p><strong>Protein:</strong> {{ $food->protein }}</p>
                            <p><strong>Carbs:</strong> {{ $food->carbs }}</p>
                            <p><strong>Fat:</strong> {{ $food->fat }}</p>
                            <p><strong>Sugar:</strong> {{ $food->sugar }}</p>
                            <p><strong>Fiber:</strong> {{ $food->fiber }}</p>
                            <p><strong>Is Custom:</strong> {{ $food->is_custom ? 'Yes' : 'No' }}</p>
                            <a href="{{ route('foods.index') }}" class="btn bg-gradient-primary">Back</a>
                        </div>
                    </div>
                </div>
            </div>
            <x-footers.auth></x-footers.auth>
        </div>
    </main>
    <x-plugins></x-plugins>
</x-layout>