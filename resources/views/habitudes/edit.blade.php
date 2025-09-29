<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-header.header></x-header.header>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="{{ isset($habitude) ? 'Edit Habitude' : 'Create Habitude' }}"></x-navbars.navs.auth>

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">
                                    {{ isset($habitude) ? 'Edit Habitude' : 'Create Habitude' }}
                                </h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ isset($habitude) ? route('habitudes.update', $habitude) : route('habitudes.store') }}" method="POST">
                                @csrf
                                @if(isset($habitude))
                                    @method('PUT')
                                @endif

                                <div class="input-group input-group-outline mb-3">
                                    <label class="form-label">Date</label>
                                    <input type="date" name="date_jour" class="form-control" value="{{ $habitude->date_jour ?? '' }}" required>
                                </div>

                                <div class="input-group input-group-outline mb-3">
                                    <label class="form-label">Sommeil (heures)</label>
                                    <input type="number" step="0.1" name="sommeil_heures" class="form-control" value="{{ $habitude->sommeil_heures ?? '' }}">
                                </div>

                                <div class="input-group input-group-outline mb-3">
                                    <label class="form-label">Eau (litres)</label>
                                    <input type="number" step="0.1" name="eau_litres" class="form-control" value="{{ $habitude->eau_litres ?? '' }}">
                                </div>

                                <div class="input-group input-group-outline mb-3">
                                    <label class="form-label">Sport (minutes)</label>
                                    <input type="number" name="sport_minutes" class="form-control" value="{{ $habitude->sport_minutes ?? '' }}">
                                </div>

                                <div class="input-group input-group-outline mb-3">
                                    <label class="form-label">Stress (niveau)</label>
                                    <input type="number" name="stress_niveau" class="form-control" value="{{ $habitude->stress_niveau ?? '' }}">
                                </div>

                                <div class="input-group input-group-outline mb-3">
                                    <label class="form-label">Méditation (minutes)</label>
                                    <input type="number" name="meditation_minutes" class="form-control" value="{{ $habitude->meditation_minutes ?? '' }}">
                                </div>

                                <div class="input-group input-group-outline mb-3">
                                    <label class="form-label">Temps écran (minutes)</label>
                                    <input type="number" name="temps_ecran_minutes" class="form-control" value="{{ $habitude->temps_ecran_minutes ?? '' }}">
                                </div>

                                <div class="input-group input-group-outline mb-3">
                                    <label class="form-label">Café (tasses)</label>
                                    <input type="number" name="cafe_cups" class="form-control" value="{{ $habitude->cafe_cups ?? '' }}">
                                </div>

                                <button type="submit" class="btn bg-gradient-primary">
                                    {{ isset($habitude) ? 'Update' : 'Save' }}
                                </button>
                                <a href="{{ route('habitudes.index') }}" class="btn btn-secondary">Retour</a>
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
