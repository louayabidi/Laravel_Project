@php use Illuminate\Support\Str; @endphp
<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-header.header></x-header.header>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Posts Management"></x-navbars.navs.auth>

        <div class="container-fluid py-4">

            {{-- SEARCH AND FILTER SECTION --}}
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('posts.index') }}" method="GET" class="row g-3 align-items-end">
                                <div class="col-md-6">
                                    <label for="search" class="form-label">Rechercher</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="material-icons">search</i>
                                        </span>
                                        <input type="text" 
                                               class="form-control" 
                                               id="search" 
                                               name="search" 
                                               placeholder="Rechercher par titre, contenu ou auteur..."
                                               value="{{ request('search') }}">
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <label for="tags" class="form-label">Filtrer par tags</label>
                                    <select class="form-select" id="tags" name="tags">
                                        <option value="">Tous les tags</option>
                                        @foreach($allTags as $tag)
                                            <option value="{{ $tag }}" 
                                                {{ request('tags') == $tag ? 'selected' : '' }}>
                                                {{ $tag }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="material-icons me-1">filter_alt</i>
                                        Filtrer
                                    </button>
                                </div>
                                
                                @if(request()->has('search') || request()->has('tags'))
                                <div class="col-12">
                                    <div class="d-flex align-items-center">
                                        <span class="text-sm text-muted me-2">
                                            @if(request('search') && request('tags'))
                                                Résultats pour "{{ request('search') }}" avec le tag "{{ request('tags') }}"
                                            @elseif(request('search'))
                                                Résultats pour "{{ request('search') }}"
                                            @elseif(request('tags'))
                                                Posts avec le tag "{{ request('tags') }}"
                                            @endif
                                        </span>
                                        <a href="{{ route('posts.index') }}" class="btn btn-sm btn-outline-secondary">
                                            <i class="material-icons">clear</i>
                                            Effacer
                                        </a>
                                    </div>
                                </div>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- MY REPORTS BUTTON --}}
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body text-center">
                            <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#myReportsModal">
                                <i class="material-icons me-2">flag</i>
                                Mes Signalements
                                @if($myReportsCount > 0)
                                <span class="badge bg-danger ms-1">{{ $myReportsCount }}</span>
                                @endif
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- APP POSTS SECTION --}}
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center px-3">
                                <h6 class="text-white text-capitalize ps-3">
                                    Application Posts 
                                    @if($posts->total() > 0)
                                    <span class="badge bg-light text-dark ms-2">{{ $posts->total() }}</span>
                                    @endif
                                </h6>
                                <a href="{{ route('posts.create') }}" class="btn btn-sm btn-light">
                                    <i class="material-icons">add</i> Nouveau Post
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

                            @if($posts->count() > 0)
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

                                        <div class="card-footer bg-transparent border-0 pt-0 pb-3 d-flex justify-content-between align-items-center">
                                            <div class="d-flex">
                                                <a href="{{ route('posts.show', $post) }}" class="btn btn-sm btn-outline-primary me-1">
                                                    <i class="material-icons text-sm">visibility</i>
                                                </a>
                                                @if(auth()->id() === $post->user_id || auth()->user()->isAdmin())
                                                <a href="{{ route('posts.edit', $post) }}" class="btn btn-sm btn-outline-warning me-1">
                                                    <i class="material-icons text-sm">edit</i>
                                                </a>
                                                <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-outline-danger me-1">
                                                        <i class="material-icons text-sm">delete</i>
                                                    </button>
                                                </form>
                                                @endif
                                            </div>

                                            <!-- Report Button - Only show if post doesn't belong to current user -->
                                            @if(auth()->id() !== $post->user_id)
                                            <div>
                                                <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#reportPostModal-{{ $post->id }}">
                                                    <i class="material-icons text-sm">flag</i>
                                                </button>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Report Modal - Only create if post doesn't belong to current user -->
                                @if(auth()->id() !== $post->user_id)
                                <div class="modal fade" id="reportPostModal-{{ $post->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header bg-gradient-danger text-white">
                                                <h6 class="modal-title">
                                                    <i class="material-icons me-2">flag</i>
                                                    Signaler ce post
                                                </h6>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('reports.store') }}" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <input type="hidden" name="post_id" value="{{ $post->id }}">

                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">Raison</label>
                                                        <select name="reason" class="form-select" required>
                                                            <option value="">Choisir un raison</option>
                                                            <option value="Spam ou publicité">Spam or advertising
                                                            </option>
                                                            <option value="Contenu inapproprié">inapropriate content</option>
                                                            <option value="Harcèlement">Harassment</option>
                                                            <option value="Informations fausses">False information
                                                            </option>
                                                            <option value="Contenu violent">Violent content
                                                            </option>
                                                            <option value="Droits d'auteur">Copyright infringement
                                                            </option>
                                                            <option value="Autre">Other</option>
                                                        </select>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">Description Detaillées
                                                        </label>
                                                        <textarea name="description" class="form-control" rows="4" placeholder="Please provide more details about the problem
