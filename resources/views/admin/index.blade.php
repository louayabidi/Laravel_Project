@php use Illuminate\Support\Str; @endphp
<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="sante"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Admin - Posts Management"></x-navbars.navs.auth>

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center px-3">
                                <h6 class="text-white text-capitalize ps-3">Administration des posts</h6>
                                <div class="d-flex">
                                    <a href="{{ route('admin.index', ['status' => 'all']) }}" class="btn btn-sm btn-outline-light me-1">Tous</a>
                                    <a href="{{ route('admin.index', ['status' => 'active']) }}" class="btn btn-sm btn-outline-light me-1">Actifs</a>
                                    <a href="{{ route('admin.index', ['status' => 'hidden']) }}" class="btn btn-sm btn-outline-light">Hidden</a>
                                </div>
                            </div>
                        </div>

                        <div class="card-body px-0 pb-2">
                            @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show mx-3" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            @endif

                            <div class="row g-4 p-3">
                                @foreach($posts as $post)
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="card shadow-sm border-0 h-100 post-card">
                                        <!-- Card Header with Author Info -->
                                        <div class="card-header bg-transparent border-0 pb-0 pt-3">
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-sm me-2">
                                                        <i class="material-icons text-primary">account_circle</i>
                                                    </div>
                                                    <div class="d-flex flex-column">
                                                        <span class="text-sm font-weight-bold">{{ $post->user->name }}</span>
                                                        <small class="text-muted">{{ $post->created_at->format('d/m/Y') }}</small>
                                                    </div>
                                                </div>
                                                <!-- Status Badge -->
                                                <span class="badge 
                                                    @if($post->status === 'active') bg-success 
                                                    @elseif($post->status === 'hidden') bg-warning 
                                                    @else bg-secondary @endif">
                                                    {{ ucfirst($post->status) }}
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Card Body -->
                                        <div class="card-body py-3">
                                            <!-- Post Title -->
                                            <h6 class="card-title text-dark font-weight-bold mb-2">
                                                {{ Str::limit($post->title, 60) }}
                                            </h6>

                                            <!-- Post Content Excerpt -->
                                            <p class="card-text text-muted small mb-3">
                                                {{ Str::limit(strip_tags($post->content), 120) }}
                                            </p>

                                            <!-- Engagement Stats -->
                                            <div class="d-flex justify-content-between small text-muted mb-3">
                                                <span>
                                                    <i class="material-icons text-sm text-primary me-1">comment</i>
                                                    {{ $post->comments_count ?? $post->comments->count() }}
                                                </span>
                                                <span>
                                                    <i class="material-icons text-sm text-danger me-1">favorite</i>
                                                    @php
                                                    $commentLikesCount = 0;
                                                    foreach ($post->comments as $comment) {
                                                    $commentLikesCount += $comment->likes_count ?? $comment->likes->count();
                                                    }
                                                    @endphp
                                                    {{ $commentLikesCount }}
                                                </span>
                                                <span>
                                                    <i class="material-icons text-sm text-warning me-1">flag</i>
                                                    {{ $post->reports_count ?? $post->reports->count() }}
                                                </span>
                                            </div>

                                            <!-- Tags -->
                                            @if($post->tags)
                                            <div class="mb-3">
                                                @foreach(explode(',', $post->tags) as $tag)
                                                @if(trim($tag) && $loop->index < 3) <span class="badge bg-gradient-secondary me-1 mb-1 small">{{ trim($tag) }}</span>
                                                    @endif
                                                    @endforeach
                                                    @if(count(explode(',', $post->tags)) > 3)
                                                    <span class="badge bg-dark small">+{{ count(explode(',', $post->tags)) - 3 }}</span>
                                                    @endif
                                            </div>
                                            @endif
                                        </div>

                                        <!-- Card Footer with Admin Actions -->
                                        <div class="card-footer bg-transparent border-0 pt-0 pb-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex">
                                                    <!-- View Button -->
                                                    <a href="{{ route('admin.show', $post) }}" class="btn btn-sm btn-outline-primary me-1" title="Voir Détails">
                                                        <i class="material-icons text-sm">visibility</i>
                                                    </a>
                                                    <!-- Reports Button -->
                                                    @if($post->reports->count() > 0)
                                                    <button class="btn btn-sm btn-outline-warning me-1" data-bs-toggle="modal" data-bs-target="#reportsModal{{ $post->id }}" title="Gérer les Signalements">
                                                        <i class="material-icons text-sm">warning</i>
                                                        <span class="badge bg-danger badge-sm">{{ $post->reports->count() }}</span>
                                                    </button>
                                                    @else
                                                    <button class="btn btn-sm btn-outline-secondary me-1" disabled title="Aucun signalement">
                                                        <i class="material-icons text-sm">check_circle</i>
                                                    </button>
                                                    @endif
                                                    <!-- Delete Button -->
                                                    <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" onclick="return confirm('Supprimer définitivement ce post ?')" class="btn btn-sm btn-outline-danger me-1" title="Supprimer">
                                                            <i class="material-icons text-sm">delete</i>
                                                        </button>
                                                    </form>
                                                </div>

                                                <!-- Hide/Unhide Toggle -->
                                                <div>
                                                    @if($post->status === 'active')
                                                    <form action="{{ route('posts.hide', $post) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-outline-warning" title="Masquer le post">
                                                            <i class="material-icons text-sm">visibility_off</i>
                                                        </button>
                                                    </form>
                                                    @else
                                                    <form action="{{ route('posts.unhide', $post) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-outline-success" title="Rendre le post visible">
                                                            <i class="material-icons text-sm">visibility</i>
                                                        </button>
                                                    </form>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Individual Modal for each post's reports -->
                                @if($post->reports->count() > 0)
                                <div class="modal fade" id="reportsModal{{ $post->id }}" tabindex="-1" aria-labelledby="reportsModalLabel{{ $post->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-header bg-gradient-warning text-white">
                                                <h5 class="modal-title" id="reportsModalLabel{{ $post->id }}">
                                                    <i class="material-icons me-2">warning</i>
                                                    Gestion des Signalements - {{ Str::limit($post->title, 50) }}
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="alert alert-info d-flex align-items-center">
                                                    <i class="material-icons me-2">info</i>
                                                    <span>{{ $post->reports->count() }} signalement(s) pour ce post</span>
                                                </div>

                                                @foreach($post->reports as $report)
                                                <div class="card border-0 shadow-sm mb-4">
                                                    <div class="card-body">
                                                        <!-- Report Header with All Attributes -->
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <div class="d-flex align-items-center mb-2">
                                                                    <div class="avatar avatar-sm bg-light-warning rounded-circle me-2">
                                                                        <i class="material-icons text-warning text-sm">flag</i>
                                                                    </div>
                                                                    <div>
                                                                        <h6 class="mb-0">{{ $report->reporter->name ?? 'Utilisateur inconnu' }}</h6>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 text-end">
                                                                <!-- Current Status Badge -->
                                                                <span class="badge 
                                                                    @if($report->status === 'pending') bg-warning
                                                                    @elseif($report->status === 'in_review') bg-info
                                                                    @elseif($report->status === 'resolved') bg-success
                                                                    @elseif($report->status === 'dismissed') bg-secondary
                                                                    @else bg-secondary @endif fs-6">
                                                                    @if($report->status === 'pending') En attente
                                                                    @elseif($report->status === 'in_review') En revue
                                                                    @elseif($report->status === 'resolved') Résolu
                                                                    @elseif($report->status === 'dismissed') Rejeté
                                                                    @else {{ $report->status }}
                                                                    @endif
                                                                </span>
                                                            </div>
                                                        </div>

                                                        <!-- Report Details Grid -->
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <div class="mb-2">
                                                                    <strong class="text-dark">Rapporté par:</strong>
                                                                    <p class="mb-1">
                                                                        {{ $report->reporter->name ?? 'Utilisateur inconnu' }}

                                                                    </p>
                                                                </div>

                                                                <div class="mb-2">
                                                                    <strong class="text-dark">Post concerné:</strong>
                                                                    <p class="mb-1">
                                                                        <a href="{{ route('admin.show', $post) }}" class="text-decoration-none">
                                                                            {{ $post->title }}
                                                                        </a>
                                                                    </p>
                                                                </div>

                                                                @if($report->comment_id)
                                                                <div class="mb-2">
                                                                    <strong class="text-dark">Commentaire concerné:</strong>

                                                                </div>
                                                                @endif
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="mb-2">
                                                                    <strong class="text-dark">Date de création:</strong>
                                                                    <p class="mb-1">{{ $report->created_at->format('d/m/Y à H:i') }}</p>
                                                                </div>

                                                                <div class="mb-2">
                                                                    <strong class="text-dark">Dernière mise à jour:</strong>
                                                                    <p class="mb-1">{{ $report->updated_at->format('d/m/Y à H:i') }}</p>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Report Content -->
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="mb-3">
                                                                    <strong class="text-dark">Raison du signalement:</strong>
                                                                    <p class="mb-1 p-2 bg-light rounded">{{ $report->reason ?? 'Aucune raison spécifiée' }}</p>
                                                                </div>

                                                                @if($report->description)
                                                                <div class="mb-3">
                                                                    <strong class="text-dark">Description détaillée:</strong>
                                                                    <p class="mb-1 p-2 bg-light rounded text-muted">{{ $report->description }}</p>
                                                                </div>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <!-- Status Change Buttons -->
                                                        <div class="d-flex gap-2 flex-wrap mt-3 pt-3 border-top">
                                                            @if($report->status !== 'pending')
                                                            <form action="{{ route('reports.updateStatus', $report) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('PATCH')
                                                                <input type="hidden" name="status" value="pending">
                                                                <button type="submit" class="btn btn-sm btn-warning">
                                                                    <i class="material-icons text-sm">schedule</i> En attente
                                                                </button>
                                                            </form>
                                                            @endif

                                                            @if($report->status !== 'in_review')
                                                            <form action="{{ route('reports.updateStatus', $report) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('PATCH')
                                                                <input type="hidden" name="status" value="in_review">
                                                                <button type="submit" class="btn btn-sm btn-info">
                                                                    <i class="material-icons text-sm">search</i> En revue
                                                                </button>
                                                            </form>
                                                            @endif

                                                            @if($report->status !== 'resolved')
                                                            <form action="{{ route('reports.updateStatus', $report) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('PATCH')
                                                                <input type="hidden" name="status" value="resolved">
                                                                <button type="submit" class="btn btn-sm btn-success">
                                                                    <i class="material-icons text-sm">check_circle</i> Résolu
                                                                </button>
                                                            </form>
                                                            @endif

                                                            @if($report->status !== 'dismissed')
                                                            <form action="{{ route('reports.updateStatus', $report) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('PATCH')
                                                                <input type="hidden" name="status" value="dismissed">
                                                                <button type="submit" class="btn btn-sm btn-secondary">
                                                                    <i class="material-icons text-sm">block</i> Rejeter
                                                                </button>
                                                            </form>
                                                            @endif

                                                            <form action="{{ route('reports.destroy', $report) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Supprimer ce signalement ?')">
                                                                    <i class="material-icons text-sm">delete</i> Supprimer
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                <a href="{{ route('admin.show', $post) }}" class="btn btn-primary">
                                                    <i class="material-icons me-1">visibility</i> Voir le Post
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @endforeach
                            </div>

                            <!-- Pagination -->
                            <div class="d-flex justify-content-center mt-4">
                                {{ $posts->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-plugins></x-plugins>
</x-layout>