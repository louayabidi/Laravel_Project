@php
use Illuminate\Support\Str;
@endphp

<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-header.header></x-header.header>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Objectifs"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="text-white text-capitalize ps-3 mb-0">Mes Objectifs</h6>
                                    <a href="{{ route('objectifs.create') }}" class="btn btn-light btn-sm me-3">
                                        <i class="fas fa-plus me-1"></i> Nouvel Objectif
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0 mt-3 px-3">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">
                                                Objectif
                                            </th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Valeur Cible
                                            </th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Période
                                            </th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Catégorie
                                            </th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                                Actions
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($objectifs as $objectif)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="me-3">
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
                                                            <a href="{{ route('objectifs.habitudes.index', $objectif->id) }}" 
                                                               class="text-dark font-weight-bold text-sm mb-0 text-decoration-none">
                                                                {{ $objectif->title }}
                                                            </a>
                                                            @if($objectif->description)
                                                                <p class="text-xs text-muted mb-0">
                                                                    {{ Str::limit($objectif->description, 50) }}
                                                                </p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge bg-gradient-primary text-white">
                                                        {{ $objectif->target_value }}
                                                    </span>
                                                    <small class="text-xs text-muted d-block mt-1">
                                                        unités
                                                    </small>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column">
                                                        <span class="text-xs text-dark fw-bold">
                                                            <i class="fas fa-play text-success me-1"></i>
                                                            {{ \Carbon\Carbon::parse($objectif->start_date)->format('d/m/Y') }}
                                                        </span>
                                                        <span class="text-xs text-dark fw-bold">
                                                            <i class="fas fa-flag text-danger me-1"></i>
                                                            {{ \Carbon\Carbon::parse($objectif->end_date)->format('d/m/Y') }}
                                                        </span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge 
                                                        @switch($objectif->status)
                                                            @case('Sport') bg-success @break
                                                            @case('Eau') bg-info @break
                                                            @case('Sommeil') bg-primary @break
                                                            @case('Stress') bg-warning @break
                                                            @default bg-secondary @break
                                                        @endswitch
                                                        text-white">
                                                        <i class="
                                                            @switch($objectif->status)
                                                                @case('Sport') fas fa-running me-1 @break
                                                                @case('Eau') fas fa-tint me-1 @break
                                                                @case('Sommeil') fas fa-bed me-1 @break
                                                                @case('Stress') fas fa-brain me-1 @break
                                                                @default fas fa-bullseye me-1 @break
                                                            @endswitch
                                                        "></i>
                                                        {{ $objectif->status }}
                                                    </span>
                                                </td>
                                                <td class="align-middle">
                                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                                        <a href="{{ route('objectifs.habitudes.index', $objectif->id) }}" 
                                                           class="btn btn-info btn-sm d-flex align-items-center justify-content-center" 
                                                           title="Voir les habitudes"
                                                           style="width: 32px; height: 32px;">
                                                            <i class="fas fa-tasks text-white fa-sm"></i>
                                                        </a>
                                                        <a href="{{ route('objectifs.edit', $objectif->id) }}" 
                                                           class="btn btn-primary btn-sm d-flex align-items-center justify-content-center"
                                                           title="Modifier"
                                                           style="width: 32px; height: 32px;">
                                                            <i class="fas fa-edit text-white fa-sm"></i>
                                                        </a>
                                                        <form action="{{ route('objectifs.destroy', $objectif->id) }}" 
                                                              method="POST" 
                                                              style="display:inline;"
                                                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet objectif ?')">
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
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center py-4">
                                                    <div class="d-flex flex-column align-items-center">
                                                        <i class="fas fa-bullseye fa-3x text-primary mb-3"></i>
                                                        <h6 class="text-primary">Aucun objectif trouvé</h6>
                                                        <p class="text-muted mb-3">Commencez par créer votre premier objectif</p>
                                                        <a href="{{ route('objectifs.create') }}" class="btn bg-gradient-primary">
                                                            <i class="fas fa-plus me-2"></i> Créer un objectif
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            @if($objectifs->hasPages())
                                <div class="d-flex justify-content-between align-items-center mt-4 px-3">
                                    <div class="text-sm text-muted">
                                        Affichage de {{ $objectifs->firstItem() }} à {{ $objectifs->lastItem() }} 
                                        sur {{ $objectifs->total() }} objectifs
                                    </div>
                                    {{ $objectifs->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <x-footers.auth></x-footers.auth>
        </div>
    </main>
</x-layout>