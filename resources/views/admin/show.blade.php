@php use Illuminate\Support\Str; @endphp
<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="sante"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Détailles du Post"></x-navbars.navs.auth>

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center px-3">
                                <h6 class="text-white text-capitalize ps-3">Détailles du Post</h6>
                                <div>
                                    <a href="{{ route('admin.index') }}" class="btn btn-sm btn-light">
                                        <i class="material-icons">arrow_back</i> Retour
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="p-3">
                                @if(session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif

                                <!-- Post Details Section -->
                                <div class="row mb-4">
                                    <div class="col-md-8">
                                        <h3 class="text-primary">{{ $post->title }}</h3>
                                        <div class="d-flex align-items-center text-sm text-muted mb-2">
                                            <i class="material-icons text-sm me-1">person</i>
                                            <span class="me-3">Par <strong>{{ $post->user->name }}</strong></span>
                                            <i class="material-icons text-sm me-1">calendar_today</i>
                                            <span> {{ $post->created_at->format('d/m/Y à H:i') }}</span>
                                        </div>
                                        @if($post->updated_at != $post->created_at)
                                            <div class="text-sm text-muted">
                                                <i class="material-icons text-sm me-1">update</i>
                                                Modifié le {{ $post->updated_at->format('d/m/Y à H:i') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <span class="badge 
                                            @if($post->status === 'active') bg-success 
                                            @elseif($post->status === 'hidden') bg-warning 
                                            @else bg-secondary @endif fs-6">
                                            {{ ucfirst($post->status) }}
                                        </span>
                                    </div>
                                </div>

                                @if($post->media_url)
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <div class="text-center">
                                            @if(Str::contains($post->media_url, ['.jpg', '.jpeg', '.png', '.gif', '.webp']))
                                                <img src="{{ $post->media_url }}" alt="Media du post" class="img-fluid rounded shadow" style="max-height: 500px;">
                                            @elseif(Str::contains($post->media_url, ['youtube.com', 'youtu.be']))
                                                <div class="ratio ratio-16x9">
                                                    <iframe src="https://www.youtube.com/embed/{{ getYouTubeId($post->media_url) }}" 
                                                            frameborder="0" allowfullscreen></iframe>
                                                </div>
                                            @else
                                                <div class="alert alert-info">
                                                    <a href="{{ $post->media_url }}" target="_blank" class="text-decoration-none">
                                                        <i class="material-icons me-2">link</i>
                                                        Voir le média externe
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <div class="row">
                                    <div class="col-12">
                                        <div class="card card-body border">
                                            <h6 class="mb-3 text-primary">Content</h6>
                                            <div class="text-justify" style="white-space: pre-line; line-height: 1.6;">
                                                {{ $post->content }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if($post->tags)
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <h6 class="text-primary">Tags :</h6>
                                        @foreach(explode(',', $post->tags) as $tag)
                                            @if(trim($tag))
                                                <span class="badge bg-gradient-secondary me-1 mb-1 fs-6">{{ trim($tag) }}</span>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                @endif

                                <!-- Statistics Section -->
                                <div class="row mt-4">
                                    <div class="col-md-3">
                                        <div class="card bg-gradient-info text-white">
                                            <div class="card-body text-center">
                                                <h4>{{ $post->comments->count() }}</h4>
                                                <p class="mb-0">Commentaires</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="card bg-gradient-danger text-white">
                                            <div class="card-body text-center">
                                                <h4>{{ $post->reports->count() }}</h4>
                                                <p class="mb-0">Signalements</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>

                                <!-- Comments Section for Admin -->
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header bg-gradient-dark text-white">
                                                <h6 class="mb-0">
                                                    <i class="material-icons me-2">comment</i>
                                                    Commentaires ({{ $post->comments->count() }})
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                @if($post->comments->count() > 0)
                                                    @foreach($post->comments->sortByDesc('created_at') as $comment)
                                                        <div class="border-bottom pb-3 mb-3">
                                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                                <div class="d-flex align-items-center">
                                                                    <strong class="me-2">{{ $comment->user->name }}</strong>
                                                                    <small class="text-muted">
                                                                        {{ $comment->created_at->format('d/m/Y à H:i') }}
                                                                    </small>
                                                                </div>
                                                                <div class="d-flex align-items-center">
                                                                    <!-- Like Count -->
                                                                    <span class="badge bg-light text-dark me-2">
                                                                        <i class="material-icons text-sm me-1">favorite</i>
                                                                        {{ $comment->likes->count() }}
                                                                    </span>
                                                                    
                                                                    <!-- Report Count if any -->
                                                                    @if($comment->reports && $comment->reports->count() > 0)
                                                                        <span class="badge bg-danger me-2">
                                                                            <i class="material-icons text-sm me-1">flag</i>
                                                                            {{ $comment->reports->count() }}
                                                                        </span>
                                                                    @endif
                                                                    
                                                                    <!-- Delete Comment Button (Admin only) -->
                                                                    @if(auth()->user()->isAdmin())
                                                                        <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="d-inline">
                                                                            @csrf @method('DELETE')
                                                                            <button type="submit" 
                                                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce commentaire ?')" 
                                                                                    class="btn btn-outline-danger btn-sm ms-2">
                                                                                <i class="material-icons text-sm">delete</i>
                                                                            </button>
                                                                        </form>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <p class="mb-2" style="white-space: pre-line;">{{ $comment->content }}</p>
                                                            
                                                            <!-- Comment Likes Details -->
                                                            @if($comment->likes->count() > 0)
                                                                <div class="mt-2">
                                                                    <small class="text-muted">
                                                                        <i class="material-icons text-sm me-1">favorite</i>
                                                                        Aimé par: 
                                                                        @foreach($comment->likes->take(3) as $like)
                                                                            {{ $like->user->name }}@if(!$loop->last), @endif
                                                                        @endforeach
                                                                        @if($comment->likes->count() > 3)
                                                                            et {{ $comment->likes->count() - 3 }} autres
                                                                        @endif
                                                                    </small>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <div class="text-center text-muted py-4">
                                                        <i class="material-icons display-4">comment</i>
                                                        <p class="mt-2 mb-0">Aucun commentaire pour ce post</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Recent Reports Section -->
                                @if($post->reports->count() > 0)
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header bg-gradient-danger text-white">
                                                <h6 class="mb-0">Signalements ({{ $post->reports->count() }})</h6>
                                            </div>
                                            <div class="card-body">
                                                @foreach($post->reports->take(5) as $report)
                                                    <div class="border-bottom pb-2 mb-2">
                                                        <div class="d-flex justify-content-between align-items-start">
                                                            <div>
                                                                <strong>
                                                                    @if($report->reporter)
                                                                        {{ $report->reporter->name }}
                                                                    @else
                                                                        Utilisateur inconnu
                                                                    @endif
                                                                </strong>
                                                                <span class="badge bg-warning ms-2">{{ $report->reason }}</span>
                                                            </div>
                                                            <small class="text-muted">{{ $report->created_at->format('d/m/Y H:i') }}</small>
                                                        </div>
                                                        @if($report->description)
                                                            <p class="mb-1 text-muted">{{ $report->description }}</p>
                                                        @endif
                                                        <div class="d-flex justify-content-between align-items-center mt-1">
                                                            <small class="text-muted">Statut: 
                                                                <span class="badge 
                                                                    @if($report->status === 'pending') bg-warning
                                                                    @elseif($report->status === 'resolved') bg-success
                                                                    @elseif($report->status === 'rejected') bg-danger
                                                                    @else bg-secondary @endif">
                                                                    {{ $report->status }}
                                                                </span>
                                                            </small>
                                                            @if($report->assignedModerator)
                                                                <small class="text-muted">
                                                                    Assigné à: {{ $report->assignedModerator->name }}
                                                                </small>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <!-- Action Buttons -->
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                @if(auth()->user()->isAdmin())
                                                    @if($post->status === 'active')
                                                        <form action="{{ route('posts.hide', $post) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-warning btn-sm">
                                                                <i class="material-icons">visibility_off</i> Masquer
                                                            </button>
                                                        </form>
                                                    @else
                                                        <form action="{{ route('posts.unhide', $post) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-success btn-sm">
                                                                <i class="material-icons">visibility</i> Afficher
                                                            </button>
                                                        </form>
                                                    @endif
                                                @endif
                                            </div>
                                            <div>
                                                @if(auth()->id() === $post->user_id || auth()->user()->isAdmin())
                                                    <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer définitivement ce post ?')" class="btn btn-danger btn-sm">
                                                            <i class="material-icons">delete</i> Supprimer
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-plugins></x-plugins>
    
    @push('scripts')
    <script>
        // Helper function for YouTube URLs
        function getYouTubeId(url) {
            const regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#&?]*).*/;
            const match = url.match(regExp);
            return (match && match[7].length === 11) ? match[7] : false;
        }
    </script>
    @endpush
</x-layout>