<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="analytics"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Edit Analytic"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Edit Analytic</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('analytics.update', $analytic->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="input-group input-group-outline mb-3">
                                    <label class="form-label">Daily Calories</label>
                                    <input type="number" step="0.01" name="daily_calories" value="{{ $analytic->daily_calories }}" class="form-control">
                                </div>
                                <div class="input-group input-group-outline mb-3">
                                    <label class="form-label">Protein</label>
                                    <input type="number" step="0.01" name="protein" value="{{ $analytic->protein }}" class="form-control" required>
                                </div>
                                <div class="input-group input-group-outline mb-3">
                                    <label class="form-label">Carbs</label>
                                    <input type="number" step="0.01" name="carbs" value="{{ $analytic->carbs }}" class="form-control" required>
                                </div>
                                <div class="input-group input-group-outline mb-3">
                                    <label class="form-label">Fat</label>
                                    <input type="number" step="0.01" name="fat" value="{{ $analytic->fat }}" class="form-control" required>
                                </div>
                                <div class="input-group input-group-outline mb-3">
                                    <label class="form-label">Week Start</label>
                                    <input type="date" name="week_start" value="{{ $analytic->week_start }}" class="form-control" required>
                                </div>
                                <div class="input-group input-group-outline mb-3">
                                    <label class="form-label">Week End</label>
                                    <input type="date" name="week_end" value="{{ $analytic->week_end }}" class="form-control" required>
                                </div>
                                <button type="submit" class="btn bg-gradient-primary">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <x-footers.auth></x-footers.auth>
        </div>
    </main>
    <x-plugins></x-plugins>
</x-layout>