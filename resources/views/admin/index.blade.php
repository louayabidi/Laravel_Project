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
                                <h6 class="text-white text-capitalize ps-3">Post Administration</h6>
                                <!-- Optional: Add a filter for status -->
                                <div class="d-flex">
                                    <a href="{{ route('admin.index', ['status' => 'all']) }}" class="btn btn-sm btn-outline-light me-1">Tous</a>
                                    <a href="{{ route('admin.index', ['status' => 'active']) }}" class="btn btn-sm btn-outline-light me-1">Actifs</a>
                                    <a href="{{ route('admin.index', ['status' => 'hidden']) }}" class="btn btn-sm btn-outline-light">Hidden</a>
                                </div>
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

                                        <!-- Card Footer with Admin Actions -->
                                        <div class="card-footer bg-transparent border-0 pt-0 pb-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex">
                                                    <!-- View Button -->
                                                    <a href="{{ route('admin.show', $post) }}" class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="tooltip" title="Voir">
                                                        <i class="material-icons text-sm">visibility</i>
                                                    </a>
                                                    <!-- Edit Button -->
                                                    <a href="{{ route('admin.edit', $post) }}" class="btn btn-sm btn-outline-warning me-1" data-bs-toggle="tooltip" title="Modifier">
                                                        <i class="material-icons text-sm">edit</i>
                                                    </a>
                                                    <!-- Delete Button -->
                                                    <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" onclick="return confirm('Supprimer définitivement ce post ?')" class="btn btn-sm btn-outline-danger me-1" data-bs-toggle="tooltip" title="Supprimer">
                                                            <i class="material-icons text-sm">delete</i>
                                                        </button>
                                                    </form>
                                                </div>

                                                <!-- Hide/Unhide Toggle -->
                                                <div>
                                                    @if($post->status === 'active')
                                                    <form action="{{ route('posts.hide', $post) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-outline-warning" data-bs-toggle="tooltip" title="Masquer le post">
                                                            <i class="material-icons text-sm">visibility_off</i>
                                                        </button>
                                                    </form>
                                                    @else
                                                    <form action="{{ route('posts.unhide', $post) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-outline-success" data-bs-toggle="tooltip" title="Rendre le post visible">
                                                            <i class="material-icons text-sm">visibility</i>
                                                        </button>
                                                    </form>
                                                    @endif
                                                </div>
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
</x-layout>