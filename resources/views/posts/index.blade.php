@php use Illuminate\Support\Str; @endphp
<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-header.header></x-header.header>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Posts Management"></x-navbars.navs.auth>

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center px-3">
                                <h6 class="text-white text-capitalize ps-3">Liste des Posts</h6>
                                <a href="{{ route('posts.create') }}" class="btn btn-sm btn-light">
                                    <i class="material-icons">add</i> New Post
                                </a>
                            </div>
                        </div>

                        <div class="card-body px-0 pb-2">
                            <!-- Success Message -->
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show mx-3" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <!-- Posts Grid -->
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
                                                    @else bg-danger @endif">
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

                                            <!-- Tags -->
                                            @if($post->tags)
                                            <div class="mb-3">
                                                @foreach(explode(',', $post->tags) as $tag)
                                                    @if(trim($tag) && $loop->index < 3)
                                                        <span class="badge bg-gradient-secondary me-1 mb-1 small">{{ trim($tag) }}</span>
                                                    @endif
                                                @endforeach
                                                @if(count(explode(',', $post->tags)) > 3)
                                                    <span class="badge bg-dark small">+{{ count(explode(',', $post->tags)) - 3 }}</span>
                                                @endif
                                            </div>
                                            @endif
                                        </div>

                                        <!-- Card Footer with Actions -->
                                        <div class="card-footer bg-transparent border-0 pt-0 pb-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex">
                                                    <!-- View Button -->
                                                    <a href="{{ route('posts.show', $post) }}" class="btn btn-sm btn-outline-primary me-1" 
                                                       data-bs-toggle="tooltip" title="Voir">
                                                        <i class="material-icons text-sm">visibility</i>
                                                    </a>

                                                    <!-- Edit & Delete (Owner or Admin) -->
                                                    @if(auth()->id() === $post->user_id || auth()->user()->isAdmin())
                                                    <a href="{{ route('posts.edit', $post) }}" class="btn btn-sm btn-outline-warning me-1" 
                                                       data-bs-toggle="tooltip" title="Modifier">
                                                        <i class="material-icons text-sm">edit</i>
                                                    </a>
                                                    
                                                    <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce post ?')" 
                                                                class="btn btn-sm btn-outline-danger me-1" data-bs-toggle="tooltip" title="Supprimer">
                                                            <i class="material-icons text-sm">delete</i>
                                                        </button>
                                                    </form>
                                                    @endif
                                                </div>

                                                <!-- Admin Actions -->
                                                @if(auth()->user()->isAdmin())
                                                <div>
                                                    @if($post->status === 'active')
                                                    <form action="{{ route('posts.hide', $post) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-outline-warning" 
                                                                data-bs-toggle="tooltip" title="Masquer">
                                                            <i class="material-icons text-sm">visibility_off</i>
                                                        </button>
                                                    </form>
                                                    @else
                                                    <form action="{{ route('posts.unhide', $post) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-outline-success" 
                                                                data-bs-toggle="tooltip" title="Afficher">
                                                            <i class="material-icons text-sm">visibility</i>
                                                        </button>
                                                    </form>
                                                    @endif
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
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

    @push('scripts')
    <script>
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    </script>
    @endpush

    <style>
    .post-card {
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        border-radius: 12px;
        border: 1px solid #e9ecef;
    }
    .post-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
    }
    .card-header .avatar {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .card-title {
        font-size: 1.1rem;
        line-height: 1.4;
        min-height: 3rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .card-text {
        min-height: 3rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .btn-outline-primary {
        border-color: #e91e63;
        color: #e91e63;
    }
    .btn-outline-primary:hover {
        background-color: #e91e63;
        border-color: #e91e63;
        color: white;
    }
    .btn-outline-warning {
        border-color: #fb8c00;
        color: #fb8c00;
    }
    .btn-outline-warning:hover {
        background-color: #fb8c00;
        border-color: #fb8c00;
        color: white;
    }
    .btn-outline-danger {
        border-color: #f44336;
        color: #f44336;
    }
    .btn-outline-danger:hover {
        background-color: #f44336;
        border-color: #f44336;
        color: white;
    }
    .btn-outline-success {
        border-color: #4caf50;
        color: #4caf50;
    }
    .btn-outline-success:hover {
        background-color: #4caf50;
        border-color: #4caf50;
        color: white;
    }
    </style>
</x-layout>