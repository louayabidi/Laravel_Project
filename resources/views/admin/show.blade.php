@php use Illuminate\Support\Str; @endphp
<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="sante"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Post Details"></x-navbars.navs.auth>

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center px-3">
                                <h6 class="text-white text-capitalize ps-3">Post Details</h6>
                                <div>
                                    <a href="{{ route('posts.index') }}" class="btn btn-sm btn-light">
                                        <i class="material-icons">arrow_back</i> Retour
                                    </a>
                                    @if(auth()->id() === $post->user_id || auth()->user()->isAdmin())
                                        <a href="{{ route('posts.edit', $post) }}" class="btn btn-sm btn-info">
                                            <i class="material-icons">edit</i> Modifier
                                        </a>
                                    @endif
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