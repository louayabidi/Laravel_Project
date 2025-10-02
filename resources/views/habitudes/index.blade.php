<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-header.header></x-header.header>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Habitudes de vie"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="text-white text-capitalize ps-3 mb-0">
                                        <i class="fas fa-chart-line me-2"></i>Habitudes de vie
                                    </h6>
                                    @if(isset($objectif_id))
                                    <a href="{{ route('objectifs.habitudes.create', $objectif_id) }}" class="btn btn-light btn-sm me-3">
                                        <i class="fas fa-plus me-1"></i>Nouvelle habitude
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0 mt-3 px-3">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Date</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Sommeil</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Eau</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Sport</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Stress</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($habitudes as $habitude)
                                            <tr>
                                                <td class="ps-3">
                                                    <span class="fw-bold text-primary">
                                                        <i class="fas fa-calendar-day me-1"></i>
                                                        {{ \Carbon\Carbon::parse($habitude->date_jour)->format('d/m/Y') }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if($habitude->sommeil_heures)
                                                        <span class="badge bg-primary text-white">
                                                            <i class="fas fa-bed me-1"></i>
                                                            {{ $habitude->sommeil_heures }}h
                                                        </span>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($habitude->eau_litres)
                                                        <span class="badge bg-info text-white">
                                                            <i class="fas fa-tint me-1"></i>
                                                            {{ $habitude->eau_litres }}L
                                                        </span>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($habitude->sport_minutes)
                                                        <span class="badge bg-success text-white">
                                                            <i class="fas fa-running me-1"></i>
                                                            {{ $habitude->sport_minutes }}min
                                                        </span>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($habitude->stress_niveau)
                                                        <span class="badge 
                                                            @if($habitude->stress_niveau <= 3) bg-success
                                                            @elseif($habitude->stress_niveau <= 6) bg-warning
                                                            @else bg-danger
                                                            @endif text-white">
                                                            <i class="fas fa-brain me-1"></i>
                                                            {{ $habitude->stress_niveau }}/10
                                                        </span>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td class="align-middle">
                                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                                        <a href="{{ route('habitudes.show', $habitude->habitude_id) }}" 
                                                           class="btn btn-info btn-sm d-flex align-items-center justify-content-center" 
                                                           title="Voir détails"
                                                           style="width: 32px; height: 32px;">
                                                            <i class="fas fa-eye text-white fa-sm"></i>
                                                        </a>
                                                        <a href="{{ route('objectifs.habitudes.edit', ['objectif' => $habitude->objectif_id, 'habitude' => $habitude->habitude_id]) }}" 
                                                           class="btn btn-primary btn-sm d-flex align-items-center justify-content-center"
                                                           title="Modifier"
                                                           style="width: 32px; height: 32px;">
                                                            <i class="fas fa-edit text-white fa-sm"></i>
                                                        </a>
                                                        <form action="{{ route('habitudes.destroy', $habitude->habitude_id) }}" 
                                                              method="POST" 
                                                              style="display:inline"
                                                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette habitude ?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" 
                                                                    class="btn btn-danger btn-sm d-flex align-items-center justify-content-center"
                                                                    title="Supprimer"
                                                                    style="width: 32px; height: 32px;">
                                                                <i class="fas fa-trash text-white fa-sm"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            @if($habitudes->hasPages())
                                <div class="d-flex justify-content-between align-items-center mt-4 px-3">
                                    <div class="text-sm text-muted">
                                        Affichage de {{ $habitudes->firstItem() }} à {{ $habitudes->lastItem() }} 
                                        sur {{ $habitudes->total() }} habitudes
                                    </div>
                                    {{ $habitudes->links() }}
                                </div>
                            @endif

                            <!-- État vide -->
                            @if($habitudes->count() == 0)
                                <div class="text-center py-5">
                                    <i class="fas fa-chart-line fa-3x text-primary mb-3"></i>
                                    <h6 class="text-primary">Aucune habitude enregistrée</h6>
                                    <p class="text-muted mb-3">Commencez par ajouter votre première habitude</p>
                                    @if(isset($objectif_id))
                                    <a href="{{ route('objectifs.habitudes.create', $objectif_id) }}" class="btn bg-gradient-primary">
                                        <i class="fas fa-plus me-2"></i>Ajouter une habitude
                                    </a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <x-footers.auth></x-footers.auth>
        </div>
    </main>
    <x-plugins></x-plugins>
</x-layout>