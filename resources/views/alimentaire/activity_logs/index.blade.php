<x-layout bodyClass="g-sidenav-show bg-gradient-to-br from-indigo-50 to-blue-200 min-h-screen" :activePage="'activity_logs'">
    <x-navbars.sidebar activePage="activity_logs"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Journal d'Activités"></x-navbars.navs.auth>

        <div class="container-fluid py-4">

            {{-- Summary Cards --}}
            <div class="row mb-4">
                <div class="col-md-4 mb-3">
                    <div class="card shadow border-0 p-4 text-center bg-gradient-to-r from-green-400 to-blue-500 text-white">
                        <h5>Total Activités</h5>
                        <h3>{{ $logs->total() }}</h3>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card shadow border-0 p-4 text-center bg-gradient-to-r from-indigo-500 to-purple-600 text-white">
                        <h5>Actions Créées</h5>
                        <h3>{{ $logs->where('action', 'created_food_goal')->count() }}</h3>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card shadow border-0 p-4 text-center bg-gradient-to-r from-pink-500 to-red-500 text-white">
                        <h5>Actions Modifiées</h5>
                        <h3>{{ $logs->where('action', 'updated_food_goal')->count() }}</h3>
                    </div>
                </div>
            </div>

            {{-- Filters --}}
            <form method="GET" action="{{ route('activity_logs') }}" class="row g-3 mb-4">
                <div class="col-md-4">
                    <input type="text" name="user" class="form-control" placeholder="Rechercher par utilisateur" value="{{ request('user') }}">
                </div>
                <div class="col-md-4">
                    <select name="action" class="form-select">
                        <option value="">Toutes les actions</option>
                        <option value="created_food_goal" {{ request('action') == 'created_food_goal' ? 'selected' : '' }}>Création Objectif</option>
                        <option value="updated_food_goal" {{ request('action') == 'updated_food_goal' ? 'selected' : '' }}>Mise à jour Objectif</option>
                        <option value="deleted_food_goal" {{ request('action') == 'deleted_food_goal' ? 'selected' : '' }}>Suppression Objectif</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex">
                    <button type="submit" class="btn btn-primary me-2">Filtrer</button>
                    <a href="{{ route('activity_logs') }}" class="btn btn-secondary">Réinitialiser</a>
                </div>
            </form>

            {{-- Activity Logs Table --}}
            <div class="row justify-content-center">
                <div class="col-12 col-lg-10">
                    <div class="card shadow-2xl border-0 bg-white/90 p-6">
                        <div class="card-header p-0 mt-n4 mx-3">
                            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg py-3 px-4">
                                <h6 class="text-white">
                                    <i class="fas fa-history mr-2"></i> Activités Récentes
                                </h6>
                            </div>
                        </div>
                        <div class="card-body">
                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            @if ($logs->isEmpty())
                                <p class="text-gray-600 italic">Aucune activité enregistrée.</p>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Utilisateur</th>
                                                <th>Action</th>
                                                <th>Description</th>
                                                <th>Détails</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($logs as $log)
                                                <tr @if($log->created_at->isToday()) class="bg-yellow-50" @endif>
                                                    <td>{{ $log->user?->name ?? 'Inconnu' }}</td>
                                                    <td>
                                                        @if ($log->action == 'created_food_goal')
                                                            <span class="badge bg-success">Création</span>
                                                        @elseif ($log->action == 'updated_food_goal')
                                                            <span class="badge bg-warning text-dark">Modification</span>
                                                        @elseif ($log->action == 'deleted_food_goal')
                                                            <span class="badge bg-danger">Suppression</span>
                                                        @else
                                                            <span class="badge bg-secondary">Autre</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $log->description ?? '-' }}</td>
                                                    <td>
                                                        @if ($log->details)
                                                            <ul class="list-unstyled mb-0">
                                                                @foreach ($log->details as $key => $value)
                                                                    <li><strong>{{ ucfirst(str_replace('_',' ', $key)) }}:</strong> {{ $value }}</li>
                                                                @endforeach
                                                            </ul>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                {{-- Pagination --}}
                                <div class="d-flex justify-content-between align-items-center mt-4">
                                    {{ $logs->links() }}
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

    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                // Initialize Bootstrap Tooltips
                const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
                tooltipTriggerList.forEach(el => new bootstrap.Tooltip(el));
            });
        </script>
    @endpush
</x-layout>
