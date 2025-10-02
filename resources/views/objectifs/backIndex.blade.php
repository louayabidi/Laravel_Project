<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="objectifs"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Objectifs & Habitudes - Administration"></x-navbars.navs.auth>

        <div class="container-fluid py-4">
            <!-- Liste des objectifs -->
            @foreach($objectifs as $objectif)
            <div class="card mb-4 shadow-sm border-0">
                <div class="card-header bg-gradient-primary shadow-primary border-radius-lg pt-3 pb-3 text-white d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="icon-shape icon-md bg-white rounded-circle text-center me-3 p-2">
                            <i class="
                                @switch($objectif->status)
                                    @case('Sport') fas fa-running text-success @break
                                    @case('Eau') fas fa-tint text-info @break
                                    @case('Sommeil') fas fa-bed text-primary @break
                                    @case('Stress') fas fa-brain text-warning @break
                                    @default fas fa-bullseye text-secondary @break
                                @endswitch
                            "></i>
                        </div>
                        <div>
                            <h6 class="mb-0 text-white">{{ $objectif->title }}</h6>
                            <small>
                                <span class="badge bg-light text-dark me-2">{{ $objectif->status }}</span>
                                <span class="text-white-50">Cible: {{ $objectif->target_value }} unités</span>
                            </small>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <span class="badge bg-light text-dark">
                            <i class="fas fa-chart-line me-1"></i>{{ $objectif->habitudes_count ?? $objectif->habitudes->count() }} habitudes
                        </span>
                        <form action="{{ route('objectifs.destroy', $objectif->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-light text-dark" 
                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet objectif et toutes ses habitudes ?')">
                                <i class="fas fa-trash me-1"></i>Supprimer
                            </button>
                        </form>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Informations objectif -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong class="text-primary">Description:</strong>
                            <p class="text-muted mb-2">{{ $objectif->description ?? 'Aucune description' }}</p>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex gap-4 text-sm">
                                <div>
                                    <strong class="text-primary">Début:</strong>
                                    <div class="text-dark">{{ \Carbon\Carbon::parse($objectif->start_date)->format('d/m/Y') }}</div>
                                </div>
                                <div>
                                    <strong class="text-primary">Fin:</strong>
                                    <div class="text-dark">{{ \Carbon\Carbon::parse($objectif->end_date)->format('d/m/Y') }}</div>
                                </div>
                                <div>
                                    <strong class="text-primary">Progression:</strong>
                                    <div class="text-dark">
                                        {{ \Carbon\Carbon::parse($objectif->start_date)->diffInDays(now()) }} / 
                                        {{ \Carbon\Carbon::parse($objectif->start_date)->diffInDays($objectif->end_date) }} jours
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Liste des habitudes -->
                    <h6 class="text-primary mb-3">
                        <i class="fas fa-list me-2"></i>Habitudes enregistrées
                    </h6>
                    
                    @forelse($objectif->habitudes as $habitude)
                    <div class="card border mb-2">
                        <div class="card-body py-2">
                            <div class="row align-items-center">
                                <div class="col-md-3">
                                    <strong class="text-primary">
                                        <i class="fas fa-user me-1"></i>{{ $habitude->objectif->user->name ?? 'Utilisateur supprimé' }}

                                    </strong>
                                    <div class="text-muted small">
                                        <i class="fas fa-calendar me-1"></i>{{ \Carbon\Carbon::parse($habitude->date_jour)->format('d/m/Y') }}
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="d-flex flex-wrap gap-3">
                                        @if($habitude->sommeil_heures)
                                        <span class="badge bg-primary text-white">
                                            <i class="fas fa-bed me-1"></i>{{ $habitude->sommeil_heures }}h
                                        </span>
                                        @endif
                                        @if($habitude->eau_litres)
                                        <span class="badge bg-info text-white">
                                            <i class="fas fa-tint me-1"></i>{{ $habitude->eau_litres }}L
                                        </span>
                                        @endif
                                        @if($habitude->sport_minutes)
                                        <span class="badge bg-success text-white">
                                            <i class="fas fa-running me-1"></i>{{ $habitude->sport_minutes }}min
                                        </span>
                                        @endif
                                        @if($habitude->stress_niveau)
                                        <span class="badge 
                                            @if($habitude->stress_niveau <= 3) bg-success
                                            @elseif($habitude->stress_niveau <= 6) bg-warning
                                            @else bg-danger
                                            @endif text-white">
                                            <i class="fas fa-brain me-1"></i>{{ $habitude->stress_niveau }}/10
                                        </span>
                                        @endif
                                        @if($habitude->meditation_minutes)
                                        <span class="badge bg-secondary text-white">
                                            <i class="fas fa-spa me-1"></i>{{ $habitude->meditation_minutes }}min
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-2 text-end">
                                    <small class="text-muted">
                                        {{ \Carbon\Carbon::parse($habitude->created_at)->format('H:i') }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4">
                        <i class="fas fa-chart-line fa-2x text-muted mb-2"></i>
                        <p class="text-muted mb-0">Aucune habitude enregistrée pour cet objectif</p>
                    </div>
                    @endforelse
                </div>
            </div>
            @endforeach

            <!-- Pagination -->
            @if($objectifs->hasPages())
            <div class="d-flex justify-content-center mt-4">
                <nav aria-label="Page navigation">
                    {{ $objectifs->links() }}
                </nav>
            </div>
            @endif

            <!-- État vide -->
            @if($objectifs->count() == 0)
            <div class="card text-center py-5">
                <div class="card-body">
                    <i class="fas fa-bullseye fa-4x text-primary mb-3"></i>
                    <h4 class="text-primary">Aucun objectif trouvé</h4>
                    <p class="text-muted mb-4">Aucun utilisateur n'a encore créé d'objectif</p>
                </div>
            </div>
            @endif
        </div>

        <x-footers.auth></x-footers.auth>
    </main>
    <x-plugins></x-plugins>
</x-layout>