<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="goals"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Goal Details"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Goal Details</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <p><strong>Age:</strong> {{ $goal->age }}</p>
                            <p><strong>Gender:</strong> {{ ucfirst($goal->gender) }}</p>
                            <p><strong>Weight:</strong> {{ $goal->weight }} kg</p>
                            <p><strong>Height:</strong> {{ $goal->height }} cm</p>
                            <p><strong>Activity Level:</strong> {{ ucfirst(str_replace('_', ' ', $goal->activity_level)) }}</p>
                            <p><strong>Goal Type:</strong> {{ ucfirst($goal->goal_type == 'lose' ? 'Perdre du poids' : ($goal->goal_type == 'maintain' ? 'Maintenir le poids' : 'Prendre du poids')) }}</p>
                            <p><strong>BMR:</strong> {{ $goal->bmr }}</p>
                            <p><strong>Daily Calories:</strong> {{ $goal->daily_calories }}</p>
                            <p><strong>Daily Protein:</strong> {{ $goal->daily_protein ?? 'N/A' }} g</p>
                            <p><strong>Daily Carbs:</strong> {{ $goal->daily_carbs ?? 'N/A' }} g</p>
                            <p><strong>Daily Fat:</strong> {{ $goal->daily_fat ?? 'N/A' }} g</p>
                            <a href="{{ route('goals.index') }}" class="btn bg-gradient-primary">Back</a>
                        </div>
                    </div>
                </div>
            </div>
            <x-footers.auth></x-footers.auth>
        </div>
    </main>
    <x-plugins></x-plugins>
</x-layout>