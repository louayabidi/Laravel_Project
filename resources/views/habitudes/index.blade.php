<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-header.header></x-header.header>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Habitudes"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Habitudes de vie</h6>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0 mt-3 px-3">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Sommeil (h)</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Eau (L)</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Sport (min)</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Stress</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Méditation (min)</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Écran (min)</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Café (tasses)</th>
                                            <th class="text-secondary opacity-7"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($habitudes as $habitude)
                                            <tr>
                                                <td>{{ $habitude->date_jour }}</td>
                                                <td>{{ $habitude->sommeil_heures }}</td>
                                                <td>{{ $habitude->eau_litres }}</td>
                                                <td>{{ $habitude->sport_minutes }}</td>
                                                <td>{{ $habitude->stress_niveau }}</td>
                                                <td>{{ $habitude->meditation_minutes }}</td>
                                                <td>{{ $habitude->temps_ecran_minutes }}</td>
                                                <td>{{ $habitude->cafe_cups }}</td>
                                                <td class="align-middle">
                                                    <a href="{{ route('habitudes.show', $habitude->habitude_id) }}" class="text-secondary font-weight-bold text-xs">Show</a>
                                                    <a href="{{ route('habitudes.edit', $habitude->habitude_id) }}" class="text-secondary font-weight-bold text-xs">Edit</a>
                                                    <form action="{{ route('habitudes.destroy', $habitude->habitude_id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-danger font-weight-bold text-xs" onclick="return confirm('Are you sure?')">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            {{ $habitudes->links() }}

<div class="mt-3 px-3">
    <a href="{{ route('habitudes.create') }}" class="btn bg-gradient-primary">Ajouter une habitude</a>
</div>
                        </div>
                    </div>
                </div>
            </div>
            <x-footers.auth></x-footers.auth>
        </div>
    </main>
    <x-plugins></x-plugins>
</x-layout>
