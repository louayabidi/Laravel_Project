<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="sante"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Modifier le Post"></x-navbars.navs.auth>

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Modifier le Post</h6>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="p-3">
                                @if($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Veuillez corriger les erreurs suivantes:</strong>
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                @endif

                                <form method="POST" action="{{ route('posts.update', $post) }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <div class="input-group input-group-static">
                                                <label class="ms-0" for="title">Titre *</label>
                                                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title" value="{{ old('title', $post->title) }}" required>
                                                @error('title')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <div class="input-group input-group-static">
                                                <label class="ms-0" for="content">Content *</label>
                                                <textarea class="form-control @error('content') is-invalid @enderror" name="content" id="content" rows="10" required>{{ old('content', $post->content) }}</textarea>
                                                @error('content')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="input-group input-group-static">
                                                <label class="ms-0" for="media_url">URL Média (optionnel)</label>
                                                <input type="url" class="form-control @error('media_url') is-invalid @enderror" name="media_url" id="media_url" value="{{ old('media_url', $post->media_url) }}">
                                                @error('media_url')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="input-group input-group-static">
                                                <label class="ms-0" for="tags">Tags (séparés par des virgules)</label>
                                                <input type="text" class="form-control @error('tags') is-invalid @enderror" name="tags" id="tags" value="{{ old('tags') }}" placeholder="fitness, nutrition, santé">
                                                @error('tags')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <small class="text-muted">Ex: fitness, nutrition, santé</small>
                                        </div>
                                    </div>

                                    @if(auth()->user()->isAdmin())
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="input-group input-group-static">
                                                <label class="ms-0" for="status">Statut</label>
                                                <select class="form-control @error('status') is-invalid @enderror" name="status" id="status">
                                                    <option value="active" {{ old('status', $post->status) === 'active' ? 'selected' : '' }}>Actif</option>
                                                    <option value="hidden" {{ old('status', $post->status) === 'hidden' ? 'selected' : '' }}>Masqué</option>
                                                    <option value="draft" {{ old('status', $post->status) === 'draft' ? 'selected' : '' }}>Brouillon</option>
                                                </select>
                                                @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    <div class="row mt-4">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="material-icons">save</i> Mettre à jour
                                            </button>
                                            <a href="{{ route('admin.show', $post) }}" class="btn btn-info">
                                                <i class="material-icons">visibility</i> Voir
                                            </a>
                                            <a href="{{ route('posts.index') }}" class="btn btn-secondary">
                                                <i class="material-icons">cancel</i> Annuler
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-plugins></x-plugins>
</x-layout>