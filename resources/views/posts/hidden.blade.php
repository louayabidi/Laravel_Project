@php use Illuminate\Support\Str; @endphp
<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-header.header></x-header.header>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Posts Masqués"></x-navbars.navs.auth>

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-warning shadow-warning border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center px-3">
                                <h6 class="text-white text-capitalize ps-3">Posts Masqués</h6>
                                <div>
                                    <a href="{{ route('posts.index') }}" class="btn btn-sm btn-light">
                                        <i class="material-icons">list</i> Tous les Posts
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-3">
                                @if(session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif

                                @if($posts->count() > 0)
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Auteur</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Titre</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tags</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date de création</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($posts as $post)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <i class="material-icons text-primary me-2">account_circle</i>
                                                        <span class="text-xs font-weight-bold">{{ $post->user->name }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="text-xs font-weight-bold">{{ Str::limit($post->title, 40) }}</span>
                                                </td>
                                                <td>
                                                    @if($post->tags && count($post->tags) > 0)
                                                        @foreach(array_slice($post->tags, 0, 2) as $tag)
                                                            <span class="badge bg-secondary me-1">{{ $tag }}</span>
                                                        @endforeach
                                                    @else
                                                        <span class="text-muted text-xs">Aucun</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="text-xs font-weight-bold">{{ $post->created_at->format('d/m/Y H:i') }}</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <a href="{{ route('posts.show', $post) }}" class="btn btn-link text-primary px-2 mb-0" data-bs-toggle="tooltip" title="Voir">
                                                            <i class="material-icons text-sm">visibility</i>
                                                        </a>
                                                        <a href="{{ route('posts.edit', $post) }}" class="btn btn-link text-warning px-2 mb-0" data-bs-toggle="tooltip" title="Modifier">
                                                            <i class="material-icons text-sm">edit</i>
                                                        </a>
                                                        <form action="{{ route('posts.unhide', $post) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-link text-success px-2 mb-0" data-bs-toggle="tooltip" title="Rendre visible">
                                                                <i class="material-icons text-sm">visibility</i>
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline">
                                                            @csrf @method('DELETE')
                                                            <button type="submit" onclick="return confirm('Supprimer définitivement ce post ?')" class="btn btn-link text-danger px-2 mb-0" data-bs-toggle="tooltip" title="Supprimer">
                                                                <i class="material-icons text-sm">delete</i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $posts->links() }}
                                </div>
                                @else
                                <div class="text-center py-4">
                                    <i class="material-icons text-muted" style="font-size: 64px;">visibility_off</i>
                                    <h5 class="text-muted mt-3">Aucun post masqué</h5>
                                    <p class="text-muted">Tous les posts sont actuellement visibles.</p>
                                    <a href="{{ route('posts.index') }}" class="btn btn-primary">
                                        <i class="material-icons">arrow_back</i> Retour aux posts
                                    </a>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-plugins></x-plugins>
</x-layout>