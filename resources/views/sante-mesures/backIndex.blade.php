<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="sante"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Mesures de Santé"></x-navbars.navs.auth>
        <!-- End Navbar -->
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <div class="d-flex justify-content-between align-items-center px-3">
                            <h6 class="text-white text-capitalize ps-3">Suivi de Santé</h6>

                        </div>
                    </div>
                </div>

                <div class="card-body pt-4">
                    <!-- Tableau des mesures -->
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Patient</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date Remplie</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Poids</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">IMC</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Fréq. Cardiaque</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tension</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Régime</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($mesures as $mesure)
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <div class="d-flex align-items-center">
                                                    <i class="material-icons text-primary me-2">account_circle</i>
                                                    <h6 class="mb-0 text-sm">{{ $mesure->user->name }}</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $mesure->date_mesure->format('d/m/Y') }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $mesure->date_remplie ? $mesure->date_remplie->format('d/m/Y') : 'N/A' }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $mesure->poids_kg }} kg</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $mesure->imc }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $mesure->freq_cardiaque }} bpm</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">
                                            {{ $mesure->tension_systolique }}/{{ $mesure->tension_diastolique }}
                                        </p>
                                    </td>
                                    <td>
                                        @if($mesure->regime)
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $mesure->regime->type_regime }}<br>
                                                <small class="text-muted">{{ $mesure->regime->valeur_cible }}kg</small>
                                            </p>
                                        @else
                                            <p class="text-xs text-muted mb-0">Aucun régime</p>
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        <a href="{{ route('sante-mesures.backShow', $mesure) }}" class="btn btn-link text-primary px-3 mb-0">
                                            <i class="material-icons text-sm me-2">visibility</i>Voir
                                        </a>
                                        @if(auth()->user()->can('delete', $mesure))
                                        <form action="{{ route('sante-mesures.destroy', $mesure) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-link text-danger px-3 mb-0"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette mesure ?')">
                                                <i class="material-icons text-sm me-2">delete</i>Supprimer
                                            </button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $mesures->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

        </main>
        <x-plugins></x-plugins>
</x-layout>