..." maxlength="500"></textarea>
                                                        <div class="form-text text-end">
                                                            <span id="charCount-{{ $post->id }}">0</span>/500 caractères
                                                        </div>
                                                    </div>

                                                    <div class="alert alert-info mb-0">
                                                        <div class="d-flex align-items-center">
                                                            <i class="material-icons text-info me-2">info</i>
                                                            <small>

                                                                Votre signalement sera examiné par notre équipe de modération. Nous traitons tous les signalements sous 24 à 48 heures.
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-danger">
                                                        <i class="material-icons me-1">send</i>
                                                        Envoyer
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @endforeach
                            </div>

                            <div class="d-flex justify-content-center mt-4">
                                {{ $posts->appends(request()->query())->links() }}
                            </div>
                            @else
                            <div class="text-center py-5">
                                <i class="material-icons display-4 text-muted">search_off</i>
                                <h5 class="text-muted mt-3">Aucun post trouvé</h5>
                                <p class="text-muted">
                                    @if(request()->has('search') || request()->has('tags'))
                                        Aucun résultat pour votre recherche. Essayez d'autres termes.
                                    @else
                                        Aucun post disponible pour le moment.
                                    @endif
                                </p>
                                @if(request()->has('search') || request()->has('tags'))
                                <a href="{{ route('posts.index') }}" class="btn btn-primary">
                                    <i class="material-icons me-1">clear_all</i>
                                    Voir tous les posts
                                </a>
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- REDDIT POSTS SECTION --}}
            <div class="row mt-5">
                <div class="col-12">
                    <h5 class="text-primary mb-3">Reddit Healthcare Posts</h5>
                </div>

                @forelse($redditPosts as $rpost)
                @php $data = $rpost['data']; @endphp
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card shadow-sm border-0 h-100 post-card">
                        <div class="card-header bg-transparent border-0 pb-0 pt-3">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm me-2">
                                        <i class="material-icons text-danger">reddit</i>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="text-sm font-weight-bold">/u/{{ $data['author'] }}</span>
                                        <small class="text-muted">{{ \Carbon\Carbon::createFromTimestamp($data['created_utc'])->format('d/m/Y') }}</small>
                                    </div>
                                </div>
                                <span class="badge bg-secondary">Reddit</span>
                            </div>
                        </div>

                        <div class="card-body py-3">
                            <h6 class="card-title text-dark font-weight-bold mb-2">
                                {{ Str::limit($data['title'], 60) }}
                            </h6>
                            <p class="card-text text-muted small mb-3">
                                {{ Str::limit(strip_tags($data['selftext'] ?? ''), 120) }}
                            </p>
                        </div>

                        <div class="card-footer bg-transparent border-0 pt-0 pb-3 d-flex justify-content-between align-items-center">
                            <a href="https://reddit.com{{ $data['permalink'] }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="material-icons text-sm">visibility</i> Voir
                            </a>
                            <span class="text-sm text-muted">{{ $data['ups'] }} ↑</span>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="alert alert-info">No Reddit posts found.</div>
                </div>
                @endforelse
            </div>

        </div>
    </main>

    {{-- MY REPORTS MODAL --}}
    <div class="modal fade" id="myReportsModal" tabindex="-1" aria-labelledby="myReportsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-gradient-info text-white">
                    <h5 class="modal-title" id="myReportsModalLabel">
                        <i class="material-icons me-2">flag</i>
                        Mes Signalements ({{ $myReportsCount }})
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if($myReports->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>Post</th>
                                    <th>Raison</th>
                                    <th>Statut</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($myReports as $report)
                                <tr>
                                    <td>
                                        @if($report->post)
                                        <a href="{{ route('posts.show', $report->post) }}" class="text-decoration-none">
                                            {{ Str::limit($report->post->title, 40) }}
                                        </a>
                                        @else
                                        <span class="text-muted">Post Supprimée</span>
                                        @endif
                                    </td>
                                    <td>{{ $report->reason }}</td>
                                    <td>
                                        <span class="badge 
                                                @if($report->status === 'pending') bg-warning
                                                @elseif($report->status === 'in_review') bg-info
                                                @elseif($report->status === 'resolved') bg-success
                                                @elseif($report->status === 'dismissed') bg-secondary
                                                @else bg-secondary @endif">
                                            @if($report->status === 'pending') Pending
                                            @elseif($report->status === 'in_review') In Review
                                            @elseif($report->status === 'resolved') Resolved
                                            @elseif($report->status === 'dismissed') Dismissed
                                            @else {{ $report->status }}
                                            @endif
                                        </span>
                                    </td>
                                    <td>{{ $report->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        @if($report->post)
                                        <a href="{{ route('posts.show', $report->post) }}" class="btn btn-sm btn-outline-primary me-1" title="View Post">
                                            <i class="material-icons text-sm">visibility</i>
                                        </a>
                                        @endif
                                        <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#reportDetailsModal-{{ $report->id }}" title="Details">
                                            <i class="material-icons text-sm">info</i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-5">
                        <i class="material-icons display-4 text-muted">flag</i>
                        <h5 class="text-muted mt-3">Pas de Signalements</h5>
                        <p class="text-muted">Vous n'avez pas encore fait de signalement .</p>
                    </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer </button>
                </div>
            </div>
        </div>
    </div>

    {{-- REPORT DETAILS MODALS - MOVED OUTSIDE THE TABLE --}}
    @foreach($myReports as $report)
    <div class="modal fade" id="reportDetailsModal-{{ $report->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-gradient-info text-white">
                    <h6 class="modal-title">Détailles de signalements</h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Post Signalée:</strong>
                            <p class="mb-2">
                                @if($report->post)
                                <a href="{{ route('posts.show', $report->post) }}" class="text-decoration-none">
                                    {{ $report->post->title }}
                                </a>
                                @else
                                <span class="text-muted">Post Supprimée</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <strong>Status:</strong>
                            <p class="mb-2">
                                <span class="badge 
                                        @if($report->status === 'pending') bg-warning
                                        @elseif($report->status === 'in_review') bg-info
                                        @elseif($report->status === 'resolved') bg-success
                                        @elseif($report->status === 'dismissed') bg-secondary
                                        @else bg-secondary @endif">
                                    @if($report->status === 'pending') Pending
                                    @elseif($report->status === 'in_review') In Review
                                    @elseif($report->status === 'resolved') Resolved
                                    @elseif($report->status === 'dismissed') Dismissed
                                    @else {{ $report->status }}
                                    @endif
                                </span>
                            </p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <strong>Raison:</strong>
                        <p class="mb-1">{{ $report->reason }}</p>
                    </div>

                    @if($report->description)
                    <div class="mb-3">
                        <strong>Description:</strong>
                        <p class="mb-1 text-muted">{{ $report->description }}</p>
                    </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6">
                            <strong>Signalement Date:</strong>
                            <p class="mb-1">{{ $report->created_at->format('d/m/Y à H:i') }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Last Update:</strong>
                            <p class="mb-1">{{ $report->updated_at->format('d/m/Y à H:i') }}</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <x-plugins></x-plugins>

    @push('scripts')
    <script>
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(el) {
            return new bootstrap.Tooltip(el)
        });

        // Character counter for report description
        document.addEventListener('DOMContentLoaded', function() {
            // Add character counter to all report modals
            const reportModals = document.querySelectorAll('[id^="reportPostModal-"]');

            reportModals.forEach(modal => {
                const postId = modal.id.split('-')[1];
                const textarea = modal.querySelector('textarea[name="description"]');
                const charCount = document.getElementById(`charCount-${postId}`);

                if (textarea && charCount) {
                    textarea.addEventListener('input', function() {
                        charCount.textContent = this.value.length;

                        // Change color when approaching limit
                        if (this.value.length > 450) {
                            charCount.classList.add('text-danger');
                            charCount.classList.remove('text-muted');
                        } else {
                            charCount.classList.remove('text-danger');
                            charCount.classList.add('text-muted');
                        }
                    });
                }
            });

            // Auto-focus on reason dropdown when modal opens
            reportModals.forEach(modal => {
                modal.addEventListener('shown.bs.modal', function() {
                    const select = this.querySelector('select[name="reason"]');
                    if (select) {
                        select.focus();
                    }
                });
            });

            // Auto-focus on search input when page loads if there's a search term
            <?php if(request('search')): ?>
            const searchInput = document.getElementById('search');
            if (searchInput) {
                searchInput.focus();
                searchInput.select();
            }
            <?php endif; ?>
        });

        // Form validation
        function validateReportForm(form) {
            const reason = form.querySelector('select[name="reason"]').value;
            const description = form.querySelector('textarea[name="description"]').value;

            if (!reason) {
                alert('Please select a reason for your report.');
                return false;
            }

            if (description.length < 10 && reason === 'Autre') {
                alert('Please provide a detailed description for "Other reason".');
                return false;
            }

            return true;
        }

        // Add form validation to all report forms
        document.querySelectorAll('form[action="{{ route("reports.store") }}"]').forEach(form => {
            form.addEventListener('submit', function(e) {
                if (!validateReportForm(this)) {
                    e.preventDefault();
                }
            });
        });
    </script>
    @endpush

    <style>
        .post-card {
            transition: transform 0.2s, box-shadow 0.2s;
            border-radius: 12px;
            border: 1px solid #e9ecef;
        }

        .post-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .modal-header {
            border-bottom: 2px solid rgba(255, 255, 255, 0.2);
        }

        .form-select:focus,
        .form-control:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.075);
        }

        .input-group-text {
            background-color: #f8f9fa;
            border-color: #ced4da;
        }
    </style>
</x-layout>