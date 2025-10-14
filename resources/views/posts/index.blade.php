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
                                                <span class="badge 
                                                    @if($post->status === 'active') bg-success 
                                                    @elseif($post->status === 'hidden') bg-warning 
                                                    @else bg-danger @endif">
                                                    {{ ucfirst($post->status) }}
                                                </span>
                                            </div>
                                        </div>

                                        <div class="card-body py-3">
                                            <h6 class="card-title text-dark font-weight-bold mb-2">
                                                {{ Str::limit($post->title, 60) }}
                                            </h6>
                                            <p class="card-text text-muted small mb-3">
                                                {{ Str::limit(strip_tags($post->content), 120) }}
                                            </p>
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

                                        <div class="card-footer bg-transparent border-0 pt-0 pb-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex">
                                                    <a href="{{ route('posts.show', $post) }}" class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="tooltip" title="Voir">
                                                        <i class="material-icons text-sm">visibility</i>
                                                    </a>

                                                    @if(auth()->id() === $post->user_id || auth()->user()->isAdmin())
                                                    <a href="{{ route('posts.edit', $post) }}" class="btn btn-sm btn-outline-warning me-1" data-bs-toggle="tooltip" title="Modifier">
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

                                                <div>
                                                    <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#reportPostModal-{{ $post->id }}">
                                                        <i class="material-icons text-sm">flag</i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Report Post Modal -->
                                <div class="modal fade" id="reportPostModal-{{ $post->id }}" tabindex="-1" aria-labelledby="reportPostModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header bg-danger text-white">
                                                <h6 class="modal-title" id="reportPostModalLabel">Report Post: {{ $post->title }}</h6>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('reports.store') }}" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                                                    <div class="mb-3">
                                                        <label class="form-label">Reason</label>
                                                        <textarea name="reason" class="form-control" rows="3" required></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-danger">Submit Report</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>

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
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.map(function (el) { return new bootstrap.Tooltip(el) });
    </script>
    @endpush

    <style>
        .post-card { transition: transform 0.2s, box-shadow 0.2s; border-radius: 12px; border: 1px solid #e9ecef; }
        .post-card:hover { transform: translateY(-5px); box-shadow: 0 8px 25px rgba(0,0,0,0.15); }
    </style>
</x-layout>
